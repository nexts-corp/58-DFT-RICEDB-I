<?php
namespace apps\user\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M10 ผู้ใช้งาน
 */
interface IViewService {
   
    /**
     * @name userManage
     * @uri /userManage
     * @description M11 จัดการข้อมูลเจ้าหน้าที่
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function userManage();
    
    /**
     * @name permissionManage
     * @uri /permissionManage
     * @description M12 จัดการสิทธิ์
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function permissionManage();
}
