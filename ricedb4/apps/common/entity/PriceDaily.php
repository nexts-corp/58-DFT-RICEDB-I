<?php
namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Price_Daily")
 */
class PriceDaily extends EntityBase{
    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="date", name="Date") */
    public $date;

    /** @Column(type="integer",length=11, name="LK_Type_Id") */
    public $typeId;

    /** @Column(type="float",length=53, name="OldPriceMin1") */
    public $oldPriceMin1;

    /** @Column(type="float",length=53, name="OldPriceMax1") */
    public $oldPriceMax1;

    /** @Column(type="float",length=53, name="NewPriceMin1") */
    public $newPriceMin1;

    /** @Column(type="float",length=53, name="NewPriceMax1") */
    public $newPriceMax1;

    /** @Column(type="float",length=53, name="OldPriceMin2") */
    public $oldPriceMin2;

    /** @Column(type="float",length=53, name="OldPriceMax2") */
    public $oldPriceMax2;

    /** @Column(type="float",length=53, name="NewPriceMin2") */
    public $newPriceMin2;

    /** @Column(type="float",length=53, name="NewPriceMax2") */
    public $newPriceMax2;

    function getDate(){
        return $this->date;
    }

    function getId(){
        return $this->id;
    }

    function getNewPriceMax1(){
        return $this->newPriceMax1;
    }

    function getNewPriceMax2(){
        return $this->newPriceMax2;
    }

    function getNewPriceMin1(){
        return $this->newPriceMin1;
    }

    function getNewPriceMin2(){
        return $this->newPriceMin2;
    }

    function getOldPriceMax1(){
        return $this->oldPriceMax1;
    }

    function getOldPriceMax2(){
        return $this->oldPriceMax2;
    }

    function getOldPriceMin1(){
        return $this->oldPriceMin1;
    }

    function getOldPriceMin2(){
        return $this->oldPriceMin2;
    }

    function getTypeId(){
        return $this->typeId;
    }

    function setDate($date){
        $this->date = $date;
    }

    function setId($id){
        $this->id = $id;
    }

    function setNewPriceMax1($newPriceMax1){
        $this->newPriceMax1 = $newPriceMax1;
    }

    function setNewPriceMax2($newPriceMax2){
        $this->newPriceMax2 = $newPriceMax2;
    }

    function setNewPriceMin1($newPriceMin1){
        $this->newPriceMin1 = $newPriceMin1;
    }

    function setNewPriceMin2($newPriceMin2){
        $this->newPriceMin2 = $newPriceMin2;
    }

    function setOldPriceMax1($oldPriceMax1){
        $this->oldPriceMax1 = $oldPriceMax1;
    }

    function setOldPriceMax2($oldPriceMax2){
        $this->oldPriceMax2 = $oldPriceMax2;
    }

    function setOldPriceMin1($oldPriceMin1){
        $this->oldPriceMin1 = $oldPriceMin1;
    }

    function setOldPriceMin2($oldPriceMin2){
        $this->oldPriceMin2 = $oldPriceMin2;
    }

    function setTypeId($typeId){
        $this->typeId = $typeId;
    }
    
    
    /*public function toParam4Update(){
        return array(
            "Id"=>$this->Id,
            "OldPriceMin1" =>  $this->OldPriceMin1,
            "OldPriceMax1"=>$this->OldPriceMax1,
            "NewPriceMin1" =>  $this->NewPriceMin1,
            "NewPriceMax1"=>$this->NewPriceMax1,
            "OldPriceMin2" =>  $this->OldPriceMin2,
            "OldPriceMax2"=>$this->OldPriceMax2,
            "NewPriceMin2" =>  $this->NewPriceMin2,
            "NewPriceMax2"=>$this->NewPriceMax2
        );
    }
    
    public function toParam4Insert(){
        return array(
            "Date" =>  $this->Date,
            "TypeId"=>$this->TypeId,
            "OldPriceMin1" =>  $this->OldPriceMin1,
            "OldPriceMax1"=>$this->OldPriceMax1,
            "NewPriceMin1" =>  $this->NewPriceMin1,
            "NewPriceMax1"=>$this->NewPriceMax1,
            "OldPriceMin2" =>  $this->OldPriceMin2,
            "OldPriceMax2"=>$this->OldPriceMax2,
            "NewPriceMin2" =>  $this->NewPriceMin2,
            "NewPriceMax2"=>$this->NewPriceMax2
        );
    }*/
    
}
