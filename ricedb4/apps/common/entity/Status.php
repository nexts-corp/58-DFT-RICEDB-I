<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Status")
 */
class Status extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Status") */
    public $status;

    /** @Column(type="string",length=50, name="Keyword") */
    public $keyword;

    /** @Column(type="date", name="Age_Stop") */
    public $ageStop;

    /** @Column(type="date", name="Date_Start") */
    public $dateStart;

    /** @Column(type="date",name="Date_End") */
    public $dateEnd;

    /** @Column(type="string",length=1,name="Active") */
    public $active;

    /** @Column(type="string",length=10,name="Sale_By") */
    public $saleBy;

    /** @Column(type="string",length=50,name="AuctionDate") */
    public $auctionDate;

    /** @Column(type="integer",length=11,name="LengthDecimal") */
    public $lengthDecimal;

    /** @Column(type="integer",length=11,name="RoundFun") */
    public $roundFun;

    /** @Column(type="integer",length=11,name="WeightDecimal") */
    public $weightDecimal;

    /** @Column(type="string",length=50,name="Reserve_Keyword") */
    public $reserveKeyword;

    /** @Column(type="string",length=50,name="LK_Release_Code") */
    public $releaseCode;

    /** @Column(type="string",length=255,name="Buyer") */
    public $buyer;

    /** @Column(type="string",length=50,name="AuctionDay1") */
    public $auctionDay1;

    /** @Column(type="string",length=50,name="AuctionDay2") */
    public $auctionDay2;

    /** @Column(type="string",length=50,name="AuctionDay3") */
    public $auctionDay3;

    /** @Column(type="string",length=50,name="AuctionDay4") */
    public $auctionDay4;

    function getId() {
        return $this->id;
    }

    function getStatus() {
        return $this->status;
    }

    function getKeyword() {
        return $this->keyword;
    }

    function getAgeStop() {
        return $this->ageStop;
    }

    function getDateStart() {
        return $this->dateStart;
    }

    function getDateEnd() {
        return $this->dateEnd;
    }

    function getActive() {
        return $this->active;
    }

    function getSaleBy() {
        return $this->saleBy;
    }

    function getAuctionDate() {
        return $this->auctionDate;
    }

    function getLengthDecimal() {
        return $this->lengthDecimal;
    }

    function getRoundFun() {
        return $this->roundFun;
    }

    function getWeightDecimal() {
        return $this->weightDecimal;
    }

    function getReserveKeyword() {
        return $this->reserveKeyword;
    }

    function getReleaseCode() {
        return $this->releaseCode;
    }

    function getBuyer() {
        return $this->buyer;
    }

    function getAuctionDay1() {
        return $this->auctionDay1;
    }

    function getAuctionDay2() {
        return $this->auctionDay2;
    }

    function getAuctionDay3() {
        return $this->auctionDay3;
    }

    function getAuctionDay4() {
        return $this->auctionDay4;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setKeyword($keyword) {
        $this->keyword = $keyword;
    }

    function setAgeStop($ageStop) {
        $this->ageStop = $ageStop;
    }

    function setDateStart($dateStart) {
        $this->dateStart = $dateStart;
    }

    function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;
    }

    function setActive($active) {
        $this->active = $active;
    }

    function setSaleBy($saleBy) {
        $this->saleBy = $saleBy;
    }

    function setAuctionDate($auctionDate) {
        $this->auctionDate = $auctionDate;
    }

    function setLengthDecimal($lengthDecimal) {
        $this->lengthDecimal = $lengthDecimal;
    }

    function setRoundFun($roundFun) {
        $this->roundFun = $roundFun;
    }

    function setWeightDecimal($weightDecimal) {
        $this->weightDecimal = $weightDecimal;
    }

    function setReserveKeyword($reserveKeyword) {
        $this->reserveKeyword = $reserveKeyword;
    }

    function setReleaseCode($releaseCode) {
        $this->releaseCode = $releaseCode;
    }

    function setBuyer($buyer) {
        $this->buyer = $buyer;
    }

    function setAuctionDay1($auctionDay1) {
        $this->auctionDay1 = $auctionDay1;
    }

    function setAuctionDay2($auctionDay2) {
        $this->auctionDay2 = $auctionDay2;
    }

    function setAuctionDay3($auctionDay3) {
        $this->auctionDay3 = $auctionDay3;
    }

    function setAuctionDay4($auctionDay4) {
        $this->auctionDay4 = $auctionDay4;
    }

}
