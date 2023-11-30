<?php

namespace Interswitch\Phoenix\Simulator\Utils;

class Constants
{
    public static $PRIKEY = "";
    public static $PUBKEY = "";
    public static $MY_TERMINAL_ID = "";
    public static $MY_SERIAL_ID = "";
    public static $ACCOUNT_PWD = "";

    //header strings
    public const TIMESTAMP = "Timestamp";
    public const TERMINAL_ID = "TerminalId";
    public const NONCE = "Nonce";
    public const SIGNATURE = "Signature";
    public const AUTHORIZATION = "Authorization";
    public const AUTHORIZATION_REALM = "InterswitchAuth";
    public const ISO_8859_1 = "ISO-8859-1";
    public const AUTH_TOKEN = "AuthToken";
    public const APP_VERSION = "v1";

    private const SANDBOX_ROUTE = "";
    public const ROOT_LINK = self::SANDBOX_ROUTE;

    public const CLIENT_ID = "";
    public const CLIENT_SECRET = "A";

    public static $POST_REQUEST = "POST";
    public static $GET_REQUEST = "GET";

    public const AES_CBC_PKCS7_PADDING = "AES/CBC/PKCS7Padding";
    public const RSA_NONE_OAEPWithSHA256AndMGF1Padding = "RSA/NONE/OAEPWithSHA256AndMGF1Padding";
}
