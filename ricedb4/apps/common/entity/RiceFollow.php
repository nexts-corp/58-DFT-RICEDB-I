<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Rice_Follow")
 */
class RiceFollow extends EntityBase {

    /**
     * @Id
     * @Column(type="string",length=20,name="Follow_Code")
     */
    public $followCode;

    /** @Column(type="string",length=20,name="Lot_Code") */
    public $lotCode;

    /**
     * @Id
     * @Column(type="string",length=255, name="LK_Status_Keyword") 
     */
    public $statusKeyword;

    /** @Column(type="integer",length=11, name="LK_Bidder_Id") */
    public $bidderId;

    /** @Column(type="integer",length=11, name="LK_Associate_Id") */
    public $associateId;

    /** @Column(type="integer",length=11, name="LK_Province_Id") */
    public $provinceId;

    /** @Column(type="integer",length=11, name="LK_Project_Id") */
    public $projectId;

    /** @Column(type="integer",length=11, name="LK_Type_Id") */
    public $typeId;

    /** @Column(type="string",length=255, name="Silo") */
    public $silo;

    /** @Column(type="float", name="Weight_Approve") */
    public $weightApprove;

    /** @Column(type="float", name="Weight_Contract") */
    public $weightContract;

    /** @Column(type="float", name="Weight_Received") */
    public $weightReceived;

    /** @Column(type="float", name="Weight_Balance") */
    public $weightBalance;

    /** @Column(type="float", name="Weight_Lost") */
    public $weightLost;

    /** @Column(type="string",length=255, name="Contract_No") */
    public $contractNo;

    /** @Column(type="date", name="Follow_Date") */
    public $followDate;

    /** @Column(type="date", name="Due_Date") */
    public $dueDate;

    /** @Column(type="string",length=255, name="Remark") */
    public $remark;

    function getFollowCode() {
        return $this->followCode;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getBidderId() {
        return $this->bidderId;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getTypeId() {
        return $this->typeId;
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

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setBidderId($bidderId) {
        $this->bidderId = $bidderId;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
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
