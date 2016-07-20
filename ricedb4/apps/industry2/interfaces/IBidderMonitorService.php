<?php

namespace apps\industry2\interfaces;

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
     
     */
    public function listsProperty();

    /**
     * @name maxPriceOne
     * @uri /maxPriceOne
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และไม่เท่ากันในแต่ละคลัง
     * @authen true
     
     */
    public function maxPriceOne();
    
    
    /**
     * @name maxPriceOne2
     * @uri /maxPriceOne2
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และไม่เท่ากันในแต่ละคลัง
     * @authen true
     
     */
    public function maxPriceOne2();

    /**
     * @name maxPriceMore
     * @uri /maxPriceMore
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด และเท่ากันในแต่ละคลัง
     * @authen true
     
     */
    public function maxPriceMore();

    /**
     * @name winner
     * @uri /winner
     * @return String[] lists Description
     * @description คลังที่มีผู้ชนะสูงสุด หลังการต่อรอง
     * @authen true
     
     */
    public function winner();

    /**
     * @name priceAll
     * @uri /priceAll
     * @return String[] lists Description
     * @description คลังที่มีการเสนอซื้อ
     * @authen true
     
     */
    public function priceAll();
}
