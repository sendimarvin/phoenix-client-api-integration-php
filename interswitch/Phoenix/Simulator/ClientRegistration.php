<?php

namespace Interswitch\Phoenix\Simulator;

use Interswitch\Phoenix\Simulator\Dto\ClientRegistrationDetail;
use Interswitch\Phoenix\Simulator\Dto\ClientRegistrationResponse;
use Interswitch\Phoenix\Simulator\Dto\CompleteClientRegistration;
use Interswitch\Phoenix\Simulator\Dto\JsonDataTransform;
use Interswitch\Phoenix\Simulator\Dto\LoginResponse;
use Interswitch\Phoenix\Simulator\Dto\PhoenixResponseCodes;
use Interswitch\Phoenix\Simulator\Dto\SystemResponse;
use Interswitch\Phoenix\Simulator\Utils\AuthUtils;
use Interswitch\Phoenix\Simulator\Utils\Constants;
use Interswitch\Phoenix\Simulator\Utils\CryptoUtils;
use Interswitch\Phoenix\Simulator\Utils\EllipticCurveUtils;
use Interswitch\Phoenix\Simulator\Utils\HttpUtil;
use Interswitch\Phoenix\Simulator\Utils\UtilMethods;

class ClientRegistration
{
    private static $LOG;

    public static $baseUrl = Constants::ROOT_LINK . "client/";
    public static $registrationEndpointUrl = self::$baseUrl . "clientRegistration";
    public static $registrationCompletionEndpointUrl = self::$baseUrl . "completeClientRegistration";

    public static function main()
    {
        self::$LOG = LoggerFactory::getLogger(ClientRegistration::class);

        $pair = CryptoUtils::generateKeyPair();
        $privateKey = base64_encode($pair->getPrivate()->getEncoded());
        $publicKey = base64_encode($pair->getPublic()->getEncoded());

        self::$LOG->info(" private key {} ", $privateKey);
        self::$LOG->info(" public key  {} ", $publicKey);

        $curveUtils = new EllipticCurveUtils("ECDH");
        $keyPair = $curveUtils->generateKeypair();
        $curvePrivateKey = $curveUtils->getPrivateKey($keyPair);
        $curvePublicKey = $curveUtils->getPublicKey($keyPair);

        $response = self::clientRegistrationRequest($publicKey, $curvePublicKey, $privateKey);

        $registrationResponse = UtilMethods::unMarshallSystemResponseObject($response, ClientRegistrationResponse::class);
        if ($registrationResponse->getResponseCode() !== PhoenixResponseCodes::APPROVED['CODE']) {
            self::$LOG->info("Client Registration failed: {} ", $registrationResponse->getResponseMessage());
        } else {
            $decryptedSessionKey = CryptoUtils::decryptWithPrivate($registrationResponse->getResponse()->getServerSessionPublicKey(), $privateKey);
            $terminalKey = $curveUtils->doECDH($curvePrivateKey, $decryptedSessionKey);
            self::$LOG->info("==============terminalKey==============");
            self::$LOG->info("terminalKey: {} ", $terminalKey);
            $authToken = CryptoUtils::decryptWithPrivate($registrationResponse->getResponse()->getAuthToken(), $privateKey);

            self::$LOG->info(" authToken {} ", $authToken);
            $transactionReference = $registrationResponse->getResponse()->getTransactionReference();
            self::$LOG->info("Enter received OTP: ");
            $otp = readline();
            self::$LOG->info("OTP Entered: {}", $otp);
            $finalResponse = self::completeRegistration($terminalKey, $authToken, $transactionReference, $otp, $privateKey);

            $response = UtilMethods::unMarshallSystemResponseObject($finalResponse, LoginResponse::class);
            if ($response->getResponseCode() === PhoenixResponseCodes::APPROVED['CODE']) {
                if ($response->getResponse()->getClientSecret() !== null && strlen($response->getResponse()->getClientSecret()) > 5) {
                    $clientSecret = CryptoUtils::decryptWithPrivate($response->getResponse()->getClientSecret(), $privateKey);
                    self::$LOG->info("clientSecret: {}", $clientSecret);
                }
            } else {
                self::$LOG->info("finalResponse: {}", $response->getResponseMessage());
            }
        }
    }

    private static function clientRegistrationRequest($publicKey, $clientSessionPublicKey, $privateKey)
    {
        $setup = new ClientRegistrationDetail();
        $setup->setSerialId(Constants::MY_SERIAL_ID);
        $setup->setName("API Client");
        $setup->setNin("123456");
        $setup->setOwnerPhoneNumber("00000");
        $setup->setPhoneNumber("00000000");
        $setup->setPublicKey($publicKey);
        $setup->setRequestReference(uuid_create());
        $setup->setTerminalId(Constants::TERMINAL_ID);
        $setup->setGprsCoordinate("");
        $setup->setClientSessionPublicKey($clientSessionPublicKey);

        $headers = AuthUtils::generateInterswitchAuth(Constants::POST_REQUEST, self::$registrationEndpointUrl, "", "", "", $privateKey);
        $json = JsonDataTransform::marshall($setup);

        return HttpUtil::postHTTPRequest(self::$registrationEndpointUrl, $headers, $json);
    }

    private static function completeRegistration($terminalKey, $authToken, $transactionReference, $otp, $privateKey)
    {
        $completeReg = new CompleteClientRegistration();

        $passwordHash = UtilMethods::hash512(Constants::ACCOUNT_PWD);

        $completeReg->setTerminalId(Constants::TERMINAL_ID);
        $completeReg->setSerialId(Constants::MY_SERIAL_ID);
        $completeReg->setOtp(CryptoUtils::encrypt($otp, $terminalKey));
        $completeReg->setRequestReference(uuid_create());
        $completeReg->setPassword(CryptoUtils::encrypt($passwordHash, $terminalKey));
        $completeReg->setTransactionReference($transactionReference);
        $completeReg->setAppVersion(Constants::APP_VERSION);
        $completeReg->setGprsCoordinate("");

        $headers = AuthUtils::generateInterswitchAuth(Constants::POST_REQUEST, self::$registrationCompletionEndpointUrl, "", $authToken, $terminalKey, $privateKey);
        $json = JsonDataTransform::marshall($completeReg);

        return HttpUtil::postHTTPRequest(self::$registrationCompletionEndpointUrl, $headers, $json);
    }
}