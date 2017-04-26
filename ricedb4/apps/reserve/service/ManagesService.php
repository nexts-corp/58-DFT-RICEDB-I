<?php

namespace apps\reserve\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\reserve\interfaces\IManagesService;

class ManagesService extends CServiceBase implements IManagesService {

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
        $sql_book = "select bk.status_id from " . $this->ent . "\\Booking bk "
                . "where bk.status_id is not null "
                . "group by bk.status_id ";
        $data_book = $this->datacontext->getObject($sql_book);
        if (count($data_book) > 0) {
            foreach ($data_book as $key_book => $val_book) {
                $status = new \apps\common\entity\Status();
                $status->id = $val_book['status_id'];
                $data_status = $this->datacontext->getObject($status);
                if (count($data_status) > 0) {
                    if (strpos($data_status[0]->active, "R") > -1) {
                        $data_status[0]->active = str_replace("R", "C", $data_status[0]->active);
                        $this->datacontext->updateObject($data_status);
                    }
                }
            }
        }
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st "
                . " WHERE st.active like 'R%' or st.active like 'C%' "
                . " ORDER BY st.id ASC";
        return $this->datacontext->getObject($sql);
    }

    public function selectBook($status_id, $book_id) {
//        $sql = "update dft_booking "
//                . "set book_status = 'Y', status_id = '" + $status_id + "' "
//                . "where book_id = '" + $book_id + '"';
//        return $this->datacontext->pdoQuery($sql);
        $book = new \apps\common\entity\Booking();
        $book->book_id = $book_id;
        $data = $this->datacontext->getObject($book)[0];
        $data->book_status = 'Y';
        $data->status_id = $status_id;
        return $this->datacontext->updateObject($data);
    }

    public function listsBook($status_id) {
        $sql = "select b.book_id,b.remark,b.book_status,sum(p.tWeight) as weightAll,b.Date_Created as dateCreated "
                . " from dft_booking b "
                . " inner join dft_product p on p.status = b.book_id "
                . " where b.status_id = '" . $status_id . "' "
                . " group by b.book_id,b.remark,b.book_status,b.Date_Created ";
        return $this->datacontext->pdoQuery($sql);
    }

    public function cancelBook($book_id) {
        $book = new \apps\common\entity\Booking();
        $book->book_id = $book_id;
        $data = $this->datacontext->getObject($book)[0];
        $status_id = $data->status_id;
        $data->book_status = 'N';
        $data->status_id = null;
        $this->datacontext->updateObject($data);
        $chk_book = new \apps\common\entity\Booking();
        $chk_book->status_id = $status_id;
        $data_chk = $this->datacontext->getObject($chk_book);
        if (count($data_chk) == 0) {
            $status = new \apps\common\entity\Status();
            $status->id = $status_id;
            $data_status = $this->datacontext->getObject($status)[0];
            $data_status->active = str_replace("C", "R", $data_status->active);
            $this->datacontext->updateObject($data_status);
        }
        return true;
    }

    public function confirmStatus($status_id) {
        $status = new \apps\common\entity\Status();
        $status->id = $status_id;
        $data = $this->datacontext->getObject($status)[0];
        $data->active = str_replace("C", "W", $data->active);
        return $this->datacontext->updateObject($data);
    }

    public function insert($status) {
        $return = true;
        if (!($this->datacontext->saveObject($status))) {
            $return = $this->datacontext->getLastMessage();
        }
        return $return;
    }

    public function export() {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $sql = "SELECT * FROM fn_product8()";
        $data = $this->datacontext->pdoQuery($sql);

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

        $name = 'คลังสินค้าคงเหลือในสต็อกของรัฐ';
        $sheet = 0;

        $objWorkSheet = $objPHPExcel->createSheet($sheet);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
        $objWorkSheet = $objPHPExcel->getActiveSheet();
        $objWorkSheet->setTitle(str_replace("/", "_", $name));

        //column name
        $row = 1;
        $objWorkSheet->mergeCells('A1:L1')
                ->setCellValueByColumnAndRow(0, $row, $name)
                ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

        $row = 3;
        $objWorkSheet->mergeCells('A' . $row . ':A' . $row)->setCellValue('A' . $row, "ลำดับที่");
        $objWorkSheet->mergeCells('B' . $row . ':B' . $row)->setCellValue('B' . $row, "รหัส"); //id
        $objWorkSheet->mergeCells('C' . $row . ':C' . $row)->setCellValue('C' . $row, "ภาค"); //zoneNameTH
        $objWorkSheet->mergeCells('D' . $row . ':D' . $row)->setCellValue('D' . $row, "จังหวัด"); //provinceNameTH
        $objWorkSheet->mergeCells('E' . $row . ':E' . $row)->setCellValue('E' . $row, "ผู้เข้าร่วม"); //associate
        $objWorkSheet->mergeCells('F' . $row . ':F' . $row)->setCellValue('F' . $row, "คลังสินค้า"); //silo
        $objWorkSheet->mergeCells('G' . $row . ':G' . $row)->setCellValue('G' . $row, "หลังที่"); //warehouse
        $objWorkSheet->mergeCells('H' . $row . ':H' . $row)->setCellValue('H' . $row, "กองที่"); //stack
        $objWorkSheet->mergeCells('I' . $row . ':I' . $row)->setCellValue('I' . $row, "ปีโครงการ"); //project
        $objWorkSheet->mergeCells('J' . $row . ':J' . $row)->setCellValue('J' . $row, "ชนิดข้าว"); //type
        $objWorkSheet->mergeCells('K' . $row . ':K' . $row)->setCellValue('K' . $row, "ปริมาณ (ตัน)"); //tWeight
        $objWorkSheet->mergeCells('L' . $row . ':L' . $row)->setCellValue('L' . $row, "เกรด"); //grade

        $row = 4;
        foreach ($data as $k => $v) {
            $objWorkSheet->setCellValueExplicit('A' . $row, $k + 1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('B' . $row, $v['id'])->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('C' . $row, $v['zoneNameTH'])->getStyle('C' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('D' . $row, $v['provinceNameTH'])->getStyle('D' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('E' . $row, $v['associate'])->getStyle('E' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('F' . $row, $v['silo']);
            $objWorkSheet->setCellValue('G' . $row, $v['warehouse'])->getStyle('G' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('H' . $row, $v['stack'])->getStyle('H' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('I' . $row, $v['project'])->getStyle('I' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('J' . $row, $v['type'])->getStyle('J' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('K' . $row, $v['tWeight']);
            $objWorkSheet->setCellValue('L' . $row, $v['grade'])->getStyle('L' . $row)->getAlignment()->applyFromArray($center);
            $row++;
        }
        $objWorkSheet->getStyle('A1:L3')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:L3')->getAlignment()->applyFromArray($middle);

        $objWorkSheet->getColumnDimension('A')->setWidth(10);
        $objWorkSheet->getColumnDimension('B')->setWidth(20);
        $objWorkSheet->getColumnDimension('C')->setWidth(20);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(10);
        $objWorkSheet->getColumnDimension('F')->setWidth(30);
        $objWorkSheet->getColumnDimension('G')->setWidth(10);
        $objWorkSheet->getColumnDimension('H')->setWidth(10);
        $objWorkSheet->getColumnDimension('I')->setWidth(20);
        $objWorkSheet->getColumnDimension('J')->setWidth(20);
        $objWorkSheet->getColumnDimension('K')->setWidth(20);
        $objWorkSheet->getColumnDimension('L')->setWidth(10);

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
