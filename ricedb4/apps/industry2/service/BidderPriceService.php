<?php

namespace apps\industry2\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry2\interfaces\IBidderPriceService;

class BidderPriceService extends CServiceBase implements IBidderPriceService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function getStatus() {
        $sql = "SELECT"
                ." st"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.active = :active";
        $param = array(
            "active" => "YI2"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsPrice($bidderHistory) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistory->id;
        $data = $this->datacontext->getObject($history);
        foreach ($data as $key => $value) {
            $sql = "SELECT"
                ." aw.associate, aw.province, aw.oWeightAll, aw.rfv"
                ." FROM ".$this->ent."\\AuctionWarehouse aw"
                ." WHERE aw.auctionNo = :auction"
                ." AND aw.wareHouseCode = :silo"
                ." AND aw.associateId = :associateId";
            $param = array(
                "auction" => $this->getStatus()->keyword,
                "silo" => $data[$key]->silo,
                "associateId" => $data[$key]->associateId
            );
            if($dataFV = $this->datacontext->getObject($sql, $param)){
                $data[$key]->associate = $dataFV[0]["associate"];
                $data[$key]->province = $dataFV[0]["province"];
                $data[$key]->weightAll = $dataFV[0]["oWeightAll"];
                $data[$key]->rfv = $dataFV[0]["rfv"];

                if ($this->getStatus()->saleBy == "SILO") {
                    $sql2 = "SELECT"
                        ." pl"
                        ." FROM ".$this->ent."\\BidderPriceSilo pl"
                        ." WHERE pl.bidderItemId = :itemId"
                        ." AND pl.round = :round";
                    $param2 = array(
                        "itemId" => $data[$key]->id,
                        "round" => "0"
                    );
                    $data2 = $this->datacontext->getObject($sql2, $param2);
                    if (isset($data2[0])) {
                        $data[$key]->round = $data2[0]->round;
                        $data[$key]->auctionPrice = $data2[0]->auctionPrice;
                    } else {
                        $data[$key]->round = "0";
                        $data[$key]->auctionPrice = "";
                    }
                }
            }
        }
        return $data;
        /*$history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistory->id;
        $data = $this->datacontext->getObject($history);
        foreach ($data as $key => $value) {
            $sql = "EXEC sp_floor_value_warehouse :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]->silo,
                "pAssId"=> $data[$key]->associateId
            );
            if ($dataFV = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]->associate = $dataFV[0]->Associate;
                $data[$key]->province = $dataFV[0]->Province;
                $data[$key]->weightAll = $dataFV[0]->Weight_All;
                //$data[$key]->rfv = $dataFV[0]->RFV2;
                $data[$key]->rfv = $dataFV[0]->RFV;

                if ($this->getStatus()->saleBy == "SILO") {
                    $sql2 = "SELECT"
                            ." pl"
                        ." FROM ".$this->ent."\\BidderPriceSilo pl"
                        ." WHERE pl.bidderItemId = :itemId"
                            ." AND pl.round = :round";
                    $param2 = array(
                        "itemId" => $data[$key]->id,
                        "round" => "0"
                    );
                    $data2 = $this->datacontext->getObject($sql2, $param2);
                    if (isset($data2[0])) {
                        $data[$key]->round = $data2[0]->round;
                        $data[$key]->auctionPrice = $data2[0]->auctionPrice;
                    } else {
                        $data[$key]->round = "0";
                        $data[$key]->auctionPrice = "";
                    }
                }
            }
        }

        return $data;*/
    }

    public function savePrice($bidderPrice) {
        $return = true;

        $price = new \apps\common\entity\BidderPriceSilo();
        $price->bidderItemId = $bidderPrice->bidderItemId;
        $price->round = $bidderPrice->round;
        $price->statusKeyword = $this->getStatus()->keyword;
        //return $price;
        $dataPrice = $this->datacontext->getObject($price);

        if ($dataPrice == null) {
            $bidderPrice->statusKeyword = $this->getStatus()->keyword;
            if (!$this->datacontext->saveObject($bidderPrice)) {
                $return = $this->datacontext->getLastMessage();
            }
        } else {
            $dataPrice[0]->auctionPrice = $bidderPrice->auctionPrice;
            $dataPrice[0]->isPassFV = $bidderPrice->isPassFV;

            if (!$this->datacontext->updateObject($dataPrice[0])) {
                $return = $this->datacontext->getLastMessage();
            }
        }

        return $return;
    }
}

?>