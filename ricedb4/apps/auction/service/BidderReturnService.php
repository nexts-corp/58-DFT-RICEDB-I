<?php

namespace apps\auction\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\auction\interfaces\IBidderReturnService;

class BidderReturnService extends CServiceBase implements IBidderReturnService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext("default");
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

    public function listsBidder() {
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
            "auctionCode" => $this->getStatus()->keyword
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
						bp.remark
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
                order by bp.paymentId,lkb.bankTH,bp.paymentNo";
        $param = array(
            "bidderHistoryId" => $bidderHistoryId
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function listsWarehouse($bidderId) {
        $sql = "select 
	
	province,
	associateId,
	associate,
	wareHouseCode,
	weightAll,
    oweightAll,
	RFV,
	bidderFirstPrice,
	bidderFirstPrice*0.02  as guarantee
	from 
		fn_auction_info('" . $this->getStatus()->keyword . "')
	where bidderNo = " . $bidderId . " and bidderMaxPrice = 'Y'

	order by province,associateId,warehouseCode";
        return $this->datacontext->pdoQuery($sql);
    }

    public function update($bidderPayment) {
        foreach ($bidderPayment as $key => $value) {
            //     echo substr($bidderPayment[$key]->paymentDate->date,0,10);
            $bidderPayment[$key]->paymentDate = new \DateTime(date(substr($bidderPayment[$key]->paymentDate->date, 0, 10)));
            if ($bidderPayment[$key]->dateReturn == "date") {
                $bidderPayment[$key]->dateReturn = new \DateTime("now");
            } 
            //  print_r($bidderPayment[$key]);
        }
        // return $bidderPayment;
        if ($this->datacontext->updateObject($bidderPayment)) {
            return true;
        } else {
            return false;
        }
    }

}

?>