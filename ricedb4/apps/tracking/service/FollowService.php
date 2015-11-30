<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use apps\tracking\interfaces\IFollowService;
use apps\common\entity\RiceFollow;

class FollowService extends CServiceBase implements IFollowService {

    public $datacontext;
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->datacontext = new \th\co\bpg\cde\data\CDataContext();
    }

    function getFollow($auccode, $associateId) {
        $sql = "select vf from apps\\common\\model\\ViewFollow vf "
                . " where vf.associateId = :associateId and "
                . " vf.statusKeyword = :keyword "
                . " order by vf.lotCode desc ";
        $param = array(
            "associateId" => $associateId,
            "keyword" => $auccode
        );
        $get = $this->datacontext->getObject($sql, $param);

        if (empty($get)) {
            $group = new \apps\common\model\GroupFollow();
            $group->associateId = $associateId;
            $group->statusKeyword = $auccode;
            $data = $this->datacontext->getObject($group);
            $siloCode = 0;
            $silo = "";
            foreach ($data as $index => $value) {
                if ($silo == "" || $silo != $value->silo) {
                    $silo = $value->silo;
                    $siloCode++;
                }
                $lotCode = date('Ymd');
                $code = $lotCode . $value->associateId . $value->provinceId . $value->projectId . $value->typeId . $siloCode;

                $follow = new RiceFollow();
                $follow->followCode = $code;
                $follow->lotCode = $lotCode;
                $follow->statusKeyword = $auccode;
                $follow->bidderId = $value->bidderNo;
                $follow->associateId = $value->associateId;
                $follow->provinceId = $value->provinceId;
                $follow->projectId = $value->projectId;
                $follow->typeId = $value->typeId;
                $follow->silo = $value->silo;
                $follow->weightApprove = $value->weightApprove;
                if (!$this->datacontext->saveObject($follow)) {
                    $this->getResponse()->add("msg", $this->datacontext->getLastMessage());
                    return false;
                }
            }
        } else {
            $lotCode = $get[0]->lotCode;
            foreach ($get as $key => $value) {
                if ($value->lotCode != $lotCode) {
                    unset($get[$key]);
                }
            }
            return $get;
        }
    }

    public function listsAuction() {
        $sql = "select s from ".$this->ent."\\Status s "
            . " where s.keyword like 'AU%' "
            . " order by s.id desc";
        return $this->datacontext->getObject($sql);
    }

    public function listsAssociate() {
        $sql = "select a from ".$this->ent."\\Associate a "
            . " order by a.id desc";
        return $this->datacontext->getObject($sql);
    }

    public function export($auccode, $associateId) {
        $follow = $this->getFollow($auccode, $associateId);
        if (isset($follow)) {
            return true;
        } else {
            return false;
        }
    }

    public function get($auccode, $associateId) {
        return $this->getFollow($auccode, $associateId);
    }

}
