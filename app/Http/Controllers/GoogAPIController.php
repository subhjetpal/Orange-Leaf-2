<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Service\Docs;
use Google\Service\Docs\Request as DocRequest;
use Google\Service\Docs\BatchUpdateDocumentRequest;
use App\Models\TradeJournal;
use App\Models\TradeSummary;
use App\Models\User;

class GoogAPIController extends Controller
{
    private $client;
    private $service;

    public function __construct(Request $req)
    {
        // Configure the Google Client
        $this->client = new GoogleClient();
        $this->client->setApplicationName('Google API');
        if ($req->api == 'Sheets') {
            $this->client->setScopes([Sheets::SPREADSHEETS]);
        } else {
            $this->client->setScopes([Docs::DOCUMENTS]);
        }

        $this->client->setAccessType('offline');

        // Path to credentials.json
        $path = storage_path('path/to/your/credentials.json');
        $this->client->setAuthConfig($path);

        // Configure the Sheets Service
        if ($req->api == 'Sheets') {
            $this->service = new Sheets($this->client);
        } else {
            $this->service = new Docs($this->client);
        }
    }

    private function getdata($sheet)
    {
        $range = $sheet;
        $response = $this->service->spreadsheets_values->get(env('SPREADSHEETID'), $range);
        $rows = $response->getValues();
        $headers = array_shift($rows);
        $array = [];
        foreach ($rows as $row) {
            $array[] = array_combine($headers, $row);
        }
        return $array;
    }
    private function getRow($sheet, $TradeID)
    {
        $array = $this->getdata($sheet);
        // $rowNo = array();
        foreach ($array as $i => $row) {
            if ($row['TradeID'] == $TradeID) {
                $rowNo = $i + 2;
                return $rowNo;
            }
        }
        return 0;
    }
    private function insert($sheet, $data)
    {
        $valueRange = new ValueRange();
        $valueRange->setValues($data);
        $range = $sheet; // the service will detect the last row of this sheet
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $this->service->spreadsheets_values->append(env('SPREADSHEETID'), $range, $valueRange, $options);
        $status = $this->service ? TRUE : FALSE;
        return $status;
    }
    private function update($sheet, $data, $rowNo)
    {
        $valueRange =  new ValueRange();
        $valueRange->setValues($data);
        if ($sheet == 'trade_journal') {
            $End = 'T';
        } elseif ($sheet == 'trade_summary') {
            $End = 'N';
        } elseif ($sheet == 'expense') {
            $End = 'G';
        }

        $range = $sheet . '!A' . $rowNo . ':' . $End . $rowNo; // where the replacement will start, here
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $this->service->spreadsheets_values->update(env('SPREADSHEETID'), $range, $valueRange, $options);

        $status = $this->service ? TRUE : FALSE;
        return $status;
    }
    private function addLog($txt)
    {
        $file = '/var/www/vhosts/doyat.in/orange-leaf.doyat.in/log.txt';
        $myfile = fopen($file, "a") or die("Unable to open file!");
        $txt = PHP_EOL . $txt;
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    private function addInProcess($text)
    {
        $requests = array();
        $requests = [
            new DocRequest([
                'insertText' => [
                    'location' => [
                        'index' => 1,
                    ],
                    'text' => $text
                ]
            ])
        ];

        $batchUpdateRequest = new BatchUpdateDocumentRequest([
            'requests' => $requests
        ]);

        $this->service->documents->batchUpdate(env('DOCSID'), $batchUpdateRequest);

        $status = $this->service ? TRUE : FALSE;
        return $status;
    }

    function inProcess()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $data = TradeJournal::where('Last_Modified', $yesterday)
                ->where('Order', 'In Process')
                ->get();

        $batchSize = 10; // Number of rows to update in each batch
        $delaySeconds = 5; // Delay time in seconds

            if ($data->count() > 0) {
                for ($i = 0; $i < $data->count(); $i += $batchSize) {
                    $batch = $data->slice($i, $batchSize);
                    foreach ($batch as $val) {
                        $text = "\n\n" . $val['UserID'] . "\nS: " . $val['Script'] . "\nE: " . $val['Entry'] . "\nSL:" . $val['Stop_Loss'] . "\nQ:" . $val['Quantity'] . "\n";

                        $res = $this->addInProcess($text);

                        if ($res) {
                            $txt = $today . ' IN-PROCESS INSERTED ' . $val['TradeID'];
                            addLog($txt);
                            echo $today . ' IN-PROCESS INSERTED ' . $val['TradeID'];
                        }
                    }
                    if ($i + $batchSize < $data->count()) {
                        echo "Delaying script for $delaySeconds seconds...\n";
                        sleep($delaySeconds);
                    }
                }
                $text = $today . "\n";
                $this->addInProcess($text);
            } else {
                $txt = $today . ' IN-PROCESS NO RECORD to MODIFY ';
                addLog($txt);
                echo $today . ' IN-PROCESS NO RECORD to MODIFY ';
            }
    }
    function journal()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $data = TradeJournal::where('Last_Modified', $yesterday)
                ->get();

