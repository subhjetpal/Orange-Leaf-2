<?php
require 'C:\xampp\htdocs\orange-leaf\vendor\autoload.php';

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;

// Create a new client from the factory
$client = ApiClientFactory::createApiClient();

$historicalData = $client->getHistoricalQuoteData(
    "INFy.BO",
    ApiClient::INTERVAL_1_DAY,
    new \DateTime("yesterday"),
    new \DateTime("today")
);

print_r($historicalData);