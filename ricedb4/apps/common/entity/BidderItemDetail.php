<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Item_Detail")
 */
class BidderItemDetail extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="integer",length=11, name="Bidder_Item_Id") */
    public $bidderItemId;

    /** @Column(type="string",length=255, name="Rice_Tracking_Id") */
    public $riceTrackingId;
    
    
    /** @Column(type="string",length=255, name="AssociateId") */
    public $associateId;

    function getId() {
        return $this->id;
    }

    function getBidderItemId() {
        return $this->bidderItemId;
    }

    function getRiceTrackingId() {
        return $this->riceTrackingId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBidderItemId($bidderItemId) {
        $this->bidderItemId = $bidderItemId;
    }

    function setRiceTrackingId($riceTrackingId) {
        $this->riceTrackingId = $riceTrackingId;
    }
    function getAssociateId() {
        return $this->associateId;
    }

    function setAssociateId($associateId) {
        $this->associateId = $associateId;
    }


    

}
