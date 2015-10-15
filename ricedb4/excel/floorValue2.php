<?php

if (PHP_SAPI == "cli")
    die("This example should only be run from a Web Browser");

/** Include PHPExcel */
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel.php");
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel/IOFactory.php");
require(dirname(__FILE__) . "/configExcel.php");
require("../apps/rice/entity/FloorValue2.php");

//$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");
$link = new PDO("dblib:host=202.44.34.86; dbname=RiceDB", "riceuser", "l2ice2015");

// rice type in this auction

$objPHPExcel = new PHPExcel();

// Create new PHPExcel object
$objPHPExcel->getActiveSheet()->setTitle("fv4-58");
//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('30');
//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);

putWord($objPHPExcel, 0, 1, $columnArr[0], "รายละเอียดคลังกลางข้าวสำหรับการประกาศเปิดประมูล ครั้งที่ 4/2558 วันที่ 19 มิถุนายน 2558", 1, 10, "center", "");
putWord($objPHPExcel, 0, 2, $columnArr[0], "", 1, 5, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[5], "FV2", 1, 3, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[8], "FV3", 1, 2, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[10], "FV4", 1, 2, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[0], "ลำดับ ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[1], "จังหวัด", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[2], "ชื่อคลังสินค้ากลาง/ไซโล", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[3], "เข้าร่วมฯ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[4], "รวมทั้งสิ้น (ตัน)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[5], "ราคาเฉลี่ย (ตัน)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[6], "มูลค่าขั้นต่ำ (บาท) (Floor Value)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[7], "มูลค่าขั้นต่ำ (บาท) (Floor Value) ปัดเศษ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[8], "ราคาเฉลี่ย (ตัน)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[9], "มูลค่าขั้นต่ำ (บาท) (Floor Value)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[10], "ราคาเฉลี่ย (ตัน)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[11], "มูลค่าขั้นต่ำ (บาท) (Floor Value)", 1, 1, "center", "border");


//$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
//$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
//$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$sql = "exec sp_dft_floor_value2 'AU4/2558',0,0,0,0";
$q = $link->prepare($sql);
$q->execute();
$result = $q->fetchAll(PDO::FETCH_CLASS, "FloorValue2");
//$sqlType = "EXEC	[sp_dft_price_avg] 'AU4/2558'";
//$resType = $link->query($sqlType);
$lineStart = 4;
$i = 1;
foreach ($result as $key => $value) {
    
    putWord($objPHPExcel, 0, $lineStart, $columnArr[0], $i++, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[1], $value->Province, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[2], $value->Silo, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[3], $value->Associate, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[4], $value->Weight_All, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[5], $value->AFV2, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[6], $value->FV2, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[7], $value->RFV2, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[8], $value->AFV3, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[9], $value->FV3, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[10], $value->AFV4, 1, 1, "center", "border");
    putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $value->FV4, 1, 1, "center", "border");
    
    $lineStart++;
}




$link = "";

// If you're serving to IE over SSL, then the following may be needed
//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//header ('Pragma: public'); // HTTP/1.0
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter -> save('php://output');
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
header('Content-Disposition: attachment; filename="file.xls"');

// Write file to the browser
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>