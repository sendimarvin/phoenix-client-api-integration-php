<?php

namespace Interswitch\Phoenix\Simulator\Utils;

class HttpUtil
{
    private static $LOG;

    public static function postHTTPRequest($resourceUrl, $headers, $data)
    {
        echo "http outgoing request body ", $data;
        echo "http outgoing request url ", $resourceUrl;

        $ch = curl_init($resourceUrl);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curlHeaders = [];
        foreach ($headers as $key => $value) {
            $curlHeaders[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);

        $resposeString = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        echo "http response code ", $responseCode;
        echo "http response body ", $resposeString;
        return $resposeString;
    }

    public static function getHTTPRequest($resourceUrl, $headers)
    {
        echo "http outgoing request url ", $resourceUrl;

        $ch = curl_init($resourceUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curlHeaders = [];
        foreach ($headers as $key => $value) {
            $curlHeaders[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeaders);

        $resposeString = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        echo "http response code ", $responseCode;
        echo "http response body ", $resposeString;
        return $resposeString;
    }
}
