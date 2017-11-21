<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Type_Doc")
 */
class TypeDoc extends EntityBase {

    /**
     * @Id 
     * @Column(type="string",length=50,name="id")
     */
    public $id;

    /** @Column(type="string",length=255, name="type_doc_name") */
    public $typeDocName;

    function getId() {
        return $this->id;
    }

    function getTypeDocName() {
        return $this->typeDocName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTypeDocName($typeDocName) {
        $this->typeDocName = $typeDocName;
    }

}
