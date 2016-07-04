<?php

namespace apps\order\interfaces;

/**
 * @name ISaveService
 * @uri /save
 * @description ประมูล
 */
interface ISaveService {
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
     * @return String[] lists Description
     * @description ข้อมูลคลัง
     * @authen true
     */
    public function getDataSilo($provinceId, $silo);

    /**
     * @name getRFVSilo
     * @uri /getRFVSilo
     * @param string provinceId Description
     * @param string silo Description
     * @return String[] lists Description
     * @description ข้อมูลคลัง + ราคาขั้นต่ำ
     * @authen true
     */
    public function getRFVSilo($provinceId, $silo);

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
     * @name listsItem
     * @uri /listsItem
     * @return string[] lists Description
     * @description รายชื่อผู้ที่เสนอราคาที่ผ่าน Property2
     * @authen true
     */
    public function listsItem();

    /**
     * @name listsItemBidder
     * @uri /listsItemBidder
     * @param string bidderHistoryId Description
     * @return apps\common\entity\BidderItem bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     * @authen true
     */
    public function listsItemBidder($bidderHistoryId);
    
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
     * @name saveAuctionPrice1
     * @uri /saveAuctionPrice1
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     */
    public function saveAuctionPrice1($bidderItem);
    /**
     * @name saveAuctionPrice2
     * @uri /saveAuctionPrice2
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return string save Description
     * @description บันทึกราคาที่เสนอซื้อ
     * @authen true
     */
    public function saveAuctionPrice2($bidderItem);
}
