<?php require_once('connect.php'); ?>
<?php
function getdata($sheet)
{
    global $service;
    $range = $sheet;
    $response = $service->spreadsheets_values->get(SPREADSHEETID, $range);
    $rows = $response->getValues();
    $headers = array_shift($rows);
    $array = [];
    foreach ($rows as $row) {
        $array[] = array_combine($headers, $row);
    }
    return $array;
}
?>
<?php
function getRow($sheet, $TradeID)
{
    $array = getdata($sheet);
    // $rowNo = array();
    foreach ($array as $i => $row) {
        if ($row['TradeID'] == $TradeID) {
            $rowNo=$i + 2;
            return $rowNo;
        }
    }
    return 0;
}
function insert($sheet, $data)
{
    global $service;
    $valueRange = new \Google_Service_Sheets_ValueRange();
    $valueRange->setValues($data);
    $range = $sheet; // the service will detect the last row of this sheet
    $options = ['valueInputOption' => 'USER_ENTERED'];
    $service->spreadsheets_values->append(SPREADSHEETID, $range, $valueRange, $options);
    $status = $service ? TRUE : FALSE;
    return $status;
}
function update($sheet, $data, $rowNo)
{
    global $service;
    $valueRange = new \Google_Service_Sheets_ValueRange();
    $valueRange->setValues($data);
    if($sheet == 'trade_journal'){
        $End='T';
    } elseif ($sheet == 'trade_summary'){
        $End='N';
    } elseif ($sheet == 'expense'){
        $End='G';
    }
    
    $range = $sheet . '!A' . $rowNo.':'.$End.$rowNo; // where the replacement will start, here
    $options = ['valueInputOption' => 'USER_ENTERED'];
    $service->spreadsheets_values->update(SPREADSHEETID, $range, $valueRange, $options);
    
    $status = $service ? TRUE : FALSE;
    return $status;
}
function addLog($txt){
    $file='/var/www/vhosts/doyat.in/orange-leaf.doyat.in/sheets/log.txt';
    $myfile = fopen($file, "a") or die("Unable to open file!");
	$txt = PHP_EOL . $txt;
    fwrite($myfile, $txt);
    fclose($myfile);
}
?>