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
$sql = "exec sp_dft_floor_price2 ?,?,?,?,?";
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
    // echo "xxxx";
    /*$dataArr[$data["riceType"]]["FP2"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP2"];
    $dataArr[$data["riceType"]]["FP3"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP3"];
    $dataArr[$data["riceType"]]["FP4"][$data["Project"]][$data["Province"]][$data["Grade"]] = $data["FP4"];*/

    //$dataArr[$data["riceType"]][$data["Province"]][$data["Grade"]]["FP2"][$data["Project"]] = $data["FP2"];
    //$header[$data["Project"]] = 1;

    $rt=$data["riceType"];
    $pv=$data["Province"];
    $gd=$data["Grade"];
    $pj=$data["Project"];
    $fp2=$data["FP2"];
    $sfp2[$rt][$pv][$gd][$pj]=$fp2;


    $fp3=$data["FP3"];
    $sfp3[$rt][$pv][$gd][$pj]=$fp3;

    $fp4=$data["FP4"];
    $sfp4[$rt][$pv][$gd][$pj]=$fp4;


    /*/if(!array_key_exists($rt,$rType)){
        $rType[$rt]=$rt;
    }

    if(!array_key_exists($pv,$pType)){
        $pType[$rt][$pv]=$pv;
    }

    if(!array_key_exists($gd,$gType)){
        $gType[$rt][$pv][$gd]=$gd;
    }

    if(!array_key_exists($pj,$pjType)){
      */
    if(!array_key_exists($pj,$pjType)){
        $pjType[$pj]=$pj;
        $npj++;
    }
    $hType[$rt][$pv][$gd][$pj]=$pj;
    //}
}
krsort($pjType);

$center = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$count = 0;
$objPHPExcel = new PHPExcel();

foreach($hType as $rt => $rType){
    $rowId = 0;

    $objWorkSheet = $objPHPExcel->createSheet($count++);
    $objWorkSheet = $objPHPExcel->setActiveSheetIndex($count-1);
    $objWorkSheet = $objPHPExcel->getActiveSheet();
    $objWorkSheet->setTitle($rt);

    $rowId += 1;
    $objWorkSheet->mergeCells($columnArr[0].$rowId.":".$columnArr[3*$npj+1].$rowId)->setCellValue($columnArr[0].$rowId, "ราคา Floor Price ของ ".$rt)
        ->getStyle($columnArr[0].$rowId)->getAlignment()->applyFromArray($center);

    $rowId += 2;
    $objWorkSheet->mergeCells($columnArr[0].$rowId.":".$columnArr[0].($rowId+1))->setCellValue($columnArr[0].$rowId, "จังหวัด")
        ->getStyle($columnArr[0].$rowId)->getAlignment()->applyFromArray($center);

    $objWorkSheet->mergeCells($columnArr[1].$rowId.":".$columnArr[1].($rowId+1))->setCellValue($columnArr[1].$rowId, "Grade")
        ->getStyle($columnArr[1].$rowId)->getAlignment()->applyFromArray($center);

    $objWorkSheet->mergeCells($columnArr[2].$rowId.":".$columnArr[$npj+1].$rowId)->setCellValue($columnArr[2].$rowId, "FP2")
        ->getStyle($columnArr[2].$rowId)->getAlignment()->applyFromArray($center);
    $objWorkSheet->mergeCells($columnArr[$npj+2].$rowId.":".$columnArr[2*$npj+1].$rowId)->setCellValue($columnArr[$npj+2].$rowId, "FP3")
        ->getStyle($columnArr[$npj+2].$rowId)->getAlignment()->applyFromArray($center);
    $objWorkSheet->mergeCells($columnArr[2*$npj+2].$rowId.":".$columnArr[3*$npj+1].$rowId)->setCellValue($columnArr[2*$npj+2].$rowId, "FP4")
        ->getStyle($columnArr[2*$npj+2].$rowId)->getAlignment()->applyFromArray($center);


    //$html.='<tr><td colspan="'.($npj*3 + 2).'">'.$rt.'</td></tr>';
    //$html.='<tr><td rowspan="2">จังหวัด</td><td rowspan="2">Grade</td><td colspan="'.$npj.'">FP2</td><td colspan="'.$npj.'">FP3</td><td colspan="'.$npj.'">FP4</td></tr>';
    //$html.='<tr>';
    $rowId += 1;
    $countPj = 0;
    for($i=0;$i<3;$i++){
        foreach($pjType as $pj => $x){
            $objWorkSheet->setCellValue($columnArr[$countPj+2].$rowId, $pj);
            $countPj++;
        }
    }
    //$html.='</tr>';

    foreach($rType as $pv => $pType){
        foreach($pType as $gd => $gType){
            //$html.="<tr>";
            //$html.="<td>".$pv."</td>";
            //$html.="<td>".$gd."</td>";
            //$html2="";
            //$html3="";
            //$html4="";
            $rowId += 1;
            $column = 0;

            $objWorkSheet->setCellValue($columnArr[$column++].$rowId, $pv)
                ->getStyle($columnArr[$column-1].$rowId)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue($columnArr[$column++].$rowId, $gd)
                ->getStyle($columnArr[$column-1].$rowId)->getAlignment()->applyFromArray($center);
            $fp2Arr = array();
            $fp3Arr = array();
            $fp4Arr = array();
            foreach($pjType as $pj => $x){

                if(isset($sfp2[$rt][$pv][$gd][$pj]))
                    $fp2=round($sfp2[$rt][$pv][$gd][$pj], 2);
                else
                    $fp2 = "-";
                if(isset($sfp3[$rt][$pv][$gd][$pj]))
                    $fp3=round($sfp3[$rt][$pv][$gd][$pj], 2);
                else
                    $fp3 = "-";
                if(isset($sfp4[$rt][$pv][$gd][$pj]))
                    $fp4=round($sfp4[$rt][$pv][$gd][$pj], 2);
                else
                    $fp4 = "-";
                //$fp3=$sfp3[$rt][$pv][$gd][$pj];
                //$fp4=$sfp4[$rt][$pv][$gd][$pj];
                //$html2.="<td>".$fp2."</td>";
                //$html3.="<td>".$fp3."</td>";
                //$html4.="<td>".$fp4."</td>";
                $fp2Arr[] = $fp2;
                $fp3Arr[] = $fp3;
                $fp4Arr[] = $fp4;

            }
            for($x = 0; $x < count($fp2Arr); $x++){
                $objWorkSheet->setCellValue($columnArr[$column++].$rowId, $fp2Arr[$x]);
            }
            for($y = 0; $y < count($fp3Arr); $y++){
                $objWorkSheet->setCellValue($columnArr[$column++].$rowId, $fp3Arr[$y]);
            }
            for($z = 0; $z < count($fp4Arr); $z++){
                $objWorkSheet->setCellValue($columnArr[$column++].$rowId, $fp4Arr[$z]);
            }
            //$html.=$html2;
            //$html.=$html3;
            //$html.=$html4;
            //$html.="</tr>";
        }


    }
    //   $html.="</table>";
    // echo $html;
    //break;
}

//$html.="</table>";
//echo $html;


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=final_floor_price_".str_replace("/", "_", $auction).".xls");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');


$link = null;

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter -> save('php://output');

?>