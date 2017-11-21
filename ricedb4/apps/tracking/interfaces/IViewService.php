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
     * @description M71 คืนหลักค้ำประกันก่อนอนุมัติคลัง
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function returns();
    
    /**
     * @name returnFinance
     * @uri /returnFinance
     * @description M72 คืนหลักค้ำประกันหลังอนุมัติคลัง
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function returnFinance();
    
    /**
     * @name forfeit
     * @uri /forfeit
     * @description M73 ริบหลักค้ำประกัน
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function forfeit();

    /**
     * @name approveAuction
     * @uri /approveAuction
     * @description M74 อนุมัติคลังสินค้าจากการประมูล
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function approveAuction();

    /**
     * @name approveSell
     * @uri /approveSell
     * @description M75 อนุมัติคลังสินค้าจากรูปแบบอื่น
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function approveSell();


    /**
     * @name follow
     * @uri /follow
     * @description M76 ติดตามปริมาณที่รับมอบ
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function follow();
    
    /**
     * @name follow2
     * @uri /follow2
     * @description M77 ปริมาณการส่งมอบ(ใหม่)
     * @authen true
     * @resource 10001000
     * @sitemap true
     */
    public function follow2();
    
    
}
