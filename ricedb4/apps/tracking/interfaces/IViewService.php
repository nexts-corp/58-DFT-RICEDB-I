<?php

namespace apps\tracking\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description M70 ติดตาม
 */
interface IViewService {
    
    /**
     * @name return
     * @uri /return
     * @description M71 คืนหลักค้ำประกันผู้ที่ไม่ชนะ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function returns();
    
    /**
     * @name returnFinance
     * @uri /returnFinance
     * @description M72 คืนหลักค้ำประกันผู้ที่ชนะ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function returnFinance();
    
    /**
     * @name forfeit
     * @uri /forfeit
     * @description M73 ริบหลักค้ำประกัน
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function forfeit();

    /**
     * @name approveAuction
     * @uri /approveAuction
     * @description M74 อนุมัติคลังสินค้าจากการประมูล
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function approveAuction();

    /**
     * @name approveSell
     * @uri /approveSell
     * @description M75 อนุมัติคลังสินค้าจากรูปแบบอื่น
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function approveSell();


    /**
     * @name follow
     * @uri /follow
     * @description M76 ติดตามปริมาณที่รับมอบ
     * @authen true
     * @resource 10000000
     * @sitemap true
     */
    public function follow();
    
    
}
