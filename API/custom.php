<?php
define('YOUR_API_KEY', 'd5S5MeLWVC2T61LhxkGH33BE6vZ0o43t');
$url_info = "https://financialmodelingprep.com/api/v3/quote/SBIN.BO?apikey=".YOUR_API_KEY;

$channel = curl_init();

curl_setopt($channel, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($channel, CURLOPT_HEADER, 0);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($channel, CURLOPT_URL, $url_info);
curl_setopt($channel, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($channel, CURLOPT_TIMEOUT, 0);
curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);

$output = curl_exec($channel);

if (curl_error($channel)) {
    return 'error:' . curl_error($channel);
} else {
    $outputJSON = json_decode($output);
    var_dump($outputJSON);
}