<?php

namespace apps\tracking\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {

    /**
     * @name approveAuction
     * @uri /approveAuction
     * @description  อนุมัติคลังสินค้า
     */
    public function approveAuction();

    /**
     * @name approveSell
     * @uri /approveSell
     * @description  อนุมัติคลังสินค้า
     */
    public function approveSell();

    /**
     * @name return
     * @uri /return
     * @description  คืนหลักค้ำประกันที่เหลือ
     */
    public function returns();
    
    /**
     * @name returnFinance
     * @uri /returnFinance
     * @description  คืนหลักค้ำประกันจากกองคลัง
     */
    public function returnFinance();

    /**
     * @name follow
     * @uri /follow
     * @description  ติดตามปริมาณที่รับมอบแล้ว
     */
    public function follow();
    
    /**
     * @name forfeit
     * @uri /forfeit
     * @description  ริบหลักค้ำประกัน
     */
    public function forfeit();
}
