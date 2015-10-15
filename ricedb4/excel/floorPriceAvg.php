<?php
if(PHP_SAPI == "cli") die("This example should only be run from a Web Browser");

/** Include PHPExcel */
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel.php");
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel/IOFactory.php");
require(dirname(__FILE__) . "/configExcel.php");


$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

// rice type in this auction

$objPHPExcel = new PHPExcel();

// Create new PHPExcel object
$objPHPExcel -> getActiveSheet() -> setTitle("test");
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

putWord($objPHPExcel, 0, 1, $columnArr[0], "ราคาข้าวเฉลี่ย 7 วัน สำหรับการประมูลข้าวสารในสต๊อกของรัฐบาล ครั้งที่ 1/1 (ราคาระหว่างวันที่ 1 - 1 dd 2558) ", 1, 10, "center", "");
putWord($objPHPExcel, 0, 2, $columnArr[0], "ชนิดข้าว ", 2, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[1], "ราคาข้าวเก่า", 1, 3, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[4], "ราคาข้าว Mean (เก่า - ใหม่)", 1, 3, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[7], "ราคาข้าวใหม่", 1, 3, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[1], "คน.", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[2], "สมาคม", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[3], "เฉลี่ย", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[4], "คน.(เก่า-ใหม่)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[5], "สมาคม(เก่า-ใหม่)", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[6], "เฉลี่ย 2", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[7], "คน.", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[8], "สมาคม", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[9], "เฉลี่ย", 1, 1, "center", "border");


$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);

