<?php

namespace apps\tracking\interfaces;

/**
 * @name IReturnService
 * @uri /return
 * @description ประมูล
 */
interface IReturnService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description การประมูล
     */
    public function listsAuction();

    /**
     * @name listsBidder
     * @uri /listsBidder
     * @param string auccode
     * @return String[] lists Description
     * @description รายชื่อผู้ที่มีหลักค้ำประกัน
     */
    public function listsBidder($auccode);
    
    /**
     * @name listsPayment
     * @uri /listsPayment
     * @param integer bidderHistoryId Description
     * @return String[] lists Description
     * @description รายชื่อผู้ที่มีหลักค้ำประกัน
     */
    public function listsPayment($bidderHistoryId);
    
    /**
     * @name listsWarehouse
     * @uri /listsWarehouse
     * @param integer bidderId Description
     * @param string auccode
     * @return String[] lists Description
     * @description รายชื่อคลังสินค้าที่ผู้เสนอซื้อเสนอราคา
     */
    public function listsWarehouse($bidderId,$auccode);
    
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\BidderPayment bidderPayment Description
     * @return boolean update Description
     * @description เปลี่ยนสถานะหลักค้ำประกัน
     */
    public function update($bidderPayment);
}
