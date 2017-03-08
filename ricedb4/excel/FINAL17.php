<?php

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require("phpexcel/Classes/PHPExcel/IOFactory.php");

$inputFileName = 'files/product17.xlsx';
//$extend = "2";
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
$link = new PDO("sqlsrv:server=127.0.0.1; Database=RiceDB", "riceuser", "l2ice2015");

// province
$provArr = array();
$sql1 = "SELECT * FROM dft_LK_Province";
$res1 = $link->query($sql1);
while ($data1 = $res1->fetch(PDO::FETCH_ASSOC)) {
    $provArr[str_replace(" ", "", $data1["Province_Name_TH"])] = $data1["Id"];
}
//print_r($provArr);
//exit();
// project
$projArr = array();
$sql2 = "SELECT * FROM dft_lk_Project";
$res2 = $link->query($sql2);
while ($data2 = $res2->fetch(PDO::FETCH_ASSOC)) {
    $projArr[str_replace(" ", "", $data2["Project"])] = $data2["Id"];
}
//print_r($projArr);
// associate
$assoArr = array();
$sql3 = "SELECT * FROM dft_LK_Associate";
$res3 = $link->query($sql3);
while ($data3 = $res3->fetch(PDO::FETCH_ASSOC)) {
    $assoArr[str_replace(" ", "", $data3["Associate"])] = $data3["Id"];
}
//print_r($assoArr);
// type
$typeArr = array();
$sql4 = "SELECT * FROM dft_LK_Type";
$res4 = $link->query($sql4);
while ($data4 = $res4->fetch(PDO::FETCH_ASSOC)) {
    $typeArr[str_replace(" ", "", $data4["Type"])] = $data4["Id"];
}
//print_r($typeArr);
// grade
$gradeArr = array();
$sql5 = "SELECT * FROM dft_LK_Grade";
$res5 = $link->query($sql5);
while ($data5 = $res5->fetch(PDO::FETCH_ASSOC)) {
    $gradeArr[str_replace(" ", "", $data5["Grade"])] = $data5["Id"];
}
//print_r($gradeArr);
//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
//$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
//echo $highestRow."<br>";
$highestRow = 12243;
//echo $highestRow;
//exit();
$count = 0;
for ($row = 4; $row <= $highestRow; $row++) {
//  Read a row of data into an array

    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'W' . $row);

//if(str_replace(" ", "", $rowData[0][9]) != '"' || str_replace(" ", "", $rowData[0][9]) == '')
//print $rowData[0][1]."<br>";
    // if (strlen($rowData[0][1]) != 0) {
    $val = array();

    $no = $rowData[0][0]; //ลำดับที่
    //print $no.",";
    $code = $rowData[0][1]; //รหัส
    //print $code.",";
    $bag = $rowData[0][2]; //เลขถุง
    //print $bag.",";
    $prov = $rowData[0][3]; //จังหวัด
//    print_r($provArr[str_replace(" ", "", $prov)]);
//    exit();
    //print $prov.",";
    $proj2 = $rowData[0][4]; //ปีโครงการ
    $proj = $rowData[0][5]; //ปีโครงการ
    //print $proj.",";
    $silo = trim($rowData[0][6]); //คลังสินค้า
    //print $silo.",";
    $asso = $rowData[0][7]; //ผู้เข้าร่วม
    //print $asso.",";
    $type = $rowData[0][8]; //ชนิดข้าว
    //print $type.",";
    $warehouse = trim($rowData[0][9]); //หลังที่
    //print $warehouse.",";
    $stack = trim($rowData[0][10]); //กองที่
    //print $stack.",";
    $weight = $rowData[0][11]; //น้ำหนักรวมกระสอบ จาก อตก อคส
    $tWeight = 0;
    if ((float) str_replace(",", "", $rowData[0][11]) > 0) {
        $tWeight = (float) str_replace(",", "", $rowData[0][11]);
    }

    //print $weightAll.",".$remark.",";

    $samp = $rowData[0][12]; //คณะที่เก็บตัวอย่าง
    //print $samp.",";

    $weightAll = $rowData[0][13]; //น้ำหนักรวมกระสอบ จาก อตก อคส
    $grade = strtoupper($rowData[0][14]); //เกรดข้าว
    if ($rowData[0][15] != "") {
        $grade = strtoupper($rowData[0][15]); //เกรดข้าวหอมมะลิ
    }
    $grade2 = $rowData[0][15];
    $remark1 = $rowData[0][16];
    $remark2 = $rowData[0][17];
    $remark3 = $rowData[0][18];
    $remark4 = $rowData[0][19];
    $remark5 = $rowData[0][20];
    $remark6 = $rowData[0][21];
    $remark7 = $rowData[0][22];
    //print $grade."<br>";

    $val = array(
        "pid" => getGUID(),
        //"pid" => $provArr[str_replace(" ", "", $prov)] . $assoArr[str_replace(" ", "", $asso)] . string_to_ascii(str_replace(" ", "", $silo)) . $warehouse . $stack,
        "no" => $no,
        "code" => $code,
        "bagNo" => $bag,
        "province" => $provArr[str_replace(" ", "", $prov)], // $prov,
        "project" => $projArr[str_replace(" ", "", $proj)], // $proj,
        "project2" => $proj2, // $proj2,
        "silo" => $silo,
        "associate" => $assoArr[str_replace(" ", "", $asso)], //$asso,
        "type" => $typeArr[str_replace(" ", "", $type)], // $type,
        "warehouse" => $warehouse,
        "stack" => $stack,
        "weight" => $weight,
        "tWeight" => $tWeight,
        "sampling" => $samp,
        "weightAll" => $weightAll,
        "grade" => $gradeArr[str_replace(" ", "", $grade)], // $grade,
        "grade2" => $grade2,
        "remark1" => $remark1,
        "remark2" => $remark2,
        "remark3" => $remark3,
        "remark4" => $remark4,
        "remark5" => $remark5,
        "remark6" => $remark6,
        "remark7" => $remark7
    );
    insertData($val);


