<?php

namespace apps\industry2\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry2\interfaces\IBidderAuctionService;

class BidderAuctionService extends CServiceBase implements IBidderAuctionService {

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
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "YI2"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsAuction($bidderHistoryId) {
        $sql1 = "SELECT province,wareHouseCode,associate,weightAll,RFV,bidderQueue,bidderName"
                . ",bidderAgent,bidderRound,bidderPrice,bidderPriceNo"
                . " FROM fn_auction_info(:auctionId)"
                . " WHERE bidderPassFV='Y'"
                . " AND isReserved='Y'"
                . " AND bidderMaxPrice='Y'";

        if ($bidderHistoryId != 0) {
            $sql1 .= " AND bidderAuctionNo = '" . $bidderHistoryId . "' ";
        }

        $sql1 .= " ORDER BY province, wareHouseCode, associate ASC";

        $param1 = array(
            "auctionId" => $this->getStatus()->keyword
        );
        $data2 = [];
        $weight = [];
        $floor = [];
        $data1 = $this->datacontext->pdoQuery($sql1, $param1);
        foreach ($data1 as $key1 => $value1) {
            $data2[$value1["province"]][$value1["wareHouseCode"]][$value1["associate"]][] = array(
                "weightAll" => $value1["weightAll"],
                //"rfv2" => $value1["RFV2"],
                "rfv" => $value1["RFV"],
                "bidderQueue" => $value1["bidderQueue"],
                "bidderName" => $value1["bidderName"],
                "bidderAgent" => $value1["bidderAgent"],
                "bidderRound" => $value1["bidderRound"],
                "bidderPrice" => $value1["bidderPrice"],
                "bidderPriceNo" => $value1["bidderPriceNo"]
            );
        }
        return $data2;
    }

    public function listsBidderPriceCF($bidderItem, $bidderInfo) {
        $result = [];
        foreach ($bidderInfo as $key => $value) {
            $sql = "SELECT"
                    . " bt.id AS bidderItemId, bi.bidderName, pl.round, pl.auctionPrice, bt.associateId"
                    . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                    . " JOIN " . $this->ent . "\\BidderItem bt WITH bt.id=pl.bidderItemId"
                    . " JOIN " . $this->ent . "\\BidderHistory bh WITH bh.id=bt.bidderHistoryId"
                    . " JOIN " . $this->ent . "\\BidderInfo bi WITH bi.id=bh.bidderId"
                    . " WHERE bt.silo = :silo"
                    . " AND bt.associateId = :associateId"
                    . " AND bi.bidderName = :bidderName"
                    . " AND pl.statusKeyword = :keyword";

            $param = array(
                "silo" => $bidderItem->silo,
                "associateId" => $bidderItem->associateId,
                "bidderName" => $value->bidderName,
                "keyword" => $this->getStatus()->keyword
            );

            $round = [];
            $bidderName = "";
            if ($data = $this->datacontext->getObject($sql, $param)) {
                foreach ($data as $key2 => $value2) {
                    $round[] = array(
                        "round" => $value2["round"],
                        "auctionPrice" => $value2["auctionPrice"]
                    );
                    $bidderName = $value2["bidderName"];
                }

                $result[] = array(
                    "bidderItemId" => $value2["bidderItemId"],
                    "bidderName" => $bidderName,
                    "round" => $round
                );
            }
        }
        return $result;
    }

    public function savePriceCF($bidderPrice) {
        $return = true;

        $price = new \apps\common\entity\BidderPriceSilo();
        $price->bidderItemId = $bidderPrice->bidderItemId;
        $price->auctionPrice = $bidderPrice->auctionPrice;
        $price->isPassFV = $bidderPrice->isPassFV;
        $price->statusKeyword = $this->getStatus()->keyword;
        $sql = "SELECT max(pl.round)+1 AS round"
                . " FROM " . $this->ent . "\\BidderPriceSilo pl"
                . " WHERE pl.bidderItemId = :itemId and pl.statusKeyword = :keyword";
        $param = array(
            "itemId" => $bidderPrice->bidderItemId,
            "keyword" => $this->getStatus()->keyword
        );
        $dataPrice = $this->datacontext->getObject($sql, $param);

        $price->round = $dataPrice[0]["round"];

        if ($this->datacontext->saveObject($price)) {
            $return = true;
        } else {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }

    public function deletePriceCF($bidderPrice) {
        $return = true;

        $sql1 = "SELECT bi.silo FROM " . $this->ent . "\\BidderItem bi WHERE bi.id=:bidderItemId";
        $param1 = array(
            "bidderItemId" => $bidderPrice->bidderItemId
        );
        $data1 = $this->datacontext->getObject($sql1, $param1);
//
        $price = new \apps\common\entity\BidderPriceSilo();
        $price->bidderItemId = $bidderPrice->bidderItemId;
        $price->round = $bidderPrice->round;
        $dataPrice = $this->datacontext->getObject($price)[0];
//        $dataPrice->statusKeyword = $dataPrice->statusKeyword . "_CUT";
        if (!$this->datacontext->removeObject($dataPrice)) {
            $return = $this->datacontext->getLastMessage();
        }

        /* if ($return == true) {
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
          } */
//return $dataPrice[0];
        return $return;
    }

    public function listsBidderMax() {
        $sql1 = "SELECT bidderNo,bidderName,bidderAuctionNo as bidderHistoryId"
                . " FROM fn_auction_info(:auctionId)"
                . " WHERE bidderPassFV='Y'"
                . " AND isReserved='Y'"
                . " AND bidderMaxPrice='Y'"
                . " group by bidderNo,bidderName,bidderAuctionNo "
// ." ORDER BY province, wareHouseCode, associate ASC";
                . " ORDER BY bidderAuctionNo ASC ";
        $param1 = array(
            "auctionId" => $this->getStatus()->keyword
        );
        return $this->datacontext->pdoQuery($sql1, $param1);
    }

}

?>