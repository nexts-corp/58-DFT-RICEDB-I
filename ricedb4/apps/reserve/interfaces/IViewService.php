<?php

namespace apps\reserve\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M30 สำรองข้าว
 */
interface IViewService {

    /**
     * @name filter
     * @uri /filter
     * @description M31 คัดคลังสินค้าคงเหลือ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function filter();

    /**
     * @name manageReserve
     * @uri /manageReserve
     * @description M32 รายการสำรองข้าว
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function manageReserve();

    /**
     * @name exportReserve
     * @uri /exportReserve
     * @description M33 ส่งไฟล์ให้ อคส./อตก. ตรวจสอบ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function exportReserve();

    /**
     * @name importReserve
     * @uri /importReserve
     * @description M34 นำไฟล์เข้าจาก อคส./อตก.
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function importReserve();
}
