<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Info")
 */
class BidderInfo extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=50, name="Tax_Id") */
    public $taxId;

    /** @Column(type="string",length=255, name="Bidder_Name") */
    public $bidderName;

    /** @Column(type="string",length=100, name="Fax") */
    public $fax;

    /** @Column(type="string",length=100, name="Email") */
    public $email;

    function getId() {
        return $this->id;
    }

    function getTaxId() {
        return $this->taxId;
    }

    function getBidderName() {
        return $this->bidderName;
    }

    function getFax() {
        return $this->fax;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTaxId($taxId) {
        $this->taxId = $taxId;
    }

    function setBidderName($bidderName) {
        $this->bidderName = $bidderName;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}
