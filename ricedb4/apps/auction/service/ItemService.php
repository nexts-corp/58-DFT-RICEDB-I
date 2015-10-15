<?php

namespace apps\auction\service;

use apps\common\entity\BidderPriceSilo;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\auction\interfaces\IItemService;

class ItemService extends CServiceBase implements IItemService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function getStatus() {
        $sqStatus = "select s from " . $this->ent . "\\Status s "
                . "where s.active = :active";
        $paramS = array(
            "active" => "Y"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    function processWin(){
        $sql = "SELECT bi FROM " . $this->ent . "\\BidderPriceSilo bi ";
        $bidder_items = $this->datacontext->getObject($sql);
        foreach ($bidder_items as $key2 => $bidder) {
            $this->findMaxPrice($bidder);
            break;
        }
        return "is ok";
    }
    
    function findMaxPrice($bidderPrice) {
        $return = true;
        $sql1 = "SELECT bi.silo,bi.associateId "
                . " FROM " . $this->ent . "\\BidderItem bi"
                . " WHERE bi.id=:bidderItemId";
        $param1 = array(
            "bidderItemId" => $bidderPrice->bidderItemId
        );
        $data1 = $this->datacontext->getObject($sql1, $param1);

        $sql2 = "SELECT ps FROM " . $this->ent . "\\BidderPriceSilo ps"
                . " JOIN " . $this->ent . "\\BidderItem bi WITH bi.id=ps.bidderItemId"
                . " JOIN " . $this->ent . "\\BidderHistory bh WITH bh.id=bi.bidderHistoryId"
                . " WHERE bi.silo=:silo and bi.associateId=:assId AND bh.statusKeyword=:keyword"
                . " ORDER BY ps.auctionPrice DESC";
        $param2 = array(
            "silo" => $data1[0]["silo"],
            "keyword" => $this->getStatus()->keyword,
            "assId" =>$data1[0]["associateId"]
        );
        $data2 = $this->datacontext->getObject($sql2, $param2);
        //return $data2;
        $maxPrice = $data2[0]->auctionPrice;
        foreach ($data2 as $key2 => $val2) {
            if ($val2->auctionPrice == $maxPrice) {
                $val2->isWinner = "Y";
                print_r($val2);
               // if (!$this->datacontext->updateObject($val2)) {
               //     $return = $this->datacontext->getLastMessage();
               // }
            } else {
                 print_r($val2);
               // $val2->isWinner = "N";
              //  if (!$this->datacontext->updateObject($val2)) {
               //     $return = $this->datacontext->getLastMessage();
              //  }
            }
        }
        return $return;
    }

    public function listsProvince() {
        $sql = "SELECT rt.provinceId, p.provinceNameTH"
                . " FROM " . $this->ent . "\\RiceTracking rt"
                . " inner join " . $this->ent . "\\Province p"
                . " with p.id = rt.provinceId"
                . " where rt.statusKeyword = :statusKeyword "
                . " group by rt.provinceId, p.provinceNameTH"
                . " order by p.provinceNameTH";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function listsSilo($provinceId, $bidderHistoryId) {
        $sql = "select rt.silo,rt.LK_Associate_Id from dft_Rice_Tracking rt"
                . " left join ("
                . " select bt.silo,bt.associateId"
                . " from dft_Bidder_History bh"
                . "  inner join dft_bidder_item bt"
                . " on bh.id = bt.bidder_history_id"
                . " where bh.id =" . $bidderHistoryId . ") selected"
                . " on rt.silo = selected.silo and rt.LK_Associate_Id=selected.associateId "
                . " where rt.LK_Status_Keyword = '" . $this->getStatus()->keyword . "'"
                . " and rt.LK_Province_Id = " . $provinceId
                . " and selected.silo is null"
                . " group by rt.silo,rt.LK_Associate_Id";

//        $param = array(
//            "statusKeyword" => $this->getStatus()->keyword,
//            "provinceId" => $provinceId,
//            "bidderHistoryId" => $bidderHistoryId
//        );
        return $this->datacontext->nativeQuery($sql);
    }

    public function getDataSilo($provinceId, $silo,$assId) {
        // $sql = "SELECT rt "
        $sql = "SELECT rt.id, rt.code, rt.projectId, rt.round, rt.silo, rt.address, rt.associateId, rt.typeId, rt.warehouse, rt.stack, "
                . " rt.weightAll, rt.statusKeyword, rt.remark, pj.project, tp.type, ac.associate"
                . " FROM " . $this->ent . "\\RiceTracking rt "
                . " inner join " . $this->ent . "\\Project pj "
                . " with rt.projectId = pj.id "
                . " join " . $this->ent . "\\Type tp"
                . " with rt.typeId = tp.id"
                . " join " . $this->ent . "\\Associate ac"
                . " with rt.associateId = ac.id and rt.associateId=:assId"
                . " where rt.statusKeyword = :statusKeyword "
                . " and rt.provinceId = :provinceId and rt.silo = :silo ";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword,
            "provinceId" => $provinceId,
            "silo" => $silo,
             "assId" => $assId
        );
        if ($data = $this->datacontext->getObject($sql, $param)) {
            return $data;
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

    public function getRFVSilo($provinceId, $silo,$assId) {
        //$silos=  explode("|", $silo);
        //$assx = array_pop($silos);
       // $pp = array_pop($silos);
      //  $xsilo=$silos[0];
        //$sile=
       // echo $provinceId;
       //echo $xsilo;
        //$pp =$silos[0];
       
        $xassId="อตก.";
        if($assId=="1"){
            $xassId="อคส.";
        }
        //echo $assId;
       // echo $assId;
        //echo $pp;
        $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo, :pAssId"; //statusKeyword,projectId,province,type,grade,silo
        //  $sql = "exec sp_dft_floor_value2 ".$this->getStatus()->keyword.", 0, ".$provinceId.", 0, 0, ".$silo;
        $param = array(
            "auctionId" => $this->getStatus()->keyword,
            "pProjectId" => 0,
            "pProvinceId" => $provinceId,
            "pTypeId" => 0,
            "pGradeId" => 0,
            "pSilo" => $silo,
             "pAssId"=> $assId
        );
        if ($data = $this->datacontext->nativeQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
           //return $data;
            $n=count($data);
             for ($i = 0; $i<$n; $i++) {
                if ($data[$i]->Associate == $xassId) {
                    $fv = new \apps\common\model\FloorValue2();
                    $fv->RFV2 = $data[$i]->RFV2;
                    $fv->Weight_All = $data[$i]->Weight_All;
                    $fv->Associate = $data[$i]->Associate;
                    $fv->Silo = $silo;
                    $fv->Province = $data[$i]->Province;
                    return $fv;
                }
            }
           // return "";
        } else {
            return $this->datacontext->getLastMessage();
        }
        // 
    }

    public function insertItem($bidderItem) {
        $return = true;
        if (!$this->datacontext->saveObject($bidderItem)) {
            $return = $this->datacontext->getLastMessage();
        } else {
            $dataRice = $bidderItem->riceTrackingId;
            foreach ($dataRice as $key => $riceTrackingId) {
                $detail = new \apps\common\entity\BidderItemDetail();
                $detail->bidderItemId = $bidderItem->id;
                $detail->riceTrackingId = $riceTrackingId;
                $detail->associateId = $bidderItem->associateId;
                if (!$this->datacontext->saveObject($detail)) {
                    $return = $this->datacontext->getLastMessage();
                }
            }
        }
        return $return;
    }

    public function listsBidderItemAll() {
        $sql = "SELECT bi.id, bi.taxId, bi.bidderName, bi.mobile, bi.typeBiz, "
                . " bh.id bidderHistoryId, bh.statusKeyword, bh.agentName, bh.queue, bh.dateRegister, count(bt.id) as countSilo"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " inner join " . $this->ent . "\\BidderItem bt"
                . " with bh.id = bt.bidderHistoryId"
                . " inner join " . $this->ent . "\\BidderInfo bi"
                . " with bh.bidderId = bi.id"
                . " where bh.statusKeyword = :statusKeyword"
                . " group by bi.id, bi.taxId, bi.bidderName, bi.mobile, bi.typeBiz, "
                . " bh.id, bh.statusKeyword, bh.agentName, bh.queue, bh.dateRegister"
                . " order by bh.queue";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        return $this->datacontext->getObject($sql, $param);
        // return true;
    }

    public function listsBidderItem($bidderHistoryId) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistoryId;
        $data = $this->datacontext->getObject($history);

        /* $sql = "SELECT bt.id, bt.bidderHistoryId, bt.silo, bps.round, bps.auctionPrice"
          . " FROM " . $this->ent . "\\BidderPriceSilo bps"
          . " join " . $this->ent . "\\BidderItem bt"
          . " with bps.bidderItemId = bt.id"
          . " where bt.bidderHistoryId = :bidderHistoryId and bps.round = :round";
         */
        $sql = "SELECT bt.id, bt.bidderHistoryId, bt.silo,bt.associateId,bps.round, bps.auctionPrice"
                . " FROM " . $this->ent . "\\BidderItem bt "
                . " join  " . $this->ent . "\\BidderPriceSilo bps "
                . " with bps.bidderItemId = bt.id"
                . " where bt.bidderHistoryId = :bidderHistoryId and bps.round =0";

        $param = array(
            "bidderHistoryId" => $bidderHistoryId
                //"round" => 0
        );
        $data = $this->datacontext->getObject($sql, $param);
        //return $data;
        foreach ($data as $key => $value) {
            //$data[$key]["bidderHistoryId"] = 0;
            $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]["silo"],
                "pAssId"=> $data[$key]["associateId"]
            );
            if ($dataFV = $this->datacontext->nativeQuery($sql, $param,
                    "apps\\common\\model\\FloorValue2")) { //sql,param,class
                
                $data[$key]["weightAll"] = $dataFV[0]->Weight_All;
                $data[$key]["rfv"] = $dataFV[0]->RFV2;
            }
        }
        return $data;
    }

