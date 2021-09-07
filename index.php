<?php
session_start();
require 'Meli/meli.php';
require 'configApp.php';

$domain = $_SERVER['HTTP_HOST'];
$appName = explode('.', $domain)[0];
?>

    <!DOCTYPE html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Official PHP SDK for Mercado Libre's API.">
        <meta name="keywords" content="API, PHP, Mercado Libre, SDK, meli, integration, e-commerce">
        <title>Mercado Libre PHP SDK</title>
        <link rel="stylesheet" href="/getting-started/style.css" />
        <script src="script.js"></script>
    </head>

    <body>
        <header class="navbar">
            <a class="logo" href="#"><img src="/getting-started/logo-developers.png" alt=""></a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <li><a target="_blank" href="http://developers.mercadolibre.com/getting-started/">Getting Started</a></li>
                    <li><a target="_blank" href="http://developers.mercadolibre.com/api-docs/">API Docs</a></li>
                    <li><a target="_blank" href="http://developers.mercadolibre.com/community/">Community</a></li>
                </ul>
            </nav>
        </header>

        <div class="header">
            <div>
                <h1>Comenzando con el SDK PHP de Mercado Libre</h1>
                <h2>SDK PHP oficial para la API de Mercado Libre.</h2>
            </div>
        </div>

        <main class="container">
            <h3>Hola desarrollador</h3>
            <p>Esta es una aplicación de muestra, implementada en Heroku con PHP SDK de Mercado Libre. ¡Siéntete libre de usarlo como base para comenzar a construir tu increíble aplicación!</p>

            <div class="row">
                <div class="col-md-6">
                    <h3>How it works?</h3>
                    <ul>
                        <li>Esta aplicación se implementó en Heroku, ya sea usando Git o usando <a href="https://github.com/heroku/go-getting-started">Heroku Button</a> en el repositorio.</li>
                        <li>Cuando Heroku recibió el código fuente, usó la cadena de herramientas go para compilar la aplicación junto con las dependencias vendidas y creó un slug desplegable.</li>
                        <li>Luego, la plataforma hace girar un dinamómetro, un contenedor liviano que proporciona un entorno aislado en el que se puede montar y ejecutar la babosa.</li>
                        <li>Puede escalar su aplicación, administrarla e implementarla <a href="https://addons.heroku.com/">150 add-on services</a>, desde el Panel de control o la CLI.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Next steps</h3>
                    <p>To start, <a href="https://developers.mercadolibre.com.ar/apps/home">go to your My Apps dashboard</a> and update your application's <b>redirect URI</b> to match the one Heroku is running: <br />
                        <code><?php echo 'https://'.$domain; ?></code>.
                        <br />
                        <br /> If you deployed this app by the Heroku Button, you need to clone this aplication to your computer by running the following on a command line shell:
                        <br />
                        <code>heroku git:clone -a <?php echo $appName; ?></code>
                        <br /> This will create a local copy of the source code, and associate the Heroku app with your local repository.</p>
                    <p>Follow the offical Heroku's guide <a target="_blank" href="https://devcenter.heroku.com/articles/git">https://devcenter.heroku.com/articles/git</a> to deploy using the Heroku cli.</p>
                    <p>You'll now be set up to run the app locally, or deploy changes to Heroku.</p>
                </div>
            </div>

            <div class="row">
                <h3>Examples</h3>
                <p>
                    Check the following examples, they will help you to start working with our API!
                </p>
                <p>
                    Note that these examples work for MLB(Brasil) by default. If you'd like to try them in your own country, please, <a href="https://github.com/mercadolibre/php-sdk/blob/master/configApp.php#L16">update this line</a> in your project, with
                    your own <b>$site_id</b> before executing them.
                </p>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <h3>oAuth</h3>
                    <p>Primero autentíquese. La autenticación es la clave para sacarle el máximo partido a la API de Mercado Libre.</p>

                    <?php
                    $meli = new Meli($appId, $secretKey);

                    if($_GET['code'] || $_SESSION['access_token']) {

                        // If code exist and session is empty
                        if($_GET['code'] && !($_SESSION['access_token'])) {
                            // If the code was in get parameter we authorize
                            $user = $meli->authorize($_GET['code'], $redirectURI);

                            // Now we create the sessions with the authenticated user
                            $_SESSION['access_token'] = $user['body']->access_token;
                            $_SESSION['expires_in'] = time() + $user['body']->expires_in;
                            $_SESSION['refresh_token'] = $user['body']->refresh_token;
                        } else {
                            // Podemos comprobar si el token de acceso no es válido comprobando la hora.
                            if($_SESSION['expires_in'] < time()) {
                                try {
                                    // Haz el proceso de actualización
                                    $refresh = $meli->refreshAccessToken();

                                    // Ahora creamos las sesiones con los nuevos parámetros
                                    $_SESSION['access_token'] = $refresh['body']->access_token;
                                    $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                                    $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
                                } catch (Exception $e) {
                                    echo "Exception: ",  $e->getMessage(), "\n";
                                }
                            }
                        }

                        echo '<pre>';
                            print_r($_SESSION);
                        echo '</pre>';

                    } else {
                        echo '<p><a alt="Login using MercadoLibre oAuth 2.0" class="btn" href="' . $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL[$siteId]) . '">Authenticate</a></p>';
                    }
                    ?>

                </div>
                <div class="col-sm-6 col-md-6">
                    <h3>Obtener sitio</h3>
                    <p>Haz un simple GET a <a href="https://api.mercadolibre.com/sites">sites resource</a> con tu <b>$site_id</b>para obtener información sobre un sitio. Como identificación, nombre, monedas, categorías y otras configuraciones.</p>
                    <p><a class="btn" href="../examples/example_get.php">GET</a></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h3>Publish an Item</h3>
                    <p>
                        This is a example of how to list an item in <b>MLB</b> (Brasil).
                       <br /> <b>Necesita estar autenticado para que funcione.</b>
                       <br /> Para poder publicar un artículo en otro país, <a href="https://github.com/mercadolibre/php-sdk/blob/master/examples/example_list_item.php">por favor actualice esto file</a>, con valores de acuerdo con el ID del sitio donde funciona su aplicación, como <b>category_id</b> y <b>currency</b>.
                     <br />
                    </p>
                    <pre class="pre-item">
