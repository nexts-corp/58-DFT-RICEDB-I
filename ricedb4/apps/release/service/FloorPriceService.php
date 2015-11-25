<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IFloorPriceService;

class FloorPriceService extends CServiceBase implements IFloorPriceService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT st.id, st.status, st.keyword, st.ageStop, st.dateStart"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.keyword like 'AU%'"
            ." ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function getFloorPrice($stopDate,$startDate,$endDate) {
        $sql = "EXEC sp_floor_price :stopDate, :startDate, :endDate, :projectId, :provinceId, :typeId, :gradeId";
        $param = array(
            "stopDate" => $stopDate,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "projectId" => 0,
            "provinceId" => 0,
            "typeId" => 0,
            "gradeId" => 0
        );

        $result = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2");

        return $result;
    }

}