<?php

namespace apps\warehouse\service;

use apps\warehouse\interfaces\IViewInventoryService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class ViewInventoryService extends CServiceBase implements IViewInventoryService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
    
    public function project() {
        $sql = "SELECT project, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY project";

        $data = $this->datacontext->pdoQuery($sql);
        
        return $data;
    }

    public function province() {
        $sql = "SELECT provinceNameTH AS province, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY provinceNameTH";

        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function type() {
        $sql = "SELECT type, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY type";

        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function grade() {
        $sql = "SELECT grade, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY grade";

        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function silo() {
        $sql = "SELECT silo, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY silo";

        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function all($columns, $draw, $start, $length){
        $condArr = [];

        //search zone
        /*if($columns[1]["search"]["value"] != ""){
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
        }*/

        $condition = '';
        if(count($condArr) > 0){
            $condition = "AND ".implode(" AND ", $condArr);
        }

        $sqlC = "SELECT COUNT(*) AS rows FROM fn_rice_tracking() WHERE status IS NULL "
            ." ".$condition;

        $count = $this->datacontext->pdoQuery($sqlC);

        $sql = "SELECT * FROM fn_rice_tracking() WHERE status IS NULL"
            ." ".$condition." ORDER BY id OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY";

        //return $sql;
        $data = $this->datacontext->pdoQuery($sql);

        $this->getResponse()->add("recordsTotal", $count[0]["rows"]);
        $this->getResponse()->add("recordsFiltered", $count[0]["rows"]);
        $this->getResponse()->add("data", $data);
        return $draw;
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
} 