<?php

namespace apps\order\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\order\interfaces\IBidderInfoService;
use apps\common\entity\BidderInfo;
use apps\common\entity\BidderHistory;
use apps\common\entity\Status;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;

class BidderInfoService extends CServiceBase implements IBidderInfoService {

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
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "YO"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsBidderType() {
        $sql = "SELECT"
                . " tp.id, tp.typeBiz, tp.optional"
                . " FROM " . $this->ent . "\\TypeBiz tp";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsRegister() {
        //get bidder in now auction
        $sql = "SELECT"
                . " bi.id as bidderInfoId, bi.taxId, bi.bidderName, bi.fax, bi.email, bh.typeBiz,"
                . " bh.id as bidderHistoryId, bh.statusKeyword, bh.queue, bh.dateRegister,"
                . " bh.agentName, bh.agentName2,bh.agentName3, bh.mobile, bh.property1, bh.remark1, bh.property2, bh.remark2,"
                . " bh.property3, bh.remark3, bh.property4, bh.remark4, bh.property5, bh.remark5,bh.property6, bh.remark6, bh.checkIn,"
                . " bh.propertyFactory1, bh.remarkFactory1, bh.propertyFactory2, bh.remarkFactory2,"
                . " bh.propertyFactory3, bh.remarkFactory3, bh.attachment, bh.typeOptional, bh.remarkSpecial"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " JOIN " . $this->ent . "\\BidderInfo bi WITH bh.bidderId = bi.id"
                . " WHERE bh.statusKeyword = :statusKeyword "
                . "ORDER BY bh.dateCreated desc";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        $dataBidder = $this->datacontext->getObject($sql, $param);
        //$result = array("data" => array());
        //$result["data"] = $dataBidder;
        return $dataBidder;
    }

    public function listsPass() {
        //get bidder that pass all property in now auction
        $sql = "SELECT"
                . " bi.id as bidderInfoId, bi.taxId, bi.bidderName, bi.fax, bi.email, bh.typeBiz,"
                . " bh.id as bidderHistoryId, bh.statusKeyword, bh.queue, bh.dateRegister,"
                . " bh.agentName, bh.agentName2, bh.agentName3, bh.mobile, bh.property1, bh.remark1, bh.property2, bh.remark2,"
                . " bh.property3, bh.remark3, bh.property4, bh.remark4, bh.property5, bh.remark5, bh.property6, bh.remark6"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " JOIN " . $this->ent . "\\BidderInfo bi WITH bh.bidderId = bi.id"
                . " WHERE bh.statusKeyword = :statusKeyword"
                . " AND bh.property1 = :p1"
                . " AND bh.property2 = :p2"
                . " AND bh.property3 = :p3"
                . " AND bh.property4 = :p4"
                . " AND bh.property5 = :p5"
                . " AND bh.property6 = :p6"
                . " AND bh.checkIn = :checkIn"                
				. " ORDER BY bh.queue";

        $param = array(
            "statusKeyword" => $this->getStatus()->keyword,
            "p1" => "Y",
            "p2" => "Y",
            "p3" => "Y",
            "p4" => "Y",
            "p5" => "Y",
            "p6" => "Y",
            "checkIn" => "Y"
        );
        $data = $this->datacontext->getObject($sql, $param);
        return $data;
    }

    public function search($bidderInfo) {
        //get bidder info
        $sql = "SELECT"
                . " bi.id as bidderInfoId, bi.taxId, bi.bidderName,bh.agentName,bh.mobile, bi.fax, bi.email, bh.typeBiz, bh.typeOptional"
                . " FROM " . $this->ent . "\\BidderInfo bi "
                . "JOIN " . $this->ent . "\\BidderHistory bh WITH bh.bidderId = bi.id "
                . " WHERE bi.taxId = :taxId "
                . " and bh.statusKeyword not like '%-I' "
                . " ORDER BY bh.dateCreated DESC";
        $param = array(
            "taxId" => $bidderInfo->taxId
        );
        $data = $this->datacontext->getObject($sql, $param);
        return $data;
    }

    public function insert($bidderInfo, $bidderHistory, $file) {
        $return = true;

        $json = new CJSONDecodeImpl();
        $bidderInfo = $json->decode(new BidderInfo(), json_decode($bidderInfo));
        $bidderHistory = $json->decode(new BidderHistory(), json_decode($bidderHistory));

        //return $bidderHistory->queue; 

        $info = new BidderInfo();
        $info->taxId = $bidderInfo->taxId;
        $info->bidderName = $bidderInfo->bidderName;
        $dataInfo = $this->datacontext->getObject($info);
        //insert bidder information data
        if (count($dataInfo) == 0) {
            if (!$this->datacontext->saveObject($bidderInfo)) {
                $return = $this->datacontext->getLastMessage();
            }
        }
        //update bidder information data
        else {
            $dataInfo[0]->taxId = $bidderInfo->taxId;
            $dataInfo[0]->fax = $bidderInfo->fax;
            $dataInfo[0]->email = $bidderInfo->email;
//            $dataInfo[0]->typeBiz = $bidderInfo->typeBiz;
//            $dataInfo[0]->typeOptional = $bidderInfo->typeOptional;
            $dataInfo[0]->dateUpdated = $bidderInfo->dateUpdated;

            if (!$this->datacontext->updateObject($dataInfo[0])) {
                $return = $this->datacontext->getLastMessage();
            }
        }

        $info2 = new BidderInfo();
        $info2->taxId = $bidderInfo->taxId;
        $info2->bidderName = $bidderInfo->bidderName;

        $dataInfo2 = $this->datacontext->getObject($info2);

        $sql = "SELECT"
                . " bh"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " JOIN " . $this->ent . "\\BidderInfo bi WITH bh.bidderId=bi.id"
                . " WHERE bh.statusKeyword = :keyword AND (bh.queue = :queue OR bi.taxId = :taxId)";
        $param = array(
            "keyword" => $this->getStatus()->keyword,
            "queue" => $bidderHistory->queue,
            "taxId" => $bidderInfo->taxId
        );

        $dataHistory = $this->datacontext->getObject($sql, $param);

        if (count($dataHistory) == 0) {
            $bidderHistory->agentName2 = $bidderHistory->agentName;
            $bidderHistory->agentName3 = $bidderHistory->agentName;
            $bidderHistory->dateRegister = new \DateTime(date("Y/m/d") . $bidderHistory->dateRegister);
            $bidderHistory->statusKeyword = $this->getStatus()->keyword;
            $bidderHistory->bidderId = $dataInfo2[0]->id;
            $bidderHistory->checkIn = 'Y';
            //insert bidder history data
            if (!$this->datacontext->saveObject($bidderHistory)) {
                $return = $this->datacontext->getLastMessage();
            }
        } else {
            $return = "คิว/เลขผู้เสียภาษีนี้ได้ถูกบันทึกไปแล้ว";
        }


        if ($file != '') {
            $time = date("YmdHis");
            $target_dir = "apps\\order\\views\\attachment\\";

            $update = new BidderHistory();
            $update->statusKeyword = $bidderHistory->statusKeyword;
            $update->queue = $bidderHistory->queue;
            $data = $this->datacontext->getObject($update);

            if ($file != "undefined") {
                $target_file = $target_dir . "RS" . $time . "-" . $file["name"];
                $fileN = "RS" . $time . "-" . $file["name"];

                if (move_uploaded_file($file["tmp_name"], $target_file)) {

                    $data[0]->attachment = $fileN;

                    if (!$this->datacontext->updateObject($data[0])) {
                        $return = $this->datacontext->getLastMessage();
                    }

                    $fileReturn = $fileN;
                }
            }
        }
        return $return;
    }

    public function update($bidderInfo, $bidderHistory, $file, $fileUpload) {
        $return = true;

        $json = new CJSONDecodeImpl();
        $bidderInfo = $json->decode(new BidderInfo(), json_decode($bidderInfo));
        $bidderHistory = $json->decode(new BidderHistory(), json_decode($bidderHistory));

        //return $bidderHistory->queue;
        $info = new BidderInfo();
        $info->id = $bidderInfo->id;
        $dataInfo = $this->datacontext->getObject($info);
        $dataInfo[0]->taxId = $bidderInfo->taxId;
        $dataInfo[0]->bidderName = $bidderInfo->bidderName;
        $dataInfo[0]->fax = $bidderInfo->fax;
        $dataInfo[0]->email = $bidderInfo->email;
//        $dataInfo[0]->typeBiz = $bidderInfo->typeBiz;
//        $dataInfo[0]->typeOptional = $bidderInfo->typeOptional;
        $dataInfo[0]->dateUpdated = $bidderInfo->dateUpdated;

        //update bidder information data
        if (!$this->datacontext->updateObject($dataInfo[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        $history = new BidderHistory();
        $history->id = $bidderHistory->id;

        $dataHistory = $this->datacontext->getObject($history);
        $dataHistory[0]->queue = $bidderHistory->queue;

        $date = date_create($bidderHistory->dateRegister);
        $dataHistory[0]->dateRegister = new \DateTime($date->format("Y/m/d") . $bidderHistory->dateRegister);

        $dataHistory[0]->agentName = $bidderHistory->agentName;
        $dataHistory[0]->agentName2 = $bidderHistory->agentName2;
        $dataHistory[0]->agentName3 = $bidderHistory->agentName3;
        $dataHistory[0]->mobile = $bidderHistory->mobile;
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
        $dataHistory[0]->property6 = $bidderHistory->property6;
        $dataHistory[0]->remark6 = $bidderHistory->remark6;

        $dataHistory[0]->propertyFactory1 = $bidderHistory->propertyFactory1;
        $dataHistory[0]->remarkFactory1 = $bidderHistory->remarkFactory1;
        $dataHistory[0]->propertyFactory2 = $bidderHistory->propertyFactory2;
        $dataHistory[0]->remarkFactory2 = $bidderHistory->remarkFactory2;
        $dataHistory[0]->propertyFactory3 = $bidderHistory->propertyFactory3;
        $dataHistory[0]->remarkFactory3 = $bidderHistory->remarkFactory3;

        $dataHistory[0]->typeBiz = $bidderHistory->typeBiz;
        $dataHistory[0]->typeOptional = $bidderHistory->typeOptional;
        
        $dataHistory[0]->remarkSpecial = $bidderHistory->remarkSpecial;

        //update bidder history data
        if (!$this->datacontext->updateObject($dataHistory[0])) {
            $return .= $this->datacontext->getLastMessage();
        }

        $hasFile = $dataHistory[0]->attachment;
        if ($fileUpload == "1") {
            $time = date("YmdHis");
            $target_dir = "apps\\order\\views\\attachment\\";

            $update = new BidderHistory();
            $update->id = $bidderHistory->id;
            $data = $this->datacontext->getObject($update);

            if ($hasFile != "") {
                if (file_exists($target_dir . $hasFile)) {
                    //return $data[0];
                    unlink($target_dir . $hasFile);
                    $fileReturn = '';

                    $data[0]->attachment = '';

                    if (!$this->datacontext->updateObject($data[0])) {
                        $return = $this->datacontext->getLastMessage();
                    }
                }
            }

            if ($file !== "undefined") {
                $target_file = $target_dir . "RS" . $time . "-" . $file["name"];
                $fileN = "RS" . $time . "-" . $file["name"];

                if (move_uploaded_file($file["tmp_name"], $target_file)) {


                    $data[0]->attachment = $fileN;

                    if (!$this->datacontext->updateObject($data[0])) {
                        $return = $this->datacontext->getLastMessage();
                    }

                    $fileReturn = $fileN;
                }
            }
        }

        return $return;
    }

    public function delete($bidderInfo, $bidderHistory) {
        $return = true;

        $history = new BidderHistory();
        $history->id = $bidderHistory->id;
        $dataHistory = $this->datacontext->getObject($history);

        //return $dataHistory;
        $hasFile = $dataHistory[0]->attachment;

        //delete bidder history
        if (!$this->datacontext->removeObject($dataHistory[0])) {
            $return = $this->datacontext->getLastMessage();
        }

        $historyCk = new BidderHistory();
        $historyCk->bidderId = $bidderInfo->id;
        $dataHistoryCk = $this->datacontext->getObject($historyCk);

        if ($hasFile != "") {
            $target_dir = "apps\\order\\views\\attachment\\";

            if (file_exists($target_dir . $hasFile)) {
                //return $data[0];
                unlink($target_dir . $hasFile);
            }
        }
        //check if count row's bidder history is 0
        if (count($dataHistoryCk) == 0) {
            $info = new BidderInfo();
            $info->id = $bidderInfo->id;
            $dataInfo = $this->datacontext->getObject($info);

            //delete bidder info
            if (!$this->datacontext->removeObject($dataInfo)) {
                $return = $this->datacontext->getLastMessage();
            }
        }

        return $return;
    }

    public function changeCheckIn($bidderHistory) {
        $return = true;

        $history = new BidderHistory();
        $history->id = $bidderHistory->id;
        $dataHistory = $this->datacontext->getObject($history);
        $dataHistory[0]->checkIn = $bidderHistory->checkIn;
        //update bidder history data
        if (!$this->datacontext->updateObject($dataHistory[0])) {
            $return .= $this->datacontext->getLastMessage();
        }
        return $return;
    }

}

?>