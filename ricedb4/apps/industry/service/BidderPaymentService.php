<?php

namespace apps\industry\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry\interfaces\IBidderPaymentService;

class BidderPaymentService extends CServiceBase implements IBidderPaymentService {

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
            "active" => "YA"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsBank() {
        $bank = new \apps\common\entity\Bank();

        return $this->datacontext->getObject($bank);
    }

    public function listsTypePayment() {
        $pay = new \apps\common\entity\Payment();

        return $this->datacontext->getObject($pay);
    }

    public function listsPayment() {
        $sql = "SELECT"
                ." bt.bidderHistoryId, bh.queue, bi.bidderName,"
                ." count(bt.id) AS countSilo, sum(ps.auctionPrice) AS auctionPrice,"
                ." sum(ps.auctionPrice)*2/100 AS guaranteePrice"
            ." FROM " . $this->ent . "\\BidderItem bt"
            ." JOIN " . $this->ent . "\\BidderHistory bh WITH bh.id = bt.bidderHistoryId"
            ." JOIN " . $this->ent . "\\BidderInfo bi WITH bi.id = bh.bidderId"
            ." JOIN " . $this->ent . "\\BidderPriceSilo ps WITH ps.bidderItemId = bt.id"
           // ." WHERE bh.statusKeyword = :keyword and ps.round = '0' and bt.isReserved = 'Y'"
            ." WHERE bh.statusKeyword = :keyword and ps.round = '0' "
            ." GROUP BY"
                ." bt.bidderHistoryId, bh.queue, bi.bidderName"
            ." ORDER BY bh.queue ASC";

        $param = array(
            "keyword" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);
        foreach ($data as $key => $value) {
            $sql2 = "SELECT"
                    ." sum(pm.amount) AS amount"
                . " FROM ".$this->ent."\\BidderPayment pm"
                . " WHERE pm.bidderHistoryId = :hid";
            $param2 = array(
                "hid" => $value["bidderHistoryId"]
            );
            $data2 = $this->datacontext->getObject($sql2, $param2);
            $data[$key]["amount"] = $data2[0]["amount"];
        }

        return $data;
    }

    public function listsItemPrice($bidderHistory) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistory->id;
        $data = $this->datacontext->getObject($history);

        $sql = "SELECT bt.id, bt.bidderHistoryId, bt.silo,bt.associateId,bps.round, bps.auctionPrice, bt.isReserved"
            . " FROM " . $this->ent . "\\BidderItem bt "
            . " join  " . $this->ent . "\\BidderPriceSilo bps "
            . " with bps.bidderItemId = bt.id"
            . " where bt.bidderHistoryId = :bidderHistoryId and bps.round =0";

        $param = array(
            "bidderHistoryId" => $bidderHistory->id
            //"round" => 0
        );
        $data = $this->datacontext->getObject($sql, $param);
        //return $data;
        foreach ($data as $key => $value) {
            //$data[$key]["bidderHistoryId"] = 0;
            /*$sql = "exec sp_floor_value_warehouse :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]["silo"],
                "pAssId"=> $data[$key]["associateId"]
            );
            if ($dataFV = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]["province"] = $dataFV[0]->Province;
                $data[$key]["associate"] = $dataFV[0]->Associate;
                $data[$key]["weightAll"] = $dataFV[0]->Weight_All;
                //$data[$key]["rfv"] = $dataFV[0]->RFV2;
                $data[$key]["rfv"] = $dataFV[0]->RFV;
            }*/
            $sql = "SELECT"
                ." aw.associate, aw.province, aw.oWeightAll, aw.rfv"
                ." FROM ".$this->ent."\\AuctionWarehouse aw"
                ." WHERE aw.auctionNo = :auction"
                ." AND aw.wareHouseCode = :silo"
                ." AND aw.associateId = :associateId";
            $param = array(
                "auction" => $this->getStatus()->keyword,
                "silo" => $data[$key]["silo"],
                "associateId" => $data[$key]["associateId"]
            );

            if($dataFV = $this->datacontext->getObject($sql, $param)){
                $data[$key]["associate"] = $dataFV[0]["associate"];
                $data[$key]["province"] = $dataFV[0]["province"];
                $data[$key]["weightAll"] = $dataFV[0]["oWeightAll"];
                $data[$key]["rfv"] = $dataFV[0]["rfv"];

                if ($this->getStatus()->saleBy == "SILO") {
                    $sql2 = "SELECT"
                        ." pl"
                        ." FROM ".$this->ent."\\BidderPriceSilo pl"
                        ." WHERE pl.bidderItemId = :itemId"
                        ." AND pl.round = :round";
                    $param2 = array(
                        "itemId" => $data[$key]["id"],
                        "round" => "0"
                    );
                    $data2 = $this->datacontext->getObject($sql2, $param2);
                    if (isset($data2[0])) {
                        $data[$key]["round"] = $data2[0]->round;
                        $data[$key]["auctionPrice"] = $data2[0]->auctionPrice;
                    } else {
                        $data[$key]["round"] = "0";
                        $data[$key]["auctionPrice"] = "";
                    }
                }
            }
        }
        return $data;
    }
    
    public function listsBidderGrt($bidderHistoryId) {
        $sql = "select bp.id, bp.bidderHistoryId, bp.paymentId, p.payment, bp.bankId, b.bankTH, bp.paymentNo, bp.amount, bp.paymentDate,bp.remark"
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



    function array_not_unique( $a = array() )
    {
        return array_diff_key( $a , array_unique( $a ) );
    }


    public function saveBidderPayment($bidderPayment) {
        $return = true;
        $final = array();

        foreach ($bidderPayment as $key => $value) {
            if ($bidderPayment[$key]->paymentNo != "" && $bidderPayment[$key]->amount != "" && $bidderPayment[$key]->paymentDate) {
                $bidderPayment[$key]->paymentDate = new \DateTime(date($bidderPayment[$key]->paymentDate));

                if ( ! in_array($bidderPayment[$key], $final)) {
                    $final[] = $bidderPayment[$key];

                    $check = new \apps\common\entity\BidderPayment();
                    $check->paymentId = $bidderPayment[$key]->paymentId;
                    $check->bankId = $bidderPayment[$key]->bankId;
                    $check->paymentNo = $bidderPayment[$key]->paymentNo;
                    $check->paymentDate = $bidderPayment[$key]->paymentDate;

                    $data = $this->datacontext->getObject($check);

                    if (count($data) > 0) {
                        return "ข้อมูลเลขที่ ".$bidderPayment[$key]->paymentNo." ถูกบันทึกไปแล้ว";
                    }
                }
            }
        }

        foreach ($final as $key => $value) {
            if ($final[$key]->paymentNo != "" && $final[$key]->amount != "" && $final[$key]->paymentDate) {
                $final[$key]->isReturn = "N";
                if ($this->datacontext->saveObject($final[$key])) {
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
    
    public function changeReserved($bidderItem) {
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItem->id;
        $data = $this->datacontext->getObject($item);
        $data[0]->isReserved = $bidderItem->isReserved;
        
        if ($this->datacontext->updateObject($data)) {
            return true;
        } else {
            return $this->datacontext->getLastMessage();
        }
        
    }
}

?>