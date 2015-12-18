<?php

namespace apps\tracking\interfaces;

/**
 * @name IForfeitService
 * @uri /forfeit
 * @description ประมูล
 */
interface IForfeitService {
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
     * @name update
     * @uri /update
     * @param apps\common\entity\BidderPayment bidderPayment
     * @return boolean update
     * @description เปลี่ยนสถานะหลักค้ำประกัน
     */
    public function update($bidderPayment);
}
