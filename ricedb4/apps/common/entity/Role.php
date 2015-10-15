<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Role")
 */
class Role extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer", length=11, name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string", length=200, name="Role") */
    public $role;

    /** @Column(type="string", length=50, name="Code") */
    public $code;
    
    
    /** @Column(type="string", length=16, name="Permission") */
    public $permission;

    function getId() {
        return $this->id;
    }

    function getRole() {
        return $this->role;
    }

    function getCode() {
        return $this->code;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setCode($code) {
        $this->code = $code;
    }
    function getPermission() {
        return $this->permission;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }


    
}
