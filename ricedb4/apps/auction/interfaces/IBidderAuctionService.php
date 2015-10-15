<?php

namespace apps\auction\interfaces;

/**
 * @name IBidderAuctionService
 * @uri /bidderAuction
 * @description ประมวลผลการประมูล
 */
interface IBidderAuctionService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     * @authen true
     * @resource 1010
     */
    public function listsAuction();
    
    /**
     * @name listsBidderPriceCF
     * @uri /listsBidderPriceCF
     * @param apps\common\entity\BidderItem bidderItem Description
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @return string[] lists Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     * @resource 1010
     */
    public function listsBidderPriceCF($bidderItem, $bidderInfo);
    
    /**
     * @name savePriceCF
     * @uri /savePriceCF
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     * @resource 1010
     */
    public function savePriceCF($bidderPrice);
    
    /**
     * @name deletePriceCF
     * @uri /deletePriceCF
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string delete Description
     * @description ลบราคาที่เสนอซื้อ
     * @authen true
     * @resource 1010
     */
    public function deletePriceCF($bidderPrice);
}
