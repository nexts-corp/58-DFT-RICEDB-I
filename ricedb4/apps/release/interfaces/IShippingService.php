<?php
namespace apps\release\interfaces;

/**
 * @name DiscountService
 * @uri /shipping
 * @description floorPrice service
 */
interface IShippingService {
    
    /**
     * @name listsDiscount
     * @uri /listsAll
     * @return String[] lists Description
     * @description อัตราค่าขนส่งทั้งหมด
     */
    public function listsAll();

    /**
     * @name lkProvince
     * @uri /lkProvince
     * @return String[] lists Description
     * @description จังหวัด
     */
    public function lkProvince();

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\LogisticCost logisticCost Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลอัตราค่าขนส่ง
     */
    public function insert($logisticCost);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\LogisticCost logisticCost Description
     * @return boolean update Description
     * @description แก้ไขข้อมูลอัตราค่าขนส่ง
     */
    public function update($logisticCost);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\LogisticCost logisticCost Description
     * @return boolean delete Description
     * @description ลบข้อมูลอัตราค่าขนส่ง
     */
    public function delete($logisticCost);
}