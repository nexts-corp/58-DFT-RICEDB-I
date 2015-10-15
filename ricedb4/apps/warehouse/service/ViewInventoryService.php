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
        $sql = "SELECT"
            ." pj.project, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\Project pj WITH pj.id=ri.projectId"
        ." GROUP BY pj.project"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);
        
        return $data;
    }

    public function province() {
        $sql = "SELECT"
            ." pv.provinceNameTH AS province, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\Province pv WITH pv.id=ri.provinceId"
        ." GROUP BY pv.provinceNameTH"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function type() {
        $sql = "SELECT"
            ." tp.type, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\Type tp WITH tp.id=ri.typeId"
        ." GROUP BY tp.type"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function grade() {
        $sql = "SELECT"
            ." gd.grade, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\grade gd WITH gd.id=ri.gradeId"
        ." GROUP BY gd.grade"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function silo() {
        $sql = "SELECT"
            ." ri.silo, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." GROUP BY ri.silo"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }
} 