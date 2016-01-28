<?php

namespace apps\industry\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry\interfaces\ISaveService;

class SaveService extends CServiceBase implements ISaveService {

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

//    public function listsProject() {
//
//        $sql = "SELECT rt.projectId, p.project"
//                . " FROM " . $this->ent . "\\RiceTracking rt"
//                . " inner join " . $this->ent . "\\Project p"
//                . " with p.id = rt.projectId"
//                . " where rt.statusKeyword = :statusKeyword"
//                . " group by rt.projectId, p.project"
//                . " order by p.project";
//        $param = array(
//            "statusKeyword" => $this->getStatus()->keyword
//        );
//        return $this->datacontext->getObject($sql, $param);
//    }
//    public function listsType($projectId) {
//        $sql = "SELECT rt.typeId, t.type"
//                . " FROM " . $this->ent . "\\RiceTracking rt"
//                . " inner join " . $this->ent . "\\Type t"
//                . " with t.id = rt.typeId"
//                . " where rt.statusKeyword = :statusKeyword and rt.projectId = :projectId"
//                . " group by rt.typeId, t.type"
//                . " order by rt.typeId";
//        $param = array(
//            "statusKeyword" => $this->getStatus()->keyword,
//            "projectId" => $projectId
//        );
//        return $this->datacontext->getObject($sql, $param);
//    }



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
//        $sql = "SELECT rt.silo"
//                . " FROM " . $this->ent . "\\RiceTracking rt"
//                . " where rt.statusKeyword = :statusKeyword and rt.provinceId = :provinceId"
//                . " group by rt.silo"
//                . " order by rt.silo";
//        $sql = "select rt.silo from " . $this->ent . "\\RiceTracking rt"
//                . " left join ("
//                . " select bt.silo"
//                . " from " . $this->ent . "\\BidderHistory bh"
//                . " inner join " . $this->ent . "\\BidderItem bt"
//                . " on bh.id = bt.bidderHistoryId"
//                . " where bh.id = :bidderHistoryId) hs"
//                . "on rt.silo = hs.silo"
//                . " where rt.statusKeyword = :statusKeyword"
//                . " and rt.provinceId = :provinceId"
//                . " and hs.silo is null"
//                . " group by rt.silo";
        $sql = "select rt.silo from dft_Rice_Tracking rt"
                . " left join ("
                . " select bt.silo"
                . " from dft_Bidder_History bh"
                . "  inner join dft_bidder_item bt"
                . " on bh.id = bt.bidder_history_id"
                . " where bh.id =" . $bidderHistoryId . ") selected"
                . " on rt.silo = selected.silo"
                . " where rt.LK_Status_Keyword = '" . $this->getStatus()->keyword . "'"
                . " and rt.LK_Province_Id = " . $provinceId
                . " and selected.silo is null"
                . " group by rt.silo";

//        $param = array(
//            "statusKeyword" => $this->getStatus()->keyword,
//            "provinceId" => $provinceId,
//            "bidderHistoryId" => $bidderHistoryId
//        );
        return $this->datacontext->nativeQuery($sql);
    }

    public function getDataSilo($provinceId, $silo) {
        // $sql = "SELECT rt "
        $sql = "SELECT rt.id, rt.code, rt.projectId, rt.round, rt.silo, rt.address, rt.associateId, rt.typeId, rt.warehouse, rt.stack, "
                . " rt.weightAll, rt.statusKeyword, rt.remark, pj.project, tp.type, ac.associate"
                . " FROM " . $this->ent . "\\RiceTracking rt "
                . " inner join " . $this->ent . "\\Project pj "
                . " with rt.projectId = pj.id "
                . " join " . $this->ent . "\\Type tp"
                . " with rt.typeId = tp.id"
                . " join " . $this->ent . "\\Associate ac"
                . " with rt.associateId = ac.id"
                . " where rt.statusKeyword = :statusKeyword and rt.provinceId = :provinceId and rt.silo = :silo ";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword,
            "provinceId" => $provinceId,
            "silo" => $silo
        );
        if ($data = $this->datacontext->getObject($sql, $param)) {
            return $data;
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

    public function getRFVSilo($provinceId, $silo) {
        $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo"; //statusKeyword,projectId,province,type,grade,silo
        //  $sql = "exec sp_dft_floor_value2 ".$this->getStatus()->keyword.", 0, ".$provinceId.", 0, 0, ".$silo;
        $param = array(
            "auctionId" => $this->getStatus()->keyword,
            "pProjectId" => 0,
            "pProvinceId" => $provinceId,
            "pTypeId" => 0,
            "pGradeId" => 0,
            "pSilo" => $silo
        );
        if ($data = $this->datacontext->nativeQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
            $fv = new \apps\common\model\FloorValue2();
            $fv->RFV2 = $data[0]->RFV2;
            $fv->Weight_All = $data[0]->Weight_All;
            $fv->Associate = $data[0]->Associate;
            $fv->Silo = $silo;
            $fv->Province = $data[0]->Province;
            return $fv;
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
                if (!$this->datacontext->saveObject($detail)) {
                    $return = $this->datacontext->getLastMessage();
                }
            }
        }
        return $return;
    }

    public function listsItem() {
        $sql = "SELECT bi.id, bi.taxId, bi.bidderName, bi.mobile, bi.typeBiz, "
                . " bh.id bidderHistoryId, bh.statusKeyword, bh.agentName, bh.queue, bh.dateRegister, count(bt.id) as countSilo"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " inner join " . $this->ent . "\\BidderItem bt"
                . " with bh.id = bt.bidderHistoryId"
                . " inner join " . $this->ent . "\\BidderInfo bi"
                . " with bh.bidderId = bi.id"
                . " where bh.statusKeyword = :statusKeyword"
                . " group by bi.id, bi.taxId, bi.bidderName, bi.mobile, bi.typeBiz, "
                . " bh.id, bh.statusKeyword, bh.agentName, bh.queue, bh.dateRegister";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        return $this->datacontext->getObject($sql, $param);
        // return true;
    }

    public function listsItemBidder($bidderHistoryId) {
//        $sql = "SELECT bt.silo "
//                . " from " . $this->ent . "\\BidderItem bt"
//                . " where bt.bidderHistoryId = :bidderHistoryId "
//                . " group by bt.silo ";
//        $param = array(
//            "bidderHistoryId" => $bidderHistoryId
//        );
//        //  $item->bidderHistoryId = $bidderHistoryId;
//        $dataItem = $this->datacontext->getObject($sql, $param);
//        return $dataItem;
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistoryId;
        $data = $this->datacontext->getObject($history);
        foreach ($data as $key => $value) {
            $sql = "exec sp_dft_floor_value2 :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]->silo
            );
            if ($dataFV = $this->datacontext->nativeQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]->weightAll = $dataFV[0]->Weight_All;
                $data[$key]->rfv = $dataFV[0]->RFV2;
            }
        }

        return $data;
    }

    public function deleteItem($bidderItemId) {
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItemId;
        $dataItem = $this->datacontext->getObject($item);
        if ($this->datacontext->removeObject($dataItem)) {
            $detail = new \apps\common\entity\BidderItemDetail();
            $detail->id = $bidderItemId;
            $dataDetail = $this->datacontext->getObject($detail);
            if ($this->datacontext->removeObject($dataDetail)) {
                return true;
            } else {
                return $this->datacontext->getLastMessage();
            }
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

    public function saveAuctionPrice1($bidderItem) {
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItem->id;

        $dataItem = $this->datacontext->getObject($item);
        $dataItem[0]->auctionPrice1 = $bidderItem->auctionPrice1;
        
        if ($this->datacontext->updateObject($dataItem[0])) {
            return true;
        } else {
            return $this->datacontext->getLastMessage();
        }
    }
    
    public function saveAuctionPrice2($bidderItem) {
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItem->id;

        $dataItem = $this->datacontext->getObject($item);
        $dataItem[0]->auctionPrice2 = $bidderItem->auctionPrice2;
        
        if ($this->datacontext->updateObject($dataItem[0])) {
            return true;
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

}

?>