<?php

namespace apps\warehouse\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\warehouse\interfaces\IHistoryService;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function find($warehouse) {
        $object = "select wh.provinceId, "
                . "wh.province, "
                . "wh.associateId, "
                . "wh.associate, "
                . "wh.wareHouseCode "
                . "from " . $this->ent . "\\AuctionWarehouse wh "
                . "where wh.wareHouseCode like :warehouse "
                . "group by  wh.provinceId, "
                . "wh.province, "
                . "wh.associateId, "
                . "wh.associate, "
                . "wh.wareHouseCode ";
        $params = array(
            "warehouse" => "%" . $warehouse . "%"
        );
        return $this->datacontext->getObject($object, $params);
    }

    public function get($warehouse) {
        $object = "select wh.auctionNo, wh.wareHouseId from " . $this->ent . "\\AuctionWarehouse wh "
                . "where wh.wareHouseCode = :warehouse "
                . "group by wh.auctionNo, wh.wareHouseId ";
        $params = array(
            "warehouse" => $warehouse
        );
        $dataAuction = $this->datacontext->getObject($object, $params);
        $history = array();
        foreach ($dataAuction as $key => $value) {
            $query = "select "
                    . " auc.auctionNo, "
                    . " auc.auctionCode, "
                    . " auc.province, "
                    . " auc.associate, "
                    . " auc.wareHouseId, "
                    . " auc.wareHouseCode, "
                    . " auc.weightAll, "
                    . " auc.typeNames, "
                    . " auc.projectNames, "
                    . " auc.gradeNames, "
                    . " auc.FV, "
                    . " auc.FV2, "
                    . " auc.FV3, "
                    . " auc.FV4, "
                    . " auc.bidderNo, "
                    . " auc.bidderName, "
                    . " auc.bidderPrice, "
                    . " auc.remarkPrice, "
                    . " auc.bidderPassFV, "
                    . " auc.bidderWinner, "
                    . " auc.isSale "
                    . " from fn_auction_info(:auctionNo) auc"
                    . " where auc.wareHouseId = :wareHouseId "
                    . " and ( "
                    . " ( auc.bidderNo is not null and auc.bidderMaxPrice = 'Y') or (auc.bidderNo is null) "
                    . " )"
                    . " order by auc.warehouseId ";
            //  . " and auc.bidderMaxPrice = 'Y' ";
            $param = array(
                "auctionNo" => $value["auctionNo"],
                "wareHouseId" => $value["wareHouseId"]
            );
            array_push($history, $this->datacontext->pdoQuery($query, $param)[0]);
        }
        return $history;
    }

    public function export($warehouse) {
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
        // $follow = $this->getFollow($value, $associateId);
        $data = $this->get($warehouse);
        if (isset($data)) {
            $objWorkSheet = $objPHPExcel->createSheet($sheet);
            $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
            $objWorkSheet = $objPHPExcel->getActiveSheet();

            $objWorkSheet->setTitle($warehouse);

            //column name
            $row = 1;
            $objWorkSheet->mergeCells('A1:R1')
                    ->setCellValueByColumnAndRow(0, $row, "ประวัติการระบายคลังสินค้า " . $warehouse)
                    ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

//                $row = 2;
//                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

            $row = 3;
              $objWorkSheet->setCellValue('A' . $row, "ลำดับ");
            $objWorkSheet->setCellValue('B' . $row, "ครั้งที่");
            $objWorkSheet->setCellValue('C' . $row, "จังหวัด");
            $objWorkSheet->setCellValue('D' . $row, "ผู้เข้าร่วม");
            $objWorkSheet->setCellValue('E' . $row, "คลังสินค้า");
            $objWorkSheet->setCellValue('F' . $row, "ปริมาณ (ตัน)");
            $objWorkSheet->setCellValue('G' . $row, "ผู้เสนอซื้อ");
            $objWorkSheet->setCellValue('H' . $row, "มูลค่าเสนอซื้อ (บาท)");
            $objWorkSheet->setCellValue('I' . $row, "ราคาเฉลี่ยต่อตัน");
            $objWorkSheet->setCellValue('J' . $row, "สถานะ");         
            $objWorkSheet->setCellValue('K' . $row, "หมายเหตุ");
            $objWorkSheet->setCellValue('L' . $row, "ชนิดข้าว");
            $objWorkSheet->setCellValue('M' . $row, "ปีโครงการ");
            $objWorkSheet->setCellValue('N' . $row, "เกรด");
            $objWorkSheet->setCellValue('O' . $row, "FV");
            $objWorkSheet->setCellValue('P' . $row, "FV2");
            $objWorkSheet->setCellValue('Q' . $row, "FV3");
            $objWorkSheet->setCellValue('R' . $row, "FV4");

            $row = 4;
            foreach ($data as $k => $v) {
                $objWorkSheet->setCellValueExplicit('A' . $row, $k + 1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                $objWorkSheet->setCellValue('B' . $row, $v["auctionCode"])->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
                $objWorkSheet->setCellValue('C' . $row, $v["province"]);
                $objWorkSheet->setCellValue('D' . $row, $v["associate"]);
                $objWorkSheet->setCellValue('E' . $row, $v["wareHouseCode"]);
                $objWorkSheet->setCellValue('F' . $row, $v["weightAll"]);
                $objWorkSheet->setCellValue('G' . $row, $v["bidderName"]);
                $objWorkSheet->setCellValue('H' . $row, $v["bidderPrice"]);
                $objWorkSheet->setCellValue('I' . $row, $v["bidderPrice"]/$v["weightAll"]);
                $objWorkSheet->setCellValue('J' . $row, $v["isSale"]);      
                $objWorkSheet->setCellValue('K' . $row, $v["remarkPrice"]);
                $objWorkSheet->setCellValue('L' . $row, $v["typeNames"]);
                $objWorkSheet->setCellValue('M' . $row, $v["projectNames"]);
                $objWorkSheet->setCellValue('N' . $row, $v["gradeNames"]);
                $objWorkSheet->setCellValue('O' . $row, $v["FV"]);
                $objWorkSheet->setCellValue('P' . $row, $v["FV2"]);
                $objWorkSheet->setCellValue('Q' . $row, $v["FV3"]);
                $objWorkSheet->setCellValue('R' . $row, $v["FV4"]);

                $row++;
            }

            //style column
            $objWorkSheet->getStyle('A1:R1')->getFont()->setBold(true);
            $objWorkSheet->getStyle('A1:R1')->getAlignment()->applyFromArray($middle);

            $objWorkSheet->getColumnDimension('A')->setWidth(10);
            $objWorkSheet->getColumnDimension('B')->setWidth(20);
            $objWorkSheet->getColumnDimension('C')->setWidth(20);
            $objWorkSheet->getColumnDimension('D')->setWidth(10);
            $objWorkSheet->getColumnDimension('E')->setWidth(30);
            $objWorkSheet->getColumnDimension('F')->setWidth(20);
            $objWorkSheet->getColumnDimension('G')->setWidth(30);
            $objWorkSheet->getColumnDimension('H')->setWidth(20);
            $objWorkSheet->getColumnDimension('I')->setWidth(20);
            $objWorkSheet->getColumnDimension('J')->setWidth(10);
            $objWorkSheet->getColumnDimension('K')->setWidth(20);
            $objWorkSheet->getColumnDimension('L')->setWidth(20);
            $objWorkSheet->getColumnDimension('M')->setWidth(20);
            $objWorkSheet->getColumnDimension('N')->setWidth(20);
            $objWorkSheet->getColumnDimension('O')->setWidth(20);
            $objWorkSheet->getColumnDimension('P')->setWidth(20);
            $objWorkSheet->getColumnDimension('Q')->setWidth(20);
            $objWorkSheet->getColumnDimension('R')->setWidth(20);

            //set protection
//                $objWorkSheet->getProtection()->setPassword('123456');
//                $objWorkSheet->getProtection()->setSheet(true);
//                $objWorkSheet->getStyle('H5:P' . $row)->getProtection()->setLocked(
//                        \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
//                );
//
//                $objWorkSheet->getStyle('N5:O' . $row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $sheet++;
        }


        //create excel file
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=ประวัติการระบายคลังสินค้า " . $warehouse . ".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();
    }

}