    public function deleteItem($bidderItemId) {
        $return = true;
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItemId;
        $dataItem = $this->datacontext->getObject($item);
        if ($this->datacontext->removeObject($dataItem)) {
            $detail = new \apps\common\entity\BidderItemDetail();
            $detail->bidderItemId = $bidderItemId;
            $dataDetail = $this->datacontext->getObject($detail);
            if ($this->datacontext->removeObject($dataDetail)) {
                $return = true;
            } else {
                $return = $this->datacontext->getLastMessage();
            }
        } else {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }

    public function saveAuctionPrice($bidderPrice) {
        $return = true;

        $price = new BidderPriceSilo();
        $price->bidderItemId = $bidderPrice->bidderItemId;
        $price->round = $bidderPrice->round;
        //return $price;
        $dataPrice = $this->datacontext->getObject($price);

        if ($dataPrice == null) {
            if ($this->datacontext->saveObject($bidderPrice)) {
                $return = true;
            } else {
                $return = $this->datacontext->getLastMessage();
            }
        } else {
            $dataPrice[0]->auctionPrice = $bidderPrice->auctionPrice;
            $dataPrice[0]->isPassFV = $bidderPrice->isPassFV;

            if ($this->datacontext->updateObject($dataPrice[0])) {
                $return = true;
            } else {
                $return = $this->datacontext->getLastMessage();
            }
        }
        if ($return == true) {
            $return = $this->findMaxPrice($bidderPrice);
        }

        return $return;
    }

    public function saveAuctionPriceCF($bidderPrice) {
        $return = true;

        $price = new BidderPriceSilo();
        $price->bidderItemId = $bidderPrice->bidderItemId;
        $price->auctionPrice = $bidderPrice->auctionPrice;
        $price->isPassFV = $bidderPrice->isPassFV;

        $sql = "SELECT max(pl.round)+1 AS round"
                . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                . " WHERE pl.bidderItemId = :itemId";
        $param = array(
            "itemId" => $bidderPrice->bidderItemId
        );
        $dataPrice = $this->datacontext->getObject($sql, $param);

        $price->round = $dataPrice[0]["round"];

        if ($this->datacontext->saveObject($price)) {
            $return = true;
        } else {
            $return = $this->datacontext->getLastMessage();
        }
        if ($return == true) {
            $return = $this->findMaxPrice($bidderPrice);
        }

        return $return;
    }

    public function deleteAuctionPrice($bidderPriceSilo) {
        $return = true;

        $sql1 = "SELECT bi.silo FROM " . $this->ent . "\\BidderItem bi WHERE bi.id=:bidderItemId";
        $param1 = array(
            "bidderItemId" => $bidderPriceSilo->bidderItemId
        );
        $data1 = $this->datacontext->getObject($sql1, $param1);

        $price = new BidderPriceSilo();
        $price->bidderItemId = $bidderPriceSilo->bidderItemId;
        $price->round = $bidderPriceSilo->round;
        $dataPrice = $this->datacontext->getObject($price);
        if (!$this->datacontext->removeObject($dataPrice[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        if ($return == true) {
            $sql2 = "SELECT ps FROM " . $this->ent . "\\BidderPriceSilo ps"
                    . " JOIN " . $this->ent . "\\BidderItem bi WITH bi.id=ps.bidderItemId"
                    . " JOIN " . $this->ent . "\\BidderHistory bh WITH bh.id=bi.bidderHistoryId"
                    . " WHERE bi.silo=:silo AND bh.statusKeyword=:keyword"
                    . " ORDER BY ps.auctionPrice DESC";
            $param2 = array(
                "silo" => $data1[0]["silo"],
                "keyword" => $this->getStatus()->keyword
            );
            $data2 = $this->datacontext->getObject($sql2, $param2);

            $maxPrice = $data2[0]->auctionPrice;
            foreach ($data2 as $key2 => $val2) {
                if ($val2->auctionPrice == $maxPrice) {
                    $val2->isWinner = "Y";
                    if (!$this->datacontext->updateObject($val2)) {
                        $return = $this->datacontext->getLastMessage();
                    }
                } else {
                    $val2->isWinner = "N";
                    if (!$this->datacontext->updateObject($val2)) {
                        $return = $this->datacontext->getLastMessage();
                    }
                }
            }
        }
        //return $dataPrice[0];
        return $return;
    }

    public function listsBidderItemPrice($bidderHistoryId) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistoryId;
        $data = $this->datacontext->getObject($history);
        foreach ($data as $key => $value) {
            $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]->silo,
                "pAssId"=> $data[$key]->associateId
            );
            if ($dataFV = $this->datacontext->nativeQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]->weightAll = $dataFV[0]->Weight_All;
                $data[$key]->rfv = $dataFV[0]->RFV2;

                if ($this->getStatus()->saleBy == "SILO") {
                    $sql2 = "SELECT pl"
                            . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                            . " WHERE pl.bidderItemId =:itemId"
                            . " AND pl.round =:round";
                    $param2 = array(
                        "itemId" => $data[$key]->id,
                        "round" => "0"
                    );
                    $data2 = $this->datacontext->getObject($sql2, $param2);
                    if (isset($data2[0])) {
                        $data[$key]->round = $data2[0]->round;
                        $data[$key]->auctionPrice = $data2[0]->auctionPrice;
                    } else {
                        $data[$key]->round = "";
                        $data[$key]->auctionPrice = "";
                    }
                }
            }
        }

        return $data;
    }

