<?php
namespace apps\warehouse\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {
   
    /**
     * @name warehouseInfo
     * @uri /warehouseInfo
     * @description ข้อมูลคลังสินค้า
     */ 
    public function warehouseInfo();
    
    /**
     * @name warehouseImport
     * @uri /warehouseImport
     * @description ข้อมูลคลังสินค้า
     */ 
    public function warehouseImport();
    
    /**
     * @name viewRicePrice
     * @uri /viewRicePrice
     * @description ข้อมูลคลังสินค้า
     */ 
    public function viewRicePrice();
    
    /**
     * @name viewRicePriceAvg
     * @uri /viewRicePriceAvg
     * @description ข้อมูลคลังสินค้า
     */ 
    public function viewRicePriceAvg();
    
    /**
     * @name viewInventory
     * @uri /viewInventory
     * @description ข้อมูลคลังสินค้า
     */ 
    public function viewInventory();
    
}
