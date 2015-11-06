<?php

namespace apps\common\model;

/**
 * @Entity
 * @Table(name="view_rice_follow")
 */
class ViewFollow {

    /**
     * @Id
     * @Column(type="string",length=50,name="followCode")
     */
    public $followCode;

    /**
     * @Column(type="string",length=20, name="lotCode") 
     */
    public $lotCode;

    /**
     * @Column(type="string",length=255, name="statusKeyword") 
     */
    public $statusKeyword;

    /** @Column(type="integer",length=11, name="bidderNo") */
    public $bidderNo;

    /** @Column(type="string",length=255, name="bidderName") */
    public $bidderName;

    /** @Column(type="integer",length=11, name="associateId") */
    public $associateId;

    /** @Column(type="string",length=255, name="associate") */
    public $associate;

    /** @Column(type="integer",length=11, name="provinceId") */
    public $provinceId;

    /** @Column(type="string",length=255, name="province") */
    public $province;

    /** @Column(type="integer",length=11, name="projectId") */
    public $projectId;

    /** @Column(type="string",length=255, name="project") */
    public $project;

    /** @Column(type="integer",length=11, name="typeId") */
    public $typeId;

    /** @Column(type="string",length=255, name="type") */
    public $type;

//    /** @Column(type="string",length=50, name="Silo_Code") */
//    public $siloCode;

    /** @Column(type="string",length=255, name="silo") */
    public $silo;

    /** @Column(type="float", name="weightApprove") */
    public $weightApprove;

    /** @Column(type="float", name="weightContract") */
    public $weightContract;

    /** @Column(type="float", name="weightReceived") */
    public $weightReceived;

    /** @Column(type="float", name="weightBalance") */
    public $weightBalance;

    /** @Column(type="float", name="weightLost") */
    public $weightLost;

    /** @Column(type="string",length=255, name="contractNo") */
    public $contractNo;

    /** @Column(type="date", name="followDate") */
    public $followDate;

    /** @Column(type="date", name="dueDate") */
    public $dueDate;

    /** @Column(type="string",length=255, name="remark") */
    public $remark;

    function getFollowCode() {
        return $this->followCode;
    }

    function getLotCode() {
        return $this->lotCode;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getBidderId() {
        return $this->bidderId;
    }

    function getBidderName() {
        return $this->bidderName;
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

    function getProjectId() {
        return $this->projectId;
    }

    function getProject() {
        return $this->project;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getType() {
        return $this->type;
    }

    function getSilo() {
        return $this->silo;
    }

    function getWeightApprove() {
        return $this->weightApprove;
    }

    function getWeightContract() {
        return $this->weightContract;
    }

    function getWeightReceived() {
        return $this->weightReceived;
    }

    function getWeightBalance() {
        return $this->weightBalance;
    }

    function getWeightLost() {
        return $this->weightLost;
    }

    function getContractNo() {
        return $this->contractNo;
    }

    function getFollowDate() {
        return $this->followDate;
    }

    function getDueDate() {
        return $this->dueDate;
    }

    function getRemark() {
        return $this->remark;
    }

    function setFollowCode($followCode) {
        $this->followCode = $followCode;
    }

    function setLotCode($lotCode) {
        $this->lotCode = $lotCode;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setBidderId($bidderId) {
        $this->bidderId = $bidderId;
    }

    function setBidderName($bidderName) {
        $this->bidderName = $bidderName;
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

    function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

    function setProject($project) {
        $this->project = $project;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setWeightApprove($weightApprove) {
        $this->weightApprove = $weightApprove;
    }

    function setWeightContract($weightContract) {
        $this->weightContract = $weightContract;
    }

    function setWeightReceived($weightReceived) {
        $this->weightReceived = $weightReceived;
    }

    function setWeightBalance($weightBalance) {
        $this->weightBalance = $weightBalance;
    }

    function setWeightLost($weightLost) {
        $this->weightLost = $weightLost;
    }

    function setContractNo($contractNo) {
        $this->contractNo = $contractNo;
    }

    function setFollowDate($followDate) {
        $this->followDate = $followDate;
    }

    function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

}
