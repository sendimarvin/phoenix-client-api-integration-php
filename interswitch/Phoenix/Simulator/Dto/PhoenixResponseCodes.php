<?php

namespace Interswitch\Phoenix\Simulator\Dto;

class PhoenixResponseCodes 
{
    const NONEXISTENT_TRANSACTION = array("90025", "NON EXISTENT TRANSACTION", "25");
    const INTERNAL_ERROR = array("90096", "AN ERROR OCCURED", "96");
    const AUTHORIZATION_ERROR = array("90063", "AUTHORIZATION ERROR", "63");
    const ROUTING_ERROR = array("90092", "ROUTING_ERROR", "92");
    const EXPIRED_TOKEN = array("90054", "EXPIRED TIN/PIN/TOKEN  OR OTP", "54");
    const APPROVED = array("90000", "TRANSACTION APPROVED", "00");
    const DEPRECATED_APPROVED = array("9000", "TRANSACTION APPROVED", "00");
    const TRANSACTION_SENT = array("90001", "TRANSACTION APPROVED", "09");
    const DUPLICATE_REFERENCE = array("90026", "DUPLICATE REQUEST REFERENCE", "26");
    const DUPLICATE_RECORD = array("90026", "DUPLICATE RECORD", "26");
    const ISSUER_INNOPERATIVE = array("90091", "REMOTE SYSTEM TEMPORARILY UNAVAILABLE", "91");
    const EXCEEDS_CONFIGURED_LIMIT = array("90098", "EXCEEDS CONFIGURED LIMIT", "98");
    const REQUEST_IN_PROGRESS = array("90009", "REQUEST IN PROGRESS", "09");
    const DECLINED = array("90020", "TRANSACTION DECLINED BY BILLER", "20");
    const SUSUPECTED_DUPLICATE = array("90094", "REJECTED AS SUSPECT DUPLICATE", "94");
    const SUSUPECTED_FRAUD = array("90059", "REJECTED AS SUSPECT DUPLICATE/FRAUD", "59");
    const ERROR_RESPONSE_FROM_HOST = array("90006", "ERROR RESPONSE FROM HOST", "06");
    const INVALID_AMOUNT = array("90013", "INVALID_AMOUNT", "13");
    const UN_RECOGNIZABLE_CUSTOMER_NUMBER = array("90052", "UN RECOGNIZABLE CUSTOMER NUMBER", "12");
    const MISSING_PHONE_NUMBER = array("900A9", "MISSING_PHONE_NUMBER", "12");
    const UN_ACCEPTABLE_TRANSACTION_FEE = array("90023", "UN ACCEPTABLE TRANSACTION FEE", "23");
    const INSUFFICIENT_FUNDS = array("90051", "INSUFFICIENT FUNDS", "51");
    const WRONG_PIN_OR_OTP = array("90055", "WRONG PIN OR OTP", "55");
    const FORMAT_ERROR = array("90030", "FORMAT ERROR", "30");

    const INVALID_PAYMENT_CODE = array("70017", "INVALID PAYMENT ITEM", "96");
    const INVALID_REQUEST_REFERENCE = array("70018", "INVALID OR DUPLICATE REQUEST REFERENCE", "12");
    const SECURITY_CONFIGURATION_REQUIRED = array("700A5", "SECURITY CONFIGURATION REQUIRED ", "A5");
    const PASSWORD_CHANGE_REQUIRED = array("700A6", "PASSWORD CHANGE REQUIRED ", "A6");
    const DATA_NOT_FOUND = array("70038", "DATA NOT FOUND", "38");
    const ACCOUNT_NOT_FOUND = array("90052", "ACCOUNT NOT FOUND", "52");
    const SAVINGS_ACCOUNT_NOT_FOUND = array("70053", "ACCOUNT NOT FOUND", "53");
    const INCORRECT_FEE_SETUP = array("70037", "INCORRECT FEE SETUP", "37");
    const TERMINAL_OWNER_NOT_SET_UP = array("70030", "TERMINAL OWNER NOT SETUP OR CONFIGURED FOR THIS ACTION", "30");
    const UNRECOGNISED_ISSUER = array("70031", "UNRECOGNIZED ISSUER ", "31");
    const BILLER_NOT_FOUND = array("70010", "BILLER NOT FOUND", "10");
    const BILLER_NOT_ENABLED_FOR_CHANNEL = array("70026", "BILLER  NOT ENABLED FOR CHANNEL", "26");
    const ISSUER_NOT_ENABLED_FOR_BILLER = array("70027", "ISSUER NOT ENABLED FOR BILLER", "27");
    const TERMINAL_OWNER_NOT_ENABLED_FOR_BILLER = array("70028", "TERMINAL OWNER NOT ENABLED FOR BILLER", "28");
    const TERMINAL_OWNER_NOT_ENABLED_FOR_CHANNEL = array("70029", "TERMINAL OWNER NOT ENABLED FOR CHANNEL", "29");
    const TRANSACTION_NOT_PERMITTED = array("70058", "TRANSACTION NOT PERMITTED", "58");
    const NO_CARD_RECORD = array("70056", "NO CARD RECORD ", "56");
    const EXPIRED_CARD = array("70054", "EXPIRED CARD ", "54");
    const TRANSACTION_NOT_PERMITED_TO_CARD = array("70057", "TRANSACTION NOT PERMITTED TO CARDHOLDER", "57");
    const PIN_TRIES_EXCEEDED = array("70038", "PIN TRIES EXCEEDED ", "38");
    const EXCEEDS_WITHDRAWAL_LIMIT = array("70061", "EXCEEDS WITHDRAWAL LIMIT", "61");
    const RESPONSE_RECEIVED_TOO_LATE = array("90009", "RESPONSE RECEIVED TOO LATE", "68");

