<?php

namespace apps\industry\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry\interfaces\IBidderItemService;

class BidderItemService extends CServiceBase implements IBidderItemService {

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
            "active" => "Y"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsCountItem(){
        $sql = "SELECT"
                ." bi.id, bi.taxId, bi.bidderName, bi.typeBiz,"
                ." bh.id bidderHistoryId, bh.statusKeyword, bh.agentName, bh.mobile, bh.queue, bh.dateRegister,"
                ." count(bt.id) as countSilo, count(bp.id) as countPrice"
            ." FROM ".$this->ent."\\BidderHistory bh"
            ." JOIN " . $this->ent . "\\BidderItem bt WITH bh.id = bt.bidderHistoryId"
            ." JOIN " . $this->ent . "\\BidderInfo bi WITH bh.bidderId = bi.id"
            ." LEFT JOIN ".$this->ent."\\BidderPriceSilo bp WITH bp.bidderItemId = bt.id AND bp.round = '0'"
            ." WHERE bh.statusKeyword = :statusKeyword"
            ." GROUP BY"
                ." bi.id, bi.taxId, bi.bidderName, bi.typeBiz,"
                ." bh.id, bh.statusKeyword, bh.agentName, bh.mobile, bh.queue, bh.dateRegister"
            ." ORDER BY bh.queue ASC";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);
        return $data;

    }

    public function listsBidderItem($bidderHistory) {
        $history = new \apps\common\entity\BidderItem();
        $history->bidderHistoryId = $bidderHistory->id;
        $data = $this->datacontext->getObject($history);

        $sql = "SELECT"
                ." bt.id, bt.bidderHistoryId, bt.silo, bt.associateId"
            . " FROM " . $this->ent . "\\BidderItem bt "
            . " WHERE bt.bidderHistoryId = :bidderHistoryId";

        $param = array(
            "bidderHistoryId" => $bidderHistory->id
            //"round" => 0
        );
        $data = $this->datacontext->getObject($sql, $param);
        foreach ($data as $key => $value) {
            //$data[$key]["bidderHistoryId"] = 0;
            /*$sql = "EXEC sp_floor_value_warehouse :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo,:pAssoId"; //statusKeyword,projectId,province,type,grade,silo
            $param = array(
                "auctionId" => $this->getStatus()->keyword,
                "pProjectId" => 0,
                "pProvinceId" => 0,
                "pTypeId" => 0,
                "pGradeId" => 0,
                "pSilo" => $data[$key]["silo"],
                "pAssoId"=> $data[$key]["associateId"]
            );
            if ($dataFV = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
                $data[$key]["associate"] = $dataFV[0]->Associate;
                $data[$key]["province"] = $dataFV[0]->Province;
                $data[$key]["weightAll"] = $dataFV[0]->OWeight_All;
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
            }
        }
        return $data;
    }

    public function listsProvince(){
        $sql = "SELECT"
                ." rt.provinceId, pv.provinceNameTH"
            ." FROM ".$this->ent."\\RiceTracking rt"
            ." JOIN ".$this->ent."\\Province pv WITH pv.id = rt.provinceId"
            ." WHERE rt.statusKeyword = :statusKeyword "
            ." GROUP BY"
                ." rt.provinceId, pv.provinceNameTH"
            ." ORDER BY pv.provinceNameTH ASC";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        return $this->datacontext->getObject($sql, $param);
    }

    public function listsSilo($bidderHistory, $province){
        $sql = "SELECT"
                ." rt.silo, rt.associateId, ac.associate"
            ." FROM ".$this->ent."\\RiceTracking rt"
            ." JOIN ".$this->ent."\\Associate ac WITH ac.id = rt.associateId"
            ." WHERE rt.statusKeyword = :statusKeyword"
                ." AND rt.provinceId = :provinceId"
            ." GROUP BY rt.silo, rt.associateId, ac.associate";

        $param = array(
            "statusKeyword" => $this->getStatus()->keyword,
            "provinceId" => $province->id,
        );

        $data = $this->datacontext->getObject($sql, $param);
        foreach($data as $key1 => $value1){
            $sql2 = "SELECT"
                    ." count(bt.silo) AS countSilo"
                ." FROM ".$this->ent."\\BidderHistory bh"
                ." JOIN ".$this->ent."\\BidderItem bt WITH bh.id = bt.bidderHistoryId"
                ." WHERE bh.id = :bidderHistoryId"
                    ." AND bt.silo = :silo"
                    ." AND bt.associateId = :associateId";
            $param2 = array(
                "bidderHistoryId" => $bidderHistory->id,
                "silo" => $value1["silo"],
                "associateId" => $value1["associateId"]
            );

            $data2 = $this->datacontext->getObject($sql2, $param2);
            if($data2[0]["countSilo"] > 0){
                unset($data[$key1]);
            }
        }
        return $data;

    }

    public function getSiloData($bidderItem, $province) {
        $st = new \apps\common\entity\AuctionWarehouse();
        $st->auctionNo = $this->getStatus()->keyword;
        $st->provinceId = $province->id;
        $st->wareHouseCode = $bidderItem->silo;
        $st->associateId = $bidderItem->associateId;
        if ($data = $this->datacontext->getObject($st)){
            $n=count($data);
            for ($i = 0; $i<$n; $i++) {
                $fv = new \apps\common\model\FloorValue2();
                $fv->rfv = $data[$i]->rfv;
                $fv->weightAll = $data[$i]->oWeightAll;
                $fv->associate = $data[$i]->associate;
                $fv->silo = $bidderItem->silo;
                $fv->province = $data[$i]->province;
                return $fv;
            }

        }
        else {
            return $this->datacontext->getLastMessage();
        }
        /*$sql = "EXEC sp_floor_value_warehouse :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo, :pAssoId"; //statusKeyword,projectId,province,type,grade,silo
        //  $sql = "exec sp_dft_floor_value2 ".$this->getStatus()->keyword.", 0, ".$provinceId.", 0, 0, ".$silo;
        $param = array(
            "auctionId" => $this->getStatus()->keyword,
            "pProjectId" => 0,
            "pProvinceId" => $province->id,
            "pTypeId" => 0,
            "pGradeId" => 0,
            "pSilo" => $bidderItem->silo,
            "pAssoId"=> $bidderItem->associateId
        );
        if ($data = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2")) { //sql,param,class
            //return $data;
            $n=count($data);
            for ($i = 0; $i<$n; $i++) {
                $fv = new \apps\common\model\FloorValue2();
                $fv->rfv = $data[$i]->RFV;
                $fv->weightAll = $data[$i]->OWeight_All;
                $fv->associate = $data[$i]->Associate;
                $fv->silo = $bidderItem->silo;
                $fv->province = $data[$i]->Province;
                return $fv;
            }
        }
        else {
            return $this->datacontext->getLastMessage();
        }*/
    }

    public function insert($bidderItem) {
        $return = true;
        $item = new \apps\common\entity\BidderItem();
        $item->bidderHistoryId = $bidderItem->bidderHistoryId;
        $item->silo = $bidderItem->silo;
        $item->associateId = $bidderItem->associateId;
        $bidderItem->isReserved = 'Y';
        $dataItem = $this->datacontext->getObject($item);
        if(count($dataItem) == 0){        
            if (!$this->datacontext->saveObject($bidderItem)) {
                $return = $this->datacontext->getLastMessage();
            }
        }
        else{
            $return = "คลังสินค้านี้ถูกบันทึกไปแล้ว ไม่สามารถบันทึกซ้ำได้";
        }
        return $return;
    }

    public function delete($bidderItem) {
        $return = true;
        $item = new \apps\common\entity\BidderItem();
        $item->id = $bidderItem->id;
        $dataItem = $this->datacontext->getObject($item);

        if (!$this->datacontext->removeObject($dataItem)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }
}

?>