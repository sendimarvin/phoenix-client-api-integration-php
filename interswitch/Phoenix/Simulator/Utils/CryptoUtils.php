<?php

namespace Interswitch\Phoenix\Simulator\Utils;

use Exception;

class CryptoUtils
{
    private static $LOG;

    public static function encrypt($plaintext, $terminalKey)
    {
        try {
            self::initialize();
            $message = utf8_encode($plaintext);
            $iv = openssl_random_pseudo_bytes(16);
            $cipherText = openssl_encrypt($message, 'aes-256-cbc', base64_decode($terminalKey), 0, $iv);
            $encryptedValue = $iv . $cipherText;
            return base64_encode($encryptedValue);
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to encrypt object");
        }
    }

    public static function decrypt($encryptedValue, $terminalKey)
    {
        try {
            $encryptedValue = base64_decode($encryptedValue);
            $iv = substr($encryptedValue, 0, 16);
            $cipherText = substr($encryptedValue, 16);
            $decryptedValue = openssl_decrypt($cipherText, 'aes-256-cbc', base64_decode($terminalKey), 0, $iv);
            return utf8_decode($decryptedValue);
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to decrypt object");
        }
    }

    public static function decryptWithPrivate($plaintext)
    {
        try {
            self::initialize();
            $message = base64_decode($plaintext);
            openssl_private_decrypt($message, $decrypted, self::getRSAPrivate());
            return utf8_decode($decrypted);
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to decryptWithPrivate ");
        }
    }

    public static function decryptWithPrivateBytes($message, $privateKey)
    {
        try {
            self::initialize();
            openssl_private_decrypt($message, $decrypted, $privateKey);
            return utf8_decode($decrypted);
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to decryptWithPrivate ");
        }
    }

    public static function decryptWithPrivateString($plaintext, $privateKey)
    {
        $message = base64_decode($plaintext);
        return self::decryptWithPrivateBytes($message, $privateKey);
    }

    public static function encryptWithPrivate($plaintext)
    {
        try {
            self::initialize();
            $message = utf8_encode($plaintext);
            openssl_private_encrypt($message, $encrypted, self::getRSAPrivate());
            return base64_encode($encrypted);
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to encryptWithPrivate ");
        }
    }

    public static function getRSAPrivate()
    {
        return self::getRSAPrivate(Constants::PRIKEY);
    }

    public static function getRSAPrivateString($privateKey)
    {
        return self::getRSAPrivate($privateKey);
    }

    public static function getRSAPrivate($privateKey)
    {
        try {
            $keyResource = openssl_get_privatekey($privateKey);
            if ($keyResource === false) {
                throw new Exception("Failed to get private key");
            }
            return $keyResource;
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to getRSAPrivate ");
        }
    }

    public static function signWithPrivateKey($data, $privateKey)
    {
        try {
            if ($data === "") {
                return "";
            }
            openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            return utf8_decode(base64_encode($signature));
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to signWithPrivateKey ");
        }
    }

    public static function verifySignature($signature, $message, $publicKey)
    {
        try {
            $pubKey = self::getPublicKey($publicKey);
            $result = openssl_verify($message, base64_decode($signature), $pubKey, OPENSSL_ALGO_SHA256);
            return $result === 1;
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to verifySignature ");
        }
    }

    public static function getPublicKey($publicKeyContent)
    {
        try {
            $keyResource = openssl_get_publickey($publicKeyContent);
            if ($keyResource === false) {
                throw new Exception("Failed to get public key");
            }
            return $keyResource;
        } catch (Exception $e) {
            self::handleException($e, PhoenixResponseCodes::INTERNAL_ERROR['CODE'], "Failure to getPublicKey ");
        }
    }

    public static function generateKeyPair()
    {
        throw new Exception("Key pair generation not implemented in OpenSSL");
    }

    private static function initialize()
    {
        if (!isset(self::$LOG)) {
            self::$LOG = LoggerFactory::getLogger(self::class);
        }
    }

    private static function handleException($exception, $errorCode, $errorMessage)
    {
        self::$LOG->error("Exception trace: {}", $exception->getTraceAsString());
        throw new SystemApiException($errorCode, $errorMessage);
    }
}