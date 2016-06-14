<?php
namespace apps\report\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M80 รายงาน
 */
interface IViewService {
   
    /**
     * @name reportAuction
     * @uri /reportAuction
     * @description M81 รายงานการประมูล
     * @authen true
     * @sitemap true
     */ 
    public function reportAuction();
}
