<?php

class UtilMethods
{
    private static $LOG;

    public static function hash512($plainText)
    {
        try {
            $hash = hash('sha512', $plainText);
            return base64_encode(hex2bin($hash));
        } catch (Exception $e) {
            self::$LOG->error("Exception trace {} ", ExceptionUtils::getStackTrace($e));
            throw new SystemApiException(PhoenixResponseCodes::INTERNAL_ERROR, "Failure to hash512 object");
        }
    }

    public static function unMarshallSystemResponseObject($response, $theClass)
    {
        try {
            $mapper = new ObjectMapper();
            $type = $mapper->getTypeFactory()->constructParametricType(SystemResponse::class, $theClass);
            return $mapper->readValue($response, $type);
        } catch (Exception $e) {
            self::$LOG->error("Exception trace {} ", ExceptionUtils::getStackTrace($e));
            throw new SystemApiException(PhoenixResponseCodes::INTERNAL_ERROR, "Failure to unmarshall json string from systemresponse object");
        }
    }

    public static function randomBytesHexEncoded($count)
    {
        try {
            $bytes = random_bytes($count);
            return bin2hex($bytes);
        } catch (Exception $e) {
            self::$LOG->error("Exception trace {} ", ExceptionUtils::getStackTrace($e));
            return null;
        }
    }

    public static function isEmptyString($str, $defaultReturn)
    {
        return self::isEmptyString($str) ? $defaultReturn : $str;
    }

    public static function isEmptyString($str)
    {
        return (is_null($str)) || ($str == null) || (strcasecmp($str, "") == 0) || (strcasecmp($str, "null") == 0);
    }
}