<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Rice_Info")
 */
class RiceInfo extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Code") */
    public $code;

    /** @Column(type="string",length=100, name="Bag_No") */
    public $bagNo;

    /** @Column(type="integer",length=11, name="LK_Province_Id") */
    public $provinceId;

    /** @Column(type="integer",length=11, name="LK_Project_Id") */
    public $projectId;

    /** @Column(type="string",length=255, name="Silo") */
    public $silo;

    /** @Column(type="integer",length=11, name="LK_Associate_Id  ") */
    public $associateId;

    /** @Column(type="integer",length=11, name="LK_Type_Id") */
    public $typeId;

    /** @Column(type="string",length=255, name="Warehouse") */
    public $warehouse;

    /** @Column(type="string",length=255, name="Stack") */
    public $stack;

    /** @Column(type="string",length=255, name="Weight") */
    public $weight;

    /** @Column(type="string",length=9, name="TWeight") */
    public $tWeight;

    /** @Column(type="string",length=100, name="Sampling_Id") */
    public $samplingId;

    /** @Column(type="integer",length=11, name="LK_Grade_Id") */
    public $gradeId;

    /** @Column(type="string",length=100, name="Discount_Rate") */
    public $discountRate;

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getBagNo() {
        return $this->bagNo;
    }

    function getProvinceId() {
        return $this->provinceId;
    }

    function getProjectId() {
        return $this->projectId;
    }

    function getSilo() {
        return $this->silo;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getWarehouse() {
        return $this->warehouse;
    }

    function getStack() {
        return $this->stack;
    }

    function getWeight() {
        return $this->weight;
    }

    function getTWeight(){
        return $this->tWeight;
    }

    function getSamplingId() {
        return $this->samplingId;
    }

    function getGradeId() {
        return $this->gradeId;
    }

    function getDiscountRate() {
        return $this->discountRate;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setBagNo($bagNo) {
        $this->bagNo = $bagNo;
    }

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setWarehouse($warehouse) {
        $this->warehouse = $warehouse;
    }

    function setStack($stack) {
        $this->stack = $stack;
    }

    function setWeight($weight) {
        $this->weight = $weight;
    }

    function setSamplingId($samplingId) {
        $this->samplingId = $samplingId;
    }

    function setGradeId($gradeId) {
        $this->gradeId = $gradeId;
    }

    function setDiscountRate($discountRate) {
        $this->discountRate = $discountRate;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setTWeight($tWeight){
        $this->tWeight = $tWeight;
    }
}
