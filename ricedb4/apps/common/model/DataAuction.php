<?php

namespace apps\common\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BidderItemPrice
 *
 * @author tawatchai
 */
class DataAuction {

    public $wareHouseId;
    public $wareHouseCode;
    public $auctionNo;
    public $auctionCode;
    public $auctionDate;
    public $provinceId;
    public $province;
    public $associateId;
    public $associate;
    public $weightAll;
    public $AFV2;
    public $AFV3;
    public $AFV4;
    public $FV2;
    public $FV3;
    public $FV4;
    public $RFV2;
    public $RFV3;
    public $RFV4;
    public $bidderNo;
    public $bidderName;
    public $bidderAgent;
    public $bidderRegister;
    public $bidderQueue;
    public $bidderAuctionNo;
    public $bidderPriceId;
    public $Property1;
    public $Property2;
    public $Property3;
    public $Property4;
    public $Property5;
    public $bidderStatus;
    public $bidderStatusCode;
    public $bidderRound;
    public $bidderPrice;
    public $bidderFirstPrice;
    public $bidderLastPrice;
    public $bidderPassFV;
    public $bidderWinner;
    public $bidderMaxPrice;

    function getWareHouseId() {
        return $this->wareHouseId;
    }

    function getWareHouseCode() {
        return $this->wareHouseCode;
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

    function getProvinceId() {
        return $this->provinceId;
    }

    function getProvince() {
        return $this->province;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getAssociate() {
        return $this->associate;
    }

    function getWeightAll() {
        return $this->weightAll;
    }

    function getAFV2() {
        return $this->AFV2;
    }

    function getAFV3() {
        return $this->AFV3;
    }

    function getAFV4() {
        return $this->AFV4;
    }

    function getFV2() {
        return $this->FV2;
    }

    function getFV3() {
        return $this->FV3;
    }

    function getFV4() {
        return $this->FV4;
    }

    function getRFV2() {
        return $this->RFV2;
    }

    function getRFV3() {
        return $this->RFV3;
    }

    function getRFV4() {
        return $this->RFV4;
    }

    function getBidderNo() {
        return $this->bidderNo;
    }

    function getBidderName() {
        return $this->bidderName;
    }

    function getBidderAgent() {
        return $this->bidderAgent;
    }

    function getBidderRegister() {
        return $this->bidderRegister;
    }

    function getBidderQueue() {
        return $this->bidderQueue;
    }

    function getBidderAuctionNo() {
        return $this->bidderAuctionNo;
    }

    function getBidderPriceId() {
        return $this->bidderPriceId;
    }

    function getProperty1() {
        return $this->Property1;
    }

    function getProperty2() {
        return $this->Property2;
    }

    function getProperty3() {
        return $this->Property3;
    }

    function getProperty4() {
        return $this->Property4;
    }

    function getProperty5() {
        return $this->Property5;
    }

    function getBidderStatus() {
        return $this->bidderStatus;
    }

    function getBidderStatusCode() {
        return $this->bidderStatusCode;
    }

    function getBidderRound() {
        return $this->bidderRound;
    }

    function getBidderPrice() {
        return $this->bidderPrice;
    }

    function getBidderFirstPrice() {
        return $this->bidderFirstPrice;
    }

    function getBidderLastPrice() {
        return $this->bidderLastPrice;
    }

    function getBidderPassFV() {
        return $this->bidderPassFV;
    }

    function getBidderWinner() {
        return $this->bidderWinner;
    }

    function getBidderMaxPrice() {
        return $this->bidderMaxPrice;
    }

    function setWareHouseId($wareHouseId) {
        $this->wareHouseId = $wareHouseId;
    }

    function setWareHouseCode($wareHouseCode) {
        $this->wareHouseCode = $wareHouseCode;
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

    function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    function setProvince($province) {
        $this->province = $province;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setAssociate($associate) {
        $this->associate = $associate;
    }

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
    }

    function setAFV2($AFV2) {
        $this->AFV2 = $AFV2;
    }

    function setAFV3($AFV3) {
        $this->AFV3 = $AFV3;
    }

    function setAFV4($AFV4) {
        $this->AFV4 = $AFV4;
    }

    function setFV2($FV2) {
        $this->FV2 = $FV2;
    }

    function setFV3($FV3) {
        $this->FV3 = $FV3;
    }

    function setFV4($FV4) {
        $this->FV4 = $FV4;
    }

    function setRFV2($RFV2) {
        $this->RFV2 = $RFV2;
    }

    function setRFV3($RFV3) {
        $this->RFV3 = $RFV3;
    }

    function setRFV4($RFV4) {
        $this->RFV4 = $RFV4;
    }

    function setBidderNo($bidderNo) {
        $this->bidderNo = $bidderNo;
    }

    function setBidderName($bidderName) {
        $this->bidderName = $bidderName;
    }

    function setBidderAgent($bidderAgent) {
        $this->bidderAgent = $bidderAgent;
    }

    function setBidderRegister($bidderRegister) {
        $this->bidderRegister = $bidderRegister;
    }

    function setBidderQueue($bidderQueue) {
        $this->bidderQueue = $bidderQueue;
    }

    function setBidderAuctionNo($bidderAuctionNo) {
        $this->bidderAuctionNo = $bidderAuctionNo;
    }

    function setBidderPriceId($bidderPriceId) {
        $this->bidderPriceId = $bidderPriceId;
    }

    function setProperty1($Property1) {
        $this->Property1 = $Property1;
    }

    function setProperty2($Property2) {
        $this->Property2 = $Property2;
    }

    function setProperty3($Property3) {
        $this->Property3 = $Property3;
    }

    function setProperty4($Property4) {
        $this->Property4 = $Property4;
    }

    function setProperty5($Property5) {
        $this->Property5 = $Property5;
    }

    function setBidderStatus($bidderStatus) {
        $this->bidderStatus = $bidderStatus;
    }

    function setBidderStatusCode($bidderStatusCode) {
        $this->bidderStatusCode = $bidderStatusCode;
    }

    function setBidderRound($bidderRound) {
        $this->bidderRound = $bidderRound;
    }

    function setBidderPrice($bidderPrice) {
        $this->bidderPrice = $bidderPrice;
    }

    function setBidderFirstPrice($bidderFirstPrice) {
        $this->bidderFirstPrice = $bidderFirstPrice;
    }

    function setBidderLastPrice($bidderLastPrice) {
        $this->bidderLastPrice = $bidderLastPrice;
    }

    function setBidderPassFV($bidderPassFV) {
        $this->bidderPassFV = $bidderPassFV;
    }

    function setBidderWinner($bidderWinner) {
        $this->bidderWinner = $bidderWinner;
    }

    function setBidderMaxPrice($bidderMaxPrice) {
        $this->bidderMaxPrice = $bidderMaxPrice;
    }

}