    public function listsBidderItemPriceAll($bidderHistoryId) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistoryId;
        $data = $this->datacontext->getObject($history);
        foreach ($data as $key => $value) {
            $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]->silo,
                   "pAssId"=> $data[$key]->associateId,
            );
            if ($dataFV = $this->datacontext->nativeQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]->weightAll = $dataFV[0]->Weight_All;
                $data[$key]->rfv = $dataFV[0]->RFV2;

                if ($this->getStatus()->saleBy == "SILO") {
                    $sql2 = "SELECT pl"
                            . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                            . " WHERE pl.bidderItemId =:itemId";
                    $param2 = array(
                        "itemId" => $data[$key]->id
                    );
                    $data2 = $this->datacontext->getObject($sql2, $param2);
                    $data[$key]->round = $data2;
                }
            }
        }
        return $data;
    }

    public function listsBidderItemPriceCF($bidderPrice) {
        $return = array();

        foreach ($bidderPrice as $key => $value) {
            //return $value->bidderItemId;

            $sql2 = "SELECT bt.id as bidderItemId, bi.bidderName, pl.round, pl.auctionPrice"
                    . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                    . " JOIN " . $this->ent . "\\BidderItem bt WITH bt.id=pl.bidderItemId"
                    . " JOIN " . $this->ent . "\\BidderHistory bh WITH bh.id=bt.bidderHistoryId"
                    . " JOIN " . $this->ent . "\\BidderInfo bi WITH bi.id=bh.bidderId"
                    . " WHERE pl.bidderItemId =:itemId";
            $param2 = array(
                "itemId" => $value->bidderItemId
            );

            $round = [];
            $bidderName = "";
            if ($data = $this->datacontext->getObject($sql2, $param2)) {
                foreach ($data as $key2 => $value2) {
                    $round[] = array(
                        "round" => $value2["round"],
                        "auctionPrice" => $value2["auctionPrice"]
                    );
                    $bidderName = $value2["bidderName"];
                }
            }
            $return[] = array(
                "bidderItemId" => $value->bidderItemId,
                "bidderName" => $bidderName,
                "round" => $round
            );
        }
        return $return;
    }

}

?>