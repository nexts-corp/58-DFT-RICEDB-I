<?php

namespace apps\industry2\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry2\interfaces\IBidderReturnService;

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
            "active" => "YI2"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    public function listsBidder() {
    //        $sql = "select "
    //                . " bh.bidderId,"
    //                . " bp.bidderHistoryId,"
    //                . "  bh.statusKeyword,"
    //                . " bh.queue,"
    //                . " bi.bidderName,"
    //                . " bh.agentName,"
    //                . " bh.mobile"
    //                . " from " . $this->ent . "\\BidderHistory bh"
    //                . " inner join " . $this->ent . "\\BidderInfo bi"
    //                . " with bi.id = bh.bidderId"
    //                . " inner join " . $this->ent . "\\BidderPayment bp"
    //                . " with bp.bidderHistoryId = bh.id"
    //                . " where"
    //                . " bh.statusKeyword = :auctionCode"
    //                . " group by"
    //                . " bh.bidderId,"
    //                . " bp.bidderHistoryId,"
    //                . " bh.statusKeyword,"
    //                . " bh.queue,"
    //                . " bi.bidderName,"
    //                . " bh.agentName,"
    //                . " bh.mobile"
    //                . " order by"
    //                . " bh.queue";
            $sql = "select
                            ai.bidderNo as bidderId,
                            ai.bidderAuctionNo as bidderHistoryId,
                            ai.bidderQueue as queue,
                            ai.bidderName,
                            ai.bidderAgent3,
                            ai.bidderMobile as mobile,
                            isnull(pby.countSiloY,0) as countSiloY,
                            isnull(pb.countSilo,0) as countSilo,
                            isnull(pby.bidderPriceY,0) as bidderPriceY,
                            isnull(pb.bidderPrice,0) as bidderPrice,
                            isnull(pby.guaranteeY,0) as guaranteePriceY,
                            isnull(pb.guarantee,0) as guaranteePrice,
                            isnull(pmn.countPaymentN,0) as countPaymentN,
                            isnull(pm.countPayment,0) as countPayment,
                            isnull(pmn.amountN,0) as amountN,
                            isnull(pm.amount,0) as amount
                    from fn_auction_info(:auctionCode1) ai
                    left join (
                            select
                                    bidderAuctionNo,
                                    count(bidderPrice) as countSilo,
                                    sum(bidderPrice) as bidderPrice,
                                    sum(bidderPrice*0.02)  as guarantee
                            from
                                    fn_auction_info(:auctionCode2)
                            where
                                    bidderRound = '0' and isReserved = 'Y'
                            group by bidderAuctionNo
                    ) pb on ai.bidderAuctionNo = pb.bidderAuctionNo
                    left join (
                            select
                                    bidderAuctionNo,
                                    count(bidderPrice) as countSiloY,
                                    sum(bidderPrice) as bidderPriceY,
                                    sum(bidderPrice*0.02)  as guaranteeY
                            from
                                    fn_auction_info(:auctionCode3)
                            where
                                    bidderMaxPrice = 'Y' and isReserved = 'Y'
                            group by bidderAuctionNo
                    ) pby on ai.bidderAuctionNo = pby.bidderAuctionNo
                    left join (
                            select
                                    bidderRegisterId,
                                    count(guaranteeAmount) as countPayment,
                                    sum(guaranteeAmount) as amount
                            from
                                    fn_auction_bidder_guarantee(:auctionCode4)
                            group by bidderRegisterId
                    ) pm on ai.bidderAuctionNo = pm.bidderRegisterId
                    left join (
                            select
                                    bidderRegisterId,
                                    count(guaranteeAmount) as countPaymentN,
                                    sum(guaranteeAmount) as amountN
                            from
                                    fn_auction_bidder_guarantee(:auctionCode5)
                            where
                                    isGuaranteeReturn = 'N'
                            group by bidderRegisterId
                    ) pmn on ai.bidderAuctionNo = pmn.bidderRegisterId
                    where
                            ai.bidderName is not null
                    group by
                            ai.bidderNo,
                            ai.bidderAuctionNo,
                            ai.bidderQueue,
                            ai.bidderName,
                            ai.bidderAgent3,
                            ai.bidderMobile,
                            pby.countSiloY,
                            pb.countSilo,
                            pby.bidderPriceY,
                            pb.bidderPrice,
                            pby.guaranteeY,
                            pb.guarantee,
                            pmn.countPaymentN,
                            pm.countPayment,
                            pmn.amountN,
                            pm.amount";
            $param = array(
                "auctionCode1" => $this->getStatus()->keyword,
                "auctionCode2" => $this->getStatus()->keyword,
                "auctionCode3" => $this->getStatus()->keyword,
                "auctionCode4" => $this->getStatus()->keyword,
                "auctionCode5" => $this->getStatus()->keyword
            );
            return $this->datacontext->pdoQuery($sql, $param);
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
                        bp.isReturn
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
