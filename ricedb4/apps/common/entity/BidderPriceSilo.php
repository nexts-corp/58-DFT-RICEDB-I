<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Price_Silo")
 */
class BidderPriceSilo extends EntityBase {

    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

    /** @Column(type="integer",length=11, name="Bidder_Item_Id") */
    public $bidderItemId;

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

    function getId() {
        return $this->id;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getBidderItemId() {
        return $this->bidderItemId;
    }

    function getAuctionPrice() {
        return $this->auctionPrice;
    }

    function getRound() {
        return $this->round;
    }

    function getIsWinner() {
        return $this->isWinner;
    }

    function getIsPassFV() {
        return $this->isPassFV;
    }

    function getIsSale() {
        return $this->isSale;
    }

    function getRemark() {
        return $this->remark;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setBidderItemId($bidderItemId) {
        $this->bidderItemId = $bidderItemId;
    }

    function setAuctionPrice($auctionPrice) {
        $this->auctionPrice = $auctionPrice;
    }

    function setRound($round) {
        $this->round = $round;
    }

    function setIsWinner($isWinner) {
        $this->isWinner = $isWinner;
    }

    function setIsPassFV($isPassFV) {
        $this->isPassFV = $isPassFV;
    }

    function setIsSale($isSale) {
        $this->isSale = $isSale;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

}
