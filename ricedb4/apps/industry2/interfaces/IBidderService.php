<?php

namespace apps\industry2\interfaces;

/**
 * @name IBidderService
 * @uri /bidder
 * @description ประมูล
 */
interface IBidderService {

    /**
     * @name listsBidderRegister
     * @uri /listsBidderRegister
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     */
    public function listsBidderRegister();

    /**
     * @name listsBidderPass
     * @uri /listsBidderPass
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     */
    public function listsBidderPass();

    /**
     * @name insertBidder
     * @uri /insertBidder
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลผู้เสนอราคารายใหม่
     * @authen true 
     */
    public function insertBidder($bidderInfo, $bidderHistory);

    /**
     * @name updateBidder
     * @uri /updateBidder
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return boolean update Description
     * @description อัพเดทข้อมูลผู้เสนอราคา
     * @authen true 
     **/
    public function updateBidder($bidderInfo, $bidderHistory);

    /**
     * @name deleteBidder
     * @uri /deleteBidder
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return boolean delete Description
     * @description อัพเดทข้อมูลผู้เสนอราคา
     * @authen true 
     **/
    public function deleteBidder($bidderInfo, $bidderHistory);
}
