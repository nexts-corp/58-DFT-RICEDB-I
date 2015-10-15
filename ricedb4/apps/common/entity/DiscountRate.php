<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_Discount_Rate")
 */
class DiscountRate extends EntityBase {
    
    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;
    
    /** @Column(type="string",length=255, name="LK_Type_Id") */
    public $typeId;
    
    /** @Column(type="string",length=255, name="LK_Grade_Id") */
    public $gradeId;
    
    /** @Column(type="float", name="DiscountStart") */
    public $discountStart;
    
    /** @Column(type="float", name="RateAvg") */
    public $rateAvg;
 
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