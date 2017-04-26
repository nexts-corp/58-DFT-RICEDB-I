<?php

namespace apps\reserve\service;

set_time_limit(0);

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\reserve\interfaces\IConfirmService;

class ConfirmService extends CServiceBase implements IConfirmService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function lkReserve() {
        $sql = "SELECT rs.reserveName, rs.reserveCode"
                . " FROM " . $this->ent . "\\Reserve rs"
                . " ORDER BY rs.id ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function lkStatusReserv() {

        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st "
                . " WHERE st.active like 'W%' "
                . " ORDER BY st.id ASC";
        return $this->datacontext->getObject($sql);
    }

    public function export($status_id) {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $sql = "SELECT b.book_id FROM " . $this->ent . "\\Booking b "
                . "where b.status_id = :status_id ";
        $param = array("status_id" => $status_id);
        $data_book = $this->datacontext->getObject($sql, $param);
//
        $sql = "SELECT p FROM " . $this->ent . "\\Product p "
                . " where p.status in ( :book_id ) "
                . "order by p.province,p.associate,p.silo,p.warehouse,p.stack";
        $param2 = array("book_id" => $data_book);
        $data = $this->datacontext->getObject($sql, $param2);
//        return $data;
//if (isset($data)) {
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

        $status = new \apps\common\entity\Status();
        $status->id = $status_id;
        $name = $this->datacontext->getObject($status)[0]->status;

        $sheet = 0;

        $objWorkSheet = $objPHPExcel->createSheet($sheet);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
        $objWorkSheet = $objPHPExcel->getActiveSheet();
        $objWorkSheet->setTitle(str_replace("/", "_", $name));

//column name
        $row = 1;
        $objWorkSheet->mergeCells('A1:N1')
                ->setCellValueByColumnAndRow(0, $row, $name)
                ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

        $row = 3;
        $objWorkSheet->mergeCells('A' . $row . ':A' . $row)->setCellValue('A' . $row, "ลำดับที่");
        $objWorkSheet->mergeCells('B' . $row . ':B' . $row)->setCellValue('B' . $row, "รหัส"); //code
        $objWorkSheet->mergeCells('C' . $row . ':C' . $row)->setCellValue('C' . $row, "เลขถุง"); //bag_no
        $objWorkSheet->mergeCells('D' . $row . ':D' . $row)->setCellValue('D' . $row, "จังหวัด"); //provinceNameTH
        $objWorkSheet->mergeCells('E' . $row . ':E' . $row)->setCellValue('E' . $row, "ปีโครงการ"); //project
        $objWorkSheet->mergeCells('F' . $row . ':F' . $row)->setCellValue('F' . $row, "คลังสินค้า"); //silo
        $objWorkSheet->mergeCells('G' . $row . ':G' . $row)->setCellValue('G' . $row, "เข้าร่วมฯ"); //ass
        $objWorkSheet->mergeCells('H' . $row . ':H' . $row)->setCellValue('H' . $row, "ชนิดข้าว"); //type
        $objWorkSheet->mergeCells('I' . $row . ':I' . $row)->setCellValue('I' . $row, "หลังที่"); //warehouse
        $objWorkSheet->mergeCells('J' . $row . ':J' . $row)->setCellValue('J' . $row, "กองที่"); //stack
        $objWorkSheet->mergeCells('K' . $row . ':K' . $row)->setCellValue('K' . $row, "ปริมาณ (ตัน)"); //weight
        $objWorkSheet->mergeCells('L' . $row . ':L' . $row)->setCellValue('L' . $row, "คณะฯ ที่เก็บตัวอย่าง"); //sampling
        $objWorkSheet->mergeCells('M' . $row . ':M' . $row)->setCellValue('M' . $row, "ปริมาณน้ำหนักข้าวรวมกระสอบ (ตัน)"); //weightAll
        $objWorkSheet->mergeCells('N' . $row . ':N' . $row)->setCellValue('N' . $row, "จัดเกรดตามแนวทางของคณะทำงานจัดระดับฯ"); //grade
        $row = 4;
        foreach ($data as $k => $v) {
            $objWorkSheet->setCellValueExplicit('A' . $row, $k + 1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('B' . $row, $v->code)->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('C' . $row, $v->bagNo)->getStyle('C' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('D' . $row, $v->province)->getStyle('D' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('E' . $row, $v->productProject)->getStyle('E' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('F' . $row, $v->silo);
            $objWorkSheet->setCellValue('G' . $row, $v->associate)->getStyle('G' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('H' . $row, $v->productType);
            $objWorkSheet->setCellValue('I' . $row, $v->warehouse)->getStyle('I' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('J' . $row, $v->stack)->getStyle('J' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('K' . $row, $v->weight);
            $objWorkSheet->setCellValue('L' . $row, $v->sampling);
            $objWorkSheet->setCellValue('M' . $row, $v->weightAll);
            $objWorkSheet->setCellValue('N' . $row, $v->productGrade)->getStyle('N' . $row)->getAlignment()->applyFromArray($center);
            $row++;
        }
        $objWorkSheet->getStyle('A1:L3')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:L3')->getAlignment()->applyFromArray($middle);

        $objWorkSheet->getColumnDimension('A')->setWidth(10);
        $objWorkSheet->getColumnDimension('B')->setWidth(20);
        $objWorkSheet->getColumnDimension('C')->setWidth(10);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(20);
        $objWorkSheet->getColumnDimension('F')->setWidth(30);
        $objWorkSheet->getColumnDimension('G')->setWidth(10);
        $objWorkSheet->getColumnDimension('H')->setWidth(20);
        $objWorkSheet->getColumnDimension('I')->setWidth(10);
        $objWorkSheet->getColumnDimension('J')->setWidth(10);
        $objWorkSheet->getColumnDimension('K')->setWidth(20);
        $objWorkSheet->getColumnDimension('L')->setWidth(10);
        $objWorkSheet->getColumnDimension('M')->setWidth(20);
        $objWorkSheet->getColumnDimension('N')->setWidth(20);
//        $objWorkSheet->getColumnDimension('O')->setWidth(20);
//        $objWorkSheet->getColumnDimension('P')->setWidth(20);
//        $objWorkSheet->getColumnDimension('X')->setWidth(20);
//        //set protection
//        $objWorkSheet->getProtection()->setPassword('123456');
//        $objWorkSheet->getProtection()->setSheet(true);
//        $objWorkSheet->getStyle('B4:B' . $row)->getProtection()->setLocked(
//                \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
//        );
//create excel file
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=" . str_replace("/", "_", $name) . ".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();
//}
    }

}