"title" => "Item De Teste - Por Favor, Não Ofertar! --kc:off",
        "category_id" => "MLB1227",
        "price" => 10,
        "currency_id" => "BRL",
        "available_quantity" => 1,
        "buying_mode" => "buy_it_now",
        "listing_type_id" => "bronze",
        "condition" => "new",
        "description" => "Item de Teste. Mercado Livre's PHP SDK.",
        "video_id" => "RXWn6kftTHY",
        "warranty" => "12 month",
        "pictures" => array(
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"
            ),
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/a/ab/Teashades.gif"
            )
        )
    )
                    </pre>

                    <?php
                    $meli = new Meli($appId, $secretKey);

                    if($_GET['code'] && $_GET['publish_item']) {

                        // If the code was in get parameter we authorize
                        $user = $meli->authorize($_GET['code'], $redirectURI);

                        // Now we create the sessions with the authenticated user
                        $_SESSION['access_token'] = $user['body']->access_token;
                        $_SESSION['expires_in'] = $user['body']->expires_in;
                        $_SESSION['refresh_token'] = $user['body']->refresh_token;

                        // We can check if the access token in invalid checking the time
                        if($_SESSION['expires_in'] + time() + 1 < time()) {
                            try {
                                print_r($meli->refreshAccessToken());
                            } catch (Exception $e) {
                                echo "Exception: ",  $e->getMessage(), "\n";
                            }
                        }

                        // Nosotros construimos el artículo para PUBLICAR
                        $item = array(
                            "title" => "Item De Teste - Por Favor, Não Ofertar! --kc:off",
        "category_id" => "MLB1227",
        "price" => 10,
        "currency_id" => "BRL",
        "available_quantity" => 1,
        "buying_mode" => "buy_it_now",
        "listing_type_id" => "bronze",
        "condition" => "new",
        "description" => "Item de Teste. Mercado Livre's PHP SDK.",
        "video_id" => "RXWn6kftTHY",
        "warranty" => "12 month",
        "pictures" => array(
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"
            ),
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/a/ab/Teashades.gif"
            )
        )
    );
                        
                        $response = $meli->post('/items', $item, array('access_token' => $_SESSION['access_token']));

                        // Llamamos a la solicitud de publicación para listar un artículo.
                        echo "<h4>Response</h4>";
                        echo '<pre class="pre-item">';
                        print_r ($response);
                        echo '</pre>';

                        echo "<h4>¡Éxito! ¡Su elemento de prueba fue incluido!</h4>";
                        echo "<p>Vaya al enlace permanente para ver cómo se ve en nuestro sitio.</p>";
                        echo '<a target="_blank" href="'.$response["body"]->permalink.'">'.$response["body"]->permalink.'</a><br />';

                    } else if($_GET['code']) {
                        echo '<p><a alt="Publish Item" class="btn" href="/?code='.$_GET['code'].'&publish_item=ok">Publish Item</a></p>';
                    } else {
                        echo '<p><a alt="Publish Item" class="btn disable" href="#">Publish Item</a> </p>';
                    }
                    ?>

                </div>

                <div class="col-md-6">
                    <h3>¡Empezar!</h3>
                    <p>Ahora sabe lo fácil que es obtener información de nuestra API. Verifique el resto de los ejemplos en el SDK y modifíquelos como desee para enumerar un elemento, actualizarlo y otras acciones.</p>
                    <p><a class="btn" href="https://github.com/mercadolibre/php-sdk/tree/master/examples">More examples</a></p>
                </div>
            </div>

            <hr>

            <div class="row">
                <h3>Sus credenciales</h3>
                <div class="row-info col-sm-3 col-md-3">
                    <b>App_Id: </b>
                    <?php echo $appId; ?>
                </div>
                <div class="row-info col-sm-3 col-md-3">
                    <b>Secret_Key: </b>
                    <?php echo $secretKey; ?>
                </div>
                <div class="row-info col-sm-3 col-md-3">
                    <b>Redirect_URI: </b>
                    <?php echo $redirectURI; ?>
                </div>
                <div class="row-info col-sm-3 col-md-3">
                    <b>Site_Id: </b>
                    <?php echo $siteId; ?>
                </div>
            </div>
            <hr>
        </main>
    </body>

    </html>
