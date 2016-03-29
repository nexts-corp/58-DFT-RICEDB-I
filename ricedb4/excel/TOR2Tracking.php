<?php

error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '-1');
require("phpexcel/Classes/PHPExcel/IOFactory.php");

$inputFileName = 'AU2_2559I.xlsx';
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
$provArr = array();
$sql1 = "SELECT * FROM dft_LK_Province";
$res1 = $link->query($sql1);
while ($data1 = $res1->fetch(PDO::FETCH_ASSOC)) {
    $provArr[str_replace(" ", "", $data1["Province_Name_TH"])] = $data1["Id"];
}

// project
$projArr = array();
$sql2 = "SELECT * FROM dft_LK_Project";
$res2 = $link->query($sql2);
while ($data2 = $res2->fetch(PDO::FETCH_ASSOC)) {
    $projArr[str_replace(" ", "", $data2["Project"])] = $data2["Id"];
}

// associate
$assoArr = array();
$sql3 = "SELECT * FROM dft_LK_Associate";
$res3 = $link->query($sql3);
while ($data3 = $res3->fetch(PDO::FETCH_ASSOC)) {
    $assoArr[str_replace(" ", "", $data3["Associate"])] = $data3["Id"];
}

// type
$typeArr = array();
$sql4 = "SELECT * FROM dft_LK_Type";
$res4 = $link->query($sql4);
while ($data4 = $res4->fetch(PDO::FETCH_ASSOC)) {
    $typeArr[str_replace(" ", "", $data4["Type"])] = $data4["Id"];
}



// grade
$gradeArr = array();
$sql5 = "SELECT * FROM dft_LK_Grade";
$res5 = $link->query($sql5);
while ($data5 = $res5->fetch(PDO::FETCH_ASSOC)) {
    $gradeArr[str_replace(" ", "", $data5["Grade"])] = $data5["Id"];
}


//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();


$count = 0;
for ($row = 3; $row <= $highestRow; $row++) {
    //  Read a row of data into an array

    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'R' . $row);

    //if(str_replace(" ", "", $rowData[0][9]) != '"' || str_replace(" ", "", $rowData[0][9]) == '')
    //print $rowData[0][1]."<br>";
    if (strlen($rowData[0][1]) != 0) {
        /* print '<tr>';
          print '<td>'.(++$count).'</td>'; */
        $val = array();

        $no = $rowData[0][0]; //ลำดับที่
        $code = $rowData[0][1]; //รหัส
        $bag = $rowData[0][2]; //เลขถุง
        $prov = $rowData[0][3]; //จังหวัด
        $proj = $rowData[0][4]; //ปีโครงการ
        //$round = $rowData[0][5]; //รอบ
        $silo = $rowData[0][6]; //คลังสินค้า
        $addr = $rowData[0][7]; //ที่อยู่
        $asso = $rowData[0][8]; //ผู้เข้าร่วม
        $type = $rowData[0][9]; //ชนิดข้าว
        $warehouse = $rowData[0][10]; //หลังที่
        $stack = $rowData[0][11]; //กองที่
        $weight = str_replace(",", "", $rowData[0][12]); //น้ำหนักไม่รวมกระสอบ
        $weightAll = str_replace(",", "", $rowData[0][13]); //น้ำหนักรวมกระสอบ จาก อตก อคส
        $samp = $rowData[0][14]; //คณะที่เก็บตัวอย่าง

        $grade = $rowData[0][15]; //เกรดข้าว
        $disc = $rowData[0][16]; //อัตราส่วนลด
        //  $gradeOptional = $rowData[0][19];
        $remark = $rowData[0][17]; //หมายเหตุ
        // $canSelect = $rowData[0][17];
//        $status = $rowData[0][16];
        // . "', '" .. "', '" . $val["discount"] . "', '" . $val["gradeOptional"] . "', '" . $val["canSelect"] . "');";

        $val = array(
            "no" => $no,
            "code" => $code,
            "bagNo" => $bag,
            "province" => $provArr[str_replace(" ", "", $prov)], // $prov,
            "project" => $projArr[str_replace(" ", "", $proj)], // $proj,
            "silo" => $silo,
            "address" => $addr,
            "associate" => $assoArr[str_replace(" ", "", $asso)], //$asso,
            "type" => $typeArr[str_replace(" ", "", $type)], // $type,
            "warehouse" => $warehouse,
            "stack" => $stack,
            "weight" => $weight,
            "sampling" => $samp,
            "grade" => $gradeArr[str_replace(" ", "", $grade)], // $grade,
            "discount" => $disc,
            "remark" => $remark,
            // "gradeOptional" => $gradeOptional,
            // "canSelect" => $canSelect,
//            "status" => $status,
            "weightAll" => $weightAll
        );
        //print ( ++$count) . " ";
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
    $statusKeyword = "AU2/2559-I";
    //$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");
    // $sqlIns = "INSERT INTO dft_Rice_Original(No, Code, Bag_No, Province, Project, Silo, Associate, Type, Warehouse, Stack, Weight, Sampling_Id, Grade, Discount_Rate, Grade_Optional, Is_Grade_Selected)"
    $sqlIns = "INSERT INTO dft_Rice_Tracking (Code, Bag_No, LK_Province_Id, LK_Project_Id, Silo,Address, LK_Associate_Id, LK_Type_Id, Warehouse, Stack, Weight,Weight_All,TWeight, Sampling_Id, LK_Grade_Id, Discount_Rate,Remark,LK_Status_Keyword)"
            . " VALUES( '" . $val["code"] . "', '" . $val["bagNo"] . "', '" . $val["province"] . "', '" . $val["project"] . "', '" . $val["silo"] . "', '" . $val["address"] . "', '" . $val["associate"] . "', '" . $val["type"] . "', '" . $val["warehouse"] . "', '" . $val["stack"] . "', '" . $val["weight"] . "','" . $val["weightAll"] . "'," . (float) $val["weightAll"] . ", '" . $val["sampling"] . "', '" . $val["grade"] . "', '" . $val["discount"] . "','" . $val["remark"] . "','" . $statusKeyword . "');";

    print $sqlIns . "<br>";

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