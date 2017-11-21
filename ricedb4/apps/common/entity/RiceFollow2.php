<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_follow")
 */
class RiceFollow2 extends EntityBase {

    /**
     * @Id
     * @Column(type="string",length=50,name="id")
     */
    public $id;

    /** @Column(type="string", name="upload_date") */
    public $upload_date;

    /** @Column(type="integer", name="upload_no") */
    public $upload_no;

    /** @Column(type="string",length=50,name="associate") */
    public $associate;

    /**
     * @Column(type="string",length=255, name="follow_code") 
     */
    public $follow_code;

    /**
     * @Column(type="string",length=10, name="follow_type") 
     */
    public $follow_type;

    /**
     * @Column(type="string",length=2, name="follow_no") 
     */
    public $follow_no;

    /**
     * @Column(type="string",length=4, name="follow_year") 
     */
    public $follow_year;

    /** @Column(type="string",length=255, name="bidder_name") */
    public $bidder_name;

    /** @Column(type="string",length=255, name="typerice_name") */
    public $typerice_name;

    /** @Column(type="string",length=255, name="project_name") */
    public $project_name;

    /** @Column(type="string",length=255, name="warehouse_name") */
    public $warehouse_name;

    /** @Column(type="string",length=255, name="province_name") */
    public $province_name;

    /** @Column(type="float", name="weight_approve") */
    public $weight_approve;

    /** @Column(type="float", name="weight_contract") */
    public $weight_contract;

    /** @Column(type="float", name="weight_received") */
    public $weight_received;

    /** @Column(type="float", name="weight_balance") */
    public $weight_balance;

    /** @Column(type="float", name="weight_lost") */
    public $weight_lost;

    /** @Column(type="string", name="received_start_date") */
    public $received_start_date;

    /** @Column(type="string", name="received_end_date") */
    public $received_end_date;

    /** @Column(type="string", name="save_date") */
    public $save_date;

    /** @Column(type="string", name="limit_date") */
    public $limit_date;

    /** @Column(type="string", name="expire_date") */
    public $expire_date;

    /** @Column(type="string",length=255, name="contract_no") */
    public $contract_no;

    /** @Column(type="string",length=255, name="remark") */
    public $remark;

    /** @Column(type="string",length=255, name="problem_found") */
    public $problem_found;

    /** @Column(type="string",length=255, name="problem_fix") */
    public $problem_fix;

    /** @Column(type="string",length=255, name="use_industry") */
    public $use_industry;

    /** @Column(type="string",length=255, name="contract_mistake") */
    public $contract_mistake;

    /** @Column(type="string",length=255, name="project_round") */
    public $project_round;

    /** @Column(type="string",length=255, name="warehouse_no") */
    public $warehouse_no;

    /** @Column(type="string",length=255, name="stack_no") */
    public $stack_no;

    function getId() {
        return $this->id;
    }

    function getUpload_date() {
        return $this->upload_date;
    }

    function getUpload_no() {
        return $this->upload_no;
    }

    function getAssociate() {
        return $this->associate;
    }

    function getFollow_code() {
        return $this->follow_code;
    }

    function getFollow_type() {
        return $this->follow_type;
    }

    function getFollow_no() {
        return $this->follow_no;
    }

    function getFollow_year() {
        return $this->follow_year;
    }

    function getBidder_name() {
        return $this->bidder_name;
    }

    function getTyperice_name() {
        return $this->typerice_name;
    }

    function getProject_name() {
        return $this->project_name;
    }

    function getWarehouse_name() {
        return $this->warehouse_name;
    }

    function getProvince_name() {
        return $this->province_name;
    }

    function getWeight_approve() {
        return $this->weight_approve;
    }

    function getWeight_contract() {
        return $this->weight_contract;
    }

    function getWeight_received() {
        return $this->weight_received;
    }

    function getWeight_balance() {
        return $this->weight_balance;
    }

    function getWeight_lost() {
        return $this->weight_lost;
    }

    function getReceived_start_date() {
        return $this->received_start_date;
    }

    function getReceived_end_date() {
        return $this->received_end_date;
    }

    function getSave_date() {
        return $this->save_date;
    }

    function getLimit_date() {
        return $this->limit_date;
    }

    function getExpire_date() {
        return $this->expire_date;
    }

    function getContract_no() {
        return $this->contract_no;
    }

    function getRemark() {
        return $this->remark;
    }

    function getProblem_found() {
        return $this->problem_found;
    }

    function getProblem_fix() {
        return $this->problem_fix;
    }

    function getUse_industry() {
        return $this->use_industry;
    }

    function getContract_mistake() {
        return $this->contract_mistake;
    }

    function getProject_round() {
        return $this->project_round;
    }

    function getWarehouse_no() {
        return $this->warehouse_no;
    }

    function getStack_no() {
        return $this->stack_no;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUpload_date($upload_date) {
        $this->upload_date = $upload_date;
    }

    function setUpload_no($upload_no) {
        $this->upload_no = $upload_no;
    }

    function setAssociate($associate) {
        $this->associate = $associate;
    }

    function setFollow_code($follow_code) {
        $this->follow_code = $follow_code;
    }

    function setFollow_type($follow_type) {
        $this->follow_type = $follow_type;
    }

    function setFollow_no($follow_no) {
        $this->follow_no = $follow_no;
    }

    function setFollow_year($follow_year) {
        $this->follow_year = $follow_year;
    }

    function setBidder_name($bidder_name) {
        $this->bidder_name = $bidder_name;
    }

    function setTyperice_name($typerice_name) {
        $this->typerice_name = $typerice_name;
    }

    function setProject_name($project_name) {
        $this->project_name = $project_name;
    }

    function setWarehouse_name($warehouse_name) {
        $this->warehouse_name = $warehouse_name;
    }

    function setProvince_name($province_name) {
        $this->province_name = $province_name;
    }

    function setWeight_approve($weight_approve) {
        $this->weight_approve = $weight_approve;
    }

    function setWeight_contract($weight_contract) {
        $this->weight_contract = $weight_contract;
    }

    function setWeight_received($weight_received) {
        $this->weight_received = $weight_received;
    }

    function setWeight_balance($weight_balance) {
        $this->weight_balance = $weight_balance;
    }

    function setWeight_lost($weight_lost) {
        $this->weight_lost = $weight_lost;
    }

    function setReceived_start_date($received_start_date) {
        $this->received_start_date = $received_start_date;
    }

    function setReceived_end_date($received_end_date) {
        $this->received_end_date = $received_end_date;
    }

    function setSave_date($save_date) {
        $this->save_date = $save_date;
    }

    function setLimit_date($limit_date) {
        $this->limit_date = $limit_date;
    }

    function setExpire_date($expire_date) {
        $this->expire_date = $expire_date;
    }

    function setContract_no($contract_no) {
        $this->contract_no = $contract_no;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function setProblem_found($problem_found) {
        $this->problem_found = $problem_found;
    }

    function setProblem_fix($problem_fix) {
        $this->problem_fix = $problem_fix;
    }

    function setUse_industry($use_industry) {
        $this->use_industry = $use_industry;
    }

    function setContract_mistake($contract_mistake) {
        $this->contract_mistake = $contract_mistake;
    }

    function setProject_round($project_round) {
        $this->project_round = $project_round;
    }

    function setWarehouse_no($warehouse_no) {
        $this->warehouse_no = $warehouse_no;
    }

    function setStack_no($stack_no) {
        $this->stack_no = $stack_no;
    }

}
