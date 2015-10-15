<?php
namespace apps\home\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {
   
    /**
     * @name inventory
     * @uri /inventory
     * @description ข้อมูลคลังสินค้า
     */ 
    public function inventory();
    
}
