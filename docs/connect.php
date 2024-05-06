<?php 
// $appLoc='/Orangeleaf/App';
// require $_SERVER['DOCUMENT_ROOT'].$appLoc.'/sheets/vendor/autoload.php';
// require 'C:\xampp\htdocs\orange-leaf\vendor\autoload.php';
require('/var/www/vhosts/doyat.in/orange-leaf.doyat.in//vendor/autoload.php'); 

// configure the Google Client
$client = new \Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([\Google_Service_Docs::DOCUMENTS]);
$client->setAccessType('offline');
// credentials.json is the key file we downloaded while setting up our Google Sheets API
$path = __DIR__.'/credentials.json';
// $path = $_SERVER['DOCUMENT_ROOT'].$appLoc.'/sheets/credentials.json';

$client->setAuthConfig($path);

// configure the Sheets Service
$service = new \Google_Service_Docs($client);

define("DOCSID", '19T4Clq_I000LfaJB-FH7FGw2-7dhaS-36J_yKzTWp_k');

?>

