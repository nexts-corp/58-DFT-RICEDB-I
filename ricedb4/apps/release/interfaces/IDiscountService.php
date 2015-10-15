<?php
namespace apps\release\interfaces;

/**
 * @name DiscountService
 * @uri /discount
 * @description floorPrice service
 */
interface IDiscountService {
    
    /**
     * @name listsDiscount
     * @uri /listsAll
     * @return String[] lists Description
     * @description ส่วนลดที่แบ่งตามชนิดและเกรดข้าวทั้งหมด
     */
    public function listsAll();
    
    /**
     * @name lkType
     * @uri /lkType
     * @return String[] lists Description
     * @description ชนิดข้าว
     */
    public function lkType();
    
    /**
     * @name lkGrade
     * @uri /lkGrade
     * @return String[] lists Description
     * @description เกรด
     */
    public function lkGrade();

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\DiscountRate discountRate Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลอัตราส่วนลด
     */
    public function insert($discountRate);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\DiscountRate discountRate Description
     * @return boolean update Description
     * @description แก้ไขข้อมูลอัตราส่วนลด
     */
    public function update($discountRate);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\DiscountRate discountRate Description
     * @return boolean delete Description
     * @description ลบข้อมูลอัตราส่วนลด
     */
    public function delete($discountRate);
} 