<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_Release_Price")
 */
class ReleasePrice extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=50, name="LK_Status_Keyword") */
    public $statusKeyword;

    /** @Column(type="string",length=20, name="Warehouse_Code") */
    public $warehouseCode;

    /** @Column(type="float", name="Release_Price") */
    public $releasePrice;

    /** @Column(type="string",length=1, name="Is_Sale") */
    public $isSale;

    /** @Column(type="string",length=255, name="Remark") */
    public $remark;

    function getId(){
        return $this->id;
    }

    function getStatusKeyword(){
        return $this->statusKeyword;
    }

    function getWarehouseCode(){
        return $this->warehouseCode;
    }

    function getReleasePrice(){
        return $this->releasePrice;
    }

    function getIsSale(){
        return $this->isSale;
    }

    function getRemark(){
        return $this->remark;
    }

    function setId($id){
        $this->id = $id;
    }

    function setStatusKeyword($statusKeyword){
        $this->statusKeyword = $statusKeyword;
    }

    function setWarehouseCode($warehouseCode){
        $this->warehouseCode = $warehouseCode;
    }

    function setReleasePrice($releasePrice){
        $this->releasePrice = $releasePrice;
    }

    function setIsSale($isSale){
        $this->isSale = $isSale;
    }

    function setRemark($remark){
        $this->remark = $remark;
    }
}