        $batchSize = 10; // Number of rows to update in each batch
        $delaySeconds = 5; // Delay time in seconds

        if ($data->count() > 0) {
            for ($i = 0; $i < $data->count(); $i += $batchSize) {
                $batch = $data->slice($i, $batchSize);
                foreach ($batch as $val) {
                    $rowNo = $this->getRow(env('JOURNAL'), $val['TradeID']);
                    $newrow = [$val['UserID'], $val['TradeID'], $val['Trade'], $val['Instrument'], $val['Order'], $val['Date'], $val['Chart'], $val['Script'], $val['System'], $val['Entry'], $val['Stop_Loss'], $val['Target1_2'], $val['Target1_3'], $val['Exit'], $val['Quantity'], $val['Candle'], $val['Risk'], $val['STT'], $val['ImageURL']];
                    $rows = [$newrow];
                    if ($rowNo == 0) {
                        $res = $this->insert(env('JOURNAL'), $rows);
                        if ($res) {
                            $txt = $today . ' JOURNAL INSERTED ' . $val['TradeID'];
                            $this->addLog($txt);
                            echo $today . ' JOURNAL INSERTED ' . $val['TradeID'];
                        }
                    } else {
                        $res = $this->update(env('JOURNAL'), $rows, $rowNo);
                        if ($res) {
                            $txt = $today . ' JOURNAL UPDATED ' . $val['TradeID'];
                            $this->addLog($txt);
                            echo $today . ' JOURNAL UPDATED ' . $val['TradeID'];
                        }
                    }
                }
                if ($i + $batchSize < count($data->count())) {
                    echo "Delaying script for $delaySeconds seconds...\n";
                    sleep($delaySeconds);
                }
            }
        } else {
            $txt = $today . ' JOURNAL NO RECORD to MODIFY ';
            addLog($txt);
            echo $today . ' JOURNAL NO RECORD to MODIFY ';
        }
    }
    function summary()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $data = TradeSummary::where('Last_Modified', $yesterday)
                ->get();

        $batchSize = 10; // Number of rows to update in each batch
        $delaySeconds = 5; // Delay time in seconds

        if ($data->count() > 0) {
            for ($i = 0; $i < $data->count(); $i += $batchSize) {
                $batch = $data->slice($i, $batchSize);
                foreach ($batch as $val) {
                    $newrow = [$val['UserID'], $val['TradeID'], $val['Trade'], $val['Instrument'], $val['Transact'], $val['Date'], $val['Script'], $val['Entry'], $val['Exit'], $val['Quantity'], $val['STT'], $val['Percent'], $val['Profit_Loss']];
                    $rows = [$newrow];
                    $res = $this->insert(env('SUMMARY'), $rows);

                    if ($res) {
                        $txt = $today . ' SUMMARY INSERTED ' . $val['TradeID'];
                        $this->addLog($txt);
                        echo $today . ' SUMMARY INSERTED ' . $val['TradeID'];
                    }
                }
                if ($i + $batchSize < count($data->count())) {
                    echo "Delaying script for $delaySeconds seconds...\n";
                    sleep($delaySeconds);
                }
            }
        } else {
            $txt = $today . ' SUMMARY NO RECORD to MODIFY ';
            $this->addLog($txt);
            echo $today . ' SUMMARY NO RECORD to MODIFY ';
        }
    }
}
