<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Type_Biz")
 */
class TypeBiz extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=50, name="Type_Biz") */
    public $typeBiz;

    function getId() {
        return $this->id;
    }

    function getTypeBiz() {
        return $this->typeBiz;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTypeBiz($typeBiz) {
        $this->typeBiz = $typeBiz;
    }

}
