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

    public const BASE_URL = Constants::ROOT_LINK . "client/";
    public static $registrationEndpointUrl = self::BASE_URL . "clientRegistration";
    public static $registrationCompletionEndpointUrl = self::BASE_URL . "completeClientRegistration";

    public static function main()
    {

        $pair = CryptoUtils::generateKeyPair();
        $privateKey = base64_encode($pair->getPrivate()->getEncoded());
        $publicKey = base64_encode($pair->getPublic()->getEncoded());

        echo " private key ", $privateKey, PHP_EOL;
        echo " public key  ", $publicKey, PHP_EOL;

        $curveUtils = new EllipticCurveUtils("ECDH");
        $keyPair = $curveUtils->generateKeypair();
        $curvePrivateKey = $curveUtils->getPrivateKey($keyPair);
        $curvePublicKey = $curveUtils->getPublicKey($keyPair);

        $response = self::clientRegistrationRequest($publicKey, $curvePublicKey, $privateKey);

        $registrationResponse = UtilMethods::unMarshallSystemResponseObject($response, ClientRegistrationResponse::class);
        if ($registrationResponse->getResponseCode() !== PhoenixResponseCodes::APPROVED['CODE']) {
            echo "Client Registration failed: ", $registrationResponse->getResponseMessage(), PHP_EOL;
        } else {
            $decryptedSessionKey = CryptoUtils::decryptWithPrivate($registrationResponse->getResponse()->getServerSessionPublicKey(), $privateKey);
            $terminalKey = $curveUtils->doECDH($curvePrivateKey, $decryptedSessionKey);
            echo "==============terminalKey==============", PHP_EOL;
            echo "terminalKey: ", $terminalKey, PHP_EOL;
            $authToken = CryptoUtils::decryptWithPrivate($registrationResponse->getResponse()->getAuthToken(), $privateKey);

            echo " authToken ", $authToken, PHP_EOL;
            $transactionReference = $registrationResponse->getResponse()->getTransactionReference();
            echo "Enter received OTP: ", PHP_EOL;
            $otp = readline();
            echo "OTP Entered: ", $otp, PHP_EOL;
            $finalResponse = self::completeRegistration($terminalKey, $authToken, $transactionReference, $otp, $privateKey);

            $response = UtilMethods::unMarshallSystemResponseObject($finalResponse, LoginResponse::class);
            if ($response->getResponseCode() === PhoenixResponseCodes::APPROVED['CODE']) {
                if ($response->getResponse()->getClientSecret() !== null && strlen($response->getResponse()->getClientSecret()) > 5) {
                    $clientSecret = CryptoUtils::decryptWithPrivate($response->getResponse()->getClientSecret(), $privateKey);
                    echo "clientSecret: ", $clientSecret, PHP_EOL;
                }
            } else {
                echo "finalResponse: ", $response->getResponseMessage(), PHP_EOL;
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