<?php
require 'C:\xampp\htdocs\orange-leaf\vendor\autoload.php';

use AlphaVantage\Options;
use AlphaVantage\Client;

$option = new Options();
$option->setApiKey('GXCDB2OAG4HLGGET');

$client = new Client($option);
$data=$client->timeSeries()->daily('SBIN.BSE');
gettype($data);

// foreach($client as $val){
//     echo($val->key);
// }