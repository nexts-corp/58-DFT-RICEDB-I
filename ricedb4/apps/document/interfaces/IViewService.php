<?php

namespace apps\document\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M90 เอกสาร
 */
interface IViewService {

    /**
     * @name auction
     * @uri /auction
     * @description M91 ประมูลทั่วไป
     * @authen true
     * @sitemap true
     */
    public function auction();

    /**
     * @name industry
     * @uri /industry
     * @description M92 ประมูลอุตสาหกรรม
     * @authen true
     * @sitemap true
     */
    public function industry();

    /**
     * @name order
     * @uri /order
     * @description M93 คำสั่งซื้อ
     * @authen true
     * @sitemap true
     */
    public function order();

    /**
     * @name industry2
     * @uri /industry2
     * @description M94 ประมูลทั่วไปอุตฯ
     * @authen true
     * @sitemap true
     */
    public function industry2();
  
}
