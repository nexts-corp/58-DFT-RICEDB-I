<?php

namespace apps\order\interfaces;

/**
 * @name IBidderReturnService
 * @uri /return
 * @description ประมูล
 */
interface IBidderReturnService {

    /**
     * @name listsBidder
     * @uri /listsBidder
     * @return String[] lists Description
     * @description รายชื่อผู้ที่มีหลักค้ำประกัน
     * @authen true
     */
    public function listsBidder();
    
    /**
     * @name listsPayment
     * @uri /listsPayment
     * @param integer bidderHistoryId Description
     * @return String[] lists Description
     * @description รายชื่อผู้ที่มีหลักค้ำประกัน
     * @authen true
     */
    public function listsPayment($bidderHistoryId);
    
    /**
     * @name listsWarehouse
     * @uri /listsWarehouse
     * @param integer bidderId Description
     * @return String[] lists Description
     * @description รายชื่อคลังสินค้าที่ผู้เสนอซื้อเสนอราคา
     * @authen true
     */
    public function listsWarehouse($bidderId);
    
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\BidderPayment bidderPayment Description
     * @return boolean update Description
     * @description เปลี่ยนสถานะหลักค้ำประกัน
     * @authen true
     */
    public function update($bidderPayment);
}
