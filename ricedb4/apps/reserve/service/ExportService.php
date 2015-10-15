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
        $return = true;

        $reserve = new \apps\common\entity\RiceReserve();
        $reserve->reserveKeyword = $reserveList->keyword;

        $data = $this->datacontext->getObject($reserve);

        $sql = "SELECT"
            ." rl.id, rl.reserveCode, rs.reserveName, rl.detail, rl.keyword, rl.target, rl.dateCreated"
        ." FROM ".$this->ent."\\ReserveList rl"
        ." JOIN ".$this->ent."\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
        ." WHERE rl.keyword = :keyword";

        $param = array(
            "keyword" => $reserveList->keyword
        );
        $list = $this->datacontext->getObject($sql, $param);

        $title = $list[0]["reserveName"]." ".$list[0]["detail"];

        return $title;

        /*$objPHPExcel = new \PHPExcel();

        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
        $objWorkSheet = $objPHPExcel->getActiveSheet();

        $title = "OK";
        $objWorkSheet->setTitle($title);

        //$response = $this->setContentType('application/vnd.ms-excel');
        //$response = $this->setContentDisposition("attachment;filename=final_floor_price_".$reserveList->keyword.".xls");

        /*header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=final_floor_price_".str_replace("/", "_", $auction).".xls");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');*/

        /*header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');


        return $objPHPExcel;*/
    }
}