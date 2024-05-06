<?php 
require('config.php'); 
include('docsFunc.php');

// fetch In Process Orders and follow the structure as Doc
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$sql = "SELECT * FROM $tb_journal WHERE `Last_Modified` = '$yesterday' and  `Order` = 'In Process' ";

$res = mysqli_query($con, $sql);
$record = array();

$batchSize = 10; // Number of rows to update in each batch
$delaySeconds = 5; // Delay time in seconds

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $record[] = $row;
    }
    if(sizeof($record)>0){
        for ($i = 0; $i < count($record); $i += $batchSize) {
            $batch = array_slice($record, $i, $batchSize);
        foreach ($batch as $val) {
            // $text=$yesterday.'\n\nP:'.$val['Script'].'\nE:'.$val['Entry'].'\nSL:'.$val['Stop_Loss'].'\nQ:'. $val['Username']-$val['$Quantity'];
            $text="\n\n".$val['UserID'] ."\nS: ".$val['Script']."\nE: ".$val['Entry']."\nSL:".$val['Stop_Loss']."\nQ:".$val['Quantity']."\n";
            
            $res = inProcess($text);
            
            if($res){
                $txt=$today.' IN-PROCESS INSERTED '.$val['TradeID'];
                addLog($txt);
                echo $today.' IN-PROCESS INSERTED '.$val['TradeID'];
            }
        }
        if ($i + $batchSize < count($record)) {
            echo "Delaying script for $delaySeconds seconds...\n";
            sleep($delaySeconds);
        }
    }
    $text=$today."\n";
    inProcess($text);
    }else{
        $txt=$today.' IN-PROCESS NO RECORD to MODIFY ';
        addLog($txt);
        echo $today.' IN-PROCESS NO RECORD to MODIFY ';
    }
 
} else {
    $txt="Server error to Proceed In-Process Entry";
	addLog($txt);
    echo "Server error to Proceed In-Process Entry";
}


?>