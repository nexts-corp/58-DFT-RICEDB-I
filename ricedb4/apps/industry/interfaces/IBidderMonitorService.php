<?php

namespace apps\industry\interfaces;

/**
 * @name IBidderMonitorService
 * @uri /bidderMonitor
 * @description ข้อมูลผู้เสนอซื้อ
 */
interface IBidderMonitorService {

    /**
     * @name listsProperty
     * @uri /listsProperty
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     * @resource 1111
     */
    public function listsProperty();

    /**
     * @name maxPriceOne
     * @uri /maxPriceOne
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และไม่เท่ากันในแต่ละคลัง
     * @authen true
     * @resource 1111
     */
    public function maxPriceOne();
    
    
    /**
     * @name maxPriceOne2
     * @uri /maxPriceOne2
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และไม่เท่ากันในแต่ละคลัง
     * @authen true
     * @resource 1111
     */
    public function maxPriceOne2();

    /**
     * @name maxPriceMore
     * @uri /maxPriceMore
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และเท่ากันในแต่ละคลัง
     * @authen true
     * @resource 1111
     */
    public function maxPriceMore();

    /**
     * @name winner
     * @uri /winner
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด หลังการต่อรอง
     * @authen true
     * @resource 1111
     */
    public function winner();

    /**
     * @name priceAll
     * @uri /priceAll
     * @return String[] lists Description
     * @description คลังที่มีการเสนอซื้อ
     * @authen true
     * @resource 1111
     */
    public function priceAll();
}
