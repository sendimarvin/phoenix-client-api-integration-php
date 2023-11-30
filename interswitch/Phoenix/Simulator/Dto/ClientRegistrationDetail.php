<?php

namespace Interswitch\Phoenix\Simulator\Dto;

class ClientRegistrationDetail extends ClientTerminalRequest {
    private $name;
    private $phoneNumber;
    private $nin;
    private $gender;
    private $emailAddress;
    private $ownerPhoneNumber;
    private $publicKey;
    private $clientSessionPublicKey;

    public function getClientSessionPublicKey() {
        return $this->clientSessionPublicKey;
    }

    public function setClientSessionPublicKey($clientSessionPublicKey) {
        $this->clientSessionPublicKey = $clientSessionPublicKey;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getNin() {
        return $this->nin;
    }

    public function setNin($nin) {
        $this->nin = $nin;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getEmailAddress() {
        return $this->emailAddress;
    }

    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    public function getOwnerPhoneNumber() {
        return $this->ownerPhoneNumber;
    }

    public function setOwnerPhoneNumber($ownerPhoneNumber) {
        $this->ownerPhoneNumber = $ownerPhoneNumber;
    }

    public function getPublicKey() {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey) {
        $this->publicKey = $publicKey;
    }
}
?>