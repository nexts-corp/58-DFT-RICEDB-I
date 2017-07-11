<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use apps\tracking\interfaces\IFollowService;
use apps\common\entity\RiceFollow;
use th\co\bpg\cde\data\CDataContext;

class FollowService extends CServiceBase implements IFollowService {

    public $datacontext;
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->datacontext = new CDataContext(NULL);
    }

    function getFollow($auccode, $associateId) {
        $sql = "select vf from apps\\common\\model\\ViewFollow vf "
                . " where vf.associateId = :associateId and "
                . " vf.statusKeyword = :keyword "
                . " order by vf.bidderName,vf.silo,vf.associateId,vf.typeId,vf.project ";
        //$sql = "SELECT v0_.followCode AS followCode0, v0_.lotCode AS lotCode1, v0_.statusKeyword AS statusKeyword2, v0_.statusName AS statusName3, v0_.bidderNo AS bidderNo4, v0_.bidderName AS bidderName5, v0_.associateId AS associateId6, v0_.associate AS associate7, v0_.provinceId AS provinceId8, v0_.province AS province9, v0_.projectId AS projectId10, v0_.project AS project11, v0_.typeId AS typeId12, v0_.type AS type13, v0_.silo AS silo14, v0_.weightApprove AS weightApprove15, v0_.weightContract AS weightContract16, v0_.weightReceived AS weightReceived17, v0_.weightBalance AS weightBalance18, v0_.weightLost AS weightLost19, v0_.contractNo AS contractNo20, v0_.followDate AS followDate21, v0_.dueDate AS dueDate22, v0_.remark AS remark23 FROM view_rice_follow v0_ WHERE v0_.associateId = :associateId AND v0_.statusKeyword = :keyword ORDER BY v0_.lotCode DESC";
        $param = array(
            "associateId" => $associateId,
            "keyword" => $auccode
        );

        $get = $this->datacontext->getObject($sql, $param);

        if (empty($get)) {
//            $group = new \apps\common\model\GroupFollow();
//            $group->associateId = $associateId;
//            $group->statusKeyword = $auccode;
//            $data = $this->datacontext->getObject($group);
            $sqlGroup = "select * from fn_follow_group_rice(:keyword,:associateId) ";
            $data = $this->datacontext->pdoQuery($sqlGroup, $param);
            $siloCode = 0;
            $silo = "";
            foreach ($data as $index => $value) {
                if ($silo == "" || $silo != $value['silo']) {
                    $silo = $value['silo'];
                    $siloCode++;
                }
                $lotCode = date('Ymd');
                $code = $lotCode . $value['associateId'] . $value['provinceId'] . $value['projectId'] . $value['typeId'] . $siloCode;

                $follow = new RiceFollow();
                $follow->followCode = $code;
                $follow->lotCode = $lotCode;
                $follow->statusKeyword = $auccode;
                $follow->bidderId = $value['bidderNo'];
                $follow->associateId = $value['associateId'];
                $follow->provinceId = $value['provinceId'];
                $follow->projectId = $value['projectId'];
                $follow->typeId = $value['typeId'];
                $follow->silo = $value['silo'];
                $follow->weightApprove = $value['weightApprove'];
//                return $follow;
                if (!$this->datacontext->saveObject($follow)) {
                    $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
                    return false;
                }
            }

            $sql = "select vf from apps\\common\\model\\ViewFollow vf "
                    . " where vf.associateId = :associateId and "
                    . " vf.statusKeyword = :keyword "
                    . " order by vf.lotCode desc ";
            $param = array(
                "associateId" => $associateId,
                "keyword" => $auccode
            );
            $get = $this->datacontext->getObject($sql, $param);
        }

        foreach ($get as $key => $value) {
            if ($value->followDate == null) {
                $get[$key]->followDate = "";
            } elseif ($value->followDate->format("Y-m-d") != "1900-01-01" && $value->followDate->format("Y-m-d") != "1970-01-01") {
                $date = $value->followDate->format("Y-m-d");
                $get[$key]->followDate = substr($date, 8, 2) . "-" . substr($date, 5, 2) . "-" . ((int) substr($date, 0, 4) + 543);
            } else {
                $get[$key]->followDate = "";
            }

            if ($value->dueDate == null) {
                $get[$key]->dueDate = "";
            } elseif ($value->dueDate->format("Y-m-d") != "1900-01-01" && $value->dueDate->format("Y-m-d") != "1970-01-01") {
                $date = $value->dueDate->format("Y-m-d");
                $get[$key]->dueDate = substr($date, 8, 2) . "-" . substr($date, 5, 2) . "-" . ((int) substr($date, 0, 4) + 543);
            } else {
                $get[$key]->dueDate = "";
            }

            if ($value->lotCode != $get[0]->lotCode) {
                unset($get[$key]);
            }
        }
        return $get;
    }

    public function listsAuction() {
        $sql = "select s from " . $this->ent . "\\Status s "
                . " where s.keyword like 'AU%' "
                . " order by s.id desc";
        return $this->datacontext->getObject($sql);
    }

    public function listsAssociate() {
        $sql = "select a from " . $this->ent . "\\Associate a "
                . " order by a.id desc";
        return $this->datacontext->getObject($sql);
    }

    public function export($auccode, $associateId) {
        $aucArr = [];
        if ($auccode == "all") {
            $list = $this->listsAuction();
            foreach ($list as $key => $value) {
                $aucArr[] = $value->keyword;
            }
        } else {
            $aucArr[] = $auccode;
        }
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
        foreach ($aucArr as $key => $value) {
            //print "(" . $key . " " . $value . " a" . $associateId . ")";
            $follow = $this->getFollow($value, $associateId);
            //print " e" . !empty($follow) . " i" . isset($follow) . " ";

            if (isset($follow) && !empty($follow)) {
                // print "pass ";
                // print $follow[0]->statusName . "<br>";
                $objWorkSheet = $objPHPExcel->createSheet($sheet);
                $objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheet);
                $objWorkSheet = $objPHPExcel->getActiveSheet();

                $name = $follow[0]->statusName;
                $objWorkSheet->setTitle(str_replace("/", "_", $name));

                //column name
                $row = 1;
                $objWorkSheet->mergeCells('A1:P1')
                        ->setCellValueByColumnAndRow(0, $row, "การจำหน่ายข้าวสารในสต็อกของรัฐ ครั้งที่ " . $name)
                        ->getStyleByColumnAndRow(0, $row)->getAlignment()->applyFromArray($middle)->setWrapText(true);

                $row = 2;
                $objWorkSheet->setCellValue('A' . $row, "Code:" . $value . "-" . $associateId);

                $row = 3;
                $objWorkSheet->mergeCells('A' . $row . ':A' . ($row + 1))->setCellValue('A' . $row, "รหัส");
                $objWorkSheet->mergeCells('B' . $row . ':B' . ($row + 1))->setCellValue('B' . $row, "ลำดับที่");
                $objWorkSheet->mergeCells('C' . $row . ':C' . ($row + 1))->setCellValue('C' . $row, "ผู้เสนอราคา");
                $objWorkSheet->mergeCells('D' . $row . ':D' . ($row + 1))->setCellValue('D' . $row, "คลังสินค้า");
                $objWorkSheet->mergeCells('E' . $row . ':E' . ($row + 1))->setCellValue('E' . $row, "ชนิดข้าว");
                $objWorkSheet->mergeCells('F' . $row . ':F' . ($row + 1))->setCellValue('F' . $row, "ปีโครงการ");
                $objWorkSheet->mergeCells('G' . $row . ':G' . ($row + 1))->setCellValue('G' . $row, "จังหวัด");
                $objWorkSheet->mergeCells('H' . $row . ':L' . $row)->setCellValue('H' . $row, "ปริมาณ (ตัน)");
                $objWorkSheet->mergeCells('M' . $row . ':M' . ($row + 1))->setCellValue('M' . $row, "เลขที่สัญญา");
                $objWorkSheet->mergeCells('N' . $row . ':N' . ($row + 1))->setCellValue('N' . $row, "ลงวันที่ (วัน-เดือน-ปี)");
                $objWorkSheet->mergeCells('O' . $row . ':O' . ($row + 1))->setCellValue('O' . $row, "ครบกำหนดสัญญา (วัน-เดือน-ปี)");
                $objWorkSheet->mergeCells('P' . $row . ':P' . ($row + 1))->setCellValue('P' . $row, "หมายเหตุ");

                $row = 4;
                $objWorkSheet->setCellValue('H' . $row, "ตามอนุมัติ");
                $objWorkSheet->setCellValue('I' . $row, "ทำสัญญาแล้ว");
                $objWorkSheet->setCellValue('J' . $row, "รับมอบแล้ว");
                $objWorkSheet->setCellValue('K' . $row, "คงเหลือ");
                $objWorkSheet->setCellValue('L' . $row, "สูญหาย");

                $row = 5;
                foreach ($follow as $k => $v) {
                    $objWorkSheet->setCellValueExplicit('A' . $row, $v->followCode)->getStyle('A' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('B' . $row, $k + 1)->getStyle('B' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('C' . $row, $v->bidderName);
                    $objWorkSheet->setCellValue('D' . $row, $v->silo);
                    $objWorkSheet->setCellValue('E' . $row, $v->type)->getStyle('E' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('F' . $row, $v->project)->getStyle('F' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('G' . $row, $v->province)->getStyle('G' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('H' . $row, $v->weightApprove);
                    $objWorkSheet->setCellValue('I' . $row, $v->weightContract);
                    $objWorkSheet->setCellValue('J' . $row, $v->weightReceived);
                    $objWorkSheet->setCellValue('K' . $row, $v->weightBalance);
                    $objWorkSheet->setCellValue('L' . $row, $v->weightLost);
                    $objWorkSheet->setCellValue('M' . $row, $v->contractNo)->getStyle('M' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('N' . $row, $v->followDate)->getStyle('N' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('O' . $row, $v->dueDate)->getStyle('O' . $row)->getAlignment()->applyFromArray($center);
                    $objWorkSheet->setCellValue('P' . $row, $v->remark);

                    $row++;
                }

                //style column
                $objWorkSheet->getStyle('A1:P4')->getFont()->setBold(true);
                $objWorkSheet->getStyle('A1:P4')->getAlignment()->applyFromArray($middle);

                $objWorkSheet->getColumnDimension('A')->setWidth(20);
                $objWorkSheet->getColumnDimension('B')->setWidth(10);
                $objWorkSheet->getColumnDimension('C')->setWidth(30);
                $objWorkSheet->getColumnDimension('D')->setWidth(30);
                $objWorkSheet->getColumnDimension('E')->setWidth(20);
                $objWorkSheet->getColumnDimension('F')->setWidth(20);
                $objWorkSheet->getColumnDimension('G')->setWidth(20);
                $objWorkSheet->getColumnDimension('H')->setWidth(20);
                $objWorkSheet->getColumnDimension('I')->setWidth(20);
                $objWorkSheet->getColumnDimension('J')->setWidth(20);
                $objWorkSheet->getColumnDimension('K')->setWidth(20);
                $objWorkSheet->getColumnDimension('L')->setWidth(20);
                $objWorkSheet->getColumnDimension('M')->setWidth(20);
                $objWorkSheet->getColumnDimension('N')->setWidth(20);
                $objWorkSheet->getColumnDimension('O')->setWidth(20);
                $objWorkSheet->getColumnDimension('P')->setWidth(30);

                //set protection
                $objWorkSheet->getProtection()->setPassword('123456');
                $objWorkSheet->getProtection()->setSheet(true);
                $objWorkSheet->getStyle('H5:P' . $row)->getProtection()->setLocked(
                        \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
                );

                $objWorkSheet->getStyle('N5:O' . $row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');

                $sheet++;
            } else {
                print "fail <br>";
            }
        }

        //create excel file
        ob_clean();

        header('Content-Type: application/vnd.ms-excel');
        if ($auccode == "all") {
            $name = "ทั้งหมด";
        }
        header("Content-Disposition: attachment;filename=สรุปปริมาณรับมอบข้าว_" . str_replace("/", "_", $name) . ".xls");

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        ob_end_flush();
        exit();
    }

    public function get($auccode, $associateId) {
        return $this->getFollow($auccode, $associateId);
    }

    public function view($file, $sheet, $row) {
        $inputFileName = $file["tmp_name"];

        $sheetActive = $sheet - 1; //start at 0
        $rowStart = $row; //start at 1

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '":' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet($sheetActive);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        $data = [];
        for ($row = $rowStart; $row <= $highestRow; $row++) {
            $list = [];
            if ($sheet->getCell('A' . $row)->getFormattedValue() != "") {
                for ($col = 1; $col < $highestColumnIndex; ++$col) {
                    $val = $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue();

                    $list[] = $val;
                }

                array_push($data, $list);
            }
        }

        return $data;
    }

    public function import($file, $sheet, $row) {
        $return = true;

        $inputFileName = $file["tmp_name"];

        $sheetActive = $sheet - 1; //start at 0
        $rowStart = $row; //start at 1

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '":' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet($sheetActive);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        $count = 0;
        $command = [];

        $keyCell = $sheet->getCell('A2')->getFormattedValue();
        $key = explode("-", str_replace("Code:", "", $keyCell));

        $auccode = $key[0];
        $associateId = $key[1];

        $check = new \apps\common\entity\RiceFollow();
        $check->statusKeyword = $auccode;
        $check->associateId = $associateId;

        for ($row = $rowStart; $row <= $highestRow; $row++) {
            $followCode = $sheet->getCell('A' . $row)->getFormattedValue();

            if ($followCode != "") {
                $check->followCode = $followCode;
                $data = $this->datacontext->getObject($check, array(), 1)[0];

                $lotCode = $data->lotCode;
                $statusKeyword = $data->statusKeyword;
                $bidderId = $data->bidderId;
                $associateId = $data->associateId;
                $provinceId = $data->provinceId;
                $projectId = $data->projectId;
                $typeId = $data->typeId;
                $silo = $data->silo;
                $weightApprove = $sheet->getCell('H' . $row)->getFormattedValue();
                $weightContract = $sheet->getCell('I' . $row)->getFormattedValue();
                $weightReceived = $sheet->getCell('J' . $row)->getFormattedValue();
                $weightBalance = $sheet->getCell('K' . $row)->getFormattedValue();
                $weightLost = $sheet->getCell('L' . $row)->getFormattedValue();
                $contractNo = $sheet->getCell('M' . $row)->getFormattedValue();

                $followDate = $sheet->getCell('N' . $row)->getFormattedValue();
                $followDate = date("Y-m-d", mktime(0, 0, 0, substr($followDate, 3, 2), substr($followDate, 0, 2), substr($followDate, 6, 4) - 543));

                $dueDate = $sheet->getCell('O' . $row)->getFormattedValue();
                $dueDate = date("Y-m-d", mktime(0, 0, 0, substr($dueDate, 3, 2), substr($dueDate, 0, 2), substr($dueDate, 6, 4) - 543));

                $remark = $sheet->getCell('P' . $row)->getFormattedValue();

                $dateCheck = '';
                if ($data->followDate != null)
                    $dateCheck = $data->followDate->format("Y-m-d");

                if ($dateCheck != $followDate) {
                    $command[] = "('" . $followCode . "', '" . $lotCode . "', '" . $statusKeyword . "', '" . $bidderId . "', '" . $associateId . "', '" . $provinceId . "', '" . $projectId . "', '" . $typeId . "', '" . $silo . "', '" . $weightApprove . "', '" . $weightContract . "', '" . $weightReceived . "', '" . $weightBalance . "', '" . $weightLost . "', '" . $contractNo . "', '" . $followDate . "', '" . $dueDate . "', '" . $remark . "')";

                    $count++;
                }

                //return $command;
            }

            if ($count == 10 || $row == $highestRow) {
                if (count($command) > 0) {
                    $insert = "INSERT INTO dft_Rice_Follow(Follow_Code, Lot_Code, LK_Status_Keyword, LK_Bidder_Id, LK_Associate_Id, LK_Province_Id, LK_Project_Id, LK_Type_Id, Silo, Weight_Approve, Weight_Contract, Weight_Received, Weight_Balance, Weight_Lost, Contract_No, Follow_Date, Due_Date, Remark) VALUES " . implode(",", $command);
                    $sql = "EXEC sp_batch_insert :cmd";
                    $param = array(
                        "cmd" => $insert
                    );

                    if (!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) {
                        return false;
                    }
                    $command = [];
                    $count = 0;
                }
            }
        }

        return $return;
    }

}
