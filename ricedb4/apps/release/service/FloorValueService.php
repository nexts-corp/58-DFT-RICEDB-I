<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IFloorValueService;

class FloorValueService extends CServiceBase implements IFloorValueService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT st.id, st.status, st.keyword"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.keyword like 'AU%'"
            ." ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function getFloorValue($auction) {
        $sql = "EXEC sp_floor_value_stack :auction";
        $param = array(
            "auction" => $auction
        );

        $result = $this->datacontext->pdoQuery($sql, $param);

        return $result;
    }
    
    public function getFloorValueSilo($auction) {
        //return $auction;
        $sql = "EXEC sp_floor_value_warehouse :auction";
        $param = array(
            "auction" => $auction
        );

        $result = $this->datacontext->pdoQuery($sql, $param);

        return $result;
    }
}