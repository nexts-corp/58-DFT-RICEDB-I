<?php

namespace apps\industry2\interfaces;

/**
 * @name IBidderAuctionService
 * @uri /bidderAuction
 * @description ประมวลผลการประมูล
 */
interface IBidderAuctionService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @param String bidderHistoryId
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     * @authen true
     */
    public function listsAuction($bidderHistoryId);

    /**
     * @name listsBidderPriceCF
     * @uri /listsBidderPriceCF
     * @param apps\common\entity\BidderItem bidderItem Description
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @return string[] lists Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     */
    public function listsBidderPriceCF($bidderItem, $bidderInfo);

    /**
     * @name savePriceCF
     * @uri /savePriceCF
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     */
    public function savePriceCF($bidderPrice);

    /**
     * @name deletePriceCF
     * @uri /deletePriceCF
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string delete Description
     * @description ลบราคาที่เสนอซื้อ
     * @authen true
     */
    public function deletePriceCF($bidderPrice);

    /**
     * @name listsBidderMax
     * @uri /listsBidderMax
     * @return String[] lists
     * @description รายชื่อผู้เสนอราคาสูงสุด
     * @authen true

     */
    public function listsBidderMax();
}
