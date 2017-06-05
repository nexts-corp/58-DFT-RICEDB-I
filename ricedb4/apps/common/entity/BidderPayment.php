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

    /** @Column(type="string",length=255, name="LK_Status_Keyword") */
    public $statusKeyword;

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

    /** @Column(type="integer",length=11,name="FinanceBank") */
    public $financeBank;

    /** @Column(type="string",length=255, name="FinanceNo") */
    public $financeNo;

    /** @Column(type="float", name="FinanceAmount") */
    public $financeAmount;

    /** @Column(type="date", name="FinanceDate") */
    public $financeDate;

    function getId() {
        return $this->id;
    }

    function getStatusKeyword() {
        return $this->statusKeyword;
    }

    function getBidderHistoryId() {
        return $this->bidderHistoryId;
    }

    function getPaymentId() {
        return $this->paymentId;
    }

    function getBankId() {
        return $this->bankId;
    }

    function getPaymentNo() {
        return $this->paymentNo;
    }

    function getAmount() {
        return $this->amount;
    }

    function getPaymentDate() {
        return $this->paymentDate;
    }

    function getRemark() {
        return $this->remark;
    }

    function getIsReturn() {
        return $this->isReturn;
    }

    function getDateReturn() {
        return $this->dateReturn;
    }

    function getFinanceBank() {
        return $this->financeBank;
    }

    function getFinanceNo() {
        return $this->financeNo;
    }

    function getFinanceAmount() {
        return $this->financeAmount;
    }

    function getFinanceDate() {
        return $this->financeDate;
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

    function setPaymentId($paymentId) {
        $this->paymentId = $paymentId;
    }

    function setBankId($bankId) {
        $this->bankId = $bankId;
    }

    function setPaymentNo($paymentNo) {
        $this->paymentNo = $paymentNo;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setPaymentDate($paymentDate) {
        $this->paymentDate = $paymentDate;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function setIsReturn($isReturn) {
        $this->isReturn = $isReturn;
    }

    function setDateReturn($dateReturn) {
        $this->dateReturn = $dateReturn;
    }

    function setFinanceBank($financeBank) {
        $this->financeBank = $financeBank;
    }

    function setFinanceNo($financeNo) {
        $this->financeNo = $financeNo;
    }

    function setFinanceAmount($financeAmount) {
        $this->financeAmount = $financeAmount;
    }

    function setFinanceDate($financeDate) {
        $this->financeDate = $financeDate;
    }

}
