<?php

namespace apps\warehouse\service;

use apps\warehouse\interfaces\IWarehouseInfoService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class WarehouseInfoService extends CServiceBase implements IWarehouseInfoService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function string_to_ascii($string) {
        $num = substr(hexdec(crc32($string)), 0, 7);
        return $num;
    }

    function createCode($id) {
        $return = true;
        //warehouse code
        $sql = "SELECT"
                . " pv.Code AS pCode, ri.LK_Province_Id, ac.Code AS aCode, ri.LK_Associate_Id, ri.Silo"
                . " FROM dft_Rice_Info ri"
                . " INNER JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
                . " INNER JOIN dft_LK_Associate ac ON ac.Id = ri.LK_Associate_Id"
                . " WHERE ri.Id='" . $id . "'"
                . " GROUP BY pv.Code, ri.LK_Province_Id, ac.Code, ri.LK_Associate_Id, ri.Silo"
                . " ORDER BY ri.Silo ASC";
        $data = $this->datacontext->pdoQuery($sql);
        $value = $data[0];

        $conv = "R" . $value["pCode"] . $value["aCode"] . $this->string_to_ascii(str_replace(" ", "", $value["Silo"]));

        $update = "UPDATE dft_Rice_Info SET Warehouse_Code='" . $conv . "' WHERE Silo='" . $value["Silo"] . "' AND LK_Associate_Id='" . $value["LK_Associate_Id"] . "' AND LK_Province_Id='" . $value["LK_Province_Id"] . "'";
        $sql = "EXEC sp_batch_exce :cmd";

        $param = array(
            "cmd" => $update
        );

        if (!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) {
            return $this->datacontext->getLastMessage();
        }

        //stack code
        $sqlTop = "SELECT Running FROM dft_Warehouse_Code WHERE Warehouse_Code = :wCode";
        $paramTop = array(
            "wCode" => $conv
        );

        $dataTop = $this->datacontext->pdoQuery($sqlTop, $paramTop)[0];


        $start = $dataTop["Running"] + 1;

        $stackCode = $conv . str_pad($start, 4, "0", STR_PAD_LEFT);

        $wCommand = [];

        $wCommand[] = "UPDATE dft_Rice_Info SET Stack_Code='" . $stackCode . "' WHERE Id='" . $id . "'";

        $wCommand[] = "UPDATE dft_Warehouse_Code SET Running = Running + 1 WHERE Warehouse_Code = '" . $conv . "'";

        if (count($wCommand) > 0) {
            $sql = "EXEC sp_batch_exce :cmd";

            $param = array(
                "cmd" => implode(";", $wCommand)
            );

            if (!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) {
                return $this->datacontext->getLastMessage();
            }
        }

        return $return;
    }

    public function listsAllRice($columns, $draw, $start, $length) {
        $condArr = [];

        //search zone
        if ($columns[1]["search"]["value"] != "") {
            $val = $columns[1]["search"]["value"];
            $condArr[] = "zoneId = '" . $val . "'";
        }

        //search province
        if ($columns[2]["search"]["value"] != "") {
            $val = $columns[2]["search"]["value"];
            $condArr[] = "provinceId = '" . $val . "'";
        }

        //search code
        if ($columns[3]["search"]["value"] != "") {
            $val = $columns[3]["search"]["value"];
            $condArr[] = "code LIKE '%" . $val . "%'";
        }

        //search silo
        if ($columns[4]["search"]["value"] != "") {
            $val = $columns[4]["search"]["value"];
            $condArr[] = "silo LIKE '%" . $val . "%'";
        }

        //search project
        if ($columns[8]["search"]["value"] != "") {
            $val = $columns[8]["search"]["value"];
            $condArr[] = "projectId = '" . $val . "'";
        }

        //search type
        if ($columns[9]["search"]["value"] != "") {
            $val = $columns[9]["search"]["value"];
            $condArr[] = "typeId = '" . $val . "'";
        }

        //search grade
        if ($columns[10]["search"]["value"] != "") {
            $val = $columns[10]["search"]["value"];
            $condArr[] = "gradeId = '" . $val . "'";
        }

        //search status
        if ($columns[12]["search"]["value"] != "") {
            $val = $columns[12]["search"]["value"];
            $condArr[] = "statusKeyword = '" . $val . "'";
        }

        $condition = '';
        if (count($condArr) > 0) {
            $condition = "WHERE " . implode(" AND ", $condArr);
        }

        $sqlC = "SELECT COUNT(*) AS rows FROM fn_rice_tracking()"
                . " " . $condition;

        $count = $this->datacontext->pdoQuery($sqlC);

        $sql = "SELECT * FROM fn_rice_tracking()"
                . " " . $condition . " ORDER BY id OFFSET " . $start . " ROWS FETCH NEXT " . $length . " ROWS ONLY";

        //return $sql;
        $data = $this->datacontext->pdoQuery($sql);

        $this->getResponse()->add("recordsTotal", $count[0]["rows"]);
        $this->getResponse()->add("recordsFiltered", $count[0]["rows"]);
        $this->getResponse()->add("data", $data);
        return $draw;
    }

    public function listsProject() {
        $sql = "SELECT"
                . " pj.id,"
                . " pj.project AS name"
                . " FROM " . $this->ent . "\\Project pj";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsZone() {
        $sql = "SELECT"
                . " zn.id,"
                . " zn.zoneNameTH AS name"
                . " FROM " . $this->ent . "\\Zone zn";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsProvince() {
        $sql = "SELECT"
                . " pv.id,"
                . " pv.provinceNameTH AS name"
                . " FROM " . $this->ent . "\\Province pv";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsType() {
        $sql = "SELECT"
                . " tp.id,"
                . " tp.type AS name"
                . " FROM " . $this->ent . "\\Type tp";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsSilo() {
        $sql = "SELECT"
                . " ri.silo AS id,"
                . " ri.silo AS name"
                . " FROM " . $this->ent . "\\RiceInfo ri"
                . " GROUP BY ri.silo";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsGrade() {
        $sql = "SELECT"
                . " gd.id,"
                . " gd.grade AS name"
                . " FROM " . $this->ent . "\\Grade gd";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsStatus() {
        $sql = "SELECT"
                . " st.keyword AS id,"
                . " st.status AS name"
                . " FROM " . $this->ent . "\\Status st";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsAssociate() {
        $sql = "SELECT"
                . " ac.id,"
                . " ac.associate AS name"
                . " FROM " . $this->ent . "\\Associate ac";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function riceInfo($id) {
        $result = [];

        $sql = "SELECT"
                . " ri.id, pv.provinceNameTH, ri.stackCode, ri.code, ri.silo, ac.associate,"
                . " ri.warehouse, ri.stack, pj.project, tp.type, gd.grade, ri.weight,"
                . " ri.discountRate, st.status"
                . " FROM " . $this->ent . "\\RiceInfo ri"
                . " JOIN " . $this->ent . "\\Province pv WITH pv.id = ri.provinceId"
                . " JOIN " . $this->ent . "\\Associate ac WITH ac.id = ri.associateId"
                . " JOIN " . $this->ent . "\\Project pj WITH pj.id = ri.projectId"
                . " JOIN " . $this->ent . "\\Type tp WITH tp.id = ri.typeId"
                . " JOIN " . $this->ent . "\\Grade gd WITH gd.id = ri.gradeId"
                . " LEFT JOIN " . $this->ent . "\\Status st WITH st.keyword = ri.statusKeyword"
                . " WHERE ri.id = :id";
        $param = array(
            "id" => $id
        );

        $data = $this->datacontext->getObject($sql, $param);

        $status = [];

        if ($data[0]["status"] != null) {
            array_push($status, array(
                "status" => $data[0]["status"]
            ));
        }

        $sql2 = "SELECT"
                . " st.status"
                . " FROM " . $this->ent . "\\RiceTracking rt"
                . " JOIN " . $this->ent . "\\Status st WITH st.keyword = rt.statusKeyword"
                . " WHERE rt.stackCode = :code"
                . " ORDER BY rt.dateCreated";
        $param2 = array(
            "code" => $data[0]["stackCode"]
        );
        $data2 = $this->datacontext->getObject($sql2, $param2);
        foreach ($data2 as $key => $val) {
            array_push($status, array(
                "status" => $val["status"]
            ));
        }

        $result = $data[0];
        unset($result["status"]);

        $result["statusArr"] = $status;

        return $result;
    }

    public function select($id) {
        $sql = "SELECT"
                . " ri.id, ri.provinceId, pv.provinceNameTH, ri.stackCode, ri.code, ri.silo, ri.associateId, ac.associate,"
                . " ri.warehouse, ri.stack, ri.projectId, pj.project, ri.typeId, tp.type, ri.gradeId, gd.grade, ri.weight,"
                . " ri.discountRate, st.status"
                . " FROM " . $this->ent . "\\RiceInfo ri"
                . " JOIN " . $this->ent . "\\Province pv WITH pv.id = ri.provinceId"
                . " JOIN " . $this->ent . "\\Associate ac WITH ac.id = ri.associateId"
                . " JOIN " . $this->ent . "\\Project pj WITH pj.id = ri.projectId"
                . " JOIN " . $this->ent . "\\Type tp WITH tp.id = ri.typeId"
                . " JOIN " . $this->ent . "\\Grade gd WITH gd.id = ri.gradeId"
                . " LEFT JOIN " . $this->ent . "\\Status st WITH st.keyword = ri.statusKeyword"
                . " WHERE ri.id = :id";
        $param = array(
            "id" => $id
        );

        $data = $this->datacontext->getObject($sql, $param);

        return $data[0];
    }

    public function insert($riceInfo) {
        $return = true;

        //$info = new \apps\common\entity\RiceInfo();
        if (!$this->datacontext->saveObject($riceInfo)) {
            $return = $this->datacontext->getLastMessage();
        }
        if ($return == true) {
            return $this->createCode($riceInfo->id);
        } else {
            return $return;
        }
    }

    public function update($riceInfo) {
        $return = true;

        if (!$this->datacontext->updateObject($riceInfo)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }

    public function delete($riceInfo) {
        $return = true;

        $info = new \apps\common\entity\RiceInfo();
        $info->id = $riceInfo->id;
        $dataInfo = $this->datacontext->getObject($info);
        if (!$this->datacontext->removeObject($dataInfo)) {
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

        //set protection
        $objWorkSheet->getProtection()->setPassword('123456');
        $objWorkSheet->getProtection()->setSheet(true);
        $objWorkSheet->getStyle('B4:B' . $row)->getProtection()->setLocked(
                \PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );
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
