<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Rice_Tracking")
 */
class RiceTracking extends EntityBase {

    /**
     * @Id
     * @Column(type="string",length=255,name="Id")
     */
    public $id;

    /** @Column(type="string", length=20, name="Warehouse_Code") */
    public $warehouseCode;

    /** @Column(type="string", length=20, name="Stack_Code") */
    public $stackCode;

    /** @Column(type="string",length=255, name="Code") */
    public $code;

    /** @Column(type="string",length=100, name="Bag_No") */
    public $bagNo;

    /** @Column(type="integer",length=11, name="LK_Province_Id") */
    public $provinceId;

    /** @Column(type="integer",length=11, name="LK_Project_Id") */
    public $projectId;

    /** @Column(type="integer",length=11, name="Round") */
    public $round;

    /** @Column(type="string",length=255, name="Silo") */
    public $silo;

    /** @Column(type="string",length=255, name="Address") */
    public $address;

    /** @Column(type="integer",length=11, name="LK_Associate_Id") */
    public $associateId;

    /** @Column(type="integer",length=11, name="LK_Type_Id") */
    public $typeId;

    /** @Column(type="string",length=255, name="Warehouse") */
    public $warehouse;

    /** @Column(type="string",length=255, name="Stack") */
    public $stack;

    /** @Column(type="string",length=255, name="Weight") */
    public $weight;

    /** @Column(type="string",length=255, name="Weight_All") */
    public $weightAll;

    /** @Column(type="string",length=100, name="Sampling_Id") */
    public $samplingId;

    /** @Column(type="integer",length=11, name="LK_Grade_Id") */
    public $gradeId;

    /** @Column(type="string",length=100, name="Discount_Rate") */
    public $discountRate;

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

    /** @Column(type="string",length=255, name="Remark") */
    public $remark;

    /** @Column(type="float", name="TWeight") */
    public $tWeight;

    /** @Column(type="string",length=10, name="UseFV") */
    public $useFV;

    /** @Column(type="string",length=10, name="UseType") */
    public $useType;

    /** @Column(type="string",length=10, name="UseGrade") */
    public $useGrade;

    /** @Column(type="string",length=10, name="Is_Bid") */
    public $isBid;

    /** @Column(type="string",length=10, name="Is_Sale") */
    public $isSale;

    /** @Column(type="string",length=10, name="Remark_Sale") */
    public $remarkSale;

    /** @Column(type="string",length=255, name="Reserve_List_Keyword") */
    public $reserveKeyword;

    function getId() {
        return $this->id;
    }

    function getWarehouseCode() {
        return $this->warehouseCode;
    }

    function getStackCode() {
        return $this->stackCode;
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

    function getRound() {
        return $this->round;
    }

    function getSilo() {
        return $this->silo;
    }

    function getAddress() {
        return $this->address;
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

    function getWeightAll() {
        return $this->weightAll;
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

    function getRemark() {
        return $this->remark;
    }

    function getTWeight() {
        return $this->tWeight;
    }

    function getUseFV() {
        return $this->useFV;
    }

    function getUseType() {
        return $this->useType;
    }

    function getUseGrade() {
        return $this->useGrade;
    }

    function getIsBid() {
        return $this->isBid;
    }

    function getIsSale() {
        return $this->isSale;
    }

    function getRemarkSale() {
        return $this->remarkSale;
    }

    function getReserveKeyword() {
        return $this->reserveKeyword;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setWarehouseCode($warehouseCode) {
        $this->warehouseCode = $warehouseCode;
    }

    function setStackCode($stackCode) {
        $this->stackCode = $stackCode;
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

    function setRound($round) {
        $this->round = $round;
    }

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setAddress($address) {
        $this->address = $address;
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

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
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

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function setTWeight($tWeight) {
        $this->tWeight = $tWeight;
    }

    function setUseFV($useFV) {
        $this->useFV = $useFV;
    }

    function setUseType($useType) {
        $this->useType = $useType;
    }

    function setUseGrade($useGrade) {
        $this->useGrade = $useGrade;
    }

    function setIsBid($isBid) {
        $this->isBid = $isBid;
    }

    function setIsSale($isSale) {
        $this->isSale = $isSale;
    }

    function setRemarkSale($remarkSale) {
        $this->remarkSale = $remarkSale;
    }

    function setReserveKeyword($reserveKeyword) {
        $this->reserveKeyword = $reserveKeyword;
    }

}
