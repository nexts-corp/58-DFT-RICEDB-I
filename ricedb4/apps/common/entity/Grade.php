<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Grade")
 */
class Grade extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Grade") */
    public $grade;

    public function getId() {
        return $this->id;
    }

    public function getGrade() {
        return $this->grade;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setGrade($grade) {
        $this->grade = $grade;
    }

}
