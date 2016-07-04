<?php

namespace apps\order\service;

use apps\order\interfaces\IPayService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class PayService extends CServiceBase implements IPayService {

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
            "active" => "YO"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    public function listsBidderPayment() {
        $sql = "SELECT bt.bidderHistoryId, bh.queue, bi.bidderName, count(bt.id) AS countSilo, sum(ps.auctionPrice) AS auctionPrice,"
                . " sum(ps.auctionPrice)*2/100 AS guaranteePrice"
                . " FROM " . $this->ent . "\\BidderItem bt"
                . " JOIN " . $this->ent . "\\BidderHistory bh"
                . " WITH bh.id=bt.bidderHistoryId"
                . " JOIN " . $this->ent . "\\BidderInfo bi"
                . " WITH bi.id=bh.bidderId"
                . " JOIN " . $this->ent . "\\BidderPriceSilo ps"
                . " WITH ps.bidderItemId=bt.id"
                . " WHERE bh.statusKeyword = :keyword and ps.round = 0"
                . " GROUP BY bt.bidderHistoryId, bh.queue, bi.bidderName"
                . " ORDER BY bh.queue";

        $param = array(
            "keyword" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);
        foreach ($data as $key => $value) {
            $sql2 = "SELECT sum(pm.amount) AS amount"
                    . " FROM " . $this->ent . "\\BidderPayment pm"
                    . " WHERE pm.bidderHistoryId = :hid";
            $param2 = array(
                "hid" => $value["bidderHistoryId"]
            );
            $data2 = $this->datacontext->getObject($sql2, $param2);
            $data[$key]["amount"] = $data2[0]["amount"];
        }

        return $data;
    }

    public function listsBank() {
        return $this->datacontext->getObject(new \apps\common\entity\Bank());
    }

    public function listsBidderGrt($bidderHistoryId) {
        $sql = "select bp.id, bp.bidderHistoryId, bp.paymentId, p.payment, bp.bankId, b.bankTH, bp.paymentNo, bp.amount, bp.paymentDate"
                . " from " . $this->ent . "\\BidderPayment bp"
                . " inner join " . $this->ent . "\\Bank b"
                . " with bp.bankId = b.id"
                . " inner join " . $this->ent . "\\Payment p"
                . " with bp.paymentId = p.id"
                . " where bp.bidderHistoryId = :bidderHistoryId";
        $param = array(
            "bidderHistoryId" => $bidderHistoryId
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function saveBidderPayment($bidderPayment) {
        $return = true;
        foreach ($bidderPayment as $key => $value) {

            if ($bidderPayment[$key]->paymentNo != "" && $bidderPayment[$key]->amount != "" && $bidderPayment[$key]->paymentDate) {
                $bidderPayment[$key]->paymentDate = new \DateTime(date($bidderPayment[$key]->paymentDate));
                if ($this->datacontext->saveObject($bidderPayment[$key])) {
                    $return = true;
                } else {
                    $return = $this->datacontext->getLastMessage();
                }
            }
        }
        return $return;
    }

    public function deletePayment($paymentId) {
        $payment = new \apps\common\entity\BidderPayment();
        $payment->id = $paymentId;
        $data = $this->datacontext->getObject($payment);
        if ($this->datacontext->removeObject($data)) {
            return true;
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

}
