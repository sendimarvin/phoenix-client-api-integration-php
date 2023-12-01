<?php

namespace Interswitch\Phoenix\Simulator\Dto;

class ClientTerminalRequest 
{
    public $terminalId;
    public $appVersion;
    public $serialId;
    public $requestReference;
    public $gprsCoordinate;

    public function getGprsCoordinate() {
        return $this->gprsCoordinate;
    }

    public function setGprsCoordinate($gprsCoordinate) {
        $this->gprsCoordinate = $gprsCoordinate;
    }

    public function getTerminalId() {
        return $this->terminalId;
    }

    public function setTerminalId($terminalId) {
        $this->terminalId = $terminalId;
    }

    public function getAppVersion() {
        return $this->appVersion;
    }

    public function setAppVersion($appVersion) {
        $this->appVersion = $appVersion;
    }

    public function getSerialId() {
        return $this->serialId;
    }

    public function setSerialId($serialId) {
        $this->serialId = $serialId;
    }

    public function getRequestReference() {
        return $this->requestReference;
    }

    public function setRequestReference($requestReference) {
        $this->requestReference = $requestReference;
    }
}
