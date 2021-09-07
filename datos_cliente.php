<?php
session_start();
require 'Meli/meli.php';
require 'configApp.php';

$domain = $_SERVER['HTTP_HOST'];
$appName = explode('.', $domain)[0];
$access_token = 'APP_USR-3889916536050367-090719-d280ae363e4d0250f5ad5364e9a4545c-380281361';

?>

    <!DOCTYPE html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Official PHP SDK for Mercado Libre's API.">
        <meta name="keywords" content="API, PHP, Mercado Libre, SDK, meli, integration, e-commerce">
        <title>Datos Clientes</title>
        <link rel="stylesheet" href="/getting-started/style.css" />
        <script src="script.js"></script>
    </head>

    <body>
        <?php
            echo $access_token , '<br>';
            echo $domain , '<br>';
            echo $appName, '<br>';
            curl -X GET -H 'Authorization: Bearer $access_token' https://api.mercadolibre.com/sites;
        ?>
    </body>

    </html>
