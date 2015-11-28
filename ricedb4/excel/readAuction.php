<?php
error_reporting(E_ALL);
set_time_limit(0);

require("phpexcel/Classes/PHPExcel/IOFactory.php");

$inputFileName = '8_2558.xls';
$auction = "AU8/2558";

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

$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

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


//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
//print $highestRow."<br>";
//print '<table border="1">';

$count = 0;
for ($row = 5; $row <= $highestRow; $row++) {
    //  Read a row of data into an array

    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'O' . $row);

    //if(str_replace(" ", "", $rowData[0][9]) != '"' || str_replace(" ", "", $rowData[0][9]) == '')
    //print $rowData[0][1]."<br>";
    if(strlen($rowData[0][1]) != 0){
        /*print '<tr>';
        print '<td>'.(++$count).'</td>';*/
        $val = array();

        $no = $rowData[0][0]; //ลำดับที่
        $code = $rowData[0][1]; //รหัส
        $bag = $rowData[0][2]; //เลขถุง
        $prov = $rowData[0][3]; //จังหวัด
        $proj = $rowData[0][4]; //ปีโครงการ
        //$round = $rowData[0][5]; //รอบการผลิต
        $round = '';
        $silo = $rowData[0][5]; //คลังสินค้า
        $asso = $rowData[0][6]; //ผู้เข้าร่วม
        $type = $rowData[0][7]; //ชนิดข้าว
        $warehouse = $rowData[0][8]; //หลังที่
        $stack = $rowData[0][9]; //กองที่
        $weight = $rowData[0][10]; //น้ำหนักไม่รวมกระสอบ
        $weightAll = $rowData[0][11]; //น้ำหนักรวมกระสอบ
        $samp = $rowData[0][12]; //คณะที่เก็บตัวอย่าง
        $grade = $rowData[0][13]; //เกรดข้าว

        $addr = $rowData[0][14]; //ที่อยู่

        //$disc = $rowData[0][16]; //อัตราส่วนลด
        $disc = '';
        
        //หาชื่อจังหวัด
        $prov = $provArr[str_replace(" ", "", $prov)];

        //หารอบการผลิต
        if(str_replace(" ", "", $proj) == "นาปี2555/56") $proj = "ปี2555/56";
        if(str_replace(" ", "", $proj) == "นาปี2556/57") $proj = "ปี2556/57";
        if(str_replace(" ", "", $proj) == "ปี2555/56"){
            if($round == "1") $proj = "ปี 2555/56(1)";
            if($round == "2") $proj = "ปี 2555/56(2)";
        }
        $proj = $projArr[str_replace(" ", "", $proj)];

        //หาที่อยู่
        if(str_replace(" ", "", $addr) == '"' || str_replace(" ", "", $addr) == ''){
            $addr = '';
        }

        //หาผู้เข้าร่วม
        $asso = $assoArr[str_replace(" ", "", $asso)];

        //หาชนิดข้าว
        if(str_replace(" ", "", $type) == "ปลายข้าวเหนียว" || str_replace(" ", "", $type) == "ปลายข้าวเหนียวA1") $type = "ปลายข้าว A1";
        if(str_replace(" ", "", $type) == "ข้าวขาว5%(ร.1)") $type = "ข้าวขาว5%";
        if(str_replace(" ", "", $type) == "ข้าวเหนียวขาว10%(ร1)") $type = "ข้าวเหนียวขาว10%";
        $type = $typeArr[str_replace(" ", "", $type)];

        //หาเกรดข้าว
        $grade = $gradeArr[str_replace(" ", "", $grade)];

        //หาอัตราส่วนลด
        if(is_float($disc)){
            $disc = $disc * 100;
            $disc = $disc.'%';
        }

        $weightAll = str_replace(",","", $weightAll);

        $val = array(
            "no" => $no,
            "code" => $code,
            "bagNo" => $bag,
            "province" => $prov,
            "project" => $proj,
            "round" => $round,
            "silo" => $silo,
            "address" => $addr,
            "associate" => $asso,
            "type" => $type,
            "warehouse" => $warehouse,
            "stack" => $stack,
            "weight" => $weight,
            "weightAll" => $weightAll,
            "sampling" => $samp,
            "grade" => $grade,
            "discount" => $disc,
            "auction" => $auction
        );
        insertData($val);

        /*foreach($val as $key => $value){
            print '<td>'.$value.'</td>';
        }
        print '</tr>';*/
    }
}
//print '</table>';

//updateAddr($auction);

$link = null;

function insertData($val){
    $link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

    /*$sqlCk = "SELECT count(*) AS Num FROM dft_Rice_Info_Original"
        ."WHERE Code='".$val["code"]."'";
    $resCk = $link -> query($sqlCk);
    $dataCk = $resCk -> fetch(PDO::FETCH_ASSOC);
*/
    //if($dataCk["Num"] == 0){
        $sqlIns = "INSERT INTO dft_Rice_Tracking(Code, Bag_No, LK_Province_Id, LK_Project_Id, Round, Silo, Address, LK_Associate_Id, LK_Type_Id, Warehouse, Stack, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate, Weight_All, LK_Status_Keyword, TWeight)"
            ." VALUES('".$val["code"]."', '".$val["bagNo"]."', '".$val["province"]."', '".$val["project"]."', '".$val["round"]."', '".$val["silo"]."', '".$val["address"]."', '".$val["associate"]."', '".$val["type"]."', '".$val["warehouse"]."', '".$val["stack"]."', '".$val["weight"]."', '".$val["sampling"]."', '".$val["grade"]."', '".$val["discount"]."', '".$val["weightAll"]."', '".$val["auction"]."', '".$val["weightAll"]."')";
        //print $sqlIns."<br>";
        if($resIns = $link -> query($sqlIns)){
            print $sqlIns."<br>";
        }
    //}
    $link = null;
}

function updateAddr($auction){
    $link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

    $sqlUp = "UPDATE dft_Rice_Tracking SET Address = grouped.Address
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
}
?>