<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IManageReleaseService;

class ManageReleaseService extends CServiceBase implements IManageReleaseService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsReserve() {
        $sql = "SELECT  rl.id,rl.reserveCode, rs.reserveName+' - '+rl.detail as detail, rl.keyword"
                . " FROM " . $this->ent . "\\ReserveList rl"
                . " JOIN " . $this->ent . "\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
                . " LEFT OUTER JOIN " . $this->ent . "\\Status st WITH st.reserveKeyword = rl.keyword"
                . " WHERE st.id is null"
//                . " GROUP BY rl.id,rl.reserveCode,rs.reserveName,rl.detail,rl.keyword"
                . " ORDER BY rl.id ASC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function lkRelease() {
        $sql = "SELECT rl.releaseCode, rl.releaseName"
                . " FROM " . $this->ent . "\\Release rl"
                . " ORDER BY rl.id ASC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsRelease() {
        $sql = "SELECT"
                . " st.id, st.status, st.keyword, st.ageStop, st.dateStart,  st.dateEnd,"
                . " st.active, st.auctionDate, st.lengthDecimal, st.roundFun, st.weightDecimal,"
                . " st.reserveKeyword, st.releaseCode, rl.releaseName, rs.target,st.buyer"
                . " FROM " . $this->ent . "\\Status st"
                . " JOIN " . $this->ent . "\\Release rl WITH st.releaseCode = rl.releaseCode"
                . " JOIN " . $this->ent . "\\ReserveList rs WITH st.reserveKeyword = rs.keyword"
                . " ORDER BY st.id ASC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function insert($status) {
        $return = true;

        $status->releaseCode = $status->keyword;

        //auction
        if ($status->keyword == "AU") {
            $status->keyword = $status->keyword . $status->status;

            $check = new \apps\common\entity\Status();
            $check->keyword = $status->keyword;

            $data = $this->datacontext->getObject($check);

            if (count($data) == 0) {
                $status->ageStop = new \DateTime($status->ageStop);
                $status->dateStart = new \DateTime($status->dateStart);
                $status->dateEnd = new \DateTime($status->dateEnd);

                if (!($this->datacontext->saveObject($status))) {
                    $return = $this->datacontext->getLastMessage();
                }
            }
            else {
                $return = "ข้อมูลนี้มีอยู่แล้ว";
            }
        }
        //release
        else {
            $status->keyword = $status->keyword . date("YmdHis");

            if (!($this->datacontext->saveObject($status))) {
                $return = $this->datacontext->getLastMessage();
            }
        }

        if($return === true){
            //แทนค่าใน rice tracking ด้วย release keyword ใหม่
            $rl = new \apps\common\entity\RiceTracking();
            $rl->reserveKeyword = $status->reserveKeyword;
            $data = $this->datacontext->getObject($rl);
            foreach($data as $key => $val){
                $data[$key]->statusKeyword = $status->keyword;
                if (!($this->datacontext->updateObject($data[$key]))) {
                    $return = $this->datacontext->getLastMessage();
                }
            }

            //ใส่ข้อมูลในตาราง release price กรณีที่ไม่ใช่การประมูล
            if ($status->releaseCode != "AU") {
                $sql = "SELECT "
                        ." rt.warehouseCode"
                    ." FROM ".$this->ent."\\RiceTracking rt"
                    ." WHERE rt.statusKeyword = :keyword"
                    ." GROUP BY rt.warehouseCode";
                $param = array(
                    "keyword" => $status->keyword
                );
                $data = $this->datacontext->getObject($sql, $param);
                foreach($data as $key => $val){
                    $rp = new \apps\common\entity\ReleasePrice();
                    $rp->statusKeyword = $status->keyword;
                    $rp->warehouseCode = $val["warehouseCode"];
                    if (!($this->datacontext->saveObject($rp))) {
                        $return = $this->datacontext->getLastMessage();
                    }
                }
            }
        }

