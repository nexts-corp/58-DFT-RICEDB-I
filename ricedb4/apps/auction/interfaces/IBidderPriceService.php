<?php

namespace apps\auction\interfaces;

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
     
     */
    public function listsPrice($bidderHistory);

    /**
     * @name savePrice
     * @uri /savePrice
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     
     */
    public function savePrice($bidderPrice);
}
