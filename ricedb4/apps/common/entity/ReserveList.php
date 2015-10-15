<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_Reserve_List")
 */
class ReserveList extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=10, name="LK_Reserve_Code") */
    public $reserveCode;

    /** @Column(type="string",length=255, name="Detail") */
    public $detail;

    /** @Column(type="string",length=50, name="Keyword") */
    public $keyword;

    /** @Column(type="string",length=50, name="Target") */
    public $target;

    function getId(){
        return $this->id;
    }

    function getReserveCode(){
        return $this->reserveCode;
    }

    function getDetail(){
        return $this->detail;
    }

    function getKeyword(){
        return $this->keyword;
    }

    function getTarget(){
        return $this->target;
    }

    function setId($id){
        $this->id = $id;
    }

    function setReserveCode($reserveCode){
        $this->reserveCode = $reserveCode;
    }

    function setDetail($detail){
        $this->detail = $detail;
    }

    function setKeyword($keyword){
        $this->keyword = $keyword;
    }

    function setTarget($target){
        $this->target = $target;
    }
}
