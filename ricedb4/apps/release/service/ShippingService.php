<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IShippingService;

class ShippingService extends CServiceBase implements IShippingService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAll() {
        $sql = "SELECT lc"
            ." FROM ".$this->ent."\\LogisticCost lc"
            ." ORDER BY lc.province ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function lkProvince() {
        $sql = "SELECT pv.id, pv.provinceNameTH"
            ." FROM ".$this->ent."\\Province pv"
            ." ORDER BY pv.provinceNameTH ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function insert($logisticCost) {
        $return = true;

        $cost = new \apps\common\entity\LogisticCost();
        $cost->province = $logisticCost->province;

        $data = $this->datacontext->getObject($cost);
        if(count($data) == 0){
            if(!$this->datacontext->saveObject($logisticCost)){
                $return = $this->datacontext->getLastMessage();
            }
        }
        else{
            $return = "มีข้อมูลนี้อยู่แล้ว";
        }
        return $return;
    }

    public function update($logisticCost) {
        $return = true;

        $cost = new \apps\common\entity\LogisticCost();
        $cost->province = $logisticCost->province;

        $data = $this->datacontext->getObject($cost);
        if(count($data) == 0 || (count($data) == 1 && $data[0]->id == $logisticCost->id)){
            $data[0]->province = $logisticCost->province;
            $data[0]->distance = $logisticCost->distance;
            $data[0]->bathPerKM = $logisticCost->bathPerKM;
            $data[0]->bathPerWeight = $logisticCost->bathPerWeight;

            if(!$this->datacontext->updateObject($data[0])){
                $return = $this->datacontext->getLastMessage();
            }
        }
        else{
            $return = "มีข้อมูลนี้อยู่แล้ว";
        }
        return $return;
    }

    public function delete($logisticCost) {
        $return = true;
        $cost = new \apps\common\entity\LogisticCost();
        $cost->id = $logisticCost->id;
        $data = $this->datacontext->getObject($cost);

        if (!$this->datacontext->removeObject($data)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }
}