<?php

namespace Interswitch\Phoenix\Simulator\Dto;

class PhoenixResponseCodes 
{
    const NONEXISTENT_TRANSACTION = [
        "CODE" => "90025",
        "MESSAGE" => "NON EXISTENT TRANSACTION",
        "SWITCH_ERROR_CODE" => "25",
    ];

    const INTERNAL_ERROR = [
        "CODE" => "90096",
        "MESSAGE" => "AN ERROR OCCURRED",
        "SWITCH_ERROR_CODE" => "96",
    ];

    const AUTHORIZATION_ERROR = [
        "CODE" => "90063",
        "MESSAGE" => "AUTHORIZATION ERROR",
        "SWITCH_ERROR_CODE" => "63",
    ];

    const ROUTING_ERROR = [
        "CODE" => "90092",
        "MESSAGE" => "ROUTING ERROR",
        "SWITCH_ERROR_CODE" => "92",
    ];

    const EXPIRED_TOKEN = [
        "CODE" => "90054",
        "MESSAGE" => "EXPIRED TIN/PIN/TOKEN OR OTP",
        "SWITCH_ERROR_CODE" => "54",
    ];

    const APPROVED = [
        "CODE" => "90000",
        "MESSAGE" => "TRANSACTION APPROVED",
        "SWITCH_ERROR_CODE" => "00",
    ];

    const DEPRECATED_APPROVED = [
        "CODE" => "9000",
        "MESSAGE" => "TRANSACTION APPROVED",
        "SWITCH_ERROR_CODE" => "00",
    ];

    const TRANSACTION_SENT = [
        "CODE" => "90001",
        "MESSAGE" => "TRANSACTION APPROVED",
        "SWITCH_ERROR_CODE" => "09",
    ];

    const DUPLICATE_REFERENCE = [
        "CODE" => "90026",
        "MESSAGE" => "DUPLICATE REQUEST REFERENCE",
        "SWITCH_ERROR_CODE" => "26",
    ];

    const DUPLICATE_RECORD = [
        "CODE" => "90026",
        "MESSAGE" => "DUPLICATE RECORD",
        "SWITCH_ERROR_CODE" => "26",
    ];

    const ISSUER_INNOPERATIVE = [
        "CODE" => "90091",
        "MESSAGE" => "REMOTE SYSTEM TEMPORARILY UNAVAILABLE",
        "SWITCH_ERROR_CODE" => "91",
    ];

    const EXCEEDS_CONFIGURED_LIMIT = [
        "CODE" => "90098",
        "MESSAGE" => "EXCEEDS CONFIGURED LIMIT",
        "SWITCH_ERROR_CODE" => "98",
    ];

    const REQUEST_IN_PROGRESS = [
        "CODE" => "90009",
        "MESSAGE" => "REQUEST IN PROGRESS",
        "SWITCH_ERROR_CODE" => "09",
    ];

    const DECLINED = [
        "CODE" => "90020",
        "MESSAGE" => "TRANSACTION DECLINED BY BILLER",
        "SWITCH_ERROR_CODE" => "20",
    ];

    const SUSPECTED_DUPLICATE = [
        "CODE" => "90094",
        "MESSAGE" => "REJECTED AS SUSPECT DUPLICATE",
        "SWITCH_ERROR_CODE" => "94",
    ];

    const SUSPECTED_FRAUD = [
        "CODE" => "90059",
        "MESSAGE" => "REJECTED AS SUSPECT DUPLICATE/FRAUD",
        "SWITCH_ERROR_CODE" => "59",
    ];

    const ERROR_RESPONSE_FROM_HOST = [
        "CODE" => "90006",
        "MESSAGE" => "ERROR RESPONSE FROM HOST",
        "SWITCH_ERROR_CODE" => "06",
    ];

    const INVALID_AMOUNT = [
        "CODE" => "90013",
        "MESSAGE" => "INVALID AMOUNT",
        "SWITCH_ERROR_CODE" => "13",
    ];

    const UN_RECOGNIZABLE_CUSTOMER_NUMBER = [
        "CODE" => "90052",
        "MESSAGE" => "UN RECOGNIZABLE CUSTOMER NUMBER",
        "SWITCH_ERROR_CODE" => "12",
    ];

    const MISSING_PHONE_NUMBER = [
        "CODE" => "900A9",
        "MESSAGE" => "MISSING PHONE NUMBER",
        "SWITCH_ERROR_CODE" => "12",
    ];

