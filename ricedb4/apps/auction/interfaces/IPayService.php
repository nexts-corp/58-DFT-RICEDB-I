<?php

namespace apps\auction\interfaces;

/**
 * @name IPayService
 * @uri /payment
 * @description ประมูล
 */
interface IPayService {

    /**
     * @name listsBidderPayment
     * @uri /listsBidderPayment
     * @return String[] lists Description
     * @description รายชื่อจังหวัดในการประมูลข้าวครั้งนี้
     * @authen true
     */
    public function listsBidderPayment();

    /**
     * @name listsBank
     * @uri /listsBank
     * @return String[] lists Description
     * @description รายชื่อธนาคาร
     * @authen true
     */
    public function listsBank();

    /**
     * @name listsBidderGrt
     * @uri /listsBidderGrt
     * @param string bidderHistoryId Description
     * @return String[] lists Description
     * @description ลิสต์หลักค้ำประกันของผู้เสนอซื้อ
     * @authen true
     */
    public function listsBidderGrt($bidderHistoryId);

    /**
     * @name saveBidderPayment
     * @uri /saveBidderPayment
     * @param apps\common\entity\BidderPayment bidderPayment Description
     * @return boolean save Description
     * @description รายชื่อธนาคาร
     * @authen true
     */
    public function saveBidderPayment($bidderPayment);

    /**
     * @name deletePayment
     * @uri /deletePayment
     * @param string paymentId Description
     * @return boolean delete Description
     * @description ลบหลักค้ำประกัน
     * @authen true
     */
    public function deletePayment($paymentId);
}
