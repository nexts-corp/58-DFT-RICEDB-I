<?php

namespace apps\industry\interfaces;

/**
 * @name IBidderPriceService
 * @uri /bidderPrice
 * @description ราคาเสนอซื้อ
 */
interface IBidderPriceService {
    /**
     * @name listsPrice
     * @uri /listsPrice
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return string[] bidderPrice Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     * @resource 1010
     */
    public function listsPrice($bidderHistory);

    /**
     * @name savePrice
     * @uri /savePrice
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     * @resource 1010
     */
    public function savePrice($bidderPrice);
}
