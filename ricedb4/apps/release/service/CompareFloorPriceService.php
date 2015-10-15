<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\ICompareFloorPriceService;

class CompareFloorPriceService extends CServiceBase implements ICompareFloorPriceService {

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

    public function showFloorPrice($auction){
        $sql = "SELECT fp.* FROM fn_floor_price_report(:auction) fp";
        $param = array(
            "auction" => $auction
        );
        $data = $this->datacontext->pdoQuery($sql, $param);

        return $data;
        /*$sql = "SELECT tp.Id as id, tp.Type as type, fp.NewPrice as fp2, fp.OldNewPrice as fp3, fp.OldPrice as fp4"
            ." FROM dft_LK_Type tp"
            ." LEFT JOIN fn_floor_price_auction(:auction) fp ON tp.Id = fp.LK_TypeId";
        $param = array(
            "auction" => $auction
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach($data as $key => $val){
            if($val["fp2"] != null) $data[$key]["fp2"] = round($val["fp2"], 2);
            if($val["fp3"] != null) $data[$key]["fp3"] = round($val["fp3"], 2);
            if($val["fp4"] != null) $data[$key]["fp4"] = round($val["fp4"], 2);

            $data[$key]["fpBidder"] = $data[$key]["fp2"];
        }
        return $data;*/
    }
}