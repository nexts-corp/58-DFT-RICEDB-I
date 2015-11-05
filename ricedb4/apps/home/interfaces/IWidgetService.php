<?php

namespace apps\home\interfaces;

/**
 * @name IWidgetService
 * @uri /widget
 * @description หน้าหลัก
 */
interface IWidgetService {
    /**
     * @name projectGroup
     * @uri /projectGroup
     * @return String[] lists Description
     * @description สินค้าคงคลังแยกตามปีโครงการ
     */
    public function projectGroup();

    /**
     * @name typeGroup
     * @uri /typeGroup
     * @return String[] lists Description
     * @description สินค้าคงคลังแยกตามชนิด
     */
    public function typeGroup();

    /**
     * @name gradeGroup
     * @uri /gradeGroup
     * @return String[] lists Description
     * @description สินค้าคงคลังแยกตามเกรด
     */
    public function gradeGroup();

    /**
     * @name ricePrice
     * @uri /ricePrice
     * @return String[] lists Description
     * @description ราคาข้าวที่อัพเดทล่าสุด
     */
    public function ricePrice();

    /**
     * @name auctionLatest
     * @uri /auctionLatest
     * @return String[] lists Description
     * @description ผลการประมูลครั้งล่าสุด
     */
    public function auctionLatest();

    /**
     * @name viewReserve
     * @uri /viewReserve
     * @return String[] lists Description
     * @description ปริมาณข้าวที่สำรองไว้
     */
    public function viewReserve();
}
