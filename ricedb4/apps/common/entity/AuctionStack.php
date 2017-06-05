<?php

namespace apps\common\entity;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuctionWarehouse
 *
 * @author tawatchai
 */

/**
 * @Entity
 * @Table(name="dft_auction_stack")
 */
class AuctionStack {

    /**
     * @Id
     * @Column(type="string",length=255,name="stackId") 
     */
    public $stackId;

    /** @Column(type="string",length=50,name="auctionNo") */
    public $auctionNo;

    /** @Column(type="string",length=50,name="auctionCode") */
    public $auctionCode;

    /** @Column(type="string",length=50,name="auctionDate") */
    public $auctionDate;

    /** @Column(type="date",length=50,name="auctionAge") */
    public $auctionAge;

    /** @Column(type="string",length=255,name="stackCode") */
    public $stackCode;

    /** @Column(type="string",length=255,name="stackBagNo") */
    public $stackBagNo;

    /** @Column(type="integer",length=11,name="provinceId") */
    public $provinceId;

    /** @Column(type="string",length=255,name="province") */
    public $province;

    /** @Column(type="integer",length=11,name="projectId") */
    public $projectId;

    /** @Column(type="string",length=255,name="project") */
    public $project;

    /** @Column(type="integer",length=11,name="projectRound") */
    public $projectRound;

    /** @Column(type="integer",length=11,name="projectMonth") */
    public $projectMonth;

    /** @Column(type="integer",length=11,name="projectYear") */
    public $projectYear;

    /** @Column(type="integer",length=11,name="stockYear") */
    public $stockYear;

    /** @Column(type="integer",length=11,name="stockMonth") */
    public $stockMonth;

    /** @Column(type="string",length=255,name="wareHouseCode") */
    public $wareHouseCode;

    /** @Column(type="string",length=255,name="wareHouseAddress") */
    public $wareHouseAddress;

    /** @Column(type="integer",length=11,name="associateId") */
    public $associateId;

    /** @Column(type="string",length=50,name="associate") */
    public $associate;

    /** @Column(type="integer",length=11,name="typeId") */
    public $typeId;

    /** @Column(type="string",length=255,name="typeName") */
    public $typeName;

    /** @Column(type="string",length=255,name="warehouse") */
    public $warehouse;

    /** @Column(type="string",length=255,name="stack") */
    public $stack;

    /** @Column(type="float",name="weight") */
    public $weight;

    /** @Column(type="float",name="oweightAll") */
    public $oweightAll;

    /** @Column(type="float",name="weightAll") */
    public $weightAll;

    /** @Column(type="integer",length=11,name="gradeId") */
    public $gradeId;

    /** @Column(type="string",length=255,name="grade") */
    public $grade;

    /** @Column(type="float",name="discount") */
    public $discount;

    /** @Column(type="float",name="logisticCost") */
    public $logisticCost;

    /** @Column(type="float",name="oldPrice") */
    public $oldPrice;

    /** @Column(type="float",name="oldNewPrice") */
    public $oldNewPrice;

    /** @Column(type="float",name="newPrice") */
    public $newPrice;

    /** @Column(type="float",name="DFP4") */
    public $dfp4;

    /** @Column(type="float",name="DFP3") */
    public $dfp3;

    /** @Column(type="float",name="DFP2") */
    public $dfp2;

    /** @Column(type="float",name="OFP4") */
    public $ofp4;

    /** @Column(type="float",name="OFP3") */
    public $ofp3;

    /** @Column(type="float",name="OFP2") */
    public $ofp2;

    /** @Column(type="float",name="FP4") */
    public $fp4;

    /** @Column(type="float",name="FP3") */
    public $fp3;

    /** @Column(type="float",name="FP2") */
    public $fp2;

    /** @Column(type="float",name="FV2") */
    public $fv2;

    /** @Column(type="float",name="FV3") */
    public $fv3;

    /** @Column(type="float",name="FV4") */
    public $fv4;

    /** @Column(type="float",name="FV") */
    public $fv;

    /** @Column(type="float",name="OFV2") */
    public $ofv2;

    /** @Column(type="float",name="OFV3") */
    public $ofv3;

    /** @Column(type="float",name="OFV4") */
    public $ofv4;

    /** @Column(type="float",name="OFV") */
    public $ofv;

    /** @Column(type="string", length=10, name="UseFV") */
    public $useFV;

    function getStackId() {
        return $this->stackId;
    }

    function getAuctionNo() {
        return $this->auctionNo;
    }

    function getAuctionCode() {
        return $this->auctionCode;
    }

    function getAuctionDate() {
        return $this->auctionDate;
    }

    function getAuctionAge() {
        return $this->auctionAge;
    }

    function getStackCode() {
        return $this->stackCode;
    }

