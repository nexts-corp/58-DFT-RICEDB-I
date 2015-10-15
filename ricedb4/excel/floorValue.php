<?php

if (PHP_SAPI == "cli")
    die("This example should only be run from a Web Browser");

/** Include PHPExcel */
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel.php");
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel/IOFactory.php");
require(dirname(__FILE__) . "/configExcel.php");
require("../apps/rice/entity/FloorValue.php");

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
putWord($objPHPExcel, 0, 2, $columnArr[0], "ลำดับ ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[1], "จังหวัด", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[2], "ปีโครงการ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[3], "รอบ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[4], "ชื่อคลังสินค้ากลาง/ไซโล", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[5], "ที่ตั้งโกดัง", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[6], "เข้าร่วมฯ", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[7], "ชนิดข้าว", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[8], "หลังที่", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[9], "กองที่", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[10], "เกรด", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[11], "น้ำหนักรวมเนื้อข้าว กระสอบ(ตัน)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[12], "Floor Price 2", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[13], "มูลค่าขั้นต่ำ (บาท) (Floor Value 2)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[14], "Floor Price 3", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[15], "มูลค่าขั้นต่ำ (บาท) (Floor Value 3)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[16], "Floor Price 4", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[17], "มูลค่าขั้นต่ำ (บาท) (Floor Value 4)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[18], "FV2 ปัดเศษ", 1, 1, "center", "border");


//$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
//$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
//$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
$sql = "exec sp_dft_floor_value 'AU4/2558',0,0,0,0";
$q = $link->prepare($sql);
$q->execute();
$result = $q->fetchAll(PDO::FETCH_CLASS, "FloorValue");
//$sqlType = "EXEC	[sp_dft_price_avg] 'AU4/2558'";
//$resType = $link->query($sqlType);
$lineStart = 3;
$tempSilo = "";
$tempKey = 1;
$tempKeySub = 1;
$tempWeight = 0;
$tempFP2 = 0;
$tempFP3 = 0;
$tempFP4 = 0;
$tempFV2 = 0;
$tempFV3 = 0;
$tempFV4 = 0;

$tempXFP2 = 0;

$stempWeight = 0;
$stempFP2 = 0;
$stempFP3 = 0;
$stempFP4 = 0;
$stempFV2 = 0;
$stempFV3 = 0;
$stempFV4 = 0;

$stempXFP2 = 0;

$i = 0;
     $style=array(
            'type'=>  PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor'=>array(
                "rgb"=>"fff000"
            )
        );
foreach ($result as $key => $value) {
    if ($tempSilo != str_replace(' ', '', $value->Silo) && $tempSilo != "") {
        
    
        putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $tempWeight, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $tempFV2 / $tempWeight, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $tempFV2, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $tempFV3, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $tempFV4 / $tempWeight, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $tempFV4, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $tempXFP2, 1, 1, "left", "border");
     for($jj=0;$jj<19;$jj++){
            $objPHPExcel->getActiveSheet()->getStyle($columnArr[$jj].$lineStart)->getFill()->applyFromArray($style);
        }
       
        
        
        $tempWeight = 0;
        $tempFP2 = 0;
        $tempFP3 = 0;
        $tempFP4 = 0;
        $tempFV2 = 0;
        $tempFV3 = 0;
        $tempFV4 = 0;
        $tempXFP2=0;
        $tempKey++;
        $tempKeySub = 1;
        $lineStart++;
        putWord($objPHPExcel, 0, $lineStart, $columnArr[0], $tempKey . " (" . $tempKeySub.")", 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[1], $value->Province, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[2], str_replace('(2)','',str_replace('(1)','',$value->Project)), 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[3], $value->Round, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[4], $value->Silo, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[5], $value->Address, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[6], $value->Associate, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[7], $value->riceType, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[8], $value->Warehouse, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[9], $value->Stack, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[10], $value->Grade, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $value->Weight_All, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $value->FP2, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $value->FV2, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $value->FP3, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $value->FV3, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $value->FP4, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $value->FV4, 1, 1, "left", "border");
        $fvp = (int) $value->FV2;
        if ($fvp % 100) {
            $xx = $fvp % 100;
            $fvp = ($fvp - $xx) + 100;
        }
        putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $fvp, 1, 1, "left", "border");
    } else if ($tempSilo == str_replace(' ', '', $value->Silo) || $tempSilo == "") {
        putWord($objPHPExcel, 0, $lineStart, $columnArr[0], $tempKey . " (" . $tempKeySub.")", 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[1], $value->Province, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[2], str_replace('(2)','',str_replace('(1)','',$value->Project)), 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[3], $value->Round, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[4], $value->Silo, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[5], $value->Address, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[6], $value->Associate, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[7], $value->riceType, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[8], $value->Warehouse, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[9], $value->Stack, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[10], $value->Grade, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $value->Weight_All, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $value->FP2, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $value->FV2, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $value->FP3, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $value->FV3, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $value->FP4, 1, 1, "left", "border");
        putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $value->FV4, 1, 1, "left", "border");
        $fvp = (int) $value->FV2;
        if ($fvp % 100) {
            $xx = $fvp % 100;
            $fvp = ($fvp - $xx) + 100;
        }
        putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $fvp, 1, 1, "left", "border");
    }
    $tempSilo = str_replace(' ', '', $value->Silo);
    $tempWeight +=(double)$value->Weight_All;
    $tempFP2 += (double)$value->FP2;
    $tempFV2 += (double)$value->FV2;
    $tempFP3 += (double)$value->FP3;
    $tempFV3 += (double)$value->FV3;
    $tempFP4 += (double)$value->FP4;
    $tempFV4 += (double)$value->FV4;
    
    $stempWeight +=(double)$value->Weight_All;
    $stempFP2 += (double)$value->FP2;
    $stempFV2 += (double)$value->FV2;
    $stempFP3 += (double)$value->FP3;
    $stempFV3 += (double)$value->FV3;
    $stempFP4 += (double)$value->FP4;
    $stempFV4 += (double)$value->FV4;
    
    $fvp = (int) $value->FV2;
        if ($fvp % 100) {
            $xx = $fvp % 100;
            $fvp = ($fvp - $xx) + 100;
        }
        
    $tempXFP2 += $fvp;
    
    $stempXFP2+=$fvp;
    
    $tempKeySub++;
    $lineStart++;
}

putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $tempFV2 / $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $tempFV2, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $tempFV3, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $tempFV4 / $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $tempFV4, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $tempXFP2, 1, 1, "left", "border");

  for($jj=0;$jj<19;$jj++){
            $objPHPExcel->getActiveSheet()->getStyle($columnArr[$jj].$lineStart)->getFill()->applyFromArray($style);
        }
 $lineStart++;
 
 putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $stempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $stempFV2 / $stempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $stempFV2, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $stempFV3, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $stempFV4 / $tempWeight, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $stempFV4, 1, 1, "left", "border");
putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $stempXFP2, 1, 1, "left", "border");

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