<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Permission")
 */
class Permission extends EntityBase {

    /**
     * @Id 
     * @Column(type="string", length=255, name="resourceCode")
     */
    public $resourceCode;

    /** @Column(type="string", length=255, name="resourceName") */
    public $resourceName;

    /** @Column(type="string", length=255, name="permission") */
    public $permission;

    function getResourceCode() {
        return $this->resourceCode;
    }

    function getResourceName() {
        return $this->resourceName;
    }

    function getPermission() {
        return $this->permission;
    }

    function setResourceCode($resourceCode) {
        $this->resourceCode = $resourceCode;
    }

    function setResourceName($resourceName) {
        $this->resourceName = $resourceName;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }

}
