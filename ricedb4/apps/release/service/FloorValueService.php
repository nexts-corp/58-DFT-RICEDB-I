<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IFloorValueService;

class FloorValueService extends CServiceBase implements IFloorValueService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT st.id, st.status, st.keyword"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.keyword like 'AU%'"
            ." ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function getFloorValue($auction) {
        $sql = "EXEC sp_floor_value_stack :auction";
        $param = array(
            "auction" => $auction
        );

        $result = $this->datacontext->pdoQuery($sql, $param);

        return $result;
    }
    
    public function getFloorValueSilo($auction) {
        //return $auction;
        $sql = "EXEC sp_floor_value_warehouse :auction";
        $param = array(
            "auction" => $auction
        );

        $result = $this->datacontext->pdoQuery($sql, $param);

        return $result;
    }

    public function exportTOR($auction){
        $columnArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'];

        $sql = "EXEC sp_floor_value_stack :auction";
        $param  = array(
            "auction" => $auction
        );
        $result = $this->datacontext->pdoQuery($sql, $param);

        $objPHPExcel = new \PHPExcel();

        // Create new PHPExcel object
        $objPHPExcel->getActiveSheet()->setTitle("TOR");
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('30');
        //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(false);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);

        $this->putWord($objPHPExcel, 0, 1, $columnArr[0], "รายละเอียดคลังกลางข้าวสำหรับการประกาศเปิดประมูล ครั้งที่ ".$result[0]["auctionCode"]."  ".$result[0]["auctionDate"], 1, 10, "center", "");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[0], "ลำดับ ", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[1], "จังหวัด", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[2], "ปีโครงการ", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[3], "รอบ", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[4], "ชื่อคลังสินค้ากลาง/ไซโล", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[5], "ที่ตั้งโกดัง", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[6], "เข้าร่วมฯ", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[7], "ชนิดข้าว", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[8], "หลังที่", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[9], "กองที่", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[10], "เกรด", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[11], "น้ำหนักรวมเนื้อข้าว กระสอบ(ตัน)", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[12], "Floor Price 2", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[13], "มูลค่าขั้นต่ำ (บาท) (Floor Value 2)", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[14], "Floor Price 3", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[15], "มูลค่าขั้นต่ำ (บาท) (Floor Value 3)", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[16], "Floor Price 4", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[17], "มูลค่าขั้นต่ำ (บาท) (Floor Value 4)", 1, 1, "center", "border");
        $this->putWord($objPHPExcel, 0, 2, $columnArr[18], "FV2 ปัดเศษ", 1, 1, "center", "border");



        //return $result;

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
            'type'=>  \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor'=>array(
                "rgb"=>"fff000"
            )
        );
        foreach ($result as $key => $value) {
            if($value["projectRound"] == "1") $value["projectRound"] = "รอบ 1";
            elseif($value["projectRound"] == "2") $value["projectRound"] = "รอบ 2";
            else $value["projectRound"] = "";

            if ($tempSilo != str_replace(' ', '', $value["wareHouseCode"]) && $tempSilo != "") {


                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $tempWeight, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $tempFV2 / $tempWeight, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $tempFV2, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $tempFV3, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $tempFV4 / $tempWeight, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $tempFV4, 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $tempXFP2, 1, 1, "left", "border");
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
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[0], $tempKey . " (" . $tempKeySub.")", 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[1], $value["province"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[2], str_replace('(2)','',str_replace('(1)','',$value["project"])), 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[3], $value["projectRound"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[4], $value["wareHouseCode"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[5], $value["wareHouseAddress"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[6], $value["associate"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[7], $value["typeName"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[8], $value["Warehouse"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[9], $value["Stack"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[10], $value["grade"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $value["OWeightAll"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $value["FP2"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $value["FV2"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $value["FP3"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $value["FV3"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $value["FP4"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $value["FV4"], 1, 1, "left", "border");
                $fvp = (int) $value["FV2"];
                if ($fvp % 100) {
                    $xx = $fvp % 100;
                    $fvp = ($fvp - $xx) + 100;
                }
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $fvp, 1, 1, "left", "border");
            } else if ($tempSilo == str_replace(' ', '', $value["wareHouseCode"]) || $tempSilo == "") {
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[0], $tempKey . " (" . $tempKeySub.")", 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[1], $value["province"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[2], str_replace('(2)','',str_replace('(1)','',$value["project"])), 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[3], $value["projectRound"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[4], $value["wareHouseCode"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[5], $value["wareHouseAddress"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[6], $value["associate"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[7], $value["typeName"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[8], $value["Warehouse"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[9], $value["Stack"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[10], $value["grade"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $value["OWeightAll"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $value["FP2"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $value["FV2"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $value["FP3"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $value["FV3"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $value["FP4"], 1, 1, "left", "border");
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $value["FV4"], 1, 1, "left", "border");
                $fvp = (int) $value["FV2"];
                if ($fvp % 100) {
                    $xx = $fvp % 100;
                    $fvp = ($fvp - $xx) + 100;
                }
                $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $fvp, 1, 1, "left", "border");
            }
            $tempSilo = str_replace(' ', '', $value["wareHouseCode"]);
            $tempWeight +=(double)$value["OWeightAll"];
            $tempFP2 += (double)$value["FP2"];
            $tempFV2 += (double)$value["FV2"];
            $tempFP3 += (double)$value["FP3"];
            $tempFV3 += (double)$value["FV3"];
            $tempFP4 += (double)$value["FP4"];
            $tempFV4 += (double)$value["FV4"];

            $stempWeight +=(double)$value["OWeightAll"];
            $stempFP2 += (double)$value["FP2"];
            $stempFV2 += (double)$value["FV2"];
            $stempFP3 += (double)$value["FP3"];
            $stempFV3 += (double)$value["FV3"];
            $stempFP4 += (double)$value["FP4"];
            $stempFV4 += (double)$value["FV4"];

            $fvp = (int) $value["FV2"];
            if ($fvp % 100) {
                $xx = $fvp % 100;
                $fvp = ($fvp - $xx) + 100;
            }

            $tempXFP2 += $fvp;

            $stempXFP2+=$fvp;

            $tempKeySub++;
            $lineStart++;
        }

        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $tempFV2 / $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $tempFV2, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $tempFV3, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $tempFV4 / $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $tempFV4, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $tempXFP2, 1, 1, "left", "border");

        for($jj=0;$jj<19;$jj++){
            $objPHPExcel->getActiveSheet()->getStyle($columnArr[$jj].$lineStart)->getFill()->applyFromArray($style);
        }
        $lineStart++;

        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[11], $stempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[12], $stempFV2 / $stempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[13], $stempFV2, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[14], $tempFV3 / $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[15], $stempFV3, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[16], $stempFV4 / $tempWeight, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[17], $stempFV4, 1, 1, "left", "border");
        $this->putWord($objPHPExcel, 0, $lineStart, $columnArr[18], $stempXFP2, 1, 1, "left", "border");


        //create excel file
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=TOR_" . str_replace("/", "_", $auction) . ".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();
    }

    function putWord($sheet, $index, $row, $column, $word, $rowWidth = 1, $columnWidth = 1, $align, $border = null){
        $columnArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'];

        $rowNew = $row + $rowWidth - 1;
        $keyNew = array_search($column, $columnArr) + $columnWidth - 1;

        if($rowWidth != 1 || $columnWidth != 1){
            $sheet -> setActiveSheetIndex($index)
                -> mergeCells($column.$row.":".$columnArr[$keyNew].$rowNew);
        }

        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);

        $sheet -> setActiveSheetIndex($index)
            -> setCellValue($column.$row, $word);

        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setWrapText(true);

        if(strpos($word,"\n") !== false){
            $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setWrapText(true);
        }

        if($align == "center"){
            $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->applyFromArray(
                array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
        }
        if($align == "right"){
            $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->applyFromArray(
                array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
            );
        }
        if($border == "border"){
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $sheet -> getActiveSheet() -> getStyle($column.$row.":".$columnArr[$keyNew].$rowNew) -> applyFromArray($styleArray);
            unset($styleArray);
        }


        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

    }
}