<?php

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require("phpexcel/Classes/PHPExcel/IOFactory.php");

$inputFileName = 'files/RiceOriginalUpTo359.xlsx';
//$extend = "2";

$count = 0;
//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
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

$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

// province
$provinceArr = array();
$sql1 = "SELECT * FROM dft_LK_Province";
$res1 = $link->query($sql1);
while ($data1 = $res1->fetch(PDO::FETCH_ASSOC)) {
    $provinceArr[str_replace(" ", "", $data1["Province_Name_TH"])] = $data1["Id"];
}

// project
$projectRiceArr = array();
$sql2 = "SELECT * FROM dft_LK_Project";
$res2 = $link->query($sql2);
while ($data2 = $res2->fetch(PDO::FETCH_ASSOC)) {
    $projectRiceArr[str_replace(" ", "", $data2["Project"])] = $data2["Id"];
}

// associate
$associateArr = array();
$sql3 = "SELECT * FROM dft_LK_Associate";
$res3 = $link->query($sql3);
while ($data3 = $res3->fetch(PDO::FETCH_ASSOC)) {
    $associateArr[str_replace(" ", "", $data3["Associate"])] = $data3["Id"];
}

// type
$riceTypeArr = array();
$sql4 = "SELECT * FROM dft_LK_Type";
$res4 = $link->query($sql4);
while ($data4 = $res4->fetch(PDO::FETCH_ASSOC)) {
    $riceTypeArr[str_replace(" ", "", $data4["Type"])] = $data4["Id"];
}

// grade
$gradeRiceArr = array();
$sql5 = "SELECT * FROM dft_LK_Grade";
$res5 = $link->query($sql5);
while ($data5 = $res5->fetch(PDO::FETCH_ASSOC)) {
    $gradeRiceArr[str_replace(" ", "", $data5["Grade"])] = $data5["Id"];
}


//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();


$count = 1;
for ($row = 4; $row <= $highestRow; $row++) {
    //  Read a row of data into an array

    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'AA' . $row);

    //if(str_replace(" ", "", $rowData[0][9]) != '"' || str_replace(" ", "", $rowData[0][9]) == '')
    //print $rowData[0][1]."<br>";
    if (strlen($rowData[0][3]) != 0) {
        /* print '<tr>';
          print '<td>'.(++$count).'</td>'; */
        $val = array();
        $id = $count++; //Id
        $no = $rowData[0][0]; //ลำดับที่
        $code = $rowData[0][1]; //รหัส
        $bagNo = $rowData[0][2]; //เลขถุง
        $province = $rowData[0][3]; //จังหวัด
        $projectRice = $rowData[0][4]; //ปีโครงการ
        $projectRiceNew = $rowData[0][5]; //ปีโครงการใหม่
        $silo = $rowData[0][6]; //คลังสินค้า
        $siloNew = $rowData[0][7]; //คลังสินค้าใหม่
        $round = $rowData[0][8]; //รอบ
        $associate = $rowData[0][9]; //ผู้เข้าร่วม
        $riceType = $rowData[0][10]; //ชนิดข้าว
        $warehouse = $rowData[0][11]; //หลังที่
        $stack = $rowData[0][12]; //กองที่
        $stackNew = $rowData[0][13]; //กองที่ใหม่
        $weight = str_replace(",", "", $rowData[0][14]); //น้ำหนักไม่รวมกระสอบ
        $samp = $rowData[0][15]; //คณะที่เก็บตัวอย่าง
        $gradeRice = $rowData[0][16]; //เกรดข้าว
        $disc = $rowData[0][17]; //อัตราส่วนลด
        $gradeRiceHMR = $rowData[0][18]; //เกรดข้าวหอมมะลิ
        $canChoose = $rowData[0][19]; //สามารถคัดแยก
        $status = $rowData[0][20]; //สถานะการจำหน่าย
        $amountSplit1 = $rowData[0][21]; //จำนวนแยกกอง1
        $amountSplit2 = $rowData[0][22]; //จำนวนแยกกอง2
        $amountSplit3 = $rowData[0][23]; //จำนวนแยกกอง3
        $stackFall = $rowData[0][24]; //กองล้ม
        $warehouseEmpty = $rowData[0][25]; //คลังว่าง
        $remark = $rowData[0][26]; //หมายเหตุ

        $val = array(
            "id" => $id,
            "no" => $no,
            "code" => $code,
            "bagNo" => $bagNo,
            "province" => $province,
            "projectRice" => $projectRice,
            "projectRiceNew" => $projectRiceNew,
            "silo" => $silo,
            "siloNew" => $siloNew,
            "round" => $round,
            "associate" => $associate,
            "riceType" => $riceType,
            "warehouse" => $warehouse,
            "stack" => $stack,
            "stackNew" => $stackNew,
            "weight" => $weight,
            "sampling" => $samp,
            "gradeRice" => $gradeRice,
            "discountRate" => $disc,
            "gradeRiceHMR" => $gradeRiceHMR,
            "canChoose" => $canChoose,
            "status" => $status,
            "amountSplit1" => $amountSplit1,
            "amountSplit2" => $amountSplit2,
            "amountSplit3" => $amountSplit3,
            "stackFall" => $stackFall,
            "warehouseEmpty" => $warehouseEmpty,
            "remark" => $remark
        );
        //print (++$count)." ";
        insertData($val);

        /* foreach($val as $key => $value){
          print '<td>'.$value.'</td>';
          }
          print '</tr>'; */
    }
}
//print '</table>';
//updateAddr($auction);

