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

  
    
}
