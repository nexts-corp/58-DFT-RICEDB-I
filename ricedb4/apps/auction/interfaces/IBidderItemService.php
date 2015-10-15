<?php

namespace apps\auction\interfaces;

/**
 * @name IBidderItemService
 * @uri /bidderItem
 * @description ข้อมูลผู้เสนอซื้อ
 */
interface IBidderItemService {
    /**
     * @name listsCountItem
     * @uri /listsCountItem
     * @return string[] lists Description
     * @description รายชื่อผู้ที่เสนอราคาที่ผ่าน Property2
     * @authen true
     * @resource 1110
     */
    public function listsCountItem();

    /**
     * @name listsBidderItem
     * @uri /listsBidderItem
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return string[] bidderItem Description
     * @description คลังที่ถูกเสนอซื้อ
     * @authen true
     * @resource 1110
     */
    public function listsBidderItem($bidderHistory);

    /**
     * @name listsProvince
     * @uri /listsProvince
     * @return String[] lists Description
     * @description รายชื่อจังหวัดในการประมูลข้าวครั้งนี้
     * @authen true
     * @resource 1110
     */
    public function listsProvince();

    /**
     * @name listsSilo
     * @uri /listsSilo
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @param apps\common\entity\Province province Description
     * @return String[] lists Description
     * @description รายชื่อคลังที่มีในการประมูลข้าวครั้งนี้
     * @authen true
     * @resource 1110
     */
    public function listsSilo($bidderHistory, $province);

    /**
     * @name getSiloData
     * @uri /getSiloData
     * @param apps\common\entity\BidderItem bidderItem Description
     * @param apps\common\entity\Province province Description
     * @return String[] lists Description
     * @description รายละเอียดคลัง
     * @authen true
     * @resource 1110
     */
    public function getSiloData($bidderItem, $province);

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return boolean add Description
     * @description เพิ่มคลังที่เสนอของผู้ประมูล
     * @authen true
     * @resource 1110
     */
    public function insert($bidderItem);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\BidderItem bidderItem Description
     * @return string delete Description
     * @description ลบคลังที่ผู้ประมูลเสนอราคาซื้อ
     * @authen true
     * @resource 1110
     */
    public function delete($bidderItem);
}
