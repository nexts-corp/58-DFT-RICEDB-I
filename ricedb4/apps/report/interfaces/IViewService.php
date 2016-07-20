<?php

namespace apps\report\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M80 รายงาน
 */
interface IViewService {

    /**
     * @name reportAuction
     * @uri /reportAuction
     * @description M81 ประมูลทั่วไป
     * @authen true
     * @sitemap true
     */
    public function reportAuction();

    /**
     * @name reportIndustry
     * @uri /reportIndustry
     * @description M82 ประมูลอุตสาหกรรม
     * @authen true
     * @sitemap true
     */
    public function reportIndustry();

    /**
     * @name reportOrder
     * @uri /reportOrder
     * @description M83 คำสั่งซื้อ
     * @authen true
     * @sitemap true
     */
    public function reportOrder();

    /**
     * @name reportIndustry2
     * @uri /reportIndustry2
     * @description M84 ประมูลทั่วไปเข้าสู่อุตสาหกรรม
     * @authen true
     * @sitemap true
     */
    public function reportIndustry2();
}
