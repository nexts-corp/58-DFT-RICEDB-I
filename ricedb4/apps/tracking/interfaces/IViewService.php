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
     * @name return
     * @uri /return
     * @description  คืนหลักค้ำประกันที่เหลือ
     */
    public function returns();

    /**
     * @name follow
     * @uri /follow
     * @description  ติดตามปริมาณที่รับมอบแล้ว
     */
    public function follow();
}
