<?php

namespace apps\reserve\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\reserve\interfaces\IExportService;

class ExportService extends CServiceBase implements IExportService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsReserve() {
        $sql = "SELECT"
            ." rl.id, rl.reserveCode, rs.reserveName, rl.detail, rl.keyword, rl.target, rl.dateCreated"
        ." FROM ".$this->ent."\\ReserveList rl"
        ." JOIN ".$this->ent."\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
        ." ORDER BY rl.id ASC";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function export($reserveList){
        //return "OK";
        //style
        $center = array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );

        $objPHPExcel = new \PHPExcel();
        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
        $objWorkSheet = $objPHPExcel->getActiveSheet();

        //column row
        $row = 1;
        $sql = "SELECT"
            ." rl.id, rl.reserveCode, rs.reserveName, rl.detail, rl.keyword, rl.target, rl.dateCreated"
            ." FROM ".$this->ent."\\ReserveList rl"
            ." JOIN ".$this->ent."\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
            ." WHERE rl.keyword = :keyword";

        $param = array(
            "keyword" => $reserveList
        );
        $list = $this->datacontext->getObject($sql, $param);
        $title = $list[0]["reserveName"];

        $objWorkSheet -> setTitle($title);

        $objWorkSheet->mergeCells('A1:O1')->setCellValueByColumnAndRow(0, $row, "รายการ".$list[0]["reserveName"]."\r\n".$list[0]["detail"])
            ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($center);


        $row = 3;
        $objWorkSheet->setCellValueByColumnAndRow(0, $row, "Code: ".$reserveList)->getProtection()->setFormatCells(true);

        $columnT = ["รหัสประจำตัว", "รหัส", "เลขถุง", "จังหวัด", "ปีโครงการ", "รอบ", "คลังสินค้า", "ที่อยู่", "ผู้เข้าร่วมฯ", "ชนิด",
                   "หลัง", "กอง", "น้ำหนัก (ตัน)", "เกรด", "อัตราส่วนลด (%)", "ปริมาณรวมกระสอบ(ตัน)"];

        $row =  4;
        foreach($columnT as $col => $val){
            $objWorkSheet->getColumnDimensionByColumn($col)->setWidth(20);
            $objWorkSheet->setCellValueByColumnAndRow($col, $row, $val)->getStyleByColumnAndRow($col, $row)->getAlignment()->applyFromArray($center);
        }

        $sql = "SELECT"
                ." rs.stackCode, rs.code, rs.bagNo, pv.provinceNameTH, pj.project, rs.silo, ac.associate, tp.type,"
                ." rs.warehouse, rs.stack, rs.weight, gd.grade, rs.discountRate"
            ." FROM ".$this->ent."\\RiceReserve rs"
            ." JOIN ".$this->ent."\\Province pv WITH pv.id = rs.provinceId"
            ." JOIN ".$this->ent."\\Project pj WITH pj.id = rs.projectId"
            ." JOIN ".$this->ent."\\Associate ac WITH ac.id = rs.associateId"
            ." JOIN ".$this->ent."\\Type tp WITH tp.id = rs.typeId"
            ." JOIN ".$this->ent."\\Grade gd WITH gd.id = rs.gradeId"
            ." WHERE rs.reserveKeyword = :reserveKeyword";

        $param = array(
            "reserveKeyword" => $reserveList
        );
        $data = $this->datacontext->getObject($sql, $param);

        $row = 5;
        foreach($data as $key => $val){
            $objWorkSheet->setCellValueExplicitByColumnAndRow(0, $row, $val["stackCode"], \PHPExcel_Cell_DataType::TYPE_STRING);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(1, $row, $val["code"], \PHPExcel_Cell_DataType::TYPE_STRING);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(2, $row, $val["bagNo"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(3, $row, $val["provinceNameTH"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(4, $row, $val["project"]);

            $objWorkSheet->setCellValueExplicitByColumnAndRow(6, $row, $val["silo"]);

            $objWorkSheet->setCellValueExplicitByColumnAndRow(8, $row, $val["associate"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(9, $row, $val["type"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(10, $row, $val["warehouse"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(11, $row, $val["stack"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(12, $row, $val["weight"], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(13, $row, $val["grade"]);
            $objWorkSheet->setCellValueExplicitByColumnAndRow(14, $row, $val["discountRate"]);

            $row++;
        }

        $objWorkSheet->getProtection()->setPassword('123456');
        $objWorkSheet->getProtection()->setSheet(true);
        $objWorkSheet->getStyle('B4:O'.$row)->getProtection()->setLocked(
            \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );

        //create excel file
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=final_floor_price_".str_replace("/", "_", "Test").".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();


    }
}