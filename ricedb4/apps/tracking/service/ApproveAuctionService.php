<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\tracking\interfaces\IApproveAuctionService;

class ApproveAuctionService extends CServiceBase implements IApproveAuctionService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext("default");
    }

    public function listsBidder($auccode) {
//        $sql = "select bidderNo,bidderAuctionNo,bidderQueue,bidderRound,bidderName,"
//                . " bidderPrice,bidderFirstPrice,bidderLastPrice,RFV2,"
//                . " wareHouseCode,oweightAll,"
//                . " provinceId,province,associateId,associate"
//                . " from dbo.fn_auction_info('" . $auccode . "')"
//              . " where bidderWinner= 'Y' and (isSale is null or isSale = '') "
//                . " order by province,associateId,wareHouseCode";
        $sql = "select a.auctionNo,a.bidderNo,a.bidderAuctionNo,a.bidderQueue,a.bidderRound,a.bidderName, "
                . " a.bidderPrice,a.bidderFirstPrice,a.bidderLastPrice,a.RFV2, "
                . " a.wareHouseCode,a.oweightAll, "
                . " a.provinceId,a.province,a.associateId,a.associate,a.isSale,c.remark,c.Id as bidderPriceId "
                . " from dbo.fn_auction_info('" . $auccode . "') a "
                . " inner join dft_Bidder_Item b "
                . " on b.bidder_history_id = a.bidderAuctionNo and b.silo = a.wareHouseCode and b.associateId = a.associateId "
                . " inner join dft_Bidder_Price_Silo c "
                . " on c.bidder_item_id = b.Id "
                . " where a.bidderWinner= 'Y' and a.isSale = 'N' "
                . " order by a.province,a.associateId,a.wareHouseCode";
        return $this->datacontext->pdoQuery($sql);
    }

    public function listsApprove($auccode) {
        $sql = "select a.auctionNo,a.bidderNo,a.bidderAuctionNo,a.bidderQueue,a.bidderRound,a.bidderName,"
                . " a.bidderPrice,a.bidderFirstPrice,a.bidderLastPrice,a.RFV2,"
                . " a.wareHouseCode,a.oweightAll,"
                . " a.provinceId,a.province,a.associateId,a.associate,a.isSale,c.remark,c.Id as bidderPriceId"
                . " from dbo.fn_auction_info('" . $auccode . "') a"
                . " inner join dft_Bidder_Item b"
                . " on b.bidder_history_id = a.bidderAuctionNo and b.silo = a.wareHouseCode and b.associateId = a.associateId"
                . " inner join dft_Bidder_Price_Silo c"
                . " on c.bidder_item_id = b.Id"
                . " where a.bidderWinner= 'Y' and isSale != 'N' "
                . " order by a.province,a.associateId,a.wareHouseCode";
        return $this->datacontext->pdoQuery($sql);
    }

    public function update($data, $isSale, $remark, $auccode) {
        $return = true;
        foreach ($data as $key => $value) {
            $bps = new \apps\common\entity\BidderPriceSilo();
            $bps->id = $value->bidderPriceId;

            $result = $this->datacontext->getObject($bps)[0];
            $result->isSale = $isSale;
            if ($remark != "-") {
                $result->remark = $remark;
            }
            if ($this->datacontext->updateObject($result)) {
                $tracking = new \apps\common\entity\RiceTracking();
                $tracking->statusKeyword = $auccode;
                $tracking->silo = $value->wareHouseCode;
                $dataTracking = $this->datacontext->getObject($tracking);
                foreach ($dataTracking as $index => $valueData) {
                    $dataTracking[$index]->isSale = $isSale;
                    $dataTracking[$index]->remarkSale = $remark;
                }
                $this->datacontext->updateObject($dataTracking);
            } else {
                $return = false;
            }
        }
        return $return;
    }

    public function delete($dataAuction) {
        $return = true;
        $price = new \apps\common\entity\BidderPriceSilo();
        $price->id = $dataAuction->bidderPriceId;
        $price = $this->datacontext->getObject($price)[0];
        $price->isSale = 'N';
        $price->remark = NULL;
        if ($this->datacontext->updateObject($price)) {
            $tracking = new \apps\common\entity\RiceTracking();
            $tracking->statusKeyword = $dataAuction->auctionNo;
            $tracking->silo = $dataAuction->wareHouseCode;
            $dataTracking = $this->datacontext->getObject($tracking);
            foreach ($dataTracking as $index => $valueData) {
                $dataTracking[$index]->isSale = "N";
                $dataTracking[$index]->remarkSale = NULL;
            }
            if (!$this->datacontext->updateObject($dataTracking)) {
                $return = false;
            }
        } else {
            $return = false;
        }
        return $return;
    }

    public function checkStatus($auccode) {
        $status = new \apps\common\entity\Status();
        $status->keyword = $auccode;
        $data = $this->datacontext->getObject($status)[0];
        if ($data->active == "F" || $data->active == "FA") {
            return true;
        } else {
            return false;
        }
    }

}

?>