    const UN_ACCEPTABLE_TRANSACTION_FEE = [
        "CODE" => "90023",
        "MESSAGE" => "UNACCEPTABLE TRANSACTION FEE",
        "SWITCH_ERROR_CODE" => "23",
    ];

    const INSUFFICIENT_FUNDS = [
        "CODE" => "90051",
        "MESSAGE" => "INSUFFICIENT FUNDS",
        "SWITCH_ERROR_CODE" => "51",
    ];

    const WRONG_PIN_OR_OTP = [
        "CODE" => "90055",
        "MESSAGE" => "WRONG PIN OR OTP",
        "SWITCH_ERROR_CODE" => "55",
    ];

    const FORMAT_ERROR = [
        "CODE" => "90030",
        "MESSAGE" => "FORMAT ERROR",
        "SWITCH_ERROR_CODE" => "30",
    ];

    const INVALID_PAYMENT_CODE = [
        "CODE" => "70017",
        "MESSAGE" => "INVALID PAYMENT ITEM",
        "SWITCH_ERROR_CODE" => "96",
    ];

    const INVALID_REQUEST_REFERENCE = [
        "CODE" => "70018",
        "MESSAGE" => "INVALID OR DUPLICATE REQUEST REFERENCE",
        "SWITCH_ERROR_CODE" => "12",
    ];

    const SECURITY_CONFIGURATION_REQUIRED = [
        "CODE" => "700A5",
        "MESSAGE" => "SECURITY CONFIGURATION REQUIRED",
        "SWITCH_ERROR_CODE" => "A5",
    ];

    const PASSWORD_CHANGE_REQUIRED = [
        "CODE" => "700A6",
        "MESSAGE" => "PASSWORD CHANGE REQUIRED",
        "SWITCH_ERROR_CODE" => "A6",
    ];

    const DATA_NOT_FOUND = [
        "CODE" => "70038",
        "MESSAGE" => "DATA NOT FOUND",
        "SWITCH_ERROR_CODE" => "38",
    ];

    const ACCOUNT_NOT_FOUND = [
        "CODE" => "90052",
        "MESSAGE" => "ACCOUNT NOT FOUND",
        "SWITCH_ERROR_CODE" => "52",
    ];

    const SAVINGS_ACCOUNT_NOT_FOUND = [
        "CODE" => "70053",
        "MESSAGE" => "SAVINGS ACCOUNT NOT FOUND",
        "SWITCH_ERROR_CODE" => "53",
    ];

    const INCORRECT_FEE_SETUP = [
        "CODE" => "70037",
        "MESSAGE" => "INCORRECT FEE SETUP",
        "SWITCH_ERROR_CODE" => "37",
    ];

    const TERMINAL_OWNER_NOT_SET_UP = [
        "CODE" => "70030",
        "MESSAGE" => "TERMINAL OWNER NOT SET UP OR CONFIGURED FOR THIS ACTION",
        "SWITCH_ERROR_CODE" => "30",
    ];

    const UNRECOGNIZED_ISSUER = [
        "CODE" => "70031",
        "MESSAGE" => "UNRECOGNIZED ISSUER",
        "SWITCH_ERROR_CODE" => "31",
    ];

    const BILLER_NOT_FOUND = [
        "CODE" => "70010",
        "MESSAGE" => "BILLER NOT FOUND",
        "SWITCH_ERROR_CODE" => "10",
    ];

    const BILLER_NOT_ENABLED_FOR_CHANNEL = [
        "CODE" => "70026",
        "MESSAGE" => "BILLER NOT ENABLED FOR CHANNEL",
        "SWITCH_ERROR_CODE" => "26",
    ];

    const ISSUER_NOT_ENABLED_FOR_BILLER = [
        "CODE" => "70027",
        "MESSAGE" => "ISSUER NOT ENABLED FOR BILLER",
        "SWITCH_ERROR_CODE" => "27",
    ];

    const TERMINAL_OWNER_NOT_ENABLED_FOR_BILLER = [
        "CODE" => "70028",
        "MESSAGE" => "TERMINAL OWNER NOT ENABLED FOR BILLER",
        "SWITCH_ERROR_CODE" => "28",
    ];

    const TERMINAL_OWNER_NOT_ENABLED_FOR_CHANNEL = [
        "CODE" => "70029",
        "MESSAGE" => "TERMINAL OWNER NOT ENABLED FOR CHANNEL",
        "SWITCH_ERROR_CODE" => "29",
    ];

