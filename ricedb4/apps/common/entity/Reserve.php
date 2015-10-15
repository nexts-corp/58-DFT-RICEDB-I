<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Reserve")
 */
class Reserve extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Reserve_Name") */
    public $reserveName;

    /** @Column(type="string",length=255, name="Reserve_Code") */
    public $reserveCode;

    function getId(){
        return $this->id;
    }

    function getReserveName(){
        return $this->reserveName;
    }

    function getReserveCode(){
        return $this->reserveCode;
    }

    function setId($id){
        $this->id = $id;
    }

    function setReserveName($reserveName){
        $this->reserveName = $reserveName;
    }

    function setReserveCode($reserveCode){
        $this->reserveCode = $reserveCode;
    }
}
