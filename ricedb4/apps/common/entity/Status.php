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

    function getActive(){
        return $this->active;
    }

    function getAgeStop(){
        return $this->ageStop;
    }

    function getAuctionDate(){
        return $this->auctionDate;
    }

    function getDateEnd(){
        return $this->dateEnd;
    }

    function getDateStart(){
        return $this->dateStart;
    }

    function getId(){
        return $this->id;
    }

    function getKeyword(){
        return $this->keyword;
    }

    function getLengthDecimal(){
        return $this->lengthDecimal;
    }

    function getReserveKeyword(){
        return $this->reserveKeyword;
    }

    function getRoundFun(){
        return $this->roundFun;
    }

    function getSaleBy(){
        return $this->saleBy;
    }

    function getStatus(){
        return $this->status;
    }

    function getWeightDecimal(){
        return $this->weightDecimal;
    }

    function getReleaseCode(){
        return $this->releaseCode;
    }

    function getBuyer(){
        return $this->buyer;
    }

    function setActive($active){
        $this->active = $active;
    }

    function setAgeStop($ageStop){
        $this->ageStop = $ageStop;
    }

    function setAuctionDate($auctionDate){
        $this->auctionDate = $auctionDate;
    }

    function setDateEnd($dateEnd){
        $this->dateEnd = $dateEnd;
    }

    function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    function setId($id){
        $this->id = $id;
    }

    function setKeyword($keyword){
        $this->keyword = $keyword;
    }

    function setLengthDecimal($lengthDecimal){
        $this->lengthDecimal = $lengthDecimal;
    }

    function setReserveKeyword($reserveKeyword){
        $this->reserveKeyword = $reserveKeyword;
    }

    function setRoundFun($roundFun){
        $this->roundFun = $roundFun;
    }

    function setSaleBy($saleBy){
        $this->saleBy = $saleBy;
    }

    function setStatus($status){
        $this->status = $status;
    }

    function setWeightDecimal($weightDecimal){
        $this->weightDecimal = $weightDecimal;
    }

    function setReleaseCode($releaseCode){
        $this->releaseCode = $releaseCode;
    }

    function setBuyer($buyer){
        $this->buyer = $buyer;
    }
}
