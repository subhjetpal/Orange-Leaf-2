<?php 
//require('C:\xampp\htdocs\Orangeleaf\App\inc\config.php'); 
require('config.php'); 
include('sheetsFunc.php');
?>

<?php
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
// $sql = "SELECT * FROM $tb_summary WHERE `Date` between '$StartDate' and '$EndDate' ";
$sql = "SELECT * FROM $tb_summary WHERE `Last_Modified` = '$yesterday' ";


$res = mysqli_query($con, $sql);
$record = array();

$batchSize = 10; // Number of rows to update in each batch
$delaySeconds = 5; // Delay time in seconds
// For Journal table
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $record[] = $row;
    }
    if(sizeof($record)>0){
        for ($i = 0; $i < count($record); $i += $batchSize) {
            $batch = array_slice($record, $i, $batchSize);
        foreach ($batch as $val) {
            $newrow = [$val['UserID'], $val['TradeID'], $val['Trade'], $val['Instrument'], $val['Transact'], $val['Date'], $val['Script'], $val['Entry'], $val['Exit'], $val['Quantity'], $val['STT'], $val['Percent'], $val['Profit_Loss']];
            $rows = [$newrow];
            $res = insert($tb_summary, $rows);
            
            if($res){
                $txt=$today.' SUMMARY INSERTED '.$val['TradeID'];
                addLog($txt);
                echo $today.' SUMMARY INSERTED '.$val['TradeID'];
            }
        }
        if ($i + $batchSize < count($record)) {
            echo "Delaying script for $delaySeconds seconds...\n";
            sleep($delaySeconds);
        }
    }
    }else{
        $txt=$today.' SUMMARY NO RECORD to MODIFY ';
        addLog($txt);
        echo $today.' SUMMARY NO RECORD to MODIFY ';
    }
 
} else {
    $txt="Server error to Proceed Summary Entry";
	addLog($txt);
    echo "Server error to Proceed Summary Entry";
}
?>