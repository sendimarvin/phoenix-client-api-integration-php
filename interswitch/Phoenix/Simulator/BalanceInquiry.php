<?php

namespace Interswitch\Phoenix\Simulator;

use Interswitch\Phoenix\Simulator\Dto\KeyExchangeResponse;
use Interswitch\Phoenix\Simulator\Dto\PhoenixResponseCodes;
use Interswitch\Phoenix\Simulator\Dto\SystemResponse;

use Interswitch\Phoenix\Simulator\Utils\AuthUtils;
use Interswitch\Phoenix\Simulator\Utils\Constants;
use Interswitch\Phoenix\Simulator\Utils\HttpUtil;

class BalanceInquiry
{
    public static string $endpointUrl = Constants::ROOT_LINK . "sente/accountBalance";

    public static function main(): void
    {
        $request = self::$endpointUrl . "?terminalId=" . Constants::MY_TERMINAL_ID . "&requestReference=123436";

        $exchangeKeys = KeyExchange::doKeyExchange();
        if ($exchangeKeys->getResponseCode() == PhoenixResponseCodes::APPROVED) {
            $headers = AuthUtils::generateInterswitchAuth(
                Constants::GET_REQUEST,
                $request,
                "",
                $exchangeKeys->getResponse()->getAuthToken(),
                $exchangeKeys->getResponse()->getTerminalKey()
            );
            HttpUtil::getHTTPRequest($request, $headers);
        }
    }
}
