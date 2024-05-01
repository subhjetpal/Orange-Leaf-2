<?php require_once('connect.php'); ?>
<?php
function inProcess($text)
{
    global $service;

    $requests = array();
    $requests = [
        new Google_Service_Docs_Request([
            'insertText' => [
                'location' => [
                    'index' => 1,
                ],
                'text' => $text
            ]
        ])
    ];

    $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest([
        'requests' => $requests
    ]);

    $service->documents->batchUpdate(DOCSID, $batchUpdateRequest);

    $status = $service ? TRUE : FALSE;
    return $status;
}
function addLog($txt){
    $file='/var/www/vhosts/doyat.in/orange-leaf.doyat.in/docs/log.txt';
    $myfile = fopen($file, "a") or die("Unable to open file!");
	$txt = PHP_EOL . $txt;
    fwrite($myfile, $txt);
    fclose($myfile);
}
?>