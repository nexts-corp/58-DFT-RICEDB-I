<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_History")
 */
class BidderHistory extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="integer",length=11, name="LK_Bidder_Id") */
    public $bidderId;

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

    /** @Column(type="integer",length=11, name="Queue") */
    public $queue;

    /** @Column(type="datetime", name="Date_Register") */
    public $dateRegister;

    /** @Column(type="string",length=255, name="Agent_Name") */
    public $agentName;

    /** @Column(type="string",length=255, name="Agent_Name2") */
    public $agentName2;

    /** @Column(type="string",length=255, name="Agent_Name3") */
    public $agentName3;

    /** @Column(type="string",length=100, name="Mobile") */
    public $mobile;

    /** @Column(type="string",length=1, name="Property1") */
    public $property1;

    /** @Column(type="string",length=255, name="Remark1") */
    public $remark1;

    /** @Column(type="string",length=1, name="Property2") */
    public $property2;

    /** @Column(type="string",length=255, name="Remark2") */
    public $remark2;

    /** @Column(type="string",length=1, name="Property3") */
    public $property3;

    /** @Column(type="string",length=255, name="Remark3") */
    public $remark3;

    /** @Column(type="string",length=1, name="Property4") */
    public $property4;

    /** @Column(type="string",length=255, name="Remark4") */
    public $remark4;

    /** @Column(type="string",length=1, name="Property5") */
    public $property5;

    /** @Column(type="string",length=255, name="Remark5") */
    public $remark5;

    /** @Column(type="string",length=1, name="Property6") */
    public $property6;

    /** @Column(type="string",length=255, name="Remark6") */
    public $remark6;

    /** @Column(type="string",length=1, name="Check_In") */
    public $checkIn;

    /** @Column(type="string",length=1, name="Property_Factory1") */
    public $propertyFactory1;

    /** @Column(type="string",length=255, name="Remark_Factory1") */
    public $remarkFactory1;

    /** @Column(type="string",length=1, name="Property_Factory2") */
    public $propertyFactory2;

    /** @Column(type="string",length=255, name="Remark_Factory2") */
    public $remarkFactory2;

    /** @Column(type="string",length=1, name="Property_Factory3") */
    public $propertyFactory3;

    /** @Column(type="string",length=255, name="Remark_Factory3") */
    public $remarkFactory3;

    /** @Column(type="string", name="Attachment") */
    public $attachment;

    /** @Column(type="integer",length=11, name="LK_Type_Biz") */
    public $typeBiz;

    /** @Column(type="string",length=255, name="Type_Optional") */
    public $typeOptional;

    /** @Column(type="string",length=255, name="Remark_Special") */
    public $remarkSpecial;

    function getId() {
        return $this->id;
    }

    function getBidderId() {
        return $this->bidderId;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getQueue() {
        return $this->queue;
    }

    function getDateRegister() {
        return $this->dateRegister;
    }

    function getAgentName() {
        return $this->agentName;
    }

    function getAgentName2() {
        return $this->agentName2;
    }

    function getAgentName3() {
        return $this->agentName3;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getProperty1() {
        return $this->property1;
    }

    function getRemark1() {
        return $this->remark1;
    }

    function getProperty2() {
        return $this->property2;
    }

    function getRemark2() {
        return $this->remark2;
    }

    function getProperty3() {
        return $this->property3;
    }

    function getRemark3() {
        return $this->remark3;
    }

    function getProperty4() {
        return $this->property4;
    }

    function getRemark4() {
        return $this->remark4;
    }

    function getProperty5() {
        return $this->property5;
    }

    function getRemark5() {
        return $this->remark5;
    }

    function getProperty6() {
        return $this->property6;
    }

    function getRemark6() {
        return $this->remark6;
    }

    function getCheckIn() {
        return $this->checkIn;
    }

    function getPropertyFactory1() {
        return $this->propertyFactory1;
    }

    function getRemarkFactory1() {
        return $this->remarkFactory1;
    }

    function getPropertyFactory2() {
        return $this->propertyFactory2;
    }

    function getRemarkFactory2() {
        return $this->remarkFactory2;
    }

    function getPropertyFactory3() {
        return $this->propertyFactory3;
    }

    function getRemarkFactory3() {
        return $this->remarkFactory3;
    }

    function getAttachment() {
        return $this->attachment;
    }

    function getTypeBiz() {
        return $this->typeBiz;
    }

    function getTypeOptional() {
        return $this->typeOptional;
    }

    function getRemarkSpecial() {
        return $this->remarkSpecial;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBidderId($bidderId) {
        $this->bidderId = $bidderId;
    }

    function setStatusKeyword($statusKeyword) {
        $this->statusKeyword = $statusKeyword;
    }

    function setQueue($queue) {
        $this->queue = $queue;
    }

    function setDateRegister($dateRegister) {
        $this->dateRegister = $dateRegister;
    }

    function setAgentName($agentName) {
        $this->agentName = $agentName;
    }

    function setAgentName2($agentName2) {
        $this->agentName2 = $agentName2;
    }

    function setAgentName3($agentName3) {
        $this->agentName3 = $agentName3;
    }

    function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function setProperty1($property1) {
        $this->property1 = $property1;
    }

    function setRemark1($remark1) {
        $this->remark1 = $remark1;
    }

    function setProperty2($property2) {
        $this->property2 = $property2;
    }

    function setRemark2($remark2) {
        $this->remark2 = $remark2;
    }

    function setProperty3($property3) {
        $this->property3 = $property3;
    }

    function setRemark3($remark3) {
        $this->remark3 = $remark3;
    }

    function setProperty4($property4) {
        $this->property4 = $property4;
    }

    function setRemark4($remark4) {
        $this->remark4 = $remark4;
    }

    function setProperty5($property5) {
        $this->property5 = $property5;
    }

    function setRemark5($remark5) {
        $this->remark5 = $remark5;
    }

    function setProperty6($property6) {
        $this->property6 = $property6;
    }

    function setRemark6($remark6) {
        $this->remark6 = $remark6;
    }

    function setCheckIn($checkIn) {
        $this->checkIn = $checkIn;
    }

    function setPropertyFactory1($propertyFactory1) {
        $this->propertyFactory1 = $propertyFactory1;
    }

    function setRemarkFactory1($remarkFactory1) {
        $this->remarkFactory1 = $remarkFactory1;
    }

    function setPropertyFactory2($propertyFactory2) {
        $this->propertyFactory2 = $propertyFactory2;
    }

    function setRemarkFactory2($remarkFactory2) {
        $this->remarkFactory2 = $remarkFactory2;
    }

    function setPropertyFactory3($propertyFactory3) {
        $this->propertyFactory3 = $propertyFactory3;
    }

    function setRemarkFactory3($remarkFactory3) {
        $this->remarkFactory3 = $remarkFactory3;
    }

    function setAttachment($attachment) {
        $this->attachment = $attachment;
    }

    function setTypeBiz($typeBiz) {
        $this->typeBiz = $typeBiz;
    }

    function setTypeOptional($typeOptional) {
        $this->typeOptional = $typeOptional;
    }

    function setRemarkSpecial($remarkSpecial) {
        $this->remarkSpecial = $remarkSpecial;
    }

}
