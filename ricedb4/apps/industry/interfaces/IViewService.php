<?php

namespace apps\industry\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M60 ประมูลอุตฯ
 */
interface IViewService {    
    /**
     * @name bidderInfo
     * @uri /bidderInfo
     * @description M61 บันทึกข้อมูลผู้เสนอซื้อ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function bidderInfo();
    
    /**
     * @name bidderItem
     * @uri /bidderItem
     * @description M62 บันทึกคลังพร้อมผู้เสนอซื้อ
     * @authen true
     * @resource 11000000
     * @sitemap true
     */
    public function bidderItem();
    
    /**
     * @name bidderPrice
     * @uri /bidderPrice
     * @description M63 บันทึกราคาเสนอซื้อ
     * @authen true
     * @resource 10100000
     * @sitemap true
     */
    public function bidderPrice();
    
    /**
     * @name bidderPayment
     * @uri /bidderPayment
     * @description M64 ตรวจหลักประกันซอง
     * @authen true
     * @resource 10010000
     * @sitemap true
     */
    public function bidderPayment();
    
    /**
     * @name bidderAuction
     * @uri /bidderAuction
     * @description M65 ผลการประมูล
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function bidderAuction();
    
    /**
     * @name bidderPriceCF
     * @uri /bidderPriceCF
     * @description M66 ต่อรองราคา
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function bidderPriceCF();
    
    /**
     * @name bidderReturn
     * @uri /bidderReturn
     * @description M67 คืนหลักประกันซอง
     * @authen true
     * @resource 10010000
     * @sitemap true
     */
    public function bidderReturn();
      
     /**
     * @name closeAuction
     * @uri /closeAuction
     * @description M68 ปิดการประมูล
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function closeAuction(); 
    
    /**
     * @name bidderProperty
     * @uri /monitor/bidderProperty
     * @description [ก่อนยื่นซอง] รายงานแสดงผู้เสนอซื้อ
     * @authen true
     * @resource 10000000
     */
    public function bidderProperty();
    
     /**
     * @name bidderProperty2
     * @uri /monitor/bidderProperty2
     * @description [หลังยื่นซอง] รายงานแสดงผู้เสนอซื้อ
     * @authen true
     * @resource 10000000
     */
    public function bidderProperty2();
    
     /**
     * @name bidderPriceAll
     * @uri /monitor/bidderPriceAll
     * @description [ก่อนต่อรองราคา] รายงานคลังสินค้าที่มีผู้เสนอซื้อ เรียงตามมูลค่าเสนอซื้อสูงสุด
     * @authen true
     * @resource 10000000
     */
    public function bidderPriceAll();
    
    /**
     * @name bidderMaxPriceOne
     * @uri /monitor/bidderMaxPriceOne
     * @description [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true
     * @resource 10000000
     */
    public function bidderMaxPriceOne();
    
     /**
     * @name bidderMaxPriceOne2
     * @uri /monitor/bidderMaxPriceOne2
     * @description [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true
     * @resource 10000000
     */
    public function bidderMaxPriceOne2();
    
     /**
     * @name bidderMaxPriceMore
     * @uri /monitor/bidderMaxPriceMore
     * @description [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และมูลค่าเสนอซื้อเท่ากัน
     * @authen true
     * @resource 10000000
     */
    public function bidderMaxPriceMore();

    /**
     * @name bidderMaxPriceMore2
     * @uri /monitor/bidderMaxPriceMore2
     * @description [ก่อนต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และมูลค่าเสนอซื้อเท่ากัน
     * @authen true
     * @resource 10000000
     */
    public function bidderMaxPriceMore2();
    
     /**
     * @name bidderWinner
     * @uri /monitor/bidderWinner
     * @description [หลังต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true
     * @resource 10000000
     */
    public function bidderWinner();

    /**
     * @name bidderWinner2
     * @uri /monitor/bidderWinner2
     * @description [หลังต่อรองราคา] ผู้เสนอซื้อที่ผ่านมูลค่าขั้นต่ำ (Floor Value) และเสนอมูลค่าสูงสุด
     * @authen true
     * @resource 10000000
     */
    public function bidderWinner2();
    
   
}
