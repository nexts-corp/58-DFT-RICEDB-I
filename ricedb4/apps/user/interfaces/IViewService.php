<?php
namespace apps\user\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M10 ผู้ใช้งาน
 */
interface IViewService {
   
    /**
     * @name userManager
     * @uri /userManager
     * @description M11 จัดการข้อมูลเจ้าหน้าที่
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function userManager();
    

}
