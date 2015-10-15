<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Payment")
 */
class Payment extends EntityBase{
    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Payment") */
    public $payment;

    function getId(){
        return $this->id;
    }

    function getPayment(){
        return $this->payment;
    }

    function setId($id){
        $this->id = $id;
    }

    function setPayment($payment){
        $this->payment = $payment;
    }


} 