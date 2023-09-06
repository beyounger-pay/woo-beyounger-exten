<?php
const apiKey = "d73d82c2801b47c8b5247ad9344d5711";
const apiSecret = "61a02d15-760d-41ca-8126-60cbb77728c8";


require 'SHA512Util.php';
require 'HttpUtil.php';

class Payment
{

    public static function testPayment()
    {
        $requestPath = "/api/v1/payment";
        $req = [
            'currency' => 'USD',
            'amount' => '100.05',
            'cust_order_id' => substr(md5(uniqid()), 0, 16),
            'payment_method' => 'creditcard',
            'merchant_name' => 'test-api-name',
            'site_id' => 1,
            'return_url' => 'https://api.beyounger.com/status.html',
            'notification_url' => 'https://api.beyounger.com/status.html',

            'customer' => [
                'email' => 'hello@gmail.com',
                'first_name' => 'Jack',
                'last_name' => 'Li',
                'phone' => '+12123434235',
                'country' => 'USA',
                'city' => 'B',
                'state' => 'A',
                'address' => 'sgasgs,shfojsg,AA',
                'zipcode' => '24000'
            ],

            'cart_items' => [
                [
                    'name' => 'Product 1',
                    'quantity' => 1,
                    'amount' => '100.00',
                    'currency' => 'USD',
                    'product_id' => '12345',
                    'category' => 'Electronics'
                ]
            ],

            'delivery_details' => [
                'delivery_type' => 'PHYSICAL',
                'delivery_method' => 'USPS - Ground Mail',
                'delivery_time' => 1415273168
            ],

            'delivery_recipient' => [
                'email' => 'hello@gmail.com',
                'phone' => '1234567890',
                'first_name' => 'Jack',
                'last_name' => 'Li',
                'country' => 'USA',
                'state' => 'California',
                'city' => 'Los Angeles',
                'address1' => '123 Main St',
                'address2' => 'Apt 4B',
                'zipcode' => '90001'
            ]
        ];
        $timeStamp = round(microtime(true) * 1000);
        $signatureData = apiKey .
            "&" . $req['cust_order_id'] .
            "&" . $req['amount'] .
            "&" . $req['currency'] .
            "&" . apiSecret .
            "&" . $timeStamp;

        $post = HttpUtil::post($requestPath, $req, $signatureData, apiKey, $timeStamp);
        echo $post;
    }


}

Payment::testPayment();