    function getStackBagNo() {
        return $this->stackBagNo;
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

    function getProjectRound() {
        return $this->projectRound;
    }

    function getProjectMonth() {
        return $this->projectMonth;
    }

    function getProjectYear() {
        return $this->projectYear;
    }

    function getStockYear() {
        return $this->stockYear;
    }

    function getStockMonth() {
        return $this->stockMonth;
    }

    function getWareHouseCode() {
        return $this->wareHouseCode;
    }

    function getWareHouseAddress() {
        return $this->wareHouseAddress;
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

    function getTypeName() {
        return $this->typeName;
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

    function getOweightAll() {
        return $this->oweightAll;
    }

    function getWeightAll() {
        return $this->weightAll;
    }

    function getGradeId() {
        return $this->gradeId;
    }

    function getGrade() {
        return $this->grade;
    }

    function getDiscount() {
        return $this->discount;
    }

    function getLogisticCost() {
        return $this->logisticCost;
    }

    function getOldPrice() {
        return $this->oldPrice;
    }

    function getOldNewPrice() {
        return $this->oldNewPrice;
    }

    function getNewPrice() {
        return $this->newPrice;
    }

    function getDfp4() {
        return $this->dfp4;
    }

    function getDfp3() {
        return $this->dfp3;
    }

    function getDfp2() {
        return $this->dfp2;
    }

    function getOfp4() {
        return $this->ofp4;
    }

    function getOfp3() {
        return $this->ofp3;
    }

    function getOfp2() {
        return $this->ofp2;
    }

    function getFp4() {
        return $this->fp4;
    }

    function getFp3() {
        return $this->fp3;
    }

    function getFp2() {
        return $this->fp2;
    }

    function getFv2() {
        return $this->fv2;
    }

    function getFv3() {
        return $this->fv3;
    }

    function getFv4() {
        return $this->fv4;
    }

    function getOfv2() {
        return $this->ofv2;
    }

    function getOfv3() {
        return $this->ofv3;
    }

    function getOfv4() {
        return $this->ofv4;
    }

    function getFv() {
        return $this->fv;
    }

    function getUseFV() {
        return $this->useFV;
    }

    function getOfv() {
        return $this->ofv;
    }

    function setStackId($stackId) {
        $this->stackId = $stackId;
    }

    function setAuctionNo($auctionNo) {
        $this->auctionNo = $auctionNo;
    }

    function setAuctionCode($auctionCode) {
        $this->auctionCode = $auctionCode;
    }

    function setAuctionDate($auctionDate) {
        $this->auctionDate = $auctionDate;
    }

    function setAuctionAge($auctionAge) {
        $this->auctionAge = $auctionAge;
    }

    function setStackCode($stackCode) {
        $this->stackCode = $stackCode;
    }

    function setStackBagNo($stackBagNo) {
        $this->stackBagNo = $stackBagNo;
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

    function setProjectRound($projectRound) {
        $this->projectRound = $projectRound;
    }

    function setProjectMonth($projectMonth) {
        $this->projectMonth = $projectMonth;
    }

    function setProjectYear($projectYear) {
        $this->projectYear = $projectYear;
    }

    function setStockYear($stockYear) {
        $this->stockYear = $stockYear;
    }

    function setStockMonth($stockMonth) {
        $this->stockMonth = $stockMonth;
    }

    function setWareHouseCode($wareHouseCode) {
        $this->wareHouseCode = $wareHouseCode;
    }

    function setWareHouseAddress($wareHouseAddress) {
        $this->wareHouseAddress = $wareHouseAddress;
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

    function setTypeName($typeName) {
        $this->typeName = $typeName;
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

    function setOweightAll($oweightAll) {
        $this->oweightAll = $oweightAll;
    }

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
    }

    function setGradeId($gradeId) {
        $this->gradeId = $gradeId;
    }

    function setGrade($grade) {
        $this->grade = $grade;
    }

    function setDiscount($discount) {
        $this->discount = $discount;
    }

    function setLogisticCost($logisticCost) {
        $this->logisticCost = $logisticCost;
    }

    function setOldPrice($oldPrice) {
        $this->oldPrice = $oldPrice;
    }

    function setOldNewPrice($oldNewPrice) {
        $this->oldNewPrice = $oldNewPrice;
    }

    function setNewPrice($newPrice) {
        $this->newPrice = $newPrice;
    }

    function setDfp4($dfp4) {
        $this->dfp4 = $dfp4;
    }

    function setDfp3($dfp3) {
        $this->dfp3 = $dfp3;
    }

    function setDfp2($dfp2) {
        $this->dfp2 = $dfp2;
    }

    function setOfp4($ofp4) {
        $this->ofp4 = $ofp4;
    }

    function setOfp3($ofp3) {
        $this->ofp3 = $ofp3;
    }

    function setOfp2($ofp2) {
        $this->ofp2 = $ofp2;
    }

    function setFp4($fp4) {
        $this->fp4 = $fp4;
    }

    function setFp3($fp3) {
        $this->fp3 = $fp3;
    }

    function setFp2($fp2) {
        $this->fp2 = $fp2;
    }

    function setFv2($fv2) {
        $this->fv2 = $fv2;
    }

    function setFv3($fv3) {
        $this->fv3 = $fv3;
    }

    function setFv4($fv4) {
        $this->fv4 = $fv4;
    }

    function setOfv2($ofv2) {
        $this->ofv2 = $ofv2;
    }

    function setOfv3($ofv3) {
        $this->ofv3 = $ofv3;
    }

    function setOfv4($ofv4) {
        $this->ofv4 = $ofv4;
    }

    function setFv($fv) {
        $this->fv = $fv;
    }

    function setOfv($ofv) {
        $this->ofv = $ofv;
    }

    function setUseFV($useFV) {
        $this->useFV = $useFV;
    }

}
