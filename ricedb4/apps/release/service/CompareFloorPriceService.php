<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\ICompareFloorPriceService;

class CompareFloorPriceService extends CServiceBase implements ICompareFloorPriceService {

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
                . " WHERE st.keyword like 'AU%' and (st.active like 'Y%' or st.active like 'F%') "
                . " ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function showFloorPrice($auction) {
        $sql = "SELECT fp.* FROM fn_floor_price_report(:auction) fp order by fp.typeId";
        $param = array(
            "auction" => $auction
        );
        $data = $this->datacontext->pdoQuery($sql, $param);

        return $data;
        /* $sql = "SELECT tp.Id as id, tp.Type as type, fp.NewPrice as fp2, fp.OldNewPrice as fp3, fp.OldPrice as fp4"
          ." FROM dft_LK_Type tp"
          ." LEFT JOIN fn_floor_price_auction(:auction) fp ON tp.Id = fp.LK_TypeId";
          $param = array(
          "auction" => $auction
          );
          $data = $this->datacontext->pdoQuery($sql, $param);
          foreach($data as $key => $val){
          if($val["fp2"] != null) $data[$key]["fp2"] = round($val["fp2"], 2);
          if($val["fp3"] != null) $data[$key]["fp3"] = round($val["fp3"], 2);
          if($val["fp4"] != null) $data[$key]["fp4"] = round($val["fp4"], 2);

          $data[$key]["fpBidder"] = $data[$key]["fp2"];
          }
          return $data; */
    }

    public function export($auccode) {
        $status = new \apps\common\entity\Status();
        $status->keyword = $auccode;
        $status = $this->datacontext->getObject($status);
        if (count($status) > 0) {
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

            $name = '';
            $sheet = 0;
           // $follow = $this->getFollow($value, $associateId);
            $data = $this->showFloorPrice($auccode);
            if (isset($data)) {
                $objWorkSheet = $objPHPExcel->createSheet($sheet);
                $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
                $objWorkSheet = $objPHPExcel->getActiveSheet();

                $name = $status[0]->status;
                $objWorkSheet->setTitle(str_replace("/", "_", $name));

                //column name
                $row = 1;
                $objWorkSheet->mergeCells('A1:I1')
                        ->setCellValueByColumnAndRow(0, $row, "เปรียบเทียบราคาขั้นต่ำการประมูลข้าว ครั้งที่ " . $name)
                        ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

//                $row = 2;
//                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

                $row = 3;
                $objWorkSheet->mergeCells('A' . $row . ':A' . ($row + 1))->setCellValue('A' . $row, "ลำดับ");
                $objWorkSheet->mergeCells('B' . $row . ':B' . ($row + 1))->setCellValue('B' . $row, "ชนิดข้าว");
                $objWorkSheet->mergeCells('C' . $row . ':E' . $row)->setCellValue('C' . $row, "ราคาตลาดตั้งต้น (บาท/ตัน)");
                $objWorkSheet->mergeCells('F' . $row . ':F' . ($row + 1))->setCellValue('F' . $row, "ราคาจากผู้เสนอซื้อ\n(บาท/ตัน)")->getStyle('F' . $row)->getAlignment()->setWrapText(true);
                $objWorkSheet->mergeCells('G' . $row . ':I' . $row)->setCellValue('G' . $row, "ส่วนต่าง (บาท/ตัน)");

                $row = 4;
                $objWorkSheet->setCellValue('C' . $row, "FP2");
                $objWorkSheet->setCellValue('D' . $row, "FP3");
                $objWorkSheet->setCellValue('E' . $row, "FP4");
                $objWorkSheet->setCellValue('G' . $row, "FP2");
                $objWorkSheet->setCellValue('H' . $row, "FP3");
                $objWorkSheet->setCellValue('I' . $row, "FP4");

                $row = 5;
                foreach ($data as $k => $v) {
                    $objWorkSheet->setCellValueExplicit('A' . $row, $k+1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('B' . $row, $v["typeName"])->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('C' . $row, $v["FloorPrice2"]);
                    $objWorkSheet->setCellValue('D' . $row, $v["FloorPrice3"]);
                    $objWorkSheet->setCellValue('E' . $row, $v["FloorPrice4"]);
                    $objWorkSheet->setCellValue('F' . $row, $v["AucFloorPrice"]);
                    $objWorkSheet->setCellValue('G' . $row, ($v["AucFloorPrice"])-($v["FloorPrice2"]));
                    $objWorkSheet->setCellValue('H' . $row, ($v["AucFloorPrice"])-($v["FloorPrice3"]));
                    $objWorkSheet->setCellValue('I' . $row, ($v["AucFloorPrice"])-($v["FloorPrice4"]));

                    $row++;
                }

                //style column
                $objWorkSheet->getStyle('A1:I4')->getFont()->setBold(true);
                $objWorkSheet->getStyle('A1:I4')->getAlignment()->applyFromArray($middle);

                $objWorkSheet->getColumnDimension('A')->setWidth(10);
                $objWorkSheet->getColumnDimension('B')->setWidth(30);
                $objWorkSheet->getColumnDimension('C')->setWidth(15);
                $objWorkSheet->getColumnDimension('D')->setWidth(15);
                $objWorkSheet->getColumnDimension('E')->setWidth(15);
                $objWorkSheet->getColumnDimension('F')->setWidth(20);
                $objWorkSheet->getColumnDimension('G')->setWidth(15);
                $objWorkSheet->getColumnDimension('H')->setWidth(15);
                $objWorkSheet->getColumnDimension('I')->setWidth(15);

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
            header("Content-Disposition: attachment;filename=เปรียบเทียบราคาขั้นต่ำการประมูลข้าว ครั้งที่" . str_replace("/", "_", $name) . ".xls");

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            ob_end_flush();
            exit();
        } else {
            return false;
        }
    }

}