//    $count++;
//    if ($count == 999)
//        exit();
    // }
}
//print '</table>';
//updateAddr($auction);
$link = null;

function insertData($val) {
//$statusKeyword = "AU2/2559-I2";
//    if($val["grade"]==10&&$val["type"]!=11){
//        $val["useType"] = 20;
//    }else{
//        $val["useType"] = $val["type"];
//    }
//    if ($val["grade"] >= 10) {
//        $val["useType"] = 20;
//    } else {
//        $val["useType"] = $val["type"];
//    }
//    $val["useGrade"] = $val["grade"];
//$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");
// $sqlIns = "INSERT INTO dft_Rice_Original(No, Code, Bag_No, Province, Project, Silo, Associate, Type, Warehouse, Stack, Weight, Sampling_Id, Grade, Discount_Rate, Grade_Optional, Is_Grade_Selected)"

    $sqlIns = "INSERT INTO dft_product ( Id
      ,No
      ,Code
      ,Bag_No
      ,LK_Province_Id
      ,LK_Project_Id
      ,productProject2
      ,Silo
      ,LK_Associate_Id
      ,LK_Type_Id
      ,warehouse
      ,stack
      ,weight
      ,tWeight
      ,sampling
      ,weightAll
      ,LK_Grade_Id
      ,productGrade2
      ,remark1
      ,remark2
      ,remark3
      ,remark4
      ,remark5
      ,remark6
      ,remark7)";
    $sqlIns .= "VALUES ("
            . "'" . $val["pid"] . "',"
            . "'" . $val["no"] . "',"
            . "'" . $val["code"] . "',"
            . "'" . $val["bagNo"] . "',"
            . "'" . $val["province"] . "',"
            . "'" . $val["project"] . "',"
            . "'" . $val["project2"] . "',"
            . "'" . $val["silo"] . "',"
            . "'" . $val["associate"] . "',"
            . "'" . $val["type"] . "',"
            . "'" . $val["warehouse"] . "',"
            . "'" . $val["stack"] . "',"
            . "'" . $val["weight"] . "',"
            . $val["tWeight"] . ","
            . "'" . $val["sampling"] . "',"
            . "'" . $val["weightAll"] . "',"
            . "'" . $val["grade"] . "',"
            . "'" . $val["grade2"] . "',"
            . "'" . $val["remark1"] . "',"
            . "'" . $val["remark2"] . "',"
            . "'" . $val["remark3"] . "',"
            . "'" . $val["remark4"] . "',"
            . "'" . $val["remark5"] . "',"
            . "'" . $val["remark6"] . "',"
            . "'" . $val["remark7"] . "');";

    print $sqlIns . "<br>";

    /* if($resIns = $link -> query($sqlIns)){
      print $sqlIns."<br>";
      } */
    //}
    $link = null;
}

function string_to_ascii($string) {
    $num = substr(hexdec(crc32($string)), 0, 7);
    return $num;
}

function getGUID() {
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = ""//chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
        //. chr(125); // "}"
        return $uuid;
    }
}

/* function updateAddr($auction){
  $link = new PDO("sqlsrv:server = 202.44.34.86;
  Database = RiceDB", "riceuser", "l2ice2015");

  $sqlUp = "UPDATE dft_Rice_Info_Original_Extend SET Address = grouped.Address
  FROM (Select Silo, Address FROM
  dft_Rice_Tracking
  WHERE Address != ''
  GROUP BY Silo, Address) grouped
  WHERE dft_Rice_Tracking.Silo = grouped.Silo";
  if($resIns = $link -> query($sqlUp)){
  print $sqlUp."<br>";
  }

  $sqlUp2 = "UPDATE dft_Rice_Tracking SET LK_Status_Keyword = '".$auction."' WHERE LK_Status_Keyword = ''";
  if($resUp2 = $link -> query($sqlUp2)){
  print $sqlUp2."<br>";
  }

  $link = null;
  } */
?>