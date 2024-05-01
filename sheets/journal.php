<?php 
//require('C:\xampp\htdocs\Orangeleaf\App\inc\config.php');
require('config.php'); 
include('sheetsFunc.php');
?>

<?php
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
// $sql = "SELECT * FROM $tb_journal_nse WHERE `Date` between '$StartDate' and '$EndDate' ";
$sql = "SELECT * FROM $tb_journal_nse WHERE `Last_Modified` = '$yesterday' ";

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
                $rowNo = getRow($tb_journal_nse, $val['TradeID']);
                $newrow = [$val['UserID'], $val['TradeID'], $val['Trade'], $val['Instrument'], $val['Order'], $val['Date'], $val['Chart'], $val['Script'], $val['System'], $val['Entry'], $val['Stop_Loss'], $val['Target1_2'], $val['Target1_3'], $val['Exit'], $val['Quantity'], $val['Candle'], $val['Risk'], $val['STT'], $val['ImageURL']];
                $rows = [$newrow];
                if ($rowNo == 0) {
                    $res = insert($tb_journal_nse, $rows);
                    if($res){
                        $txt=$today.' JOURNAL INSERTED '.$val['TradeID'];
                        addLog($txt);
                        echo $today.' JOURNAL INSERTED '.$val['TradeID'];
                    }
                } else {
                    $res = update($tb_journal_nse, $rows, $rowNo);
                    if($res){
                        $txt=$today.' JOURNAL UPDATED '.$val['TradeID'];
                        addLog($txt);
                        echo $today.' JOURNAL UPDATED '.$val['TradeID'];
                    }
                }
            }
            if ($i + $batchSize < count($record)) {
                echo "Delaying script for $delaySeconds seconds...\n";
                sleep($delaySeconds);
            }
        }

    }else{
        $txt=$today.' JOURNAL NO RECORD to MODIFY ';
        addLog($txt);
        echo $today.' JOURNAL NO RECORD to MODIFY ';
    }

} else {
    $txt="Server error to Proceed Journal Entry";
	addLog($txt);
    echo "Server error to Proceed Journal Entry";;
}
?>