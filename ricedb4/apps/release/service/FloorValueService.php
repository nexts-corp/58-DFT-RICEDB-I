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
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword like 'AU%'"
                . " ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function getFloorValue($auction) {
//        $sql = "EXEC sp_floor_value_stack :auction";
//        $param = array(
//            "auction" => $auction
//        );
//
//        $result = $this->datacontext->pdoQuery($sql, $param);
        $sql = "select st from " . $this->ent . "\\AuctionStack st "
                . "where st.auctionNo = :auction ";
        $param = array(
            "auction" => $auction
        );
        $result = $this->datacontext->getObject($sql, $param);

        return $result;
    }

    public function getFloorValueSilo($auction) {
//        $sql = "EXEC sp_floor_value_warehouse :auction";
//        $param = array(
//            "auction" => $auction
//        );
//
//        $result = $this->datacontext->pdoQuery($sql, $param);
        $sql = "select wh from " . $this->ent . "\\AuctionWarehouse wh "
                . "where wh.auctionNo = :auction ";
        $param = array(
            "auction" => $auction
        );
        $result = $this->datacontext->getObject($sql, $param);
        return $result;
    }

    public function exportStack($auction) {
        $status = new \apps\common\entity\Status();
        $status->keyword = $auction;
        $status = $this->datacontext->getObject($status);
        if (count($status) > 0) {
            $sql = "EXEC sp_floor_value_stack :auction";
            $param = array(
                "auction" => $auction
            );
            $data = $this->datacontext->pdoQuery($sql, $param);


            if (isset($data)) {
                ///////////////////////////// Excel /////////////////////////////
                //style
                $middle = array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                );

                $center = array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                );

                $bold = array(
                    'font' => array(
                        'bold' => true
                    )
                );
                $objPHPExcel = new \PHPExcel();
                $sheet = 0;
                $objWorkSheet = $objPHPExcel->createSheet($sheet);
                $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
                $objWorkSheet = $objPHPExcel->getActiveSheet();

                $name = $status[0]->status;
                $objWorkSheet->setTitle(str_replace("/", "_", $name));

                //column name
                $row = 1;
                $objWorkSheet->mergeCells('A1:J1')
                        ->setCellValueByColumnAndRow(0, $row, "รายละเอียดคลังสินค้ากลางสำหรับการจำหน่ายข้าวสารในสต็อกของรัฐ ครั้งที่ " . $name)
                        ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

//                $row = 2;
//                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

                $row = 2;
                // $objWorkSheet->mergeCells('A' . $row . ':A' . ($row + 1))->setCellValue('A' . $row, "ลำดับ");
                $objWorkSheet->setCellValue('A' . $row, "ลำดับ");
                $objWorkSheet->setCellValue('B' . $row, "จังหวัด");
                $objWorkSheet->setCellValue('C' . $row, "ปีโครงการ");
                $objWorkSheet->setCellValue('D' . $row, "คลังสินค้า");
                $objWorkSheet->setCellValue('E' . $row, "ผู้เข้าร่วม");
                $objWorkSheet->setCellValue('F' . $row, "ชนิดข้าว");
                $objWorkSheet->setCellValue('G' . $row, "หลังที่");
                $objWorkSheet->setCellValue('H' . $row, "กองที่");
                $objWorkSheet->setCellValue('I' . $row, "เกรด");
                $objWorkSheet->setCellValueByColumnAndRow(9, $row, "น้ำหนัก\nรวมกระสอบ(ตัน)")
                        ->getStyleByColumnAndRow(9, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);
                //$objWorkSheet->setCellValue('J' . $row, "น้ำหนักรวมกระสอบ(ตัน)");
                $objWorkSheet->setCellValue('K' . $row, "FP2");
                $objWorkSheet->setCellValue('L' . $row, "FV2");
                $objWorkSheet->setCellValue('M' . $row, "FP3");
                $objWorkSheet->setCellValue('N' . $row, "FV3");
                $objWorkSheet->setCellValue('O' . $row, "FP4");
                $objWorkSheet->setCellValue('P' . $row, "FV4");
                $row++;

                $temp = array(
                    "no" => 0,
                    "silo" => '',
                    "weight" => 0,
                    "fp2" => 0,
                    "fp3" => 0,
                    "fp4" => 0,
                    "fv2" => 0,
                    "fv3" => 0,
                    "fv4" => 0
                );
                $sum = array(
                    "no" => 0,
                    "weight" => 0,
                    "fp2" => 0,
                    "fp3" => 0,
                    "fp4" => 0,
                    "fv2" => 0,
                    "fv3" => 0,
                    "fv4" => 0
                );

                foreach ($data as $k => $v) {
                    if ($v["wareHouseCode"] != $temp["silo"] && $temp["silo"] != '') {
                        $sum = $this->summary($sum, $temp);
                        $temp = $this->printSum($objWorkSheet, $row, $temp, $center, "รวม");
                        $row++;
                    }
                    $temp = $this->printRow($objWorkSheet, $row, $sum, $v, $temp, $center);
                    $row++;
                }
                $sum = $this->summary($sum, $temp);
                $temp = $this->printSum($objWorkSheet, $row, $temp, $center, "รวม");
                $sum = $this->printSum($objWorkSheet, ++$row, $sum, $center, "รวมทั้งหมด");
                //style column
                $objWorkSheet->getStyle('A1:P2')->getFont()->setBold(true);
                $objWorkSheet->getStyle('A1:P2')->getAlignment()->applyFromArray($middle);
                $objWorkSheet->getColumnDimension('A')->setWidth(10); //ลำดับ
                $objWorkSheet->getColumnDimension('B')->setWidth(15); //จังหวัด
                $objWorkSheet->getColumnDimension('C')->setWidth(15); //ปีโครงการ
                $objWorkSheet->getColumnDimension('D')->setWidth(35); //คลังสินค้า
                $objWorkSheet->getColumnDimension('E')->setWidth(10); //ผู้เข้าร่วม
                $objWorkSheet->getColumnDimension('F')->setWidth(20); //ชนิดข้าว
                $objWorkSheet->getColumnDimension('G')->setWidth(10); //หลังที่
                $objWorkSheet->getColumnDimension('H')->setWidth(10); //กองที่
                $objWorkSheet->getColumnDimension('I')->setWidth(10); //เกรด
                $objWorkSheet->getColumnDimension('J')->setWidth(15); //น้ำหนักรวมกระสอบ(ตัน)
                $objWorkSheet->getColumnDimension('K')->setWidth(15); //FP2
                $objWorkSheet->getColumnDimension('L')->setWidth(15); //FV2
                $objWorkSheet->getColumnDimension('M')->setWidth(15); //FP3
                $objWorkSheet->getColumnDimension('N')->setWidth(15); //FV3
                $objWorkSheet->getColumnDimension('O')->setWidth(15); //FP4
                $objWorkSheet->getColumnDimension('P')->setWidth(15); //FV4

                $sheet++;
            }


            //create excel file
            ob_clean();

            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=รายละเอียดคลังสินค้ากลางสำหรับการจำหน่ายข้าวสารในสต็อกของรัฐ ครั้งที่" . str_replace("/", "_", $name) . ".xls");

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            ob_end_flush();
            exit();
        } else {
            return false;
        }
    }

    public function exportWarehouse($auction) {
        $status = new \apps\common\entity\Status();
        $status->keyword = $auction;
        $status = $this->datacontext->getObject($status);
        if (count($status) > 0) {
            $sql = "EXEC sp_floor_value_warehouse :auction";
            $param = array(
                "auction" => $auction
            );
            $data = $this->datacontext->pdoQuery($sql, $param);


            if (isset($data)) {
                ///////////////////////////// Excel /////////////////////////////
                //style
                $middle = array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                );

                $center = array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                );

                $bold = array(
                    'font' => array(
                        'bold' => true
                    )
                );
                $objPHPExcel = new \PHPExcel();
                $sheet = 0;
                $objWorkSheet = $objPHPExcel->createSheet($sheet);
                $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
                $objWorkSheet = $objPHPExcel->getActiveSheet();

                $name = $status[0]->status;
                $objWorkSheet->setTitle(str_replace("/", "_", $name));

                //column name
                $row = 1;
                $objWorkSheet->mergeCells('A1:H1')
                        ->setCellValueByColumnAndRow(0, $row, "คลังสินค้ากลางสำหรับการจำหน่ายข้าวสารในสต็อกของรัฐ ครั้งที่ " . $name)
                        ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

//                $row = 2;
//                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

                $row = 2;
                // $objWorkSheet->mergeCells('A' . $row . ':A' . ($row + 1))->setCellValue('A' . $row, "ลำดับ");
                $objWorkSheet->setCellValue('A' . $row, "ลำดับ");
                $objWorkSheet->setCellValue('B' . $row, "จังหวัด");
                $objWorkSheet->setCellValue('C' . $row, "คลังสินค้า");
                $objWorkSheet->setCellValue('D' . $row, "ผู้เข้าร่วม");
                $objWorkSheet->setCellValue('E' . $row, "น้ำหนัก\nรวมกระสอบ(ตัน)")
                        ->getStyleByColumnAndRow(9, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);
                $objWorkSheet->setCellValue('F' . $row, "FV2");
                $objWorkSheet->setCellValue('G' . $row, "FV3");
                $objWorkSheet->setCellValue('H' . $row, "FV4");
                $row++;

                $temp = array(
                    "weight" => 0,
                    "fv2" => 0,
                    "fv3" => 0,
                    "fv4" => 0
                );

                foreach ($data as $k => $v) {
                    $objWorkSheet->setCellValueExplicit('A' . $row, ($k + 1))->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('B' . $row, $v["province"]);
                    $objWorkSheet->setCellValue('C' . $row, $v["wareHouseCode"]);
                    $objWorkSheet->setCellValue('D' . $row, $v["associate"]);
                    $objWorkSheet->setCellValue('E' . $row, round($v["OWeightAll"], 6));
                    $objWorkSheet->setCellValue('F' . $row, $v["FV2"]);
                    $objWorkSheet->setCellValue('G' . $row, $v["FV3"]);
                    $objWorkSheet->setCellValue('H' . $row, $v["FV4"]);
                    $temp["weight"] += (float) (round($v["OWeightAll"], 6));
                    $temp["fv2"] += (float) ($v["FV2"]);
                    $temp["fv3"] += (float) ($v["FV3"]);
                    $temp["fv4"] += (float) ($v["FV4"]);
                    $row++;
                }
                $objWorkSheet->mergeCells('A' . $row . ':D' . $row);
                $objWorkSheet->setCellValue('A' . $row, "รวม")->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                $objWorkSheet->setCellValue('E' . $row, $temp["weight"]);
                $objWorkSheet->setCellValue('F' . $row, $temp["fv2"]);
                $objWorkSheet->setCellValue('G' . $row, $temp["fv3"]);
                $objWorkSheet->setCellValue('H' . $row, $temp["fv4"]);
                $objWorkSheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true);
                //style column
                $objWorkSheet->getStyle('A1:H2')->getFont()->setBold(true);
                $objWorkSheet->getStyle('A1:H2')->getAlignment()->applyFromArray($middle);
                $objWorkSheet->getColumnDimension('A')->setWidth(10); //ลำดับ
                $objWorkSheet->getColumnDimension('B')->setWidth(15); //จังหวัด
                $objWorkSheet->getColumnDimension('C')->setWidth(35); //คลังสินค้า
                $objWorkSheet->getColumnDimension('D')->setWidth(10); //ผู้เข้าร่วม
                $objWorkSheet->getColumnDimension('E')->setWidth(15); //น้ำหนักรวมกระสอบ(ตัน)
                $objWorkSheet->getColumnDimension('F')->setWidth(15); //FV2
                $objWorkSheet->getColumnDimension('G')->setWidth(15); //FV3
                $objWorkSheet->getColumnDimension('H')->setWidth(15); //FV4

                $sheet++;
            }


            //create excel file
            ob_clean();

            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=คลังสินค้ากลางสำหรับการจำหน่ายข้าวสารในสต็อกของรัฐ ครั้งที่" . str_replace("/", "_", $name) . ".xls");

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            ob_end_flush();
            exit();
        } else {
            return false;
        }
    }

    function summary($sum, $temp) {
        $sum["no"] ++;
        $sum["weight"] += (float) ($temp["weight"]);
        $sum["fp2"] += (float) ($temp["fp2"]);
        $sum["fp3"] += (float) ($temp["fp3"]);
        $sum["fp4"] += (float) ($temp["fp4"]);
        $sum["fv2"] += (float) ($temp["fv2"]);
        $sum["fv3"] += (float) ($temp["fv3"]);
        $sum["fv4"] += (float) ($temp["fv4"]);
        return $sum;
    }

    function printRow($objWorkSheet, $row, $sum, $v, $temp, $center) {
        $objWorkSheet->setCellValueExplicit('A' . $row, ($sum["no"] + 1) . "." . ++$temp["no"])->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
        $objWorkSheet->setCellValue('B' . $row, $v["province"]);
        $objWorkSheet->setCellValue('C' . $row, $v["project"]);
        $objWorkSheet->setCellValue('D' . $row, $v["wareHouseCode"]);
        $objWorkSheet->setCellValue('E' . $row, $v["associate"]);
        $objWorkSheet->setCellValue('F' . $row, $v["typeName"]);
        $objWorkSheet->setCellValue('G' . $row, $v["Warehouse"]);
        $objWorkSheet->setCellValue('H' . $row, $v["Stack"]);
        $objWorkSheet->setCellValue('I' . $row, $v["grade"]);
        $objWorkSheet->setCellValue('J' . $row, round($v["OWeightAll"], 6));
        $objWorkSheet->setCellValue('K' . $row, $v["FP2"]);
        $objWorkSheet->setCellValue('L' . $row, $v["FV2"]);
        $objWorkSheet->setCellValue('M' . $row, $v["FP3"]);
        $objWorkSheet->setCellValue('N' . $row, $v["FV3"]);
        $objWorkSheet->setCellValue('O' . $row, $v["FP4"]);
        $objWorkSheet->setCellValue('P' . $row, $v["FV4"]);

        $temp["silo"] = $v["wareHouseCode"];
        $temp["weight"] += (float) (round($v["OWeightAll"], 6));
        $temp["fp2"] += (float) ($v["FP2"]);
        $temp["fp3"] += (float) ($v["FP3"]);
        $temp["fp4"] += (float) ($v["FP4"]);
        $temp["fv2"] += (float) ($v["FV2"]);
        $temp["fv3"] += (float) ($v["FV3"]);
        $temp["fv4"] += (float) ($v["FV4"]);
        return $temp;
    }

    function printSum($objWorkSheet, $row, $temp, $center, $text) {
        $objWorkSheet->mergeCells('A' . $row . ':I' . $row);
        $objWorkSheet->setCellValue('A' . $row, $text)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
        $objWorkSheet->setCellValue('J' . $row, $temp["weight"]);
        $objWorkSheet->setCellValue('K' . $row, $temp["fp2"]);
        $objWorkSheet->setCellValue('L' . $row, $temp["fv2"]);
        $objWorkSheet->setCellValue('M' . $row, $temp["fp3"]);
        $objWorkSheet->setCellValue('N' . $row, $temp["fv3"]);
        $objWorkSheet->setCellValue('O' . $row, $temp["fp4"]);
        $objWorkSheet->setCellValue('P' . $row, $temp["fv4"]);
        $objWorkSheet->getStyle('A' . $row . ':P' . $row)->getFont()->setBold(true);
        $temp["no"] = 0;
        $temp["weight"] = 0;
        $temp["fp2"] = 0;
        $temp["fp3"] = 0;
        $temp["fp4"] = 0;
        $temp["fv2"] = 0;
        $temp["fv3"] = 0;
        $temp["fv4"] = 0;
        return $temp;
    }

    function putWord($sheet, $index, $row, $column, $word, $rowWidth = 1, $columnWidth = 1, $align, $border = null) {
        $columnArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'];

        $rowNew = $row + $rowWidth - 1;
        $keyNew = array_search($column, $columnArr) + $columnWidth - 1;

        if ($rowWidth != 1 || $columnWidth != 1) {
            $sheet->setActiveSheetIndex($index)
                    ->mergeCells($column . $row . ":" . $columnArr[$keyNew] . $rowNew);
        }

        $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);

        $sheet->setActiveSheetIndex($index)
                ->setCellValue($column . $row, $word);

        $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->setWrapText(true);

        if (strpos($word, "\n") !== false) {
            $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->setWrapText(true);
        }

        if ($align == "center") {
            $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->applyFromArray(
                    array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
        }
        if ($align == "right") {
            $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->applyFromArray(
                    array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
            );
        }
        if ($border == "border") {
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $sheet->getActiveSheet()->getStyle($column . $row . ":" . $columnArr[$keyNew] . $rowNew)->applyFromArray($styleArray);
            unset($styleArray);
        }


        $sheet->getActiveSheet()->getStyle($column . $row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    }

}
