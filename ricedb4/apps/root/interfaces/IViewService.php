<?php
namespace apps\root\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M90 Root
 */
interface IViewService {
   
    /**
     * @name index
     * @uri /index
     * @description index
     * @authen true
     */ 
    public function index();
    
    
     /**
     * @name logout
     * @uri /logout
     * @description logout
     * @authen true
     */ 
    public function logout();
    
    
    

}
