<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Item")
 */
class BidderItem extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

    /** @Column(type="integer",length=11, name="Bidder_History_Id") */
    public $bidderHistoryId;

    /** @Column(type="string",length=255, name="Silo") */
    public $silo;

    /** @Column(type="string",length=255, name="AssociateId") */
    public $associateId;

    /** @Column(type="string",length=1, name="Is_Reserved") */
    public $isReserved;
    public $rfv;
    public $weightAll;
    public $riceTrackingId;

    //public $round;
//    public $auctionPrice;
    function getId() {
        return $this->id;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getBidderHistoryId() {
        return $this->bidderHistoryId;
    }

    function getSilo() {
        return $this->silo;
    }

    function getAssociateId() {
        return $this->associateId;
    }

    function getIsReserved() {
        return $this->isReserved;
    }

    function getRfv() {
        return $this->rfv;
    }

    function getWeightAll() {
        return $this->weightAll;
    }

    function getRiceTrackingId() {
        return $this->riceTrackingId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setBidderHistoryId($bidderHistoryId) {
        $this->bidderHistoryId = $bidderHistoryId;
    }

    function setSilo($silo) {
        $this->silo = $silo;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }

    function setIsReserved($isReserved) {
        $this->isReserved = $isReserved;
    }

    function setRfv($rfv) {
        $this->rfv = $rfv;
    }

    function setWeightAll($weightAll) {
        $this->weightAll = $weightAll;
    }

    function setRiceTrackingId($riceTrackingId) {
        $this->riceTrackingId = $riceTrackingId;
    }

}
