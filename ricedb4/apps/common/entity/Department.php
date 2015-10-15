<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Department")
 */
class Department extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer", length=11, name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string", length=255, name="Department") */
    public $department;

    function getId() {
        return $this->id;
    }

    function getDepartment() {
        return $this->department;
    }
    function setId($id) {
        $this->id = $id;
    }

    function setDepartment($department) {
        $this->department = $department;
    }
}
