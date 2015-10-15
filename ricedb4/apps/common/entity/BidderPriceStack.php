<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Price_Stack")
 */
class BidderPriceStack extends EntityBase {

    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="integer",length=11, name="Bidder_Item_Id") */
    public $bidderItemDetailId;

    /** @Column(type="float",length=53, name="Auction_Price") */
    public $auctionPrice;

    /** @Column(type="integer",length=11, name="Round") */
    public $round;

    /** @Column(type="string",length=1, name="Is_Winner") */
    public $isWinner;

    /** @Column(type="string",length=1, name="Is_Pass_FV") */
    public $isPassFV;

    /** @Column(type="string",length=1, name="Is_Sale") */
    public $isSale;

    /** @Column(type="string",length=255, name="Remark") */
    public $remark;

    function getIsSale() {
        return $this->isSale;
    }

    function setIsSale($isSale) {
        $this->isSale = $isSale;
    }

    function getAuctionPrice() {
        return $this->auctionPrice;
    }

    function getBidderItemDetailId() {
        return $this->bidderItemDetailId;
    }

    function getId() {
        return $this->id;
    }

    function getIsWinner() {
        return $this->isWinner;
    }

    function getIsPassFV() {
        return $this->isPassFV;
    }

    function getRemark() {
        return $this->remark;
    }

    function getRound() {
        return $this->round;
    }

    function setAuctionPrice($auctionPrice) {
        $this->auctionPrice = $auctionPrice;
    }

    function setBidderItemDetailId($bidderItemDetailId) {
        $this->bidderItemDetailId = $bidderItemDetailId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIsWinner($isWinner) {
        $this->isWinner = $isWinner;
    }

    function setIsPassFV($isPassFV) {
        $this->isPassFV = $isPassFV;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function setRound($round) {
        $this->round = $round;
    }

}
