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
        $condArr = [];

        //search zone
        if($columns[1]["search"]["value"] != ""){
            $val = $columns[1]["search"]["value"];
            $condArr[] = "zoneId = '".$val."'";
        }

        //search province
        if($columns[2]["search"]["value"] != ""){
            $val = $columns[2]["search"]["value"];
            $condArr[] = "provinceId = '".$val."'";
        }

        //search code
        if($columns[3]["search"]["value"] != ""){
            $val = $columns[3]["search"]["value"];
            $condArr[] = "code LIKE '%".$val."%'";
        }

        //search silo
        if($columns[4]["search"]["value"] != ""){
            $val = $columns[4]["search"]["value"];
            $condArr[] = "silo LIKE '%".$val."%'";
        }

        //search project
        if($columns[8]["search"]["value"] != ""){
            $val = $columns[8]["search"]["value"];
            $condArr[] = "projectId = '".$val."'";
        }

        //search type
        if($columns[9]["search"]["value"] != ""){
            $val = $columns[9]["search"]["value"];
            $condArr[] = "typeId = '".$val."'";
        }

        //search grade
        if($columns[10]["search"]["value"] != ""){
            $val = $columns[10]["search"]["value"];
            $condArr[] = "gradeId = '".$val."'";
        }

        //search status
        if($columns[12]["search"]["value"] != ""){
            $val = $columns[12]["search"]["value"];
            $condArr[] = "statusKeyword = '".$val."'";
        }

        $condition = '';
        if(count($condArr) > 0){
            $condition = "WHERE ".implode(" AND ", $condArr);
        }
        /*$sqlC = "SELECT"
                ." COUNT(*) AS rows"
            ." FROM dft_Rice_Info ri"
            ." JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
            ." JOIN dft_LK_Zone zn ON zn.Id = pv.LK_Zone_Id"
            ." ".$condition1;*/
        $sqlC = "SELECT count(data.id) AS rows FROM"
                ." (SELECT"
                    ." ri.Id AS id, pv.LK_Zone_Id AS zoneId, ri.LK_Province_Id AS provinceId, ri.Code AS code,"
                    ." ri.LK_Project_Id AS projectId, ri.LK_Type_Id AS typeId, ri.LK_Grade_Id AS gradeId,"
                    ." (CASE"
                        ." WHEN rt.LK_Status_Keyword is not null THEN rt.LK_Status_Keyword"
                        ." ELSE ri.LK_Status_Keyword"
                    ." END) AS statusKeyword"
                ." FROM dft_Rice_Info ri"
                ." LEFT JOIN dft_Rice_Tracking rt ON rt.Stack_Code = ri.Stack_Code"
                ." INNER JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
                ." INNER JOIN dft_LK_Zone zn ON zn.Id = pv.LK_Zone_Id"
                ." WHERE rt.Id is null OR rt.Id ="
                    ." (SELECT MAX(Id)"
                    ." FROM   dft_Rice_Tracking"
                    ." WHERE  Stack_Code = ri.Stack_Code)"
                ." ) data"
                ." LEFT JOIN dft_LK_Status st ON st.Keyword = data.statusKeyword"
                ." ".$condition;

        $count = $this->datacontext->pdoQuery($sqlC);

        $sql = "SELECT"
                ." data.*, st.Status AS status FROM"
                ." (SELECT"
                    ." ri.Id AS id, pv.LK_Zone_Id AS zoneId, zn.Zone_Name_TH AS zoneNameTH, ri.LK_Province_Id AS provinceId,"
                    ." pv.Province_Name_TH AS provinceNameTH, ri.Code AS code, ri.Silo AS silo, ac.Associate AS associate,"
                    ." ri.Warehouse AS warehouse, ri.Stack AS stack, ri.LK_Project_Id AS projectId, pj.Project AS project,"
                    ." ri.LK_Type_Id AS typeId, tp.Type AS type, ri.LK_Grade_Id AS gradeId, gd.Grade AS grade,"
                    ." ri.Discount_Rate AS discountRate,"
                    ." (CASE"
                        ." WHEN rt.LK_Status_Keyword is not null THEN rt.LK_Status_Keyword"
                        ." ELSE ri.LK_Status_Keyword"
                    ." END) AS statusKeyword"
                ." FROM dft_Rice_Info ri"
                ." LEFT JOIN dft_Rice_Tracking rt ON rt.Stack_Code = ri.Stack_Code"
                ." INNER JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
                ." INNER JOIN dft_LK_Zone zn ON zn.Id = pv.LK_Zone_Id"
                ." INNER JOIN dft_LK_Associate ac ON ac.Id = ri.LK_Associate_Id"
                ." INNER JOIN dft_LK_Project pj ON pj.Id = ri.LK_Project_Id"
                ." INNER JOIN dft_LK_Type tp ON tp.Id = ri.LK_Type_Id"
                ." INNER JOIN dft_LK_Grade gd ON gd.Id = ri.LK_Grade_Id"
                ." WHERE rt.Id is null OR rt.Id ="
                    ." (SELECT MAX(Id)"
                    ." FROM   dft_Rice_Tracking"
                    ." WHERE  Stack_Code = ri.Stack_Code)"
                ." ) data"

                ." LEFT JOIN dft_LK_Status st ON st.Keyword = data.statusKeyword"
                ." ".$condition." ORDER BY data.Id OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";

        //return $sql;
        $data = $this->datacontext->pdoQuery($sql);

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
                ." ri.id, pv.provinceNameTH, ri.stackCode, ri.code, ri.silo, ac.associate,"
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
            ." WHERE rt.stackCode = :code"
            ." ORDER BY rt.dateCreated";
        $param2 = array(
            "code" => $data[0]["stackCode"]
        );
        $data2 = $this->datacontext->getObject($sql2, $param2);
        foreach($data2 as $key => $val){
            array_push($status, array(
                "status" => $val["status"]
            ));
        }

        $result = $data[0];
        unset($result["status"]);

        $result["statusArr"] = $status;

        return $result;
    }
}