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
} 