    const TRANSACTION_NOT_PERMITTED = [
        "CODE" => "70058",
        "MESSAGE" => "TRANSACTION NOT PERMITTED",
        "SWITCH_ERROR_CODE" => "58",
    ];

    const NO_CARD_RECORD = [
        "CODE" => "70056",
        "MESSAGE" => "NO CARD RECORD",
        "SWITCH_ERROR_CODE" => "56",
    ];

    const EXPIRED_CARD = [
        "CODE" => "70054",
        "MESSAGE" => "EXPIRED CARD",
        "SWITCH_ERROR_CODE" => "54",
    ];

    const TRANSACTION_NOT_PERMITTED_TO_CARD = [
        "CODE" => "70057",
        "MESSAGE" => "TRANSACTION NOT PERMITTED TO CARDHOLDER",
        "SWITCH_ERROR_CODE" => "57",
    ];

    const PIN_TRIES_EXCEEDED = [
        "CODE" => "70038",
        "MESSAGE" => "PIN TRIES EXCEEDED",
        "SWITCH_ERROR_CODE" => "38",
    ];

    const EXCEEDS_WITHDRAWAL_LIMIT = [
        "CODE" => "70061",
        "MESSAGE" => "EXCEEDS WITHDRAWAL LIMIT",
        "SWITCH_ERROR_CODE" => "61",
    ];

    const RESPONSE_RECEIVED_TOO_LATE = [
        "CODE" => "90009",
        "MESSAGE" => "RESPONSE RECEIVED TOO LATE",
        "SWITCH_ERROR_CODE" => "68",
    ];

    public $CODE;
    public $MESSAGE;
    public $SWITCH_ERROR_CODE;

    public function __construct($code, $message, $switchErrorCode)
    {
        $this->CODE = $code;
        $this->MESSAGE = $message;
        $this->SWITCH_ERROR_CODE = $switchErrorCode;
    }

    public static function getInternalResponseCodes()
    {
        return [
            self::AUTHORIZATION_ERROR['CODE'],
            self::INTERNAL_ERROR['CODE'],
            self::ERROR_RESPONSE_FROM_HOST['CODE'],
            self::ISSUER_INNOPERATIVE['CODE'],
            self::ROUTING_ERROR['CODE'],
        ];
    }

    public static function retrieveMessage($code)
    {
        return self::retrieveValue($code, 'MESSAGE');
    }

    public static function retrieveSwitchCode($code)
    {
        return self::retrieveValue($code, 'SWITCH_ERROR_CODE');
    }

    public static function retrieveBasedOnSwitchCode($code)
    {
        return self::retrieveValueBySwitchCode($code, 'CODE');
    }

    public static function values()
    {
        $values = [];
        foreach (self::constants() as $constant) {
            $values[] = $constant;
        }
        return $values;
    }

    private static function retrieveValue($code, $key)
    {
        foreach (self::constants() as $constant) {
            if (strcasecmp($constant['CODE'], $code) === 0) {
                return $constant[$key];
            }
        }
        return '';
    }

    private static function retrieveValueBySwitchCode($code, $key)
    {
        foreach (self::constants() as $constant) {
            if (strcasecmp($constant['SWITCH_ERROR_CODE'], $code) === 0) {
                return $constant[$key];
            }
        }
        return self::DECLINED['CODE'];
    }

    private static function constants()
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
            self::SUSPECTED_DUPLICATE,
            self::SUSPECTED_FRAUD,
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
            self::UNRECOGNIZED_ISSUER,
            self::BILLER_NOT_FOUND,
            self::BILLER_NOT_ENABLED_FOR_CHANNEL,
            self::ISSUER_NOT_ENABLED_FOR_BILLER,
            self::TERMINAL_OWNER_NOT_ENABLED_FOR_BILLER,
            self::TERMINAL_OWNER_NOT_ENABLED_FOR_CHANNEL,
            self::TRANSACTION_NOT_PERMITTED,
            self::NO_CARD_RECORD,
            self::EXPIRED_CARD,
            self::TRANSACTION_NOT_PERMITTED_TO_CARD,
            self::PIN_TRIES_EXCEEDED,
            self::EXCEEDS_WITHDRAWAL_LIMIT,
            self::RESPONSE_RECEIVED_TOO_LATE
        ];
    }
}