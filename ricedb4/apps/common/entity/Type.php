<?php
  namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Type")
 */
class Type extends EntityBase {
    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;
    
    /** @Column(type="string",length=255, name="Type") */
    public $type;
 
    function getId() {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setType($type) {
        $this->type = $type;
    }
}