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
    
    /** @Column(type="string",length=1, name="Check_In") */
    public $checkIn;

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

    function getAgentName2(){
        return $this->agentName2;
    }

    function getMobile(){
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

    function getProperty3(){
        return $this->property3;
    }

    function getProperty4(){
        return $this->property4;
    }

    function getProperty5(){
        return $this->property5;
    }

    function getRemark3(){
        return $this->remark3;
    }

    function getRemark4(){
        return $this->remark4;
    }

    function getRemark5(){
        return $this->remark5;
    }

    function getCheckIn(){
        return $this->checkIn;
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

    function setAgentName2($agentName2){
        $this->agentName2 = $agentName2;
    }

    function setMobile($mobile){
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

    function setProperty3($property3){
        $this->property3 = $property3;
    }

    function setProperty4($property4){
        $this->property4 = $property4;
    }

    function setProperty5($property5){
        $this->property5 = $property5;
    }

    function setRemark3($remark3){
        $this->remark3 = $remark3;
    }

    function setRemark4($remark4){
        $this->remark4 = $remark4;
    }

    function setRemark5($remark5){
        $this->remark5 = $remark5;
    }

    function setCheckIn($checkIn){
        $this->checkIn = $checkIn;
    }
}
