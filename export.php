<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet autoload.php file
include 'controller.php';

if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
    header("Location: admin/");
    exit();
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Create a new worksheet and set its title
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Participants');

$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Transaction Details');
$fetchTransactionDetails = fetchTransactionDetails();
$transactionHeadings = ["Id","Transaction Ref","Bill Amount","Transaction Date","Registrer Name","Club Name","Email","Mobile"];
$transactionData = [];
array_push($transactionData, $transactionHeadings);
foreach($fetchTransactionDetails as $row){
    $dataRow = array($row['id'],$row['transactionRef'],$row['amount'],$row['date'],$row['registrerName'],$row['clubName'],$row['email'],$row['mobile']);
    array_push($transactionData, $dataRow);
}

foreach ($transactionData as $rowIndex => $rowData) {
    foreach ($rowData as $columnIndex => $cellData) {
        $sheet2->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + 1, $cellData);
    }
}
// Sample data (Replace this with your actual data retrieval process)
$fetchParticipantsData = fetchEventRegisterDetails();
$headings = ["Id","Club Name","Name","Call Name","Type","Mobile","Transaction Ref.","Registrer Name","Registrer GST"];
$data = [];
array_push($data, $headings);
foreach($fetchParticipantsData as $row){
    $dataRow = array($row['id'],$row['clubName'],$row['name'],$row['callName'],$row['type'],$row['mobile'],$row['transaction_ref'],$row['registrerName'],$row['gst']);
    array_push($data, $dataRow);
}

// Add data to the worksheet
foreach ($data as $rowIndex => $rowData) {
    foreach ($rowData as $columnIndex => $cellData) {
        $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex + 1, $cellData);
    }
}

// Create Excel writer object and specify the file path
$writer = new Xlsx($spreadsheet);
$filePath = 'RegisterBook.xlsx';

// Save the Excel file to the specified path
$writer->save($filePath);

// Output the Excel file as a download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filePath .'"');
header('Cache-Control: max-age=0');

// Send the file to the browser
$writer->save('php://output');
