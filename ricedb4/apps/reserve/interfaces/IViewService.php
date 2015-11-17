<?php
namespace apps\reserve\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {

    /**
     * @name manageReserve
     * @uri /manageReserve
     * @description  รายการสำรองข้าว
     */
    public function manageReserve();


    /**
     * @name manageReserve2
     * @uri /manageReserve2
     * @description  รายการสำรองข้าว
     */
    public function manageReserve2();

    /**
     * @name exportReserve
     * @uri /exportReserve
     * @description  ส่งไฟล์ให้ อคส./อตก. ตรวจสอบ
     */ 
    public function exportReserve();
    
    /**
     * @name importReserve
     * @uri /importReserve
     * @description  นำไฟล์เข้าจาก อคส./อตก.
     */ 
    public function importReserve();
}
