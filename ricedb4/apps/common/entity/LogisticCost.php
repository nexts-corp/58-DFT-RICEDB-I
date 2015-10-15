<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_Logistic_Cost")
 */
class LogisticCost extends EntityBase {
    
    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;
    
    /** @Column(type="string",length=255, name="Province") */
    public $province;
    
    /** @Column(type="float", name="Distance") */
    public $distance;
    
    /** @Column(type="float", name="BathPerKM") */
    public $bathPerKM;
    
    /** @Column(type="float", name="BathPerWeight") */
    public $bathPerWeight;
    
 
    function getId() {
        return $this->id;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getGradeId() {
        return $this->gradeId;
    }

    function getDiscountStart() {
        return $this->discountStart;
    }

    function getRateAvg() {
        return $this->rateAvg;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setGradeId($gradeId) {
        $this->gradeId = $gradeId;
    }

    function setDiscountStart($discountStart) {
        $this->discountStart = $discountStart;
    }

    function setRateAvg($rateAvg) {
        $this->rateAvg = $rateAvg;
    }
}