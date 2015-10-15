<?php

namespace apps\reserve\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\reserve\interfaces\IManageService;

class ManageService extends CServiceBase implements IManageService {

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
            ." FROM ".$this->ent."\\Reserve rs"
            ." ORDER BY rs.id ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function lkProject(){
        $sql = "SELECT"
            ." pj.id,"
            ." pj.project AS name"
            ." FROM ".$this->ent."\\Project pj";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function lkProvince(){
        $sql = "SELECT"
            ." pv.id,"
            ." pv.provinceNameTH AS name"
            ." FROM ".$this->ent."\\Province pv";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function lkType(){
        $sql = "SELECT"
            ." tp.id,"
            ." tp.type AS name"
            ." FROM ".$this->ent."\\Type tp";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function lkGrade(){
        $sql = "SELECT"
            ." gd.id,"
            ." gd.grade AS name"
            ." FROM ".$this->ent."\\Grade gd";
        $data = $this->datacontext->getObject($sql);

        return $data;
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

    public function listsReserveByIndex($reserveList){
        $sql = "SELECT "
            ." rr"
        ." FROM ".$this->ent."\\RiceReserve rr"
        ." WHERE rr.reserveKeyword = :keyword";
        $param = array(
            "keyword" => $reserveList->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function listsRiceCanReserve($columns, $draw, $start, $length){
        $condArr1 = [];
        $condArr2 = [];

        //search province
        if($columns[1]["search"]["value"] != ""){
            $val = $columns[1]["search"]["value"];
            $condArr1[] = "LK_Province_Id = '".$val."'";
            $condArr2[] = "pv.id = '".$val."'";
        }

        //search code
        if($columns[2]["search"]["value"] != ""){
            $val = $columns[2]["search"]["value"];
            $condArr1[] = "Code LIKE '%".$val."%'";
            $condArr2[] = "ri.code LIKE '%".$val."%'";
        }

        //search silo
        if($columns[3]["search"]["value"] != ""){
            $val = $columns[3]["search"]["value"];
            $condArr1[] = "Silo LIKE '%".$val."%'";
            $condArr2[] = "ri.silo LIKE '%".$val."%'";
        }

        //search project
        if($columns[7]["search"]["value"] != ""){
            $val = $columns[7]["search"]["value"];
            $condArr1[] = "LK_Project_Id = '".$val."'";
            $condArr2[] = "pj.id = '".$val."'";
        }

        //search type
        if($columns[8]["search"]["value"] != ""){
            $val = $columns[8]["search"]["value"];
            $condArr1[] = "LK_Type_Id = '".$val."'";
            $condArr2[] = "tp.id = '".$val."'";
        }

        //search grade
        if($columns[9]["search"]["value"] != ""){
            $val = $columns[9]["search"]["value"];
            $condArr1[] = "LK_Grade_Id = '".$val."'";
            $condArr2[] = "gd.id = '".$val."'";
        }

        $condition1 = '';
        $condition2 = '';
        if(count($condArr1) > 0){
            $condition1 = "WHERE ".implode(" AND ", $condArr1);
            $condition2 = "WHERE ".implode(" AND ", $condArr2);
        }
        $sqlC = "SELECT"
            ." COUNT(*) AS rows"
            ." FROM dft_Rice_Info ri"
            ." JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
            ." JOIN dft_LK_Zone zn ON zn.Id = pv.LK_Zone_Id"
            ." ".$condition1;

        $count = $this->datacontext->pdoQuery($sqlC);

        $sql = "SELECT"
            ." ri.id AS riceInfoId, ri.provinceId, pv.provinceNameTH, ri.code, ri.silo, ac.associate,"
            ." ri.warehouse, ri.stack, ri.projectId, pj.project, ri.typeId, tp.type, ri.gradeId, gd.grade,"
            ." ri.discountRate, ri.weight"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." JOIN ".$this->ent."\\Province pv WITH pv.id = ri.provinceId"
            ." JOIN ".$this->ent."\\Associate ac WITH ac.id = ri.associateId"
            ." JOIN ".$this->ent."\\Project pj WITH pj.id = ri.projectId"
            ." JOIN ".$this->ent."\\Type tp WITH tp.id = ri.typeId"
            ." JOIN ".$this->ent."\\Grade gd WITH gd.id = ri.gradeId"
            ." ".$condition2;

        $data = $this->datacontext->getObject($sql, array(), $length, $start);

        $this->getResponse()->add("recordsTotal", $count[0]["rows"]);
        $this->getResponse()->add("recordsFiltered", $count[0]["rows"]);
        $this->getResponse()->add("data", $data);
        return $draw;
    }

    public function insert($reserveList, $riceReserve){
        $return = true;

        $reserveList->keyword = $reserveList->reserveCode.date("YmdHis");

        if(!($this->datacontext->saveObject($reserveList))){
            $return = $this->datacontext->getLastMessage();
        }

        $conditionArr = array();
        foreach($riceReserve as $key => $val){
            $conditionArr[$key] = "ri.id='".$val->riceInfoId."'";
        }
        $condition = implode(" OR ", $conditionArr);

        $sql = "SELECT"
            ." ri"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." WHERE (".$condition.")";

        $data = $this->datacontext->getObject($sql);
        foreach($data as $key => $val){
            $rice = new \apps\common\entity\RiceReserve();
            $rice->riceInfoId = $val->id;
            $rice->reserveKeyword = $reserveList->keyword;

            $check = $this->datacontext->getObject($rice);

            if(count($check) == 0){
                $rice->code = $val->code;
                $rice->bagNo = $val->bagNo;
                $rice->provinceId = $val->provinceId;
                $rice->projectId = $val->projectId;
                $rice->silo = $val->silo;
                $rice->associateId = $val->associateId;
                $rice->typeId = $val->typeId;
                $rice->warehouse = $val->warehouse;
                $rice->stack = $val->stack;
                $rice->weight = $val->weight;
                $rice->samplingId = $val->samplingId;
                $rice->gradeId = $val->gradeId;
                $rice->discountRate = $val->discountRate;


                if(!($this->datacontext->saveObject($rice))){
                    $return = $this->datacontext->getLastMessage();
                }
            }
        }
        return $return;
    }

    public function update($reserveList, $riceReserve){
        $return = true;

        $list = new \apps\common\entity\ReserveList();
        $list->keyword = $reserveList->keyword;
        $dataList = $this->datacontext->getObject($list);
        $dataList[0]->detail = $reserveList->detail;
        $dataList[0]->target = $reserveList->target;
        $dataList[0]->reserveCode = $reserveList->reserveCode;
        $dataList[0]->keyword = $reserveList->reserveCode.substr($reserveList->keyword, 2);

        //update reserve list data
        if (!$this->datacontext->updateObject($dataList[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        //delete old data in Rice Reserve
        $reserve = new \apps\common\entity\RiceReserve();
        $reserve->reserveKeyword = $reserveList->keyword;
        $dataHistory = $this->datacontext->getObject($reserve);
        if (!$this->datacontext->removeObject($dataHistory)) {
            $return = $this->datacontext->getLastMessage();
        }

        // insert new data
        $conditionArr = array();
        foreach($riceReserve as $key => $val){
            $conditionArr[$key] = "ri.id='".$val->riceInfoId."'";
        }
        $condition = implode(" OR ", $conditionArr);

        $sql = "SELECT"
            ." ri"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." WHERE (".$condition.")";

        $data = $this->datacontext->getObject($sql);
        foreach($data as $key => $val){
            $rice = new \apps\common\entity\RiceReserve();
            $rice->riceInfoId = $val->id;
            $rice->reserveKeyword = $dataList[0]->keyword;

            $check = $this->datacontext->getObject($rice);

            if(count($check) == 0){
                $rice->code = $val->code;
                $rice->bagNo = $val->bagNo;
                $rice->provinceId = $val->provinceId;
                $rice->projectId = $val->projectId;
                $rice->silo = $val->silo;
                $rice->associateId = $val->associateId;
                $rice->typeId = $val->typeId;
                $rice->warehouse = $val->warehouse;
                $rice->stack = $val->stack;
                $rice->weight = $val->weight;
                $rice->samplingId = $val->samplingId;
                $rice->gradeId = $val->gradeId;
                $rice->discountRate = $val->discountRate;


                if(!($this->datacontext->saveObject($rice))){
                    $return = $this->datacontext->getLastMessage();
                }
            }
        }
        return $return;
    }

    public function delete($reserveList){
        $return = true;

        $list = new \apps\common\entity\ReserveList();
        $list->keyword = $reserveList->keyword;
        $dataList = $this->datacontext->getObject($list);
        if (!$this->datacontext->removeObject($dataList)) {
            $return = $this->datacontext->getLastMessage();
        }

        //delete old data in Rice Reserve
        $reserve = new \apps\common\entity\RiceReserve();
        $reserve->reserveKeyword = $reserveList->keyword;
        $dataHistory = $this->datacontext->getObject($reserve);
        if (!$this->datacontext->removeObject($dataHistory)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }
}