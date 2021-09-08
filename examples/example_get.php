<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

$url = '/sites/' . $siteId;


$result1 = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';
