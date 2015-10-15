<?php

namespace apps\warehouse\service;


use apps\warehouse\interfaces\IViewRicePriceService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class ViewRicePriceService extends CServiceBase implements IViewRicePriceService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
    
    public function view($date) {
        $sql = "SELECT pd.id, tp.type,"
                ." pd.oldPriceMin1, pd.oldPriceMax1, pd.newPriceMin1, pd.newPriceMax1,"
                ." pd.oldPriceMin2, pd.oldPriceMax2, pd.newPriceMin2, pd.newPriceMax2"
            ." FROM ".$this->ent."\\PriceDaily pd"
            ." INNER JOIN ".$this->ent."\\Type tp WITH tp.id = pd.typeId"
            ." WHERE pd.date = :date"
            ." ORDER BY pd.typeId ASC";
        $param = array(
            "date" => $date
        );
        
        $data = $this->datacontext->getObject($sql, $param);
        
        return $data;
    }
} 