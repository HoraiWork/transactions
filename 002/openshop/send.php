<?php

$url = 'https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp';
$salt="66475b8a-bdef-4a48-880d-55348a93c8fd";

$data = $_POST;

$data['AMOUNT'] = $data['AMOUNT'] * 100;

$query = str_replace("%3B", ";", http_build_query($data));

$val = explode("&", $query);

asort($val, false);

$arr = implode($salt, $val).$salt;

$hash = hash("sha1", $arr);

$query = $url.'?'.http_build_query($data).'&SHASIGN='.$hash;


$response = [
    'order_id' => $_POST['ORDERID'] ?? rand(10000, 15000),
    'url' => $query,
];

echo json_encode($response, true);

