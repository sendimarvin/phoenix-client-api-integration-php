<?php

namespace Interswitch\Phoenix\Simulator;

use Interswitch\Phoenix\Simulator\Utils\AuthUtils;
use Interswitch\Phoenix\Simulator\Utils\Constants;
use Interswitch\Phoenix\Simulator\Utils\HttpUtil;
use Interswitch\Phoenix\Simulator\Utils\PhoenixResponseCodes;


class AccountInquiry
{
    public static $endpointUrl = Constants::ROOT_LINK . "sente/customerValidation";

    public static function main(array $args): void
    {
        // $rootNode = new \stdClass();

        $requestData = [
            "paymentCode" => "53046936951",
            "customerId" => Constants::MY_TERMINAL_ID,
            "requestReference" => self::generateUUID(),
            "terminalId" => Constants::MY_TERMINAL_ID,
            "amount" => "600",
            "amount" => "800",
        ];

        $exchangeKeys = KeyExchange::doKeyExchange();
        if ($exchangeKeys->getResponseCode() === PhoenixResponseCodes::APPROVED) {
            $headers = AuthUtils::generateInterswitchAuth(
                Constants::POST_REQUEST,
                self::$endpointUrl,
                "",
                $exchangeKeys->getResponse()->getAuthToken(),
                $exchangeKeys->getResponse()->getTerminalKey()
            );
            try {
                HttpUtil::postHTTPRequest(self::$endpointUrl, $headers, $requestData);
            } catch (JsonException $e) {
                // Handle JSON serialization exception
                echo "JSON serialization error: " . $e->getMessage();
            }
        }
    }

    static function generateUUID() {
        if (function_exists('uuid_create')) {
            $uuid = uuid_create(UUID_TYPE_RANDOM);
    
            // Convert binary UUID to string representation
            $uuidString = bin2hex(uuid_parse($uuid));
    
            // Format UUID as per RFC 4122 (e.g., xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx)
            $formattedUUID = sprintf(
                '%s-%s-%s-%s-%s',
                substr($uuidString, 0, 8),
                substr($uuidString, 8, 4),
                substr($uuidString, 12, 4),
                substr($uuidString, 16, 4),
                substr($uuidString, 20)
            );
    
            return $formattedUUID;
        } else {
            // Fallback if uuid_create function is not available
            return uniqid();
        }
    }
}

// Example usage
AccountInquiry::main([]);
