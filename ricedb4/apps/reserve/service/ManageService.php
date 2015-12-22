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
            ." rr.id, rr.warehouseCode, rr.stackCode, pv.provinceNameTH, rr.code, rr.silo,"
            ." ac.associate, rr.warehouse, rr.stack, pj.project, tp.type, gd.grade, rr.tWeight"
        ." FROM ".$this->ent."\\RiceReserve rr"
        ." JOIN ".$this->ent."\\Province pv WITH pv.id = rr.provinceId"
        ." JOIN ".$this->ent."\\Associate ac WITH ac.id = rr.associateId"
        ." JOIN ".$this->ent."\\Project pj WITH pj.id = rr.projectId"
        ." JOIN ".$this->ent."\\Type tp WITH tp.id = rr.typeId"
        ." JOIN ".$this->ent."\\Grade gd WITH gd.id = rr.gradeId"
        ." WHERE rr.reserveKeyword = :keyword";
        $param = array(
            "keyword" => $reserveList->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function listsRiceCanReserve($columns, $draw, $start, $length){
        $condArr = [];

        //search province
        if($columns[1]["search"]["value"] != ""){
            $val = $columns[1]["search"]["value"];
            $condArr[] = "provinceId = '".$val."'";
        }

        //search code
        if($columns[2]["search"]["value"] != ""){
            $val = $columns[2]["search"]["value"];
            $condArr[] = "code LIKE '%".$val."%'";
        }

        //search silo
        if($columns[3]["search"]["value"] != ""){
            $val = $columns[3]["search"]["value"];
            $condArr[] = "silo LIKE '%".$val."%'";
        }

        //search project
        if($columns[7]["search"]["value"] != ""){
            $val = $columns[7]["search"]["value"];
            $condArr[] = "projectId = '".$val."'";
        }

        //search type
        if($columns[8]["search"]["value"] != ""){
            $val = $columns[8]["search"]["value"];
            $condArr[] = "typeId = '".$val."'";
        }

        //search grade
        if($columns[9]["search"]["value"] != ""){
            $val = $columns[9]["search"]["value"];
            $condArr[] = "gradeId = '".$val."'";
        }

        $condition = '';
        if(count($condArr) > 0){
            $condition = "AND ".implode(" AND ", $condArr);
        }
        $sqlC = "SELECT COUNT(*) AS rows FROM fn_rice_tracking() WHERE status IS NULL AND tWeight != 0"
            ." ".$condition;

        $count = $this->datacontext->pdoQuery($sqlC);

        $sql = "SELECT * FROM fn_rice_tracking() WHERE status IS NULL AND tWeight != 0"
            ." ".$condition." ORDER BY id OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";

        $data = $this->datacontext->pdoQuery($sql);

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
            $conditionArr[$key] = "ri.stackCode='".$val->stackCode."'";
        }
        $condition = implode(" OR ", $conditionArr);

        $sql = "SELECT"
            ." ri"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." WHERE (".$condition.")";

        $data = $this->datacontext->getObject($sql);
        $count = 0;
        $command = [];
        foreach($data as $key => $val){
            $warehouseCode = $val->warehouseCode;
            $stackCode = $val->stackCode;
            $reserveKeyword = $reserveList->keyword;
            $code = $val->code;
            $bagNo = $val->bagNo;
            $provinceId = $val->provinceId;
            $projectId = $val->projectId;
            $silo = $val->silo;
            $associateId = $val->associateId;
            $typeId = $val->typeId;
            $warehouse = $val->warehouse;
            $stack = $val->stack;
            $tWeight = $val->tWeight;
            $weight = $val->weight;
            $samplingId = $val->samplingId;
            $gradeId = $val->gradeId;
            $discountRate = $val->discountRate;

            $command[] = "('".$warehouseCode."', '".$stackCode."', '".$reserveKeyword."', '".$code."',"
                ."'".$bagNo."', '".$provinceId."', '".$projectId."', '".$silo."', '".$associateId."',"
                ."'".$typeId."', '".$warehouse."', '".$stack."', '".$tWeight."', '".$weight."', '".$samplingId."',"
                ."'".$gradeId."', '".$discountRate."')";
            $count++;

            if($count == 10 || $key == count($data) - 1){
                if(count($command) > 0){
                    $insert = "INSERT INTO dft_Rice_Reserve(Warehouse_Code, Stack_Code, Reserve_List_Keyword,
                        Code, Bag_No, LK_Province_Id, LK_Project_Id, Silo, LK_Associate_Id, LK_Type_Id,
                        Warehouse, Stack, TWeight, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate)
                        VALUES ".implode(",", $command);

                    $sql = "EXEC sp_batch_insert :cmd";

                    $param = array(
                        "cmd" =>  $insert
                    );

                    if(!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")){
                        return $this->datacontext->getLastMessage();
                    }
                    $command = [];
                    $count = 0;
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
            $conditionArr[$key] = "ri.stackCode='".$val->stackCode."'";
        }
        $condition = implode(" OR ", $conditionArr);

        $sql = "SELECT"
            ." ri"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." WHERE (".$condition.")";

        $data = $this->datacontext->getObject($sql);
        $count = 0;
        $command = [];
        foreach($data as $key => $val){
            $warehouseCode = $val->warehouseCode;
            $stackCode = $val->stackCode;
            $reserveKeyword = $reserveList->keyword;
            $code = $val->code;
            $bagNo = $val->bagNo;
            $provinceId = $val->provinceId;
            $projectId = $val->projectId;
            $silo = $val->silo;
            $associateId = $val->associateId;
            $typeId = $val->typeId;
            $warehouse = $val->warehouse;
            $stack = $val->stack;
            $tWeight = $val->tWeight;
            $weight = $val->weight;
            $samplingId = $val->samplingId;
            $gradeId = $val->gradeId;
            $discountRate = $val->discountRate;

            $command[] = "('".$warehouseCode."', '".$stackCode."', '".$reserveKeyword."', '".$code."',"
                ."'".$bagNo."', '".$provinceId."', '".$projectId."', '".$silo."', '".$associateId."',"
                ."'".$typeId."', '".$warehouse."', '".$stack."', '".$tWeight."', '".$weight."', '".$samplingId."',"
                ."'".$gradeId."', '".$discountRate."')";
            $count++;

            if($count == 10 || $key == count($data) - 1){
                if(count($command) > 0){
                    $insert = "INSERT INTO dft_Rice_Reserve(Warehouse_Code, Stack_Code, Reserve_List_Keyword,
                        Code, Bag_No, LK_Province_Id, LK_Project_Id, Silo, LK_Associate_Id, LK_Type_Id,
                        Warehouse, Stack, TWeight, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate)
                        VALUES ".implode(",", $command);

                    $sql = "EXEC sp_batch_insert :cmd";

                    $param = array(
                        "cmd" =>  $insert
                    );

                    if(!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")){
                        return $this->datacontext->getLastMessage();
                    }
                    $command = [];
                    $count = 0;
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