<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Bank")
 */
class Bank extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Bank_TH") */
    public $bankTH;

    /** @Column(type="string",length=255, name="Bank_EN") */
    public $bankEN;

    function getId() {
        return $this->id;
    }

    function getBankTH() {
        return $this->bankTH;
    }

    function getBankEN() {
        return $this->bankEN;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBankTH($bankTH) {
        $this->bankTH = $bankTH;
    }

    function setBankEN($bankEN) {
        $this->bankEN = $bankEN;
    }

}
