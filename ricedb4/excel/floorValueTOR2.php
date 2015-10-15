<?php
if(PHP_SAPI == "cli") die("This example should only be run from a Web Browser");

/** Include PHPExcel */
require("PHPExcel/Classes/PHPExcel.php");
require("PHPExcel/Classes/PHPExcel/IOFactory.php");
require("configExcel.php");


$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

// rice type in this auction
$dataArr = array();
//$auction = $_GET["auction"];
$auction = "AU4/2558";

$projectId = 0;
$provinceId = 0;
$typeId = 0;
$gradeId = 0;
$sql = "exec sp_dft_floor_value ?,?,?,?,?";
$q = $link->prepare($sql);
$q->bindParam(1, $auction, PDO::PARAM_STR);

$q->bindParam(2, $projectId, PDO::PARAM_INT);
$q->bindParam(3, $provinceId, PDO::PARAM_INT);
$q->bindParam(4, $typeId, PDO::PARAM_INT);
$q->bindParam(5, $gradeId, PDO::PARAM_INT);
$q->execute();

//print_r($link->errorInfo());

//$rType=array();
$pjType=array();
//$gType=array();
$hType=array();
$sfp2=array();
$sfp3=array();
$sfp4=array();
$npj=0;

while($data = $q -> fetch(PDO::FETCH_ASSOC)){
    //   echo "xxxx";
    echo "xxxx";
    /*$dataArr[$data["riceType"]]["FP2"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP2"];
    $dataArr[$data["riceType"]]["FP3"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP3"];
    $dataArr[$data["riceType"]]["FP4"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP4"];*/

    //$dataArr[$data["riceType"]][$data["Province"]][$data["Grade"]]["FP2"][$data["Project"]] = $data["FP2"];
    //$header[$data["Project"]] = 1;


    //}
}
//krsort($pjType);


?>