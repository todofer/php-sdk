<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

$url1 = '/sites/' . $siteId;
$url = '/items?ids=899944948' . $siteId;


$result = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';
