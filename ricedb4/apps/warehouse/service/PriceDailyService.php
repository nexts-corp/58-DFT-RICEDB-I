<?php

namespace apps\warehouse\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\warehouse\interfaces\IPriceDailyService;

class PriceDailyService extends CServiceBase implements IPriceDailyService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function select() {
        /* $sql = "SELECT * FROM dft_Price_Daily";
          $res = $this->link->query($sql);
          while ($data = $res->fetch(PDO::FETCH_ASSOC)) {
          array_push($this->result, array(
          "Id" => $data["Id"],
          "LK_Type_Id" => $data["LK_Type_Id"],
          "Date" => $data["Date"],
          "OldPriceMin1" => $data["OldPriceMin1"],
          "OldPriceMax1" => $data["OldPriceMax1"],
          "NewPriceMin1" => $data["NewPriceMin1"],
          "NewPriceMax1" => $data["NewPriceMax1"],
          "OldPriceMin2" => $data["OldPriceMin2"],
          "OldPriceMax2" => $data["OldPriceMax2"],
          "NewPriceMin2" => $data["NewPriceMin2"],
          "NewPriceMax2" => $data["NewPriceMax2"]
          ));
          }
          return $this->result; */
    }

    public function whereDate($date) {
        $sql = "SELECT"
                . " CASE WHEN  pd.id IS NULL THEN 0 ELSE pd.id END AS id,"
                . " t.id as typeId,"
                . " t.type,"
                . " CASE WHEN pd.date IS NULL THEN :Date1 ELSE pd.date AS date,"
                . " CASE WHEN pd.oldPriceMin1 IS NULL THEN 0 ELSE pd.oldPriceMin1 AS oldPriceMin1,"
                . " CASE WHEN pd.oldPriceMax1 IS NULL THEN 0 ELSE pd.oldPriceMax1 AS oldPriceMax1,"
                . " CASE WHEN pd.newPriceMin1 IS NULL THEN 0 ELSE pd.newPriceMin1 AS newPriceMin1,"
                . " CASE WHEN pd.newPriceMax1 IS NULL THEN 0 ELSE pd.newPriceMax1 AS newPriceMax1,"
                . " CASE WHEN pd.oldPriceMin2 IS NULL THEN 0 ELSE pd.oldPriceMin2 AS oldPriceMin2,"
                . " CASE WHEN pd.oldPriceMax2 IS NULL THEN 0 ELSE pd.oldPriceMax2 AS oldPriceMax2,"
                . " CASE WHEN pd.newPriceMin2 IS NULL THEN 0 ELSE pd.newPriceMin2 AS newPriceMin2,"
                . " CASE WHEN pd.newPriceMax2 IS NULL THEN 0 ELSE pd.newPriceMax2 AS newPriceMax2"
                . " FROM  " . $this->ent . "\\Type t"
                . " LEFT JOIN " . $this->ent . "\\PriceDaily pd WITH t.id = pd.typeId AND pd.date = :Date2";

        $param = array(
            "Date1" => $date,
            "Date2" => $date
        );

        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function whereMonth($date1, $date2) {
        $sql = "SELECT"
                . " pd.date AS start,"
                . " count(pd) AS num"
                . " FROM " . $this->ent . "\\PriceDaily pd"
                . " WHERE pd.date >= :Date1 AND pd.date <= :Date2"
                . " GROUP BY pd.date";
        $param = array(
            "Date1" => $date1,
            "Date2" => $date2);
        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function save($prices) {
        //print_r($prices);
        $return = true;
        foreach ($prices as $key => $price) {
            if ($price->id == 0) {
                $price->date = new \DateTime($price->date);
                if (!$this->datacontext->saveObject($price)) {
                    $return = $this->datacontext->getLastMessage();
                }
            } else {
                $daily = new \apps\common\entity\PriceDaily();
                $daily->id = $price->id;
                $data = $this->datacontext->getObject($daily);
                $data[0]->oldPriceMin1 = $price->oldPriceMin1;
                $data[0]->oldPriceMax1 = $price->oldPriceMax1;
                $data[0]->newPriceMin1 = $price->newPriceMin1;
                $data[0]->newPriceMax1 = $price->newPriceMax1;
                $data[0]->oldPriceMin2 = $price->oldPriceMin2;
                $data[0]->oldPriceMax2 = $price->oldPriceMax2;
                $data[0]->newPriceMin2 = $price->newPriceMin2;
                $data[0]->newPriceMax2 = $price->newPriceMax2;

                if (!$this->datacontext->updateObject($data)) {
                    $return = false;
                }
            }
        }
        return $return;
    }

    public function export($date) {


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
        $data = $this->whereDate($date);
        if (isset($data)) {
            $objWorkSheet = $objPHPExcel->createSheet($sheet);
            $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
            $objWorkSheet = $objPHPExcel->getActiveSheet();
            
            $objWorkSheet->setTitle(str_replace("-", "_", $date));

            //column name
            $row = 1;
            $objWorkSheet->mergeCells('A1:J1')
                    ->setCellValueByColumnAndRow(0, $row, "ราคาข้าวประจำวันที่ " . $date)
                    ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

//                $row = 2;
//                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

            $row = 3;
            $objWorkSheet->mergeCells('A' . $row . ':A' . ($row+2))->setCellValue('A' . $row, "ลำดับ");
            $objWorkSheet->mergeCells('B' . $row . ':B' . ($row+2))->setCellValue('B' . $row, "ชนิดข้าว");
            $objWorkSheet->mergeCells('C' . $row . ':F' . $row)->setCellValue('C' . $row, "กรมการค้าภายใน");
            $objWorkSheet->mergeCells('G' . $row . ':J' . $row)->setCellValue('G' . $row, "สมาคมโรงสีข้าวไทย");//->getStyle('F' . $row)->getAlignment()->setWrapText(true);
            

            $row = 4;
            $objWorkSheet->mergeCells('C' . $row . ':D' . $row)->setCellValue('C' . $row, "ราคาข้าวเก่า");
            $objWorkSheet->mergeCells('E' . $row . ':F' . $row)->setCellValue('E' . $row, "ราคาข้าวใหม่");
            $objWorkSheet->mergeCells('G' . $row . ':H' . $row)->setCellValue('G' . $row, "ราคาข้าวเก่า");
            $objWorkSheet->mergeCells('I' . $row . ':J' . $row)->setCellValue('I' . $row, "ราคาข้าวใหม่");
            
            $row = 5;
            $objWorkSheet->setCellValue('C' . $row, "ต่ำสุด");
            $objWorkSheet->setCellValue('D' . $row, "สูงสุด");
            $objWorkSheet->setCellValue('E' . $row, "ต่ำสุด");
            $objWorkSheet->setCellValue('F' . $row, "สูงสุด");
            $objWorkSheet->setCellValue('G' . $row, "ต่ำสุด");
            $objWorkSheet->setCellValue('H' . $row, "สูงสุด");
            $objWorkSheet->setCellValue('I' . $row, "ต่ำสุด");
            $objWorkSheet->setCellValue('J' . $row, "สูงสุด");

            $row = 6;
            foreach ($data as $k => $v) {
                $objWorkSheet->setCellValueExplicit('A' . $row, $k + 1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                $objWorkSheet->setCellValue('B' . $row, $v["type"])->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
                $objWorkSheet->setCellValue('C' . $row, $v["oldPriceMin1"]);
                $objWorkSheet->setCellValue('D' . $row, $v["oldPriceMax1"]);
                $objWorkSheet->setCellValue('E' . $row, $v["newPriceMin1"]);
                $objWorkSheet->setCellValue('F' . $row, $v["newPriceMax1"]);
                $objWorkSheet->setCellValue('G' . $row, $v["oldPriceMin2"]);
                $objWorkSheet->setCellValue('H' . $row, $v["oldPriceMax2"]);
                $objWorkSheet->setCellValue('I' . $row, $v["newPriceMin2"]);
                $objWorkSheet->setCellValue('J' . $row, $v["newPriceMax2"]);

                $row++;
            }

            //style column
            $objWorkSheet->getStyle('A1:J5')->getFont()->setBold(true);
            $objWorkSheet->getStyle('A1:J5')->getAlignment()->applyFromArray($middle);

            $objWorkSheet->getColumnDimension('A')->setWidth(10);
            $objWorkSheet->getColumnDimension('B')->setWidth(30);
            $objWorkSheet->getColumnDimension('C')->setWidth(15);
            $objWorkSheet->getColumnDimension('D')->setWidth(15);
            $objWorkSheet->getColumnDimension('E')->setWidth(15);
            $objWorkSheet->getColumnDimension('F')->setWidth(15);
            $objWorkSheet->getColumnDimension('G')->setWidth(15);
            $objWorkSheet->getColumnDimension('H')->setWidth(15);
            $objWorkSheet->getColumnDimension('I')->setWidth(15);
            $objWorkSheet->getColumnDimension('J')->setWidth(15);

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
        header("Content-Disposition: attachment;filename=ราคาข้าวประจำวันที่ " . str_replace("-", "_", $date) . ".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();
    }

}
