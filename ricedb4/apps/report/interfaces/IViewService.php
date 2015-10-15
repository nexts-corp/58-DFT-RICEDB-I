<?php
namespace apps\report\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {
   
    /**
     * @name reportAuction
     * @uri /reportAuction
     * @description  reportAuction
     */ 
    public function reportAuction();
    
     /**
     * @name stack
     * @uri /stack
     * @description  stack
     */ 
    public function stack();
    
     /**
     * @name warehouse
     * @uri /warehouse
     * @description  warehouse
     */ 
    public function warehouse();
}
