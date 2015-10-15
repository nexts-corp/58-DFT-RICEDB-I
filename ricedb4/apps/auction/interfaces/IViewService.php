<?php

namespace apps\auction\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {    
    /**
     * @name bidderInfo
     * @uri /bidderInfo
     * @description  บันทึกข้อมูลผู้เสนอซื้อ
     * @authen true 
     */
    public function bidderInfo();
    
    /**
     * @name bidderItem
     * @uri /bidderItem
     * @description  บันทึกคลังพร้อมผู้เสนอซื้อ
     * @authen true 
     */
    public function bidderItem();
    
    /**
     * @name bidderPrice
     * @uri /bidderPrice
     * @description  บันทึกราคาเสนอซื้อ
     * @authen true 
     */
    public function bidderPrice();
    
    /**
     * @name bidderPayment
     * @uri /bidderPayment
     * @description ตรวจหลักประกันซอง
     * @authen true 
     */
    public function bidderPayment();
    
    /**
     * @name bidderAuction
     * @uri /bidderAuction
     * @description  ผลการประมูล
     * @authen true 
     */
    public function bidderAuction();
    
    /**
     * @name bidderPriceCF
     * @uri /bidderPriceCF
     * @description  ต่อรองราคา
     * @authen true 
     */
    public function bidderPriceCF();
    
    /**
     * @name bidderReturn
     * @uri /bidderReturn
     * @description  คืนหลักประกันซอง
     * @authen true 
     */
    public function bidderReturn();
    
    /**
     * @name bidderProperty
     * @uri /monitor/bidderProperty
     * @description  [ก่อนยื่นซอง] รายงานแสดงผู้เสนอซื้อ
     * @authen true 
     */
    public function bidderProperty();
    
     /**
     * @name bidderProperty2
     * @uri /monitor/bidderProperty2
     * @description  [หลังยื่นซอง] รายงานแสดงผู้เสนอซื้อ
     * @authen true 
     */
    public function bidderProperty2();
    
     /**
     * @name bidderPriceAll
     * @uri /monitor/bidderPriceAll
     * @description  [ก่อนต่อรองราคา] รายงานคลังสินค้าที่มีผู้เสนอซื้อ เรียงตามมูลค่าเสนอซื้อสูงสุด
     * @authen true 
     */
    public function bidderPriceAll();
    
    /**
     * @name bidderMaxPriceOne
     * @uri /monitor/bidderMaxPriceOne
     * @description  [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true 
     */
    public function bidderMaxPriceOne();
    
     /**
     * @name bidderMaxPriceOne2
     * @uri /monitor/bidderMaxPriceOne2
     * @description  [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true 
     */
    public function bidderMaxPriceOne2();
    
     /**
     * @name bidderMaxPriceMore
     * @uri /monitor/bidderMaxPriceMore
     * @description  [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และมูลค่าเสนอซื้อเท่ากัน
     * @authen true 
     */
    public function bidderMaxPriceMore();
    
     /**
     * @name bidderWinner
     * @uri /monitor/bidderWinner
     * @description  [หลังต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true 
     */
    public function bidderWinner();
    
     /**
     * @name bidderMonitor
     * @uri /monitor/bidderMonitor
     * @description  bidderMonitor
     * @authen true
     */
    public function bidderMonitor();  
     /**
     * @name closeAuction
     * @uri /closeAuction
     * @description จบการประมูล
     * @authen true
     */
    public function closeAuction(); 
}
