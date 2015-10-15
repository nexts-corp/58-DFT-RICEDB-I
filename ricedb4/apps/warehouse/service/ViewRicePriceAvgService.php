<?php

namespace apps\warehouse\service;


use apps\warehouse\interfaces\IViewRicePriceAvgService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class ViewRicePriceAvgService extends CServiceBase implements IViewRicePriceAvgService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
    
    public function view($date1, $date2) {
        $sql = "SELECT * FROM fn_rice_price_avg(:pstartDate,:pendDate)";
        $param = array(
            "pstartDate" => $date1,
            "pendDate" => $date2
        );
        
        $data = $this->datacontext->pdoQuery($sql, $param);
        
        
        return $data;
    }
} 