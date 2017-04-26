<?php

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require("phpexcel/Classes/PHPExcel/IOFactory.php");

$inputFileName = 'p2/province.xlsx';
//$extend = "2";

$count = 0;


//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($inputFileName);

    /* $objPHPExcel->getActiveSheet()->getStyle('N4')
      ->getNumberFormat()->applyFromArray(
      array(
      'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
      )
      ); */
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
            . '": ' . $e->getMessage());
}



//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
//$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
//echo $highestRow."<br>";
$highestRow = 77;
//echo $highestRow;
//exit();
$count = 0;
for ($row = 1; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'I' . $row);

    if (strlen($rowData[0][1]) != 0) {
        //$val = array();
        $id = $rowData[0][0];
        $th = $rowData[0][1];
        $en = $rowData[0][2];

        print "{ 
					id : '" . $id . "' ,
					province_name_th : '" . str_replace(" ", "", $th) . "' ,
					province_name_en : '" . $en . "' 
					}";
        if ($row != $highestRow)
            print ",<br>";

        /*  print "<table>"; 
          print "<tr>";
          print "<td>".str_replace("  ","",$th)."</td>";
          print "</tr>";
          print "</table>"; */
    }
}
?>