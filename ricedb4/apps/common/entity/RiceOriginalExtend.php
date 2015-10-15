<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Rice_Original_Extend")
 */
class RiceOriginalExtend extends EntityBase {

    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string", length=255, name="No") */
    public $no;

    /** @Column(type="string", length=255, name="Code") */
    public $code;

    /** @Column(type="string", length=255, name="Bag_No") */
    public $bagNo;

    /** @Column(type="string", length=255, name="Province") */
    public $province;

    /** @Column(type="string", length=255, name="Project") */
    public $project;

    /** @Column(type="string", length=255, name="Silo") */
    public $silo;

    /** @Column(type="string", length=255, name="Associate") */
    public $associate;

    /** @Column(type="string", length=255, name="Type") */
    public $type;

    /** @Column(type="string", length=255, name="Warehouse") */
    public $warehouse;

    /** @Column(type="string", length=255, name="Stack") */
    public $stack;

    /** @Column(type="string", length=255, name="Weight") */
    public $weight;

    /** @Column(type="string", length=255, name="Sampling_Id") */
    public $samplingId;

    /** @Column(type="string", length=255, name="Grade") */
    public $grade;

    /** @Column(type="string", length=255, name="Discount_Rate") */
    public $discountRate;

    /** @Column(type="string", length=255, name="Status") */
    public $status;

    /** @Column(type="string", length=50, name="Extend") */
    public $extend;

    /** @Column(type="string", length=50, name="Weight_All") */
    public $weightAll;

    function getId() {
        return $this->id;
    }

    function getAssociate(){
        return $this->associate;
    }

    function getBagNo(){
        return $this->bagNo;
    }

    function getCode(){
        return $this->code;
    }

    function getDiscountRate(){
        return $this->discountRate;
    }

    function getExtend(){
        return $this->extend;
    }

    function getGrade(){
        return $this->grade;
    }

    function getno(){
        return $this->no;
    }

    function getProject(){
        return $this->project;
    }

    function getProvince(){
        return $this->province;
    }

    function getSamplingId(){
        return $this->samplingId;
    }

    function getSilo(){
        return $this->silo;
    }

    function getStack(){
        return $this->stack;
    }

    function getStatus(){
        return $this->status;
    }

    function getType(){
        return $this->type;
    }

    function getWarehouse(){
        return $this->warehouse;
    }

    function getWeight(){
        return $this->weight;
    }

    function getWeightAll(){
        return $this->weightAll;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAssociate($associate){
        $this->associate = $associate;
    }

    function setBagNo($bagNo){
        $this->bagNo = $bagNo;
    }

    function setCode($code){
        $this->code = $code;
    }

    function setDiscountRate($discountRate){
        $this->discountRate = $discountRate;
    }

    function setExtend($extend){
        $this->extend = $extend;
    }

    function setGrade($grade){
        $this->grade = $grade;
    }

    function setno($no){
        $this->no = $no;
    }

    function setProject($project){
        $this->project = $project;
    }

    function setProvince($province){
        $this->province = $province;
    }

    function setSamplingId($samplingId){
        $this->samplingId = $samplingId;
    }

    function setSilo($silo){
        $this->silo = $silo;
    }

    function setStack($stack){
        $this->stack = $stack;
    }

    function setStatus($status){
        $this->status = $status;
    }

    function setType($type){
        $this->type = $type;
    }

    function setWarehouse($warehouse){
        $this->warehouse = $warehouse;
    }

    function setWeight($weight){
        $this->weight = $weight;
    }

    function setWeightAll($weightAll){
        $this->weightAll = $weightAll;
    }
}