$link = null;

function insertData($val) {
    $link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

    $field = "INSERT INTO dft_Rice_Original(";
    $vals = "VALUES(";
    $c = 0;
    foreach ($val as $key => $value) {
        if ($c == 0) {
            $field .= $key;
            $vals .= "'".$value."'";
            $c = 1;
        } else {
            $field .= "," . $key;
            $vals .= ",'".$value."'";
        }
    }
    $txt = $field.") ".$vals.");";
//    $sqlIns = "INSERT INTO dft_Rice_Original(No, Code, Bag_No, Province, Project, Silo, Associate, Type, Warehouse, Stack, Weight, Sampling_Id, Grade, Discount_Rate, Weight_All, Status, Grade_Optional, Is_Grade_Selected)"
//            . " VALUES('" . $val["no"] . "', '" . $val["code"] . "', '" . $val["bagNo"] . "', '" . $val["province"] . "', '" . $val["project"] . "', '" . $val["silo"] . "', '" . $val["associate"] . "', '" . $val["type"] . "', '" . $val["warehouse"] . "', '" . $val["stack"] . "', '" . $val["weight"] . "', '" . $val["sampling"] . "', '" . $val["grade"] . "', '" . $val["discount"] . "', '" . $val["weightAll"] . "', '" . $val["status"] . "', '" . $val["gradeOptional"] . "', '" . $val["canSelect"] . "');";
    print $txt . "<br>";
    /* if($resIns = $link -> query($sqlIns)){
      print $sqlIns."<br>";
      } */
    //}
    $link = null;
}

/* function updateAddr($auction){
  $link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

  $sqlUp = "UPDATE dft_Rice_Info_Original_Extend SET Address = grouped.Address
  FROM (Select Silo, Address FROM
  dft_Rice_Tracking
  WHERE Address != ''
  GROUP BY Silo, Address) grouped
  WHERE dft_Rice_Tracking.Silo=grouped.Silo";
  if($resIns = $link -> query($sqlUp)){
  print $sqlUp."<br>";
  }

  $sqlUp2 = "UPDATE dft_Rice_Tracking SET LK_Status_Keyword='".$auction."' WHERE LK_Status_Keyword = ''";
  if($resUp2 = $link -> query($sqlUp2)){
  print $sqlUp2."<br>";
  }

  $link = null;
  } */
?>