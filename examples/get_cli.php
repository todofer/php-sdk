<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

$url = 'https://api.mercadolibre.com/orders/4849135930/billing_info'; 

$result = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';
