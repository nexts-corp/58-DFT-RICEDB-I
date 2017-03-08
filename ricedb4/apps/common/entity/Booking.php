<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_booking")
 */
class Booking extends EntityBase {

    /**
     * @Id 
     * @Column(type="string",length=50,name="book_id")
     */
    public $book_id;

    /** @Column(type="string",length=255, name="remark") */
    public $remark;

    /** @Column(type="string",length=10, name="book_status") */
    public $book_status;

    /** @Column(type="string",length=50, name="status_id") */
    public $status_id;

    /** @Column(type="string", name="obj_query") */
    public $obj_query;

    function getBook_id() {
        return $this->book_id;
    }

    function getRemark() {
        return $this->remark;
    }

    function getBook_status() {
        return $this->book_status;
    }

    function getStatus_id() {
        return $this->status_id;
    }

    function getObj_query() {
        return $this->obj_query;
    }

    function setBook_id($book_id) {
        $this->book_id = $book_id;
    }

    function setRemark($remark) {
        $this->remark = $remark;
    }

    function setBook_status($book_status) {
        $this->book_status = $book_status;
    }

    function setStatus_id($status_id) {
        $this->status_id = $status_id;
    }

    function setObj_query($obj_query) {
        $this->obj_query = $obj_query;
    }

}
