<?php
require __DIR__ . '/vendor/autoload.php';
// const host = "http://localhost:8585";
const host = "https://api.beyounger.com";


class HttpUtil
{

    public static function post($requestPath, $reqObject, $signatureData, $apiKey, float $timStamp)
    {
        $SIGN_SEPARATOR = ":";

        $sign = SHA256Util::sign($signatureData);

        $authorizationStr = $apiKey
            . $SIGN_SEPARATOR
            . $timStamp
            . $SIGN_SEPARATOR
            . $sign;

        //$client = new \GuzzleHttp\Client();忽略证书配置
        $client = new GuzzleHttp\Client([
            'verify' => false,
        ]);

        $response = $client->post(host . $requestPath, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $authorizationStr
            ],
            'body' => json_encode($reqObject, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ]);

        $responseBody = $response->getBody()->getContents();

        if ($response->getStatusCode() >= 400) {
            echo 'Error: ' . $responseBody;
        } else {
            echo $responseBody;
        }
    }

    public static function get($requestPath, $requestQueryStr, $signatureData, $apiKey, $timStamp)
    {

        $SIGN_SEPARATOR = ':';
        $sign = SHA256Util::sign($signatureData);

        $authorizationStr = $apiKey
            . $SIGN_SEPARATOR
            . $timStamp
            . $SIGN_SEPARATOR
            . $sign;

        //$client = new \GuzzleHttp\Client();忽略证书配置
        $client = new GuzzleHttp\Client([
            'verify' => false,
        ]);
        $response = $client->get(host . $requestPath, [
            'headers' => ['Authorization' => $authorizationStr],
            'query' => $requestQueryStr
        ]);

        return $response->getBody()->getContents();
    }
}
