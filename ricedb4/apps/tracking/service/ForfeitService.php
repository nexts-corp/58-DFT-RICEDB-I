<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\tracking\interfaces\IForfeitService;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;

class ForfeitService extends CServiceBase implements IForfeitService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext("default");
        $this->json = new CJSONDecodeImpl();
    }

    function getStatus() {
        $sqStatus = "select s from " . $this->ent . "\\Status s "
                . "where s.active = :active";
        $paramS = array(
            "active" => "T"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    public function listsAuction() {
        $sql = "select s from " . $this->ent . "\\Status s "
                . " where s.keyword like 'AU%' "
                . " order by s.id desc";
        return $this->datacontext->getObject($sql);
    }

    public function listsBidder($auccode) {
        $sql = "select "
                . " bh.bidderId,"
                . " bp.bidderHistoryId,"
                . "  bh.statusKeyword,"
                . " bh.queue,"
                . " bi.bidderName,"
                . " bh.agentName,"
                . " bh.mobile"
                . " from " . $this->ent . "\\BidderHistory bh"
                . " inner join " . $this->ent . "\\BidderInfo bi"
                . " with bi.id = bh.bidderId"
                . " inner join " . $this->ent . "\\BidderPayment bp"
                . " with bp.bidderHistoryId = bh.id"
                . " where"
                . " bh.statusKeyword = :auctionCode"
                . " group by"
                . " bh.bidderId,"
                . " bp.bidderHistoryId,"
                . " bh.statusKeyword,"
                . " bh.queue,"
                . " bi.bidderName,"
                . " bh.agentName,"
                . " bh.mobile"
                . " order by"
                . " bh.queue";
        $param = array(
            "auctionCode" => $auccode
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function listsPayment($bidderHistoryId) {
        $sql = "select 
                        bp.id,
                        bh.bidderId,
                        bp.bidderHistoryId,
                        bh.statusKeyword,
                        bh.queue,
                        bi.bidderName,
                        bh.agentName,
                        bh.mobile,
                        bp.paymentId,
                        lkp.payment,
                        bp.bankId,
                        lkb.bankTH,
                        bp.paymentNo,
                        bp.amount,
                        bp.paymentDate,
                        bp.isReturn,
                        bp.dateReturn
                from " . $this->ent . "\\BidderHistory bh
                inner join " . $this->ent . "\\BidderInfo bi
                        with bi.id = bh.bidderId
                inner join " . $this->ent . "\\BidderPayment bp
                        with bp.bidderHistoryId = bh.id
                inner join " . $this->ent . "\\Bank lkb
                        with lkb.id = bp.bankId
                inner join " . $this->ent . "\\Payment lkp
                        with lkp.id = bp.paymentId
                where bp.bidderHistoryId = :bidderHistoryId
                order by bp.isReturn asc,bp.dateReturn desc,bp.paymentId,lkb.bankTH,bp.paymentNo asc";
        $param = array(
            "bidderHistoryId" => $bidderHistoryId
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function listsWarehouse($bidderId, $auccode) {
        $sql = "select 
	
	province,
	associateId,
	associate,
	wareHouseCode,
	weightAll,
               oweightAll,
	RFV2,
	bidderLastPrice,
	bidderLastPrice*0.02  as guarantee,
                isSale
	from 
		fn_auction_info('" . $auccode . "')
	where bidderNo = " . $bidderId . " and bidderWinner = 'Y'

	order by province,associateId,warehouseCode";
        return $this->datacontext->pdoQuery($sql);
    }

    public function update($bidderPayment) {
        foreach ($bidderPayment as $key => $value) {
            $bidderPayment[$key]->dateReturn = new \DateTime(date($bidderPayment[$key]->dateReturn));
        }
        if ($this->datacontext->updateObject($bidderPayment)) {
            return true;
        } else {
            return false;
        }
    }

}

?>