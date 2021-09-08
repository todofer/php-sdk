<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

$url = '/sites/' . $siteId;

curl -X GET -H 'Authorization: Bearer $ACCESS_TOKEN' https://api.mercadolibre.com/orders/2000002713305156/billing_info
$result1 = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';
