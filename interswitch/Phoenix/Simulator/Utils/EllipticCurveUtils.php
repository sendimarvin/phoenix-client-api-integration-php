<?php

namespace Interswitch\Phoenix\Simulator\Utils;

use phpseclib3\Crypt\EC;
use phpseclib3\Crypt\ECDSA;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;

class EllipticCurveUtils
{
    private const ELIPTIC_CURVE_PRIME256 = 'prime256v1';
    private string $protocol;

    public function __construct(string $protocol)
    {
        $this->protocol = $protocol;
    }

    public function loadPublicKey(string $data)
    {
        $ec = new EC($this->protocol);
        $ec->loadPublicKey($data);
        return PublicKeyLoader::load($ec);
    }

    public function loadPrivateKey(string $data)
    {
        $ec = new EC($this->protocol);
        $ec->loadPrivateKey($data);
        return $ec;
    }

    public static function savePrivateKey(EC $key)
    {
        return $key->getPrivateKey()->toBytes();
    }

    public static function savePublicKey(EC $key)
    {
        return $key->getPublicKey()->toBytes(true);
    }

    public static function getSignature(string $plaintext, EC $privateKey)
    {
        $ecdsaSign = new ECDSA('sha256');
        $ecdsaSign->setPrivateKey($privateKey->getPrivateKey());
        $ecdsaSign->update($plaintext);
        return base64_encode($ecdsaSign->sign());
    }

    public function doECDH(string $privateKey, string $publicKey)
    {
        $ecdh = new EC('prime256v1');
        $ecdh->loadPrivateKey(base64_decode($privateKey));
        $ecdh->loadPublicKey(base64_decode($publicKey));
        return base64_encode($ecdh->computeSecret());
    }

    public function generateKeypair()
    {
        // $ec = new EC('prime256v1');
        // $ec->setPrivateKeyFormat(EC::FORMAT_ASN1);


        $privateKey = \phpseclib3\Crypt\EC::createKey('prime256v1');
        $publicKey = $privateKey->getPublicKey();

        // $privateKey = $ec->createKey();
        // $publicKey = $ec->getPublicKey();
        return [$privateKey, $publicKey];
    }

    public function getPrivateKey(EC $key)
    {
        return base64_encode(self::savePrivateKey($key));
    }

    public function getPublicKey(EC $key)
    {
        return base64_encode(self::savePublicKey($key));
    }
}