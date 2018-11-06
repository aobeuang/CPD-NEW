<?php

require_once('third_party/PHPExcel.php');

$dataArray = array(
    array(
        'PHP7',
        'Java Script',
        'Java',
        'Node JS',
    )
);

// create php excel object
$doc = new PHPExcel();

// set active sheet 
$doc->setActiveSheetIndex(0);

// read data to active sheet
$doc->getActiveSheet()->fromArray($dataArray);

//save our workbook as this file name
$filename = 'just_some_random_name.xls';
//mime type
header('Content-Type: application/vnd.ms-excel');
//tell browser what's the file name
header('Content-Disposition: attachment;filename="' . $filename . '"');

header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format

$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');
?>