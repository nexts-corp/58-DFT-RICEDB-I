<?php

namespace apps\industry\interfaces;

/**
 * @name IItemService
 * @uri /item
 * @description ประมูล
 */
interface IItemService {
//    /**
//     * @name listsProject
//     * @uri /listsProject
//     * @return String[] lists Description
//     * @description รายชื่อปีโครงการที่มีในการประมูลข้าวครั้งนี้
//     */
//    public function listsProject();
//    /**
//     * @name listsType
//     * @uri /listsType
//     * @param string projectId Description
//     * @return String[] lists Description
//     * @description รายชื่อชนิดข้าวที่มีในปีโครงการนี้และประมูลข้าวครั้งนี้
//     */
//    public function listsType($projectId);

    /**
     * @name listsProvince
     * @uri /listsProvince
     * @return String[] lists Description
     * @description รายชื่อจังหวัดในการประมูลข้าวครั้งนี้
     * @authen true
     */
    public function listsProvince();

    /**
     * @name listsSilo
     * @uri /listsSilo
     * @param string provinceId Description
     * @param string bidderHistoryId Description
     * @return String[] lists Description
     * @description รายชื่อคลังที่มีในการประมูลข้าวครั้งนี้
     * @authen true
     */
    public function listsSilo($provinceId, $bidderHistoryId);

    /**
     * @name getDataSilo
     * @uri /getDataSilo
     * @param string provinceId Description
     * @param string silo Description
     * @param string assId Description
     * @return String[] lists Description
     * @description ข้อมูลคลัง
     * @authen true
     */
    public function getDataSilo($provinceId, $silo,$assId);

    /**
     * @name getRFVSilo
     * @uri /getRFVSilo
     * @param string provinceId Description
     * @param string silo Description
     * @param string assId Description
     * @return String[] lists Description
     * @description ข้อมูลคลัง + ราคาขั้นต่ำ
     * @authen true
     */
    public function getRFVSilo($provinceId, $silo,$assId);

    /**
     * @name insertItem
     * @uri /insertItem
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return boolean add Description
     * @description เพิ่มคลังที่เสนอของผู้ประมูล
     * @authen true
     */
    public function insertItem($bidderItem);

    /**
     * @name listsBidderItemAll
     * @uri /listsBidderItemAll
     * @return string[] lists Description
     * @description รายชื่อผู้ที่เสนอราคาที่ผ่าน Property2
     * @authen true
     */
    public function listsBidderItemAll();

    /**
     * @name listsBidderItem
     * @uri /listsBidderItem
     * @param string bidderHistoryId Description
     * @return string[] bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     */
    public function listsBidderItem($bidderHistoryId);

    /**
     * @name deleteItem
     * @uri /deleteItem
     * @param string bidderItemId Description
     * @return string delete Description
     * @description ลบคลังที่ผู้ประมูลเสนอราคาซื้อ
     * @authen true
     */
    public function deleteItem($bidderItemId);

    /**
     * @name saveAuctionPrice
     * @uri /saveAuctionPrice
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     */
    public function saveAuctionPrice($bidderPrice);

    /**
     * @name saveAuctionPriceCF
     * @uri /saveAuctionPriceCF
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     */
    public function saveAuctionPriceCF($bidderPrice);

    /**
     * @name deleteAuctionPrice
     * @uri /deleteAuctionPrice
     * @param apps\common\entity\BidderPriceSilo bidderPrice Description
     * @return string delete Description
     * @description ลบราคาที่เสนอซื้อ
     * @authen true
     */
    public function deleteAuctionPrice($bidderPrice);

    /**
     * @name listsBidderItem
     * @uri /listsBidderItemPrice
     * @param string bidderHistoryId Description
     * @return apps\common\entity\BidderItem bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     */
    public function listsBidderItemPrice($bidderHistoryId);

    /**
     * @name listsBidderItem
     * @uri /listsBidderItemPriceAll
     * @param string bidderHistoryId Description
     * @return apps\common\entity\BidderItem bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     */
    public function listsBidderItemPriceAll($bidderHistoryId);

    /**
     * @name listsBidderItemPriceCF
     * @uri /listsBidderItemPriceCF
     * @param string[] bidderPrice Description
     * @return string[] list Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true 
     */
    public function listsBidderItemPriceCF($bidderPrice);
    
    
      /**
     * @name processWin
     * @uri /process/win
     * @return string list Description
     * @description processWin
     * @authen true 
     */
    public function processWin();
}
