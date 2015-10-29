<?php

namespace apps\tracking\interfaces;

/**
 * @name ViewService
 * @uri /view
 * @description ViewService
 */
interface IViewService {

    /**
     * @name approve
     * @uri /approve
     * @description  อนุมัติคลังสินค้า
     */
    public function approve();

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
