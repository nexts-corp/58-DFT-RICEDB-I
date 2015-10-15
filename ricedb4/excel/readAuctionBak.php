<?php
set_time_limit(0);

include 'PHPExcel/Classes/PHPExcel/IOFactory.php';

//$inputFileName = 'auction4_2558.xlsx';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);

    /*$objPHPExcel->getActiveSheet()->getStyle('N4')
        ->getNumberFormat()->applyFromArray(
            array(
                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
            )
        );*/
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
        . '": ' . $e->getMessage());
}

$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

// province
$provArr = array();
$sql1 = "SELECT * FROM dft_LK_Province";
$res1 = $link -> query($sql1);
while($data1 = $res1 -> fetch(PDO::FETCH_ASSOC)){
    $provArr[str_replace(" ", "", $data1["Province_Name_TH"])] = $data1["Id"];
}

// project
$projArr = array();
$sql2 = "SELECT * FROM dft_LK_Project";
$res2 = $link -> query($sql2);
while($data2 = $res2 -> fetch(PDO::FETCH_ASSOC)){
    $projArr[str_replace(" ", "", $data2["Project"])] = $data2["Id"];
}

// associate
$assoArr = array();
$sql3 = "SELECT * FROM dft_LK_Associate";
$res3 = $link -> query($sql3);
while($data3 = $res3 -> fetch(PDO::FETCH_ASSOC)){
    $assoArr[str_replace(" ", "", $data3["Associate"])] = $data3["Id"];
}

// type
$typeArr = array();
$sql4 = "SELECT * FROM dft_LK_Type";
$res4 = $link -> query($sql4);
while($data4 = $res4 -> fetch(PDO::FETCH_ASSOC)){
    $typeArr[str_replace(" ", "", $data4["Type"])] = $data4["Id"];
}

// grade
$gradeArr = array();
$sql5 = "SELECT * FROM dft_LK_Grade";
$res5 = $link -> query($sql5);
while($data5 = $res5 -> fetch(PDO::FETCH_ASSOC)){
    $gradeArr[str_replace(" ", "", $data5["Grade"])] = $data5["Id"];
}
$link = null;

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(1);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
//print $highestRow."<br>";
//print '<table border="1">';

$count = 0;
$tmpAddr = "";
for ($row = 4; $row <= $highestRow; $row++) {
    //  Read a row of data into an array

    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'S' . $row);

    //if(str_replace(" ", "", $rowData[0][9]) != '"' || str_replace(" ", "", $rowData[0][9]) == '')
    //print $rowData[0][1]."<br>";
    if(strlen($rowData[0][3]) != 0){
        //print '<tr>';
        //print '<td>'.(++$count).'</td>';
        $valArr = array();
        foreach($rowData[0] as $k=>$v){
            if($k == 5){
                $v = $provArr[str_replace(" ", "", $v)];
            }
            if($k == 6){
                if(str_replace(" ", "", $v) == "ปี2555/56"){
                    if($rowData[0][7] == "1") $v = "ปี 2555/56(1)";
                    if($rowData[0][7] == "2") $v = "ปี 2555/56(2)";
                }
                $v = $projArr[str_replace(" ", "", $v)];
            }
            if($k == 9){
                if(str_replace(" ", "", $v) == '"' || str_replace(" ", "", $v) == '')
                    $v = $tmpAddr;

                $tmpAddr = $v;
            }
            if($k == 10){
                $v = $assoArr[str_replace(" ", "", $v)];
            }
            if($k == 11){
                if(str_replace(" ", "", $v) == "ปลายข้าวเหนียว") $v = "ปลายข้าว A1";
                $v = $typeArr[str_replace(" ", "", $v)];
            }
            if($k == 16){
                $v = $gradeArr[str_replace(" ", "", $v)];
            }
            if($k == 17){
                if(is_float($v)){
                    $v = $v * 100;
                    $v = $v.'%';
                }
            }
            $valArr[] = $v;
            //print '<td>'.$v.'</td>';
        }
        insertData($valArr);

        //print '</tr>';
    }
}
//print '</table>';

function insertData($val){
    $link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

    /*$sqlCk = "SELECT count(*) AS Num FROM dft_Rice_Info_Original WHERE Code='".$val[1]."'";
    $resCk = $link -> query($sqlCk);
    $dataCk = $resCk -> fetch(PDO::FETCH_ASSOC);

    if($dataCk["Num"] == 0){*/
    $sqlIns = "INSERT INTO dft_Rice_Tracking(Code, Bag_No, LK_Province_Id, LK_Project_Id, Round, Silo, Address, LK_Associate_Id, LK_Type_Id, Warehouse, Stack, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate, Weight_All)"
        ." VALUES('".$val[3]."', '".$val[4]."', '".$val[5]."', '".$val[6]."', '".$val[7]."', '".$val[8]."', '".$val[9]."', '".$val[10]."', '".$val[11]."', '".$val[12]."', '".$val[13]."', '".$val[14]."', '".$val[15]."', '".$val[16]."', '".$val[17]."', '".$val[18]."')";
    if($resIns = $link -> query($sqlIns)){
        print $sqlIns."<br>";
    }
    //}
    $link = null;
}
?>