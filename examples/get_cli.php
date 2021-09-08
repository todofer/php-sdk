<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);



curl -X GET -H "Authorization: Bearer TG-6138c4c6bb17c300084fe110-380281361" "https://api.mercadolibre.com/orders/4849969117/billing_info"


$params = array();

$url = 'https://api.mercadolibre.com/orders/4849135930/billing_info'; 

$result = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';
