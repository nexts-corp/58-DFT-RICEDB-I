<?php

namespace apps\reserve\service;

set_time_limit(0);

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\reserve\interfaces\IFilterService;

class FilterService extends CServiceBase implements IFilterService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsGrade() {
        $sql = "SELECT"
                . " g.id,g.grade "
                . " FROM " . $this->ent . "\\Grade g";
        return $this->datacontext->getObject($sql);
    }

    public function listsProject() {
        $sql = "SELECT"
                . " pj.id,pj.project "
                . " FROM " . $this->ent . "\\Project pj";
        return $this->datacontext->getObject($sql);
    }

    public function listsType() {
        $sql = "SELECT"
                . " t.id,t.type "
                . " FROM " . $this->ent . "\\Type t ";
        return $this->datacontext->getObject($sql);
    }

    public function lists() {
//        $book = new \apps\common\entity\Booking();
//        $book->book_status = 'N';
//        return $this->datacontext->getObject($book);

        $sql = "select b.book_id,b.remark,b.book_status,sum(p.tWeight) as weightAll,b.Date_Created as dateCreated "
                . " from dft_booking b "
                . " inner join dft_product p on p.book_id = b.book_id "
                . " where b.book_status = 'N' "
                . " group by b.book_id,b.remark,b.book_status,b.Date_Created ";
        return $this->datacontext->pdoQuery($sql);
    }

    public function selector($selector, $book_id) {
        $query = "SELECT * FROM ( SELECT * ";
        $str = "SELECT province,lk_province_id,associate,lk_associate_id,silo, "
                . " CASE WHEN book_id is null or book_id = '' then 'false' else 'true' end as status, "
                . " COUNT(*) AS countAll,SUM(tWeight) AS weightAll,"
                . " SUM(CASE WHEN lk_grade_id > 0 and lk_grade_id <10 THEN tWeight ELSE 0 END) weightGood,"
                . " SUM(CASE WHEN lk_grade_id >=10 THEN tWeight ELSE 0 END) weightBad,";
        $whereG = "AND";
        $where = array();
        $chkGrade = "";
        foreach ($selector->grade as $key => $val) {

            $query .= ", CASE WHEN a.weightAll != 0 "; //select percent
            $query .= " THEN(a.gradeSelect" . $key . "/a.weightAll) * 100 ";
            $query .= " ELSE 0 END AS percent" . $key . "";

            $chkGrade .= "a.gradeSelect" . $key . "+";
//            $str .= " SUM(CASE WHEN lk_grade_id = ";             //count select grade
//            $str .= implode(" OR lk_grade_id = ", $val->id);
//            $str .= " THEN 1 ELSE 0 END ) gradeSelect" . $key . ",";

            $str .= " SUM(CASE WHEN lk_grade_id = ";            //select grade
            $str .= implode(" OR lk_grade_id = ", $val->id);
            $str .= " THEN tWeight ELSE 0 END ) gradeSelect" . $key . ",";

            $whereG .= " percent" . $key . " > " . $val->start . " AND percent" . $key . " <= " . $val->end . " AND";
        }
        if ($chkGrade != "") {
            $query .= ",CASE WHEN a.weightAll != 0 "
                    . " THEN iif(100-((( " . rtrim($chkGrade, "+") . ")/a.weightAll) * 100)<=0"
                    . ",0"
                    . ",100-((( " . rtrim($chkGrade, "+") . ")/a.weightAll) * 100 ))"
                    . " ELSE 0 END AS percent" . count($selector->grade) . "";
            ;
        }
        $query = rtrim($query, ",") . " FROM ( ";

        if (!empty($selector->type)) {
            $str .= " SUM(CASE WHEN lk_type_id = ";            //select type
            $str .= implode(" OR lk_type_id = ", $selector->type);
            $str .= " THEN tWeight ELSE 0 END ) typeSelect,";
            $where[0] = " typeSelect >0 ";
        }
        if (!empty($selector->noType)) {
            $str .= " SUM(CASE WHEN lk_type_id = ";            //select no type
            $str .= implode(" OR lk_type_id = ", $selector->noType);
            $str .= " THEN tWeight ELSE 0 END ) noTypeSelect,";
            $where[1] = " noTypeSelect = 0 ";
        }
        if (!empty($selector->project)) {
            $str .= " SUM(CASE WHEN lk_project_id = ";            //select project
            $str .= implode(" OR lk_project_id = ", $selector->project);
            $str .= " THEN tWeight ELSE 0 END ) projectSelect,";
            $where[2] = " projectSelect >0 ";
        }
        if (!empty($selector->noProject)) {
            $str .= " SUM(CASE WHEN lk_project_id = ";            //select no project
            $str .= implode(" OR lk_project_id = ", $selector->noProject);
            $str .= " THEN tWeight ELSE 0 END ) noProjectSelect,";
            $where[3] = " noProjectSelect = 0 ";
        }
        if (!empty($selector->noGrade)) {
            $str .= " SUM(CASE WHEN lk_grade_id = ";            //select no grade
            $str .= implode(" OR lk_grade_id = ", $selector->noGrade);
            $str .= " THEN tWeight ELSE 0 END ) noGradeSelect,";
            $where[4] = " noGradeSelect = 0 ";
        }
        if (empty($where) && $whereG == "AND") {
            $where = "";
        } elseif (empty($where) && $whereG != "AND") {
            $where = "";
            $whereG = "WHERE " . ltrim($whereG, "AND");
        } else {
            $where = "WHERE " . implode(" AND ", $where);
        }
        $str = rtrim($str, ",") . " FROM dft_product WHERE book_id = '' OR book_id IS NULL ";
        if ($book_id != "") {
            $str .= " OR book_id = '" . $book_id . "' ";
        }
        $str .= " GROUP BY province,lk_province_id,associate,lk_associate_id,silo,book_id ";

        $query .= $str . ") a ) data " . $where . rtrim($whereG, "AND");
        $query .= " ORDER BY province,associate,silo ";
//        return $query;
        $data = $this->datacontext->pdoQuery($query);
        return $data;
    }

    public function detail($silo, $associateId, $provinceId, $book_id) {

        $sql = "SELECT * "
                . " FROM dft_product "
                . " WHERE silo = '" . $silo . "' and lk_associate_id='" . $associateId . "' and lk_province_id='" . $provinceId . "'  and (book_id is null or book_id = '' ";
        if ($book_id != "") {
            $sql .= " or book_id = '" . $book_id . "' ";
        }
        $sql .= ") ";
        return $this->datacontext->pdoQuery($sql);
    }

    public function get($book_id) {
        $book = new \apps\common\entity\Booking();
        $book->book_id = $book_id;
        return $this->datacontext->getObject($book)[0];
    }

    public function save($book_id, $remark, $silo, $obj_query) {
//        $nocount = "SET NOCOUNT ON;";
//        $this->datacontext->pdoQuery($nocount);

        $res = true;
        $book = new \apps\common\entity\Booking();
        $book->book_id = $book_id;
        $dataBook = $this->datacontext->getObject($book);
        $book->remark = $remark;
        $book->book_status = 'N';
        $book->obj_query = $obj_query;

        if (count($dataBook) > 0) {
            $res = $this->datacontext->updateObject($book);
            $clear = "update dft_product "
                    . "set book_id = null,remark0 = null "
                    . "where book_id = '" . $book_id . "' ";
            $this->datacontext->pdoQuery($clear);
        } else {
            $res = $this->datacontext->saveObject($book);
        }

        if ($res) {
            $sql = "";
            foreach ($silo as $key => $value) {
                $sql .= "update dft_product "
                        . "set book_id = '" . $book_id . "' ";
                if (property_exists($value, 'percent')) {
                    $sql .= ",remark0 ='" . $value->percent . "' ";
                }
                $sql .= " where silo = '" . $value->silo . "' "
                        . "and lk_associate_id = '" . $value->associateid . "' "
                        . "and lk_province_id = '" . $value->provinceid . "' "
                        . "and (book_id='' or book_id is null); ";
//                $this->datacontext->pdoQuery($sql);
            }
//            $nocount = "SET NOCOUNT OFF;";
//            $this->datacontext->pdoQuery($nocount);
            $cmd = "EXEC sp_batch_exce :cmd";
            $param = array(
                "cmd" => $sql
            );
            if ($this->datacontext->pdoQuery($cmd, $param, "apps\\common\\model\\SQLUpdate")[0]->sdata == "ok") {
                return true;
            } else {
                return false;
            }
//            return $sql;
        } else {
            return false;
        }
    }

    public function delete($book_id) {
        $sql = "update dft_product "
                . "set book_id = null,remark0 = null "
                . "where book_id = '" . $book_id . "' ";
        $this->datacontext->pdoQuery($sql);
        $book = new \apps\common\entity\Booking();
        $book->book_id = $book_id;
        return $this->datacontext->removeObject($book);
    }

    public function export($book_id) {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $sql = "SELECT * FROM dft_product where book_id = '" . $book_id . "' "
                . "order by province,associate,silo,warehouse,stack";
        $data = $this->datacontext->pdoQuery($sql);

        $pivot = $this->pivot($book_id);
//        print_r($pivot);
//        exit();
        if (count($pivot) > 0) {
            $condition = array_keys($pivot[0]);
//            print_r($condition);
//            exit();
            unset($condition[0]);
            foreach ($data as $key => &$value) {
                $data_filter = (array) array_filter($pivot, function($v) use ($value) {
                            return $v['id'] == $value['Id'];
                        });
                $data_filter = $data_filter[array_keys($data_filter)[0]];
                unset($data_filter['id']);
                $value = array_merge($value, $data_filter);
            }
        }
        $sql2 = "SELECT * FROM dft_booking where book_id = '" . $book_id . "'";
        $data_book = $this->datacontext->pdoQuery($sql2);

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

        $name = $book_id;

        $sheet = 0;

        $objWorkSheet = $objPHPExcel->createSheet($sheet);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
        $objWorkSheet = $objPHPExcel->getActiveSheet();
        $objWorkSheet->setTitle(str_replace("/", "_", $name));

//column name
        $row = 1;
        $objWorkSheet->mergeCells('A1:X1')
                ->setCellValueByColumnAndRow(0, $row, $name)
                ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

        $row = 3;
        $objWorkSheet->mergeCells('A' . $row . ':A' . $row)->setCellValue('A' . $row, "ลำดับที่");
        $objWorkSheet->mergeCells('B' . $row . ':B' . $row)->setCellValue('B' . $row, "รหัส"); //code
        $objWorkSheet->mergeCells('C' . $row . ':C' . $row)->setCellValue('C' . $row, "เลขถุง"); //bag_no
        $objWorkSheet->mergeCells('D' . $row . ':D' . $row)->setCellValue('D' . $row, "จังหวัด"); //provinceNameTH
        $objWorkSheet->mergeCells('E' . $row . ':E' . $row)->setCellValue('E' . $row, "ปีโครงการ"); //project
        $objWorkSheet->mergeCells('F' . $row . ':F' . $row)->setCellValue('F' . $row, "ปีโครงการปรับ"); //project2
        $objWorkSheet->mergeCells('G' . $row . ':G' . $row)->setCellValue('G' . $row, "คลังสินค้า"); //silo
        $objWorkSheet->mergeCells('H' . $row . ':H' . $row)->setCellValue('H' . $row, "เข้าร่วมฯ"); //ass
        $objWorkSheet->mergeCells('I' . $row . ':I' . $row)->setCellValue('I' . $row, "ชนิดข้าว"); //type
        $objWorkSheet->mergeCells('J' . $row . ':J' . $row)->setCellValue('J' . $row, "หลังที่"); //warehouse
        $objWorkSheet->mergeCells('K' . $row . ':K' . $row)->setCellValue('K' . $row, "กองที่"); //stack
        $objWorkSheet->mergeCells('L' . $row . ':L' . $row)->setCellValue('L' . $row, "ปริมาณ (ตัน)"); //weight
        $objWorkSheet->mergeCells('M' . $row . ':M' . $row)->setCellValue('M' . $row, "คณะฯ ที่เก็บตัวอย่าง"); //sampling
        $objWorkSheet->mergeCells('N' . $row . ':N' . $row)->setCellValue('N' . $row, "ปริมาณน้ำหนักข้าวรวมกระสอบ (ตัน)"); //weightAll
        $objWorkSheet->mergeCells('O' . $row . ':O' . $row)->setCellValue('O' . $row, "จัดเกรดตามแนวทางของคณะทำงานจัดระดับฯ"); //grade
        $objWorkSheet->mergeCells('P' . $row . ':P' . $row)->setCellValue('P' . $row, "จัดระดับข้าวหอมมะลิเกรด C (ตรวจสอบ)"); //grade2
        $objWorkSheet->mergeCells('Q' . $row . ':Q' . $row)->setCellValue('Q' . $row, "ประมูลช่วง คสช. (คต.)"); //remark1
        $objWorkSheet->mergeCells('R' . $row . ':R' . $row)->setCellValue('R' . $row, "การระบายภาระผูกพัน"); //remark2
        $objWorkSheet->mergeCells('S' . $row . ':S' . $row)->setCellValue('S' . $row, "หมายเหตุ.1"); //remark3
        $objWorkSheet->mergeCells('T' . $row . ':T' . $row)->setCellValue('T' . $row, "หมดคลัง"); //remark4
        $objWorkSheet->mergeCells('U' . $row . ':U' . $row)->setCellValue('U' . $row, "กลุ่ม 1 ตามมติ นบข. ครั้งที่ 2/60 นำมาประมูล 1/60"); //remark5
        $objWorkSheet->mergeCells('V' . $row . ':V' . $row)->setCellValue('V' . $row, "หมายเหตุ"); //remark6
        $objWorkSheet->mergeCells('W' . $row . ':W' . $row)->setCellValue('W' . $row, "กลุ่ม ประมูล 1/60"); //remark7

        if (count($pivot) > 0) { //Title conditions grade from remark0 
            $rowCondition = 23;
            for ($i = 1; $i <= count($condition); $i++) {
                $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($rowCondition++);
                $objWorkSheet->mergeCells($columnLetter . $row . ':' . $columnLetter . $row)->setCellValue($columnLetter . $row, $condition[$i]); //remark0
//                echo $condition[$i];
            }
        }
//        exit();
        $row = 4;
        foreach ($data as $k => $v) {
            $objWorkSheet->setCellValueExplicit('A' . $row, $k + 1)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('B' . $row, $v['Code'])->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('C' . $row, $v['Bag_No'])->getStyle('C' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('D' . $row, $v['province'])->getStyle('D' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('E' . $row, $v['productProject2'])->getStyle('E' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('F' . $row, $v['productProject'])->getStyle('F' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('G' . $row, $v['Silo']);
            $objWorkSheet->setCellValue('H' . $row, $v['associate'])->getStyle('H' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('I' . $row, $v['productType'])->getStyle('I' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('J' . $row, $v['warehouse'])->getStyle('J' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('K' . $row, $v['stack'])->getStyle('K' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('L' . $row, $v['weight']);
            $objWorkSheet->setCellValue('M' . $row, $v['sampling'])->getStyle('M' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('N' . $row, $v['weightAll']);
            $objWorkSheet->setCellValue('O' . $row, $v['productGrade'])->getStyle('O' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('P' . $row, $v['productGrade2'])->getStyle('P' . $row)->getAlignment()->applyFromArray($center);
            $objWorkSheet->setCellValue('Q' . $row, $v['remark1']);
            $objWorkSheet->setCellValue('R' . $row, $v['remark2']);
            $objWorkSheet->setCellValue('S' . $row, $v['remark3']);
            $objWorkSheet->setCellValue('T' . $row, $v['remark4']);
            $objWorkSheet->setCellValue('U' . $row, $v['remark5']);
            $objWorkSheet->setCellValue('V' . $row, $v['remark6']);
            $objWorkSheet->setCellValue('W' . $row, $v['remark7']);
            if (count($pivot) > 0) { //Detail conditions grade from remark0 
                $rowCondition = 23;
                for ($i = 1; $i <= count($condition); $i++) {
                    $columnLetter = \PHPExcel_Cell::stringFromColumnIndex($rowCondition++);
                    $objWorkSheet->setCellValue($columnLetter . $row, $v[$condition[$i]])->getStyle($columnLetter . $row)->getAlignment()->applyFromArray($center);
                }
            }

            $row++;
        }
        $objWorkSheet->getStyle('A1:L3')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:L3')->getAlignment()->applyFromArray($middle);

        $objWorkSheet->getColumnDimension('A')->setWidth(10);
        $objWorkSheet->getColumnDimension('B')->setWidth(10);
        $objWorkSheet->getColumnDimension('C')->setWidth(10);
        $objWorkSheet->getColumnDimension('D')->setWidth(20);
        $objWorkSheet->getColumnDimension('E')->setWidth(20);
        $objWorkSheet->getColumnDimension('F')->setWidth(20);
        $objWorkSheet->getColumnDimension('G')->setWidth(30);
        $objWorkSheet->getColumnDimension('H')->setWidth(10);
        $objWorkSheet->getColumnDimension('I')->setWidth(20);
        $objWorkSheet->getColumnDimension('J')->setWidth(10);
        $objWorkSheet->getColumnDimension('K')->setWidth(10);
        $objWorkSheet->getColumnDimension('L')->setWidth(20);
        $objWorkSheet->getColumnDimension('M')->setWidth(10);
        $objWorkSheet->getColumnDimension('N')->setWidth(20);
        $objWorkSheet->getColumnDimension('O')->setWidth(20);
        $objWorkSheet->getColumnDimension('P')->setWidth(20);
        //$objWorkSheet->getColumnDimension('X')->setWidth(20);
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

    public function stack($book_id) {
        $product = new \apps\common\entity\Product();
        $product->bookId = $book_id;
        return $this->datacontext->getObject($product);
    }

    public function cut($book_id, $data_cut) {
        $update = "update dft_product "
                . "set book_id = null,remark0 = null "
                . "where book_id = '" . $book_id . "' and Id in (" . $data_cut . ") ";
        $sql = "EXEC sp_batch_exce :data";
        $param = array(
            "data" => $update
        );
        if ($this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")[0]->sdata == "ok") {
            return true;
        } else {
            return false;
        };
    }

    public function pivot($bookId) {
        $cmd = "EXEC sp_filter_pivot :book ";
        $param = array(
            "book" => $bookId
        );
        $data = $this->datacontext->pdoQuery($cmd, $param);
        return $data;
//        $array = get_object_vars($data[0]);
//        $properties = array_keys($array);
    }

}
