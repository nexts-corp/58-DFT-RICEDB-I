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
 * @Table(name="dft_auction_warehouse")
 */
class AuctionWarehouse {

    /**
     * @Id
     * @Column(type="integer",length=11,name="wareHouseId") 
     */
    public $wareHouseId;

    /** @Column(type="string",length=255,name="wareHouseCode") */
    public $wareHouseCode;

    /** @Column(type="string",length=50,name="auctionNo") */
    public $auctionNo;

    /** @Column(type="string",length=50,name="auctionCode") */
    public $auctionCode;

    /** @Column(type="string",length=50,name="auctionDate") */
    public $auctionDate;

    /** @Column(type="integer",length=11,name="provinceId") */
    public $provinceId;

    /** @Column(type="string",length=255,name="province") */
    public $province;

    /** @Column(type="integer",length=11,name="associateId") */
    public $associateId;

    /** @Column(type="string",length=50,name="associate") */
    public $associate;

    /** @Column(type="string",length=255,name="address") */
    public $address;

    /** @Column(type="float",name="OWeightAll") */
    public $oWeightAll;

    /** @Column(type="float",name="WeightAll") */
    public $weightAll;

    /** @Column(type="float",name="OAFV2") */
    public $oafv2;

    /** @Column(type="float",name="OAFV3") */
    public $oafv3;

    /** @Column(type="float",name="OAFV4") */
    public $oafv4;

    /** @Column(type="float",name="OAFV") */
    public $oafv;

    /** @Column(type="float",name="AFV2") */
    public $afv2;

    /** @Column(type="float",name="AFV3") */
    public $afv3;

    /** @Column(type="float",name="AFV4") */
    public $afv4;

    /** @Column(type="float",name="AFV") */
    public $afv;

    /** @Column(type="float",name="OFV2") */
    public $ofv2;

    /** @Column(type="float",name="OFV3") */
    public $ofv3;

    /** @Column(type="float",name="OFV4") */
    public $ofv4;

    /** @Column(type="float",name="OFV") */
    public $ofv;

    /** @Column(type="float",name="FV2") */
    public $fv2;

    /** @Column(type="float",name="FV3") */
    public $fv3;

    /** @Column(type="float",name="FV4") */
    public $fv4;

    /** @Column(type="float",name="FV") */
    public $fv;

    /** @Column(type="float",name="ORFV2") */
    public $orfv2;

    /** @Column(type="float",name="ORFV3") */
    public $orfv3;

    /** @Column(type="float",name="ORFV4") */
    public $orfv4;

    /** @Column(type="float",name="ORFV") */
    public $orfv;

    /** @Column(type="float",name="RFV2") */
    public $rfv2;

    /** @Column(type="float",name="RFV3") */
    public $rfv3;

    /** @Column(type="float",name="RFV4") */
    public $rfv4;

    /** @Column(type="float",name="RFV") */
    public $rfv;

    /** @Column(type="float",name="Remark") */
    public $remark;

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

    function getAddress() {
        return $this->address;
    }

    function getOWeightAll() {
        return $this->oWeightAll;
    }

    function getWeightAll() {
        return $this->weightAll;
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

    function getAfv2() {
        return $this->afv2;
    }

    function getAfv3() {
        return $this->afv3;
    }

    function getAfv4() {
        return $this->afv4;
    }

    function getOafv2() {
        return $this->oafv2;
    }

    function getOafv3() {
        return $this->oafv3;
    }

    function getOafv4() {
        return $this->oafv4;
    }

    function getRfv2() {
        return $this->rfv2;
    }

    function getRfv3() {
        return $this->rfv3;
    }

    function getRfv4() {
        return $this->rfv4;
    }

    function getOrfv2() {
        return $this->orfv2;
    }

    function getOrfv3() {
        return $this->orfv3;
    }

    function getOrfv4() {
        return $this->orfv4;
    }

    function getAfv(){
        return $this->afv;
    }

    function getFv(){
        return $this->fv;
    }

    function getOafv(){
        return $this->oafv;
    }

    function getOfv(){
        return $this->ofv;
    }

    function getOrfv(){
        return $this->orfv;
    }

    function getRemark(){
        return $this->remark;
    }

    function getRfv(){
        return $this->rfv;
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

    function setAddress($address) {
        $this->address = $address;
    }

    function setOWeightAll($oWeightAll) {
        $this->oWeightAll = $oWeightAll;
    }

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
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

    function setAfv2($afv2) {
        $this->afv2 = $afv2;
    }

    function setAfv3($afv3) {
        $this->afv3 = $afv3;
    }

    function setAfv4($afv4) {
        $this->afv4 = $afv4;
    }

    function setOafv2($oafv2) {
        $this->oafv2 = $oafv2;
    }

    function setOafv3($oafv3) {
        $this->oafv3 = $oafv3;
    }

    function setOafv4($oafv4) {
        $this->oafv4 = $oafv4;
    }

    function setRfv2($rfv2) {
        $this->rfv2 = $rfv2;
    }

    function setRfv3($rfv3) {
        $this->rfv3 = $rfv3;
    }

    function setRfv4($rfv4) {
        $this->rfv4 = $rfv4;
    }

    function setOrfv2($orfv2) {
        $this->orfv2 = $orfv2;
    }

    function setOrfv3($orfv3) {
        $this->orfv3 = $orfv3;
    }

    function setOrfv4($orfv4) {
        $this->orfv4 = $orfv4;
    }

    function setAfv($afv){
        $this->afv = $afv;
    }

    function setFv($fv){
        $this->fv = $fv;
    }

    function setOafv($oafv){
        $this->oafv = $oafv;
    }

    function setOfv($ofv){
        $this->ofv = $ofv;
    }

    function setOrfv($orfv){
        $this->orfv = $orfv;
    }

    function setRemark($remark){
        $this->remark = $remark;
    }

    function setRfv($rfv){
        $this->rfv = $rfv;
    }

}