$sqlType = "EXEC	[sp_dft_price_avg] 'AU4/2558'";
$resType = $link -> query($sqlType);
$lineStart = 4;
while($dataType = $resType -> fetch(PDO::FETCH_ASSOC)){
    $lineType = $lineStart++;


    $objPHPExcel->getActiveSheet()->getRowDimension($lineType)->setRowHeight(25);

    putWord($objPHPExcel, 0, $lineType, $columnArr[0], $dataType["riceType"], 1, 1, "left", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[1], replacePrice($dataType["sumOldMean1"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[2], replacePrice($dataType["sumOldMean2"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[3], replacePrice($dataType["OldPrice"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[4], replacePrice($dataType["sumOldNewMean1"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[5], replacePrice($dataType["sumOldNewMean2"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[6], replacePrice($dataType["OldNewPrice"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[7], replacePrice($dataType["sumNewMean1"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[8], replacePrice($dataType["sumNewMean2"]), 1, 1, "right", "border");
    putWord($objPHPExcel, 0, $lineType, $columnArr[9], replacePrice($dataType["NewPrice"]), 1, 1, "right", "border");


}




//putWord($objPHPExcel, 0, 2, "a", "ตัวชี้วัดคำรับรอง ปี "."a", 2, 1, "center", "border");


/*
$sqlWork = "SELECT bg_Org_Faculty.Name AS Faculty_Name, bg_Work_Type.Field_Name, bg_Work_Type.Name FROM bg_Org_Faculty INNER JOIN bg_Work_Type ON bg_Org_Faculty.Work_Type_Id=bg_Work_Type.Id WHERE bg_Org_Faculty.Id='".$facultyId."'";
$resWork = $link -> query($sqlWork);
$dataWork = $resWork -> fetch(PDO::FETCH_ASSOC);

// Add header data
//putWord(sheet, index, row, column, word, rowWidth, columnWidth, align, border);
putWord($objPHPExcel, 0, 1, $columnArr[0], "ตัวชี้วัดคำรับรองการปฏิบัติงาน ประจำปีงบประมาณ พ.ศ.".$_COOKIE["mis"]["year"]."\nประเภทส่วนงาน".$dataWork["Name"]." : ".$dataWork["Faculty_Name"] , 1, 8, "center");

putWord($objPHPExcel, 0, 2, $columnArr[0], "ตัวชี้วัดคำรับรอง ปี ".$_COOKIE["mis"]["year"], 2, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[1], "หน่วยนับ", 2, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[2], "ค่าเป้าหมาย\nตัวชี้วัด", 2, 1, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[3], "เกณฑ์การให้คะแนนผลลัพธ์ของตัวชี้วัด (ระดับคะแนน)", 1, 5, "center", "border");
putWord($objPHPExcel, 0, 2, $columnArr[8], "หมายเหตุ", 2, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[3], "คะแนน 1", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[4], "คะแนน 2", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[5], "คะแนน 3", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[6], "คะแนน 4", 1, 1, "center", "border");
putWord($objPHPExcel, 0, 3, $columnArr[7], "คะแนน 5", 1, 1, "center", "border");

// Get MySQL Data
$sqlType = "SELECT * FROM bg_Plan_Type ORDER BY Id ASC";
$resType = $link -> query($sqlType);
$lineStart = 4;
while($dataType = $resType -> fetch(PDO::FETCH_ASSOC)){
    $lineType = $lineStart++;
    putWord($objPHPExcel, 0, $lineType, $columnArr[0], "ตัวชี้วัด".$dataType["Name"], 1, 9, "left", "border");
    $objPHPExcel -> getActiveSheet() -> getStyle($columnArr[0].$lineType) -> applyFromArray($styleBU);

    if($dataType["Code"] != "work"){
        $sqlIssues = "SELECT * FROM bg_Plan_Issue WHERE Plan_Type_Id='".$dataType["Id"]."' ORDER BY Name ASC";
        $resIssues = $link -> query($sqlIssues);
        while($dataIssues = $resIssues -> fetch(PDO::FETCH_ASSOC)){
            $lineIssues = $lineStart++;
            putWord($objPHPExcel, 0, $lineIssues, $columnArr[0], "ประเด็นยุทธศาสตร์ที่ ".$dataIssues["Name"], 1, 9, "left", "border");
            $objPHPExcel -> getActiveSheet() -> getStyle($columnArr[0].$lineIssues) -> applyFromArray($styleB);

            $sqlTarget = "SELECT * FROM bg_Plan_Target WHERE Plan_Issue_Id='".$dataIssues['Id']."' ORDER BY Name ASC";
            $resTarget = $link -> query($sqlTarget);
            while($dataTarget = $resTarget -> fetch(PDO::FETCH_ASSOC)){
                $lineTarget = $lineStart++;
                putWord($objPHPExcel, 0, $lineTarget, $columnArr[0], "เป้าประสงค์ที่ ".$dataTarget["Name"], 1, 9, "left", "border");
                $objPHPExcel -> getActiveSheet() -> getStyle($columnArr[0].$lineTarget) -> applyFromArray($styleB);

                $headerTarget = explode(" ", $dataTarget["Name"]);
                $count = 1;
                $sqlAff = "SELECT * FROM bg_Affirmative_Target WHERE Plan_Target_Id='".$dataTarget["Id"]."' AND Org_Faculty_Id='".$facultyId."' ORDER BY Plan_Target_Id, No ASC";
                $resAff = $link -> query($sqlAff);
                while($dataAff = $resAff -> fetch(PDO::FETCH_ASSOC)){
                    $lineIn = $lineStart++;

                    putWord($objPHPExcel, 0, $lineIn, $columnArr[0], boxExcel(text2html($dataAff["No"]." ".$dataAff["Name"])), 1, 1, "left");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[1], $dataAff["Unit"], 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[2], $dataAff[$dataAff["Target"]], 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[3], text2html($dataAff["Score1"]), 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[4], text2html($dataAff["Score2"]), 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[5], text2html($dataAff["Score3"]), 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[6], text2html($dataAff["Score4"]), 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[7], text2html($dataAff["Score5"]), 1, 1, "center");
                    putWord($objPHPExcel, 0, $lineIn, $columnArr[8], boxExcel(text2html($dataAff["Remark"])), 1, 1, "left");
                }
            }
        }
    }
    else{
        //specific
        $lineIn = $lineStart++;

        putWord($objPHPExcel, 0, $lineIn, $columnArr[0], "ตัวชี้วัด", 1, 1, "left");
        putWord($objPHPExcel, 0, $lineIn, $columnArr[1], "", 1, 1, "center");
        putWord($objPHPExcel, 0, $lineIn, $columnArr[2], "", 1, 1, "left");

    }
}

// Set header
$objPHPExcel -> getActiveSheet() -> getRowDimension('1') -> setRowHeight(40);
$objPHPExcel -> getActiveSheet() -> getStyle('A1') -> getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('A2') -> getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('B2') -> getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('C2') -> getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Set width of column
for($i = 0; $i < count($columnArr); $i++) {
    if($i == 0) $width = 45;
    elseif($i == count($columnArr) - 1) $width = 30;
    else $width = 20;
    $objPHPExcel -> getActiveSheet() -> getColumnDimension($columnArr[$i]) -> setWidth($width);
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=ตัวชี้วัดคำรับรอง_".$_COOKIE["mis"]["year"]."_".$dataWork["Faculty_Name"].".xls");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
*/

$link = null;

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
$objWriter -> save('php://output');






?>