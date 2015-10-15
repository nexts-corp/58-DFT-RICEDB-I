<?php

namespace apps\warehouse\service;


use apps\warehouse\interfaces\IWarehouseInfoService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class WarehouseInfoService extends CServiceBase implements IWarehouseInfoService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
    
    public function listsAllRice($columns, $draw, $start, $length){
        $condArr1 = [];
        $condArr2 = [];

        //search zone
        if($columns[1]["search"]["value"] != ""){
            $val = $columns[1]["search"]["value"];
            $condArr1[] = "LK_Zone_Id = '".$val."'";
            $condArr2[] = "zn.id = '".$val."'";
        }

        //search province
        if($columns[2]["search"]["value"] != ""){
            $val = $columns[2]["search"]["value"];
            $condArr1[] = "LK_Province_Id = '".$val."'";
            $condArr2[] = "pv.id = '".$val."'";
        }

        //search code
        if($columns[3]["search"]["value"] != ""){
            $val = $columns[3]["search"]["value"];
            $condArr1[] = "Code LIKE '%".$val."%'";
            $condArr2[] = "ri.code LIKE '%".$val."%'";
        }

        //search silo
        if($columns[4]["search"]["value"] != ""){
            $val = $columns[4]["search"]["value"];
            $condArr1[] = "Silo LIKE '%".$val."%'";
            $condArr2[] = "ri.silo LIKE '%".$val."%'";
        }

        //search project
        if($columns[8]["search"]["value"] != ""){
            $val = $columns[8]["search"]["value"];
            $condArr1[] = "LK_Project_Id = '".$val."'";
            $condArr2[] = "pj.id = '".$val."'";
        }

        //search type
        if($columns[9]["search"]["value"] != ""){
            $val = $columns[9]["search"]["value"];
            $condArr1[] = "LK_Type_Id = '".$val."'";
            $condArr2[] = "tp.id = '".$val."'";
        }

        //search grade
        if($columns[10]["search"]["value"] != ""){
            $val = $columns[10]["search"]["value"];
            $condArr1[] = "LK_Grade_Id = '".$val."'";
            $condArr2[] = "gd.id = '".$val."'";
        }

        //search status
        if($columns[12]["search"]["value"] != ""){
            $val = $columns[12]["search"]["value"];
            $condArr1[] = "LK_Status_Keyword = '".$val."'";
            $condArr2[] = "st.keyword = '".$val."'";
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
                ." ri.id, pv.zoneId, zn.zoneNameTH, ri.provinceId, pv.provinceNameTH, ri.code, ri.silo, ac.associate,"
                ." ri.warehouse, ri.stack, ri.projectId, pj.project, ri.typeId, tp.type, ri.gradeId, gd.grade,"
                ." ri.discountRate, ri.statusKeyword, st.status"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." JOIN ".$this->ent."\\Province pv WITH pv.id = ri.provinceId"
            ." JOIN ".$this->ent."\\Zone zn WITH zn.id = pv.zoneId"
            ." JOIN ".$this->ent."\\Associate ac WITH ac.id = ri.associateId"
            ." JOIN ".$this->ent."\\Project pj WITH pj.id = ri.projectId"
            ." JOIN ".$this->ent."\\Type tp WITH tp.id = ri.typeId"
            ." JOIN ".$this->ent."\\Grade gd WITH gd.id = ri.gradeId"
            ." LEFT JOIN ".$this->ent."\\Status st WITH st.keyword = ri.statusKeyword"
            ." ".$condition2;

        $data = $this->datacontext->getObject($sql, array(), $length, $start);

        $this->getResponse()->add("recordsTotal", $count[0]["rows"]);
        $this->getResponse()->add("recordsFiltered", $count[0]["rows"]);
        $this->getResponse()->add("data", $data);
        return $draw;
    }

    public function listsProject(){
        $sql = "SELECT"
                ." pj.id,"
                ." pj.project AS name"
            ." FROM ".$this->ent."\\Project pj";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsZone(){
        $sql = "SELECT"
                ." zn.id,"
                ." zn.zoneNameTH AS name"
            ." FROM ".$this->ent."\\Zone zn";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsProvince(){
        $sql = "SELECT"
                ." pv.id,"
                ." pv.provinceNameTH AS name"
            ." FROM ".$this->ent."\\Province pv";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsType(){
        $sql = "SELECT"
                ." tp.id,"
                ." tp.type AS name"
            ." FROM ".$this->ent."\\Type tp";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsSilo(){
        $sql = "SELECT"
                ." ri.silo AS id,"
                ." ri.silo AS name"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." GROUP BY ri.silo";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsGrade(){
        $sql = "SELECT"
                ." gd.id,"
                ." gd.grade AS name"
            ." FROM ".$this->ent."\\Grade gd";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsStatus(){
        $sql = "SELECT"
                ." st.keyword AS id,"
                ." st.status AS name"
            ." FROM ".$this->ent."\\Status st";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function riceInfo($id){
        $result = [];

        $sql = "SELECT"
                ." ri.id, pv.provinceNameTH, ri.code, ri.silo, ac.associate,"
                ." ri.warehouse, ri.stack, pj.project, tp.type, gd.grade,"
                ." ri.discountRate, st.status"
            ." FROM ".$this->ent."\\RiceInfo ri"
            ." JOIN ".$this->ent."\\Province pv WITH pv.id = ri.provinceId"
            ." JOIN ".$this->ent."\\Associate ac WITH ac.id = ri.associateId"
            ." JOIN ".$this->ent."\\Project pj WITH pj.id = ri.projectId"
            ." JOIN ".$this->ent."\\Type tp WITH tp.id = ri.typeId"
            ." JOIN ".$this->ent."\\Grade gd WITH gd.id = ri.gradeId"
            ." LEFT JOIN ".$this->ent."\\Status st WITH st.keyword = ri.statusKeyword"
            ." WHERE ri.id = :id";
        $param = array(
            "id" => $id
        );

        $data = $this->datacontext->getObject($sql, $param);

        $status = [];

        if($data[0]["status"] != null){
            array_push($status, array(
                "status" => $data[0]["status"]
            ));
        }

        $sql2 = "SELECT"
                ." st.status"
            ." FROM ".$this->ent."\\RiceTracking rt"
            ." JOIN ".$this->ent."\\Status st WITH st.keyword = rt.statusKeyword"
            ." WHERE rt.code = :code"
            ." ORDER BY rt.dateCreated";
        $param2 = array(
            "code" => $data[0]["code"]
        );
        $data2 = $this->datacontext->getObject($sql2, $param2);
        foreach($data2 as $key => $val){
            array_push($status, array(
                "status" => $data2[0]["status"]
            ));
        }

        $result = $data[0];
        unset($result["status"]);

        $result["statusArr"] = $status;

        return $result;
    }
}