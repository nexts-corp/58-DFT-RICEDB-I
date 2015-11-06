<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use apps\tracking\interfaces\IFollowService;
use apps\common\entity\RiceFollow;

class FollowService extends CServiceBase implements IFollowService {

    public $datacontext;

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

    public function export($auccode, $associateId) {
        if (empty($this->getFollow($auccode, $associateId))) {
            //return false;
        } else {
            //return true;
        }
    }

    public function get($auccode, $associateId) {
        return $this->getFollow($auccode, $associateId);
    }

}
