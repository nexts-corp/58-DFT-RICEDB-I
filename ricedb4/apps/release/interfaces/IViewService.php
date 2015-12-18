<?php
namespace apps\release\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {
    
    /**
     * @name manageRelease
     * @uri /manageRelease
     * @description  manageRelease
     */ 
    public function manageRelease();

    /**
     * @name createRelease
     * @uri /createRelease
     * @description  createRelease
     */
    public function createRelease();
    
    /**
     * @name viewRelease
     * @uri /viewRelease
     * @description  createRelease
     */ 
    public function viewRelease();
    
    /**
     * @name manageDiscount
     * @uri /manageDiscount
     * @description  createRelease
     */ 
    public function manageDiscount();
    
    /**
     * @name manageShippingCost
     * @uri /manageShippingCost
     * @description  createRelease
     */ 
    public function manageShippingCost();
    
    /**
     * @name floorPrice
     * @uri /floorPrice
     * @description  floorPrice
     */ 
    public function floorPrice();
    
    /**
     * @name floorValue
     * @uri /floorValue
     * @description  floorValue
     */ 
    public function floorValue();
    
    /**
     * @name floorValueSilo
     * @uri /floorValueSilo
     * @description  floorValue
     */ 
    public function floorValueSilo();

    /**
     * @name compareFloorPrice
     * @uri /compareFloorPrice
     * @description  compareFloorPrice
     */
    public function compareFloorPrice();

    /**
     * @name chooseFloorValue
     * @uri /chooseFloorValue
     * @description  chooseFloorPrice
     */
    public function chooseFloorValue();
}