        return $return;
    }

    public function update($status) {
        $return = true;

        $check = new \apps\common\entity\Status();
        $check->id = $status->id;
        $data = $this->datacontext->getObject($check);

        $oldCode = $data[0]->releaseCode;
        $oldRelease = $data[0]->keyword;

        if ($data[0]->releaseCode != $status->keyword) {
            if ($status->keyword == "AU") {
                $data[0]->keyword = $status->keyword . $status->status;

                $check2 = new \apps\common\entity\Status();
                $check2->keyword = $data[0]->keyword;

                $data2 = $this->datacontext->getObject($check);

                if (count($data) != 0) {
                    return "ข้อมูลนี้มีอยู่แล้ว";
                }
            }
            else {
                if ($data[0]->releaseCode == "AU") {
                    $data[0]->keyword = $status->keyword . date("YmdHis");
                }
                else {
                    $data[0]->keyword = $status->keyword . str_replace($data[0]->releaseCode, "", $data[0]->keyword);
                }
            }
        }

        return $status->id;
        $newCode = $status->keyword;
        $newRelease = $data[0]->keyword;

        $data[0]->status = $status->status;
        $data[0]->reserveKeyword = $status->reserveKeyword;
        $data[0]->buyer = $status->buyer;
        $data[0]->auctionDate = $status->auctionDate;
        $data[0]->releaseCode = $status->keyword;

        if ($status->releaseCode == "AU") {
            $data[0]->ageStop = new \DateTime($status->ageStop);
            $data[0]->dateStart = new \DateTime($status->dateStart);
            $data[0]->dateEnd = new \DateTime($status->dateEnd);
            $data[0]->lengthDecimal = $status->lengthDecimal;
            $data[0]->roundFun = $status->roundFun;
            $data[0]->weightDecimal = $status->weightDecimal;
        } else {
            $data[0]->ageStop = null;
            $data[0]->dateStart = null;
            $data[0]->dateEnd = null;
            $data[0]->lengthDecimal = "";
            $data[0]->roundFun = "";
            $data[0]->weightDecimal = "";
        }

        if (!($this->datacontext->updateObject($data[0]))) {
            $return = $this->datacontext->getLastMessage();
        }

        if($return === true) {
            //แทนค่าใน rice tracking ด้วย release keyword ใหม่
            $rl = new \apps\common\entity\RiceTracking();
            $rl->statusKeyword = $oldRelease;
            $data = $this->datacontext->getObject($rl);
            foreach($data as $key => $val){
                $data[$key]->statusKeyword = $newRelease;
                if (!($this->datacontext->updateObject($data[$key]))) {
                    $return = $this->datacontext->getLastMessage();
                }
            }

            //ลบข้อมูลที่อยู่ใน release price
            if ($oldCode != 'AU') {
                $rp = new \apps\common\entity\ReleasePrice();
                $rp->statusKeyword = $oldRelease;
                $data = $this->datacontext->getObject($rp);
                foreach($data as $key => $val){
                    if (!($this->datacontext->removeObject($data[$key]))) {
                        $return = $this->datacontext->getLastMessage();
                    }
                }
            }

            //ใส่ข้อมูลในตาราง release price กรณีที่ไม่ใช่การประมูล
            if ($newCode != "AU") {
                $sql = "SELECT "
                        ." rt.warehouseCode"
                    ." FROM ".$this->ent."\\RiceTracking rt"
                    ." WHERE rt.statusKeyword = :keyword"
                    ." GROUP BY rt.warehouseCode";
                $param = array(
                    "keyword" => $newRelease
                );
                $data = $this->datacontext->getObject($sql, $param);
                foreach($data as $key => $val){
                    $rp = new \apps\common\entity\ReleasePrice();
                    $rp->statusKeyword = $newRelease;
                    $rp->warehouseCode = $val["warehouseCode"];
                    if (!($this->datacontext->saveObject($rp))) {
                        $return = $this->datacontext->getLastMessage();
                    }
                }
            }
        }
        return $return;
    }

    public function delete($status) {
        $return = true;

        $list = new \apps\common\entity\Status();
        $list->keyword = $status->keyword;
        $dataList = $this->datacontext->getObject($list);

        $releaseCode = $dataList[0]->releaseCode;

        if (!$this->datacontext->removeObject($dataList)) {
            $return = $this->datacontext->getLastMessage();
        }

        //update rice tracking
        $rl = new \apps\common\entity\RiceTracking();
        $rl->statusKeyword = $status->keyword;
        $data = $this->datacontext->getObject($rl);
        foreach($data as $key => $val){
            $data[$key]->statusKeyword = '';
            if (!($this->datacontext->updateObject($data[$key]))){
                $return = $this->datacontext->getLastMessage();
            }
        }

        //ลบข้อมูลในตาราง release price กรณีที่ไม่ใช่การประมูล
        if($releaseCode != "AU"){
            $rp = new \apps\common\entity\ReleasePrice();
            $rp->statusKeyword = $status->keyword;
            $data = $this->datacontext->getObject($rp);
            foreach($data as $key => $val){
                if (!($this->datacontext->removeObject($data[$key]))) {
                    $return = $this->datacontext->getLastMessage();
                }
            }

        }
        return $return;
    }

    public function getReservName($keyword) {
        $sql = "SELECT  rl.id,rl.reserveCode, rs.reserveName+' - '+rl.detail as detail, rl.keyword"
                . " FROM " . $this->ent . "\\ReserveList rl"
                . " JOIN " . $this->ent . "\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
                . " WHERE rl.keyword = :keyword"
                . " ORDER BY rl.id ASC";
        $pam = array(
            "keyword" => $keyword
        );
        $data = $this->datacontext->getObject($sql, $pam)[0];

        return $data;
    }

}
