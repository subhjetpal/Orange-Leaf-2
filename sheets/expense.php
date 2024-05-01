<?php 
//require('C:\xampp\htdocs\Orangeleaf\App\inc\config.php'); 
require('config.php'); 
include('sheetsFunc.php');
?>

<?php
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
// $sql = "SELECT * FROM $tb_expense WHERE `Date` between '$StartDate' and '$EndDate' ";
$sql = "SELECT * FROM $tb_expense WHERE `Last_Modified` = '$yesterday' ";


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
            foreach ($record as $val) {
                $newrow = [$val['UserID'], $val['ExpenseID'], $val['TradeID'], $val['Date'], $val['Instrument'], $val['Amount'], $val['Charges']];
                $rows = [$newrow];
                $res = insert($tb_expense, $rows);
        
                if($res){
                    $txt=$today.' EXPENSE '.$val['TradeID'];
                    addLog($txt);
                    echo $today.' EXPENSE '.$val['TradeID'];
                }
            }
            if ($i + $batchSize < count($record)) {
                echo "Delaying script for $delaySeconds seconds...\n";
                sleep($delaySeconds);
            }
        }
    }else{
        $txt=$today.' EXPENSE NO RECORD to MODIFY ';
        addLog($txt);
        echo $today.' EXPENSE NO RECORD to MODIFY ';
    }
 
} else {
    $txt="Server error to Proceed Expense Entry";
	addLog($txt);
    echo "Server error to Proceed Expense Entry";
}
?>