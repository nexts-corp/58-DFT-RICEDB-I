<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_product")
 */
class Product extends EntityBase {

    /**
     * @Id
     * @Column(type="string",length=100,name="Id")
     */
    public $id;

//    /** @Column(type="string", length=20, name="Warehouse_Code") */
//    public $warehouseCode;
//
//    /** @Column(type="string", length=20, name="Stack_Code") */
//    public $stackCode;

    /** @Column(type="string",length=255, name="Code") */
    public $code;

    /** @Column(type="string",length=100, name="Bag_No") */
    public $bagNo;

    /** @Column(type="string",length=50, name="LK_Associate_Id") */
    public $associateId;

    /** @Column(type="string",length=50, name="associate") */
    public $associate;

    /** @Column(type="string",length=50, name="LK_Province_Id") */
    public $provinceId;

    /** @Column(type="string",length=255, name="province") */
    public $province;

    /** @Column(type="string",length=255, name="Silo") */
    public $silo;

    /** @Column(type="string",length=50, name="LK_Project_Id") */
    public $projectId;

    /** @Column(type="string",length=255, name="productProject") */
    public $productProject;

    /** @Column(type="string",length=50, name="LK_Type_Id") */
    public $typeId;

    /** @Column(type="string",length=50, name="productType") */
    public $productType;

    /** @Column(type="string",length=50, name="LK_Grade_Id") */
    public $gradeId;

    /** @Column(type="string",length=50, name="productGrade") */
    public $productGrade;

    /** @Column(type="string",length=255, name="warehouse") */
    public $warehouse;

    /** @Column(type="string",length=255, name="stack") */
    public $stack;

    /** @Column(type="string",length=255, name="sampling") */
    public $sampling;

    /** @Column(type="string",length=255, name="weight") */
    public $weight;

    /** @Column(type="float", name="tWeight") */
    public $tWeight;

    /** @Column(type="float", name="weightAll") */
    public $weightAll;

    /** @Column(type="string",length=10, name="useFV") */
    public $useFV;

    /** @Column(type="string",length=10, name="useType") */
    public $useType;

    /** @Column(type="string",length=10, name="useGrade") */
    public $useGrade;

    /** @Column(type="string",length=255, name="book_id") */
    public $bookId;

    /** @Column(type="string",length=10, name="isBid") */
    public $isBid;

    /** @Column(type="string",length=10, name="isSale") */
    public $isSale;

    /** @Column(type="string",length=255, name="remark0") */
    public $remark0;

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getBagNo() {
        return $this->bagNo;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getAssociate() {
        return $this->associate;
    }

    function getProvinceId() {
        return $this->provinceId;
    }

    function getProvince() {
        return $this->province;
    }

    function getSilo() {
        return $this->silo;
    }

    function getProjectId() {
        return $this->projectId;
    }

    function getProductProject() {
        return $this->productProject;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getProductType() {
        return $this->productType;
    }

    function getGradeId() {
        return $this->gradeId;
    }

    function getProductGrade() {
        return $this->productGrade;
    }

    function getWarehouse() {
        return $this->warehouse;
    }

    function getStack() {
        return $this->stack;
    }

    function getSampling() {
        return $this->sampling;
    }

    function getWeight() {
        return $this->weight;
    }

    function getTWeight() {
        return $this->tWeight;
    }

    function getWeightAll() {
        return $this->weightAll;
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

    function getBookId() {
        return $this->bookId;
    }

    function getIsBid() {
        return $this->isBid;
    }

    function getIsSale() {
        return $this->isSale;
    }

    function getRemark0() {
        return $this->remark0;
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

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setAssociate($associate) {
        $this->associate = $associate;
    }

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    function setProvince($province) {
        $this->province = $province;
    }

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

    function setProductProject($productProject) {
        $this->productProject = $productProject;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setProductType($productType) {
        $this->productType = $productType;
    }

    function setGradeId($gradeId) {
        $this->gradeId = $gradeId;
    }

    function setProductGrade($productGrade) {
        $this->productGrade = $productGrade;
    }

    function setWarehouse($warehouse) {
        $this->warehouse = $warehouse;
    }

    function setStack($stack) {
        $this->stack = $stack;
    }

    function setSampling($sampling) {
        $this->sampling = $sampling;
    }

    function setWeight($weight) {
        $this->weight = $weight;
    }

    function setTWeight($tWeight) {
        $this->tWeight = $tWeight;
    }

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
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

    function setBookId($bookId) {
        $this->bookId = $bookId;
    }

    function setIsBid($isBid) {
        $this->isBid = $isBid;
    }

    function setIsSale($isSale) {
        $this->isSale = $isSale;
    }

    function setRemark0($remark0) {
        $this->remark0 = $remark0;
    }


   

}
