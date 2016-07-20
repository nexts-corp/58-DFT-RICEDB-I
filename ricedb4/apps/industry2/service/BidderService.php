<?php

namespace apps\industry2\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry2\interfaces\IBidderService;
use apps\common\entity\BidderInfo;
use apps\common\entity\BidderHistory;
use apps\common\entity\Status;

class BidderService extends CServiceBase implements IBidderService {

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
            "active" => "YI2"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    public function listsBidderRegister() {
        $sql = "SELECT"
                ." bi.id as bidderInfoId, bi.taxId, bi.bidderName, bi.mobile, bi.fax, bi.email, bi.typeBiz,"
                ." bh.id as bidderHistoryId, bh.statusKeyword, bh.queue, bh.dateRegister,"
                ." bh.agentName, bh.property1, bh.remark1, bh.property2, bh.remark2,"
                ." bh.property3, bh.remark3, bh.property4, bh.remark4, bh.property5, bh.remark5"
            ." FROM " . $this->ent . "\\BidderHistory bh"
            ." JOIN " . $this->ent . "\\BidderInfo bi "
            ." WITH bh.bidderId = bi.id"
            ." WHERE bh.statusKeyword =:statusKeyword";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        $dataBidder = $this->datacontext->getObject($sql, $param); //get bidder in auction Lastest
        return $dataBidder;
    }

    public function listsBidderPass() {
        $sql = "SELECT"
                ." bi.id as bidderInfoId, bi.taxId, bi.bidderName, bi.mobile, bi.fax, bi.email, bi.typeBiz,"
                ." bh.id as bidderHistoryId, bh.statusKeyword, bh.queue, bh.dateRegister,"
                ." bh.agentName, bh.property1, bh.remark1, bh.property2, bh.remark2,"
                ." bh.property3, bh.remark3, bh.property4, bh.remark4, bh.property5, bh.remark5"
            ." FROM " . $this->ent . "\\BidderHistory bh"
            ." JOIN " . $this->ent . "\\BidderInfo bi "
            ." WITH bh.bidderId = bi.id"
            ." WHERE bh.statusKeyword =:statusKeyword"
            ." AND bh.property1 =:p1"
            ." AND bh.property2 =:p2"
            ." AND bh.property3 =:p3"
            ." AND bh.property4 =:p4"
            ." AND bh.property5 =:p5";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword,
            "p1" => "Y",
            "p2" => "Y",
            "p3" => "Y",
            "p4" => "Y",
            "p5" => "Y"
        );
        $dataBidder = $this->datacontext->getObject($sql, $param); //get bidder in auction Lastest
        return $dataBidder;
    }

    public function insertBidder($bidderInfo, $bidderHistory) {
        $return = true;

        $bidderHistory->dateRegister = new \DateTime(date("Y/m/d").$bidderHistory->dateRegister);
        if (!$this->datacontext->saveObject($bidderInfo)) {
            $return = $this->datacontext->getLastMessage();
        }

        $bidderHistory->statusKeyword = $this->getStatus()->keyword;
        $bidderHistory->bidderId = $bidderInfo->id;
        if (!$this->datacontext->saveObject($bidderHistory)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }

    public function updateBidder($bidderInfo, $bidderHistory) {
        $return = true;

        $info = new BidderInfo();
        $info->id = $bidderInfo->id;
        $dataInfo = $this->datacontext->getObject($info);
        $dataInfo[0]->taxId = $bidderInfo->taxId;
        $dataInfo[0]->bidderName = $bidderInfo->bidderName;
        $dataInfo[0]->mobile = $bidderInfo->mobile;
        $dataInfo[0]->fax = $bidderInfo->fax;
        $dataInfo[0]->email = $bidderInfo->email;
        $dataInfo[0]->typeBiz = $bidderInfo->typeBiz;
        $dataInfo[0]->dateUpdated = $bidderInfo->dateUpdated;
        if (!$this->datacontext->updateObject($dataInfo[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        $history = new BidderHistory();
        $history->id = $bidderHistory->id;
        $history->statusKeyword = $bidderHistory->statusKeyword;

        $dataHistory = $this->datacontext->getObject($history);
        $dataHistory[0]->queue = $bidderHistory->queue;

        $date = date_create($bidderHistory->dateRegister);
        $dataHistory[0]->dateRegister = new \DateTime($date->format("Y/m/d").$bidderHistory->dateRegister);

        $dataHistory[0]->agentName = $bidderHistory->agentName;
        $dataHistory[0]->property1 = $bidderHistory->property1;
        $dataHistory[0]->remark1 = $bidderHistory->remark1;
        $dataHistory[0]->property2 = $bidderHistory->property2;
        $dataHistory[0]->remark2 = $bidderHistory->remark2;
        $dataHistory[0]->property3 = $bidderHistory->property3;
        $dataHistory[0]->remark3 = $bidderHistory->remark3;
        $dataHistory[0]->property4 = $bidderHistory->property4;
        $dataHistory[0]->remark4 = $bidderHistory->remark4;
        $dataHistory[0]->property5 = $bidderHistory->property5;
        $dataHistory[0]->remark5 = $bidderHistory->remark5;
        if (!$this->datacontext->updateObject($dataHistory[0])) {
            $return .= $this->datacontext->getLastMessage();
        }
        return $return;
    }

    public function deleteBidder($bidderInfo, $bidderHistory){
        $return = true;

        $hdata = new BidderHistory();
        $hdata->id = $bidderHistory->id;
        $idata = $this->datacontext->getObject($hdata);
        if (!$this->datacontext->removeObject($idata[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        $history = new BidderHistory();
        $history->bidderId = $bidderInfo->id;
        $dataInfo = $this->datacontext->getObject($history);
        if(count($dataInfo) == 0){
            $info = new BidderInfo();
            $info->id = $bidderInfo->id;
            $idata2 = $this->datacontext->getObject($info);
            if (!$this->datacontext->removeObject($idata2)) {
                $return = $this->datacontext->getLastMessage();
            }
        }

        return $return;
    }
}

?>