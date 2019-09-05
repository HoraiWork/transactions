<?php
require "curl/curl.php"

$curl = new Curl();
$curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');
$response =  $curl->post('http://localhost/tool-shop/wp-json/wc/v3/products/', array(
    'token' => 'slavaukraine',
    'locale' => 'en',
    'products' => $products,
));


$woocommerce = new Client(
    'http://localhost/tool-shop/',
    'ck_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    'cs_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    [
        'version' => 'wc/v3',
    ]
);


$priceInSQL = json_decode($curl->response,true);

return $priceInSQL;

}