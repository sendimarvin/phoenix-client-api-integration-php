<?php

namespace Interswitch\Phoenix\Simulator;

use Interswitch\Phoenix\Simulator\Dto\JSONDataTransform;
use Interswitch\Phoenix\Simulator\Dto\KeyExchangeResponse;
use Interswitch\Phoenix\Simulator\Dto\PaymentRequest;
use Interswitch\Phoenix\Simulator\Dto\PhoenixResponseCodes;
use Interswitch\Phoenix\Simulator\Dto\SystemResponse;

use Interswitch\Phoenix\Simulator\Utils\AuthUtils;
use Interswitch\Phoenix\Simulator\Utils\Constants;
use Interswitch\Phoenix\Simulator\Utils\HttpUtil;

class PaymentNotification
{
    public static string $endpointUrl = Constants::ROOT_LINK . "sente/xpayment";

    /**
     * @throws \Exception
     */
    public static function main(): void
    {
        $request = [
            "paymentCode" => 53046936951,
            "customerId" => "3ISO0159",
            "requestReference" => self::generateUUID(),
            "terminalId" => Constants::MY_TERMINAL_ID,
            "amount" => 600,
            "currencyCode" => "800",
        ];

        $additionalData = $request["amount"]
            .$request["terminalId"]
            .$request["requestReference"]
            .$request["customerId"]
            .$request["paymentCode"];

        $exchangeKeys = KeyExchange::doKeyExchange();

        if ($exchangeKeys->responseCode == PhoenixResponseCodes::APPROVED) {
            $authToken = $exchangeKeys->response->authToken;
            $sessionKey = $exchangeKeys->response->terminalKey;

            $headers = AuthUtils::generateInterswitchAuth(
                Constants::POST_REQUEST,
                self::$endpointUrl,
                $additionalData,
                $authToken,
                $sessionKey
            );

            HttpUtil::postHTTPRequest(self::$endpointUrl, $headers, JSONDataTransform::marshall($request));
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
