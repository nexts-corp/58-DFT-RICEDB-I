<?php

namespace apps\user\interfaces;

/**
 * @name IPermissionManageService
 * @uri /permissionManage
 * @description ข้อมูลเจ้าหน้าที่
 */
interface IPermissionManageService {

    /**
     * @name lists
     * @uri /lists
     * @return String[] lists
     * @description ลิสต์ Role & Permission
     * @authen true
     */
    public function lists();
    
    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\Permission permission ข้อมูลสิทธิ์
     * @return boolean save
     * @description ลิสต์ Role & Permission
     * @authen true
     */
    public function save($permission);
    
}
