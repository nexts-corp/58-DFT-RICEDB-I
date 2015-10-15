<?php

namespace apps\auction\interfaces;

/**
 * @name IBidderPaymentService
 * @uri /bidderPayment
 * @description ราคาเสนอซื้อ
 */
interface IBidderPaymentService {
    /**
     * @name listsPayment
     * @uri /listsPayment
     * @return String[] lists Description
     * @description หลักประกัน 2%
     * @authen true
     * @resource 1001
     */
    public function listsPayment();

    /**
     * @name listsItemPrice
     * @uri /listsItemPrice
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return string[] bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ
     * @authen true
     * @resource 1001
     */
    public function listsItemPrice($bidderHistory);

    /**
     * @name listsBank
     * @uri /listsBank
     * @return string[] lists Description
     * @description รายชื่อธนาคาร
     * @authen true
     * @resource 1001
     */
    public function listsBank();
    
    /**
     * @name listsBidderGrt
     * @uri /listsBidderGrt
     * @param string bidderHistoryId Description
     * @return String[] lists Description
     * @description ลิสต์หลักค้ำประกันของผู้เสนอซื้อ
     * @authen true
     * @resource 1001
     */
    public function listsBidderGrt($bidderHistoryId);
    
    /**
     * @name saveBidderPayment
     * @uri /saveBidderPayment
     * @param apps\common\entity\BidderPayment bidderPayment Description
     * @return boolean save Description
     * @description รายชื่อธนาคาร
     * @authen true
     * @resource 1001
     */
    public function saveBidderPayment($bidderPayment);

    /**
     * @name deletePayment
     * @uri /deletePayment
     * @param string paymentId Description
     * @return boolean delete Description
     * @description ลบหลักค้ำประกัน
     * @authen true
     * @resource 1001
     */
    public function deletePayment($paymentId);
    
    /**
     * @name changeReserved
     * @uri /changeReserved
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return string save Description
     * @description ลบคลังที่ผู้ประมูลเสนอราคาซื้อ
     * @authen true
     * @resource 1001
     */
    public function changeReserved($bidderItem);
}
