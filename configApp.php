<?php

/* Go to My Apps dashboard: https://developers.mercadolibre.com.ar/apps/home, and get the information you need in order to the following enviroment variables */

/* Your Application Id */
$appId = getenv('Redirect_URI');

/* Your Secret Key */
$secretKey = getenv('lBWtsgtedsxo6WJODvoez6l8f6Dqg8I0');

/* The Redirect url */
$redirectURI = getenv('https://todofer.herokuapp.com/');

/* The site id of the country where your application will work.
If you don't know your site_id go to our sites resources: https://api.mercadolibre.com/sites  */
$siteId = 'MLA';



//////////////////////////////////////////////////////////////////////////////////////////////////////
//If you don't use Heroku use the next config

// $appId = '3889916536050367';

// $secretKey = 'lBWtsgtedsxo6WJODvoez6l8f6Dqg8I0';

// $redirectURI = 'https://todofer.herokuapp.com/';

// $siteId = 'MLA';
