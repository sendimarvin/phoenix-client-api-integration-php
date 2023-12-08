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

        // $pair = CryptoUtils::generateKeyPair();

        [$privateKey, $publicKey] = CryptoUtils::generateKeyPair();
        // $privateKey = base64_encode($privateKey);
        // $publicKey = base64_encode($publicKey);

        echo " private key ", $privateKey, PHP_EOL;
        echo " public key  ", $publicKey, PHP_EOL;

        $curveUtils = new EllipticCurveUtils("ECDH");
        [$curvePrivateKey, $curvePublicKey ] = $curveUtils->generateKeypair();
        // $curvePrivateKey = $curveUtils->getPrivateKey($keyPair);
        // $curvePublicKey = $curveUtils->getPublicKey($keyPair);

        // print_r(PhoenixResponseCodes::APPROVED['CODE']);
        // die();
        $response = self::clientRegistrationRequest($publicKey, $curvePublicKey, $privateKey);

        // $response = json_decode($response);

        // print_r($response);
        // die();

        $registrationResponse = UtilMethods::unMarshallSystemResponseObject($response, ClientRegistrationResponse::class);

        
        // print_r($registrationResponse);
        // die();
        if ($registrationResponse->responseCode !== PhoenixResponseCodes::APPROVED['CODE']) {
            echo "Client Registration failed: ", $registrationResponse->responseMessage, PHP_EOL;
        } else {
            // echo "==============terminalKey==============", PHP_EOL;
            // echo "==============terminalKey==============", PHP_EOL;
            // echo "==============terminalKey==============", PHP_EOL;
            // print_r($privateKey);
            // die();
            $decryptedSessionKey = CryptoUtils::decryptWithPrivate($registrationResponse->response->serverSessionPublicKey, $privateKey);
            $terminalKey = $curveUtils->doECDH($curvePrivateKey, $decryptedSessionKey);
            echo "==============terminalKey==============", PHP_EOL;
            echo "terminalKey: ", $terminalKey, PHP_EOL;
            $authToken = CryptoUtils::decryptWithPrivate($registrationResponse->response->authToken, $privateKey);

            // echo "==============authToken==============", PHP_EOL;
            // print_r($authToken);
            // die();

            echo " authToken ", $authToken, PHP_EOL;
            $transactionReference = $registrationResponse->response->transactionReference;
            echo "Enter received OTP: ", PHP_EOL;
            $otp = readline();
            echo "OTP Entered: ", $otp, PHP_EOL;

            die();
            $finalResponse = self::completeRegistration($terminalKey, $authToken, $transactionReference, $otp, $privateKey);

            $response = UtilMethods::unMarshallSystemResponseObject($finalResponse, LoginResponse::class);
            if ($response->getResponseCode() === PhoenixResponseCodes::APPROVED['CODE']) {
                if ($response->getResponse()->getClientSecret() !== null && strlen($response->response->clientSecret) > 5) {
                    $clientSecret = CryptoUtils::decryptWithPrivate($response->response->clientSecret, $privateKey);
                    echo "clientSecret: ", $clientSecret, PHP_EOL;
                }
            } else {
                echo "finalResponse: ", $response->responseMessage, PHP_EOL;
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
        $setup->setRequestReference(self::generateUUID());
        $setup->setTerminalId(Constants::TERMINAL_ID);
        $setup->setGprsCoordinate("");
        $setup->setClientSessionPublicKey($clientSessionPublicKey);

        $headers = AuthUtils::generateInterswitchAuth(Constants::POST_REQUEST, self::$registrationEndpointUrl, "", "", "", $privateKey);
        $json = $setup;


        // print_r($json);
        // die();

        return HttpUtil::postHTTPRequest(self::$registrationEndpointUrl, $headers, $json);
    }

    private static function completeRegistration($terminalKey, $authToken, $transactionReference, $otp, $privateKey)
    {
        $completeReg = new CompleteClientRegistration();

        $passwordHash = UtilMethods::hash512(Constants::ACCOUNT_PWD);

        $completeReg->setTerminalId(Constants::TERMINAL_ID);
        $completeReg->setSerialId(Constants::MY_SERIAL_ID);
        $completeReg->setOtp(CryptoUtils::encrypt($otp, $terminalKey));
        $completeReg->setRequestReference(self::generateUUID());
        $completeReg->setPassword(CryptoUtils::encrypt($passwordHash, $terminalKey));
        $completeReg->setTransactionReference($transactionReference);
        $completeReg->setAppVersion(Constants::APP_VERSION);
        $completeReg->setGprsCoordinate("");

        $headers = AuthUtils::generateInterswitchAuth(Constants::POST_REQUEST, self::$registrationCompletionEndpointUrl, "", $authToken, $terminalKey, $privateKey);
        $json = JsonDataTransform::marshall($completeReg);

        return HttpUtil::postHTTPRequest(self::$registrationCompletionEndpointUrl, $headers, $json);
    }


    static function generateUUID() {
        if (function_exists('uuid_create')) {
            $uuid = uuid_create(UUID_TYPE_RANDOM);
    
            // Convert binary UUID to string representation
            $uuidString = bin2hex(uuid_parse($uuid));
    
            // Format UUID as per RFC 4122 (e.g., xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx)
            $formattedUUID = sprintf(
                '%s-%s-%s-%s-%s',
                substr($uuidString, 0, 8),
                substr($uuidString, 8, 4),
                substr($uuidString, 12, 4),
                substr($uuidString, 16, 4),
                substr($uuidString, 20)
            );
    
            return $formattedUUID;
        } else {
            // Fallback if uuid_create function is not available
            return uniqid();
        }
    }
}