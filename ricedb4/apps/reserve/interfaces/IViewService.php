<?php
namespace apps\reserve\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M30 สำรองข้าว
 */
interface IViewService {

    /**
     * @name manageReserve
     * @uri /manageReserve
     * @description M31 รายการสำรองข้าว
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function manageReserve();

    /**
     * @name exportReserve
     * @uri /exportReserve
     * @description M32 ส่งไฟล์ให้ อคส./อตก. ตรวจสอบ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function exportReserve();
    
    /**
     * @name importReserve
     * @uri /importReserve
     * @description M33 นำไฟล์เข้าจาก อคส./อตก.
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function importReserve();
}
