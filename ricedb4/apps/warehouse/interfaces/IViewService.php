<?php
namespace apps\warehouse\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M20 คลังสินค้า
 */
interface IViewService {
   
    /**
     * @name warehouseInfo
     * @uri /warehouseInfo
     * @description M21 ข้อมูลคลังสินค้า
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function warehouseInfo();
    
    /**
     * @name warehouseImport
     * @uri /warehouseImport
     * @description M22 นำเข้าข้อมูลคลังสินค้า
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function warehouseImport();

    /**
     * @name priceDaily
     * @uri /priceDaily
     * @description M23 ราคาข้าวประจำวัน
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function priceDaily();

    /**
     * @name viewRicePrice
     * @uri /viewRicePrice
     * @description M24 ข้อมูลราคาข้าว
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function viewRicePrice();
    
    /**
     * @name viewRicePriceAvg
     * @uri /viewRicePriceAvg
     * @description M25 ข้อมูลราคาข้าวเฉลี่ย
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function viewRicePriceAvg();
    
    /**
     * @name viewInventory
     * @uri /viewInventory
     * @description M26 สินค้าคงคลัง
     * @authen true
     * @resource 10000000
     * @sitemap true
     */ 
    public function viewInventory();
    
}
