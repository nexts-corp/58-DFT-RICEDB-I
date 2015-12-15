<?php

namespace apps\common\model;

/**
 * @Entity
 * @Table(name="view_group_follow")
 */
class GroupFollow {

    /**
     * @Id 
     * @Column(type="string",length=50, name="statusKeyword") */
    public $statusKeyword;
    /**
     * @Column(type="string",length=255, name="statusName")
     */
    public $statusName;

    /**
     * @Id  
     * @Column(type="integer",length=11, name="associateId") */
    public $associateId;

    /** @Column(type="string",length=255, name="associate") */
    public $associate;

    /**
     * @Id  
     * @Column(type="integer",length=11, name="provinceId") */
    public $provinceId;

    /** @Column(type="string",length=255, name="province") */
    public $province;

    /**
     * @Id 
     * @Column(type="integer",length=11, name="projectId") */
    public $projectId;

    /** @Column(type="string",length=255, name="project") */
    public $project;

    /** 
     * @Id 
     * @Column(type="integer",length=11, name="typeId") */
    public $typeId;

    /** @Column(type="string",length=255, name="type") */
    public $type;

    /** @Column(type="string",length=255, name="silo") */
    public $silo;

    /** @Column(type="float", name="weightApprove") */
    public $weightApprove;

    /** @Column(type="integer",length=11, name="bidderNo") */
    public $bidderNo;

    /** @Column(type="string",length=255, name="bidderName") */
    public $bidderName;

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

    function getSilo() {
        return $this->silo;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getAssociate() {
        return $this->associate;
    }

    function getTypeId() {
        return $this->typeId;
    }

    function getType() {
        return $this->type;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getStatusName() {
        return $this->statusName;
    }

    function getWeightApprove() {
        return $this->weightApprove;
    }

    function getBidderNo() {
        return $this->bidderNo;
    }

    function getBidderName() {
        return $this->bidderName;
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

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setAssociate($associate) {
        $this->associate = $associate;
    }

    function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setStatusName($statusName) {
        $this->statusName = $statusName;
    }

    function setWeightApprove($weightApprove) {
        $this->weightApprove = $weightApprove;
    }

    function setBidderNo($bidderNo) {
        $this->bidderNo = $bidderNo;
    }

    function setBidderName($bidderName) {
        $this->bidderName = $bidderName;
    }

}
