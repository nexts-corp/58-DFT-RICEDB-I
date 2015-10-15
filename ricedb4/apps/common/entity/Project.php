<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Project")
 */
class Project extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Project") */
    public $project;

    function getId() {
        return $this->id;
    }

    function getProject() {
        return $this->project;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProject($project) {
        $this->project = $project;
    }

}
