<?php

namespace Interswitch\Phoenix\Simulator\Utils;

use Exception;

class SystemApiException extends Exception 
{
    private $responseMessage;
    private $responseCode;
    private $exception;

    public function __construct($code, $message, $exception = null) 
    {
        parent::__construct();
        $this->responseMessage = $message;
        $this->responseCode = $code;
        $this->exception = $exception;
    }

    public function getException() 
    {
        return $this->exception;
    }

    public function setException($exception) 
    {
        $this->exception = $exception;
    }

    public function getErrorMessage() 
    {
        return $this->responseMessage;
    }

    public function getErrorCode() 
    {
        return $this->responseCode;
    }
}
