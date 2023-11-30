<?php

namespace Interswitch\Phoenix\Simulator\Utils;

use phpseclib\Crypt\AES;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;

class CryptoUtils
{
    public static function encrypt($plaintext, $terminalKey)
    {
        try {
            \phpseclib3\Crypt\AES::register();
            $message = \phpseclib3\Helper::str2bin($plaintext);
            $iv = Hex::decode(UtilMethods::randomBytesHexEncoded(16));
            $ivParameterSpec = new \phpseclib3\Crypt\AES\MODE_CBC($iv);
            $cipher = new \phpseclib3\Crypt\AES();
            $keyBytes = Base64::decode($terminalKey);
            $cipher->setKey($keyBytes);
            $cipher->setIV($iv);
            $secret = $iv . $cipher->encrypt($message);
            return Base64::encode($secret);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function decrypt($encryptedValue, $terminalKey)
    {
        try {
            $secretKeyBytes = Base64::decode($terminalKey);
            $iv = \phpseclib3\Helper::subStr($encryptedValue, 0, 16);
            $encryptedValue = \phpseclib3\Helper::subStr($encryptedValue, 16);
            $ivParameterSpec = new \phpseclib3\Crypt\AES\MODE_CBC($iv);
            $cipher = new \phpseclib3\Crypt\AES();
            $cipher->setKey($secretKeyBytes);
            $cipher->setIV($iv);
            $clear = $cipher->decrypt($encryptedValue);
            return $clear;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function decryptWithPrivate($plaintext)
    {
        try {
            $rsa = new RSA();
            $rsa->setPrivateKey(getRSAPrivate());
            $message = Base64::decode($plaintext);
            $rsa->load($rsa->getPrivateKey());
            $secret = $rsa->decrypt($message);
            return $secret;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function decryptWithPrivateBytes($message, $privateKey)
    {
        try {
            $rsa = new RSA();
            $rsa->setPrivateKey($privateKey);
            $rsa->load($rsa->getPrivateKey());
            $secret = $rsa->decrypt($message);
            return $secret;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function decryptWithPrivateString($plaintext, $privateKey)
    {
        $message = Base64::decode($plaintext);
        return decryptWithPrivateBytes($message, getRSAPrivate($privateKey));
    }

    public static function encryptWithPrivate($plaintext)
    {
        try {
            $rsa = new RSA();
            $rsa->setPrivateKey(getRSAPrivate());
            $message = $plaintext;
            $rsa->load($rsa->getPrivateKey());
            $secret = $rsa->encrypt($message);
            return Base64::encode($secret);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function getRSAPrivate($privateKey = null)
    {
        try {
            $keyBytes = Base64::decode(trim($privateKey));
            $spec = new PKCS8($keyBytes);
            $rsa = new RSA();
            $rsa->load($spec->getPrivateKey());
            return $rsa->getPrivateKey();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function signWithPrivateKeyString($data, $privateKey)
    {
        return signWithPrivateKey($data, getRSAPrivate($privateKey));
    }

    public static function signWithPrivateKey($data, $privateKey = null)
    {

        if (isnull($privateKey))
        return signWithPrivateKey($data, getRSAPrivate());

        try {
            if (empty($data)) {
                return '';
            }
            $rsa = new RSA();
            $rsa->setPrivateKey($privateKey);
            $rsa->load($rsa->getPrivateKey());
            $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
            $signature = $rsa->sign($data);
            return Base64::encode($signature);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function verifySignatureX($signature, $message)
    {
        $pubKey = getPublicKey(Constants::PUBKEY);
        return verifySignature($signature, $message, $pubKey);
    }

    public static function verifySignatureString($signature, $message, $publicKey)
    {
        $pubKey = getPublicKey($publicKey);
        return verifySignature($signature, $message, $pubKey);
    }

    public static function verifySignature($signature, $message, $pubKey = null)
    {

        if (isnull($pubKey ))
        return verifySignatureX($signature, $message);

        try {
            $rsa = new RSA();
            $rsa->setPublicKey($pubKey);
            $rsa->load($rsa->getPublicKey());
            $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
            $isVerified = $rsa->verify($message, $signature);
            return $isVerified;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function generateKeyPair()
    {
        try {
            $rsa = new RSA();
            $keyPair = $rsa->createKey(2048);
            return $keyPair;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function getPublicKey($publicKeyContent)
    {
        try {
            $key = Base64::decode($publicKeyContent);
            $rsa = new RSA();
            $rsa->setPublicKey($key);
            $rsa->load($rsa->getPublicKey());
            return $rsa->getPublicKey();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