    public $CODE;
    public $MESSAGE;
    public $SWITCH_ERROR_CODE;

    function __construct($code, $message, $switcherrorCode)
    {
        $this->CODE = $code;
        $this->MESSAGE = $message;
        $this->SWITCH_ERROR_CODE = $switcherrorCode;
    }

    /**
     * these errors happen within isw systems
     * @return
     */
    public static function getInternalResponseCodes()
    {
        $internalCodes = array();
        array_push($internalCodes, self::AUTHORIZATION_ERROR['CODE']);
        array_push($internalCodes, self::INTERNAL_ERROR['CODE']);
        array_push($internalCodes, self::ERROR_RESPONSE_FROM_HOST['CODE']);
        array_push($internalCodes, self::ISSUER_INNOPERATIVE['CODE']);
        array_push($internalCodes, self::ROUTING_ERROR['CODE']);
        return $internalCodes;
    }

    public static function retrieveMessage($code)
    {
        foreach (self::values() as $value) {
            if (strcasecmp($value['CODE'], $code) == 0) {
                return $value['MESSAGE'];
            }
        }
        return "";
    }

    public static function retrieveSwitchCode($code)
    {
        foreach (self::values() as $value) {
            if (strcasecmp($value['CODE'], $code) == 0) {
                return $value['SWITCH_ERROR_CODE'];
            }
        }
        return "";
    }

    public static function retrieveBasedOnSwitchCode($code)
    {
        foreach (self::values() as $value) {
            if (strcasecmp($value['SWITCH_ERROR_CODE'], $code) == 0) {
                return $value['CODE'];
            }
        }
        return self::DECLINED['CODE'];
    }

    public static function values()
    {
        return [
            self::NONEXISTENT_TRANSACTION,
            self::INTERNAL_ERROR,
            self::AUTHORIZATION_ERROR,
            self::ROUTING_ERROR,
            self::EXPIRED_TOKEN,
            self::APPROVED,
            self::DEPRECATED_APPROVED,
            self::TRANSACTION_SENT,
            self::DUPLICATE_REFERENCE,
            self::DUPLICATE_RECORD,
            self::ISSUER_INNOPERATIVE,
            self::EXCEEDS_CONFIGURED_LIMIT,
            self::REQUEST_IN_PROGRESS,
            self::DECLINED,
            self::SUSUPECTED_DUPLICATE,
            self::SUSUPECTED_FRAUD,
            self::ERROR_RESPONSE_FROM_HOST,
            self::INVALID_AMOUNT,
            self::UN_RECOGNIZABLE_CUSTOMER_NUMBER,
            self::MISSING_PHONE_NUMBER,
            self::UN_ACCEPTABLE_TRANSACTION_FEE,
            self::INSUFFICIENT_FUNDS,
            self::WRONG_PIN_OR_OTP,
            self::FORMAT_ERROR,
            self::INVALID_PAYMENT_CODE,
            self::INVALID_REQUEST_REFERENCE,
            self::SECURITY_CONFIGURATION_REQUIRED,
            self::PASSWORD_CHANGE_REQUIRED,
            self::DATA_NOT_FOUND,
            self::ACCOUNT_NOT_FOUND,
            self::SAVINGS_ACCOUNT_NOT_FOUND,
            self::INCORRECT_FEE_SETUP,
            self::TERMINAL_OWNER_NOT_SET_UP,
            self::UNRECOGNISED_ISSUER,
            self::BILLER_NOT_FOUND,
            self::BILLER_NOT_ENABLED_FOR_CHANNEL,
            self::ISSUER_NOT_ENABLED_FOR_BILLER,
            self::TERMINAL_OWNER_NOT_ENABLED_FOR_BILLER,
            self::TERMINAL_OWNER_NOT_ENABLED_FOR_CHANNEL,
            self::TRANSACTION_NOT_PERMITTED,
            self::NO_CARD_RECORD,
            self::EXPIRED_CARD,
            self::TRANSACTION_NOT_PERMITED_TO_CARD,
            self::PIN_TRIES_EXCEEDED,
            self::EXCEEDS_WITHDRAWAL_LIMIT,
            self::RESPONSE_RECEIVED_TOO_LATE
        ];
    }
}