<?php
namespace apps\release\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M40 ระบายข้าว
 */
interface IViewService {
    
    /**
     * @name manageRelease
     * @uri /manageRelease
     * @description M41 รายการระบายข้าว
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function manageRelease();
    
    /**
     * @name manageDiscount
     * @uri /manageDiscount
     * @description M42 อัตราส่วนลด
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function manageDiscount();
    
      
    /**
     * @name manageShippingCost
     * @uri /manageShippingCost
     * @description M43 อัตราค่าขนส่ง
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function manageShippingCost();
    /**
     * @name chooseFloorValue
     * @uri /chooseFloorValue
     * @description M44 กำหนด Floor Value
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function chooseFloorValue();
    
     /**
     * @name compareFloorPrice
     * @uri /compareFloorPrice
     * @description M45 เปรียบเทียบ Floor Price
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function compareFloorPrice();
    
    /**
     * @name floorPrice
     * @uri /floorPrice
     * @description M46 Final Floor Price
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function floorPrice();
    
    /**
     * @name floorValue
     * @uri /floorValue
     * @description M47 ข้อมูลรายกอง
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function floorValue();
    
    /**
     * @name floorValueSilo
     * @uri /floorValueSilo
     * @description M48 ข้อมูลรายคลัง
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function floorValueSilo();

    
}
