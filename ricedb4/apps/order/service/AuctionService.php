<?php

namespace apps\order\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\order\interfaces\IAuctionService;

class AuctionService extends CServiceBase implements IAuctionService {

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
        if (empty($dataStatus)) {
            return null;
        } else {
            return $dataStatus[0];
        }
    }

    public function check() {
        if($this->getStatus() == null){
            return "close";
        }else{
            return "open";
        }
    }

    public function close() {
        $sql = "select wareHouseCode from fn_auction_info('" . $this->getStatus()->keyword . "') " .
                " where bidderName is not null " .
                " group by wareHouseCode ";
        $wh = $this->datacontext->pdoQuery($sql); // หาคลังที่มีผู้เสนอราคา จาก fn_auction_info

        $select = "select rt from  " . $this->ent . "\\RiceTracking rt "
                . " where rt.statusKeyword = :keyword and rt.silo in ( :wareHouseCode ) ";
        $param = array(
            "keyword" => $this->getStatus()->keyword,
            "wareHouseCode" => $wh
        );
        $dataBid = $this->datacontext->getObject($select, $param); //เอาคลังที่หาได้จาก fn มา get จาก RiceTracking

        foreach ($dataBid as $key => $value) {
            $dataBid[$key]->isBid = 'Y';
            $dataBid[$key]->isSale = 'N';
        } // flag ให้ isBid เป็น Y แล้ว isSale เป็น N สำหรับคลังที่มีผู้เสนอราคา
        if ($this->datacontext->updateObject($dataBid)) { //ทำการอัพเดทลง RiceTracking
            $select2 = "select rt from  " . $this->ent . "\\RiceTracking rt "
                    . " where rt.statusKeyword = :keyword and ( rt.isBid is null or rt.isBid <> 'Y' ) ";
            $param2 = array(
                "keyword" => $this->getStatus()->keyword
            );
            $dataNoBid = $this->datacontext->getObject($select2, $param2); // หาคลังที่ isBid เป็น null หรือ != Y

            foreach ($dataNoBid as $key => $value) {
                $dataNoBid[$key]->isBid = 'N';
                $dataNoBid[$key]->isSale = 'N';
            } //flag ให้ เป็น N ทั้งคู่สำหรับคลังที่ไม่มีผู้เสนอราคา
            if ($this->datacontext->updateObject($dataNoBid)) { // อัพเดทลง RiceTracking
                $status = $this->getStatus();
                $status->active = 'F';
                if ($this->datacontext->updateObject($status)) {
                    return true;
                } else {
                    $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
                    return false;
                }
            } else {
                $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
                return false;
            }
        } else {
            $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
            return false;
        }
    }

}

?>