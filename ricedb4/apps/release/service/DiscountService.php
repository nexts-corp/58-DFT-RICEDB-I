<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IDiscountService;

class DiscountService extends CServiceBase implements IDiscountService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAll() {
        $sql = "SELECT dr.id, dr.typeId, tp.type, gd.grade, dr.gradeId, dr.discountStart, dr.rateAvg"
            ." FROM ".$this->ent."\\DiscountRate dr"
            ." JOIN ".$this->ent."\\Type tp WITH tp.id=dr.typeId"
            ." JOIN ".$this->ent."\\Grade gd WITH gd.id=dr.gradeId"
            ." ORDER BY dr.typeId, dr.gradeId ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }
    
    public function lkType() {
        $sql = "SELECT tp.id, tp.type"
            ." FROM ".$this->ent."\\Type tp"
            ." ORDER BY tp.id ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }
    
    public function lkGrade() {
        $sql = "SELECT gd.id, gd.grade"
            ." FROM ".$this->ent."\\Grade gd"
            ." ORDER BY gd.id ASC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function insert($discountRate) {
        $return = true;

        $discount = new \apps\common\entity\DiscountRate();
        $discount->typeId = $discountRate->typeId;
        $discount->gradeId = $discountRate->gradeId;
        $data = $this->datacontext->getObject($discount);

        if(count($data) == 0){
            if(!$this->datacontext->saveObject($discountRate)){
                $return = $this->datacontext->getLastMessage();
            }
        }
        else{
            $return = "มีข้อมูลนี้อยู่แล้ว";
        }
        return $return;
    }

    public function update($discountRate) {
        $return = true;

        $discount = new \apps\common\entity\DiscountRate();
        $discount->typeId = $discountRate->typeId;
        $discount->gradeId = $discountRate->gradeId;

        $data = $this->datacontext->getObject($discount);
        if(count($data) == 0 || (count($data) == 1 && $data[0]->id == $discountRate->id)){
            $data[0]->typeId = $discountRate->typeId;
            $data[0]->gradeId = $discountRate->gradeId;
            $data[0]->discountStart = $discountRate->discountStart;
            $data[0]->rateAvg = $discountRate->rateAvg;

            if(!$this->datacontext->updateObject($data[0])){
                $return = $this->datacontext->getLastMessage();
            }
        }
        else{
            $return = "มีข้อมูลนี้อยู่แล้ว";
        }
        return $return;
    }

    public function delete($discountRate) {
        $return = true;
        $discount = new \apps\common\entity\DiscountRate();
        $discount->id = $discountRate->id;
        $data = $this->datacontext->getObject($discount);

        if (!$this->datacontext->removeObject($data)) {
            $return = $this->datacontext->getLastMessage();
        }

        return $return;
    }
}