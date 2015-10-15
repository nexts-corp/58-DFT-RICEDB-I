<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Payment")
 */
class BidderPayment extends EntityBase {

    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="integer",length=11, name="Bidder_History_Id") */
    public $bidderHistoryId;

    /** @Column(type="integer",length=11, name="LK_Payment_Id") */
    public $paymentId;

    /** @Column(type="integer",length=11,name="LK_Bank_Id") */
    public $bankId;

    /** @Column(type="string",length=255, name="Payment_No") */
    public $paymentNo;

    /** @Column(type="float", name="Amount") */
    public $amount;

    /** @Column(type="date", name="Payment_Date") */
    public $paymentDate;

    /** @Column(type="string",length=255, name="remark") */
    public $remark;

    /** @Column(type="string",length=1, name="isReturn") */
    public $isReturn;

    /** @Column(type="date", name="dateReturn") */
    public $dateReturn;

    function getDateReturn() {
        return $this->dateReturn;
    }

    function setDateReturn($dateReturn) {
        $this->dateReturn = $dateReturn;
    }

    function getRemark() {
        return $this->remark;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function getIsReturn() {
        return $this->isReturn;
    }

    function setIsReturn($isReturn) {
        $this->isReturn = $isReturn;
    }

    function getPaymentDate() {
        return $this->paymentDate;
    }

    function setPaymentDate($paymentDate) {
        $this->paymentDate = $paymentDate;
    }

    function getAmount() {
        return $this->amount;
    }

    function getBankId() {
        return $this->bankId;
    }

    function getBidderHistoryId() {
        return $this->bidderHistoryId;
    }

    function getId() {
        return $this->id;
    }

    function getPaymentId() {
        return $this->paymentId;
    }

    function getPaymentNo() {
        return $this->paymentNo;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setBankId($bankId) {
        $this->bankId = $bankId;
    }

    function setBidderHistoryId($bidderHistoryId) {
        $this->bidderHistoryId = $bidderHistoryId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPaymentId($paymentId) {
        $this->paymentId = $paymentId;
    }

    function setPaymentNo($paymentNo) {
        $this->paymentNo = $paymentNo;
    }

}
