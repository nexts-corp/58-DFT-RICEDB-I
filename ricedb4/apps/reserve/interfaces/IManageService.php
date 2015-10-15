<?php
namespace apps\reserve\interfaces;

/**
 * @name ManageService
 * @uri /manage
 * @description reserve service
 */
interface IManageService {
    
    /**
     * @name lkReserve
     * @uri /lkReserve
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function lkReserve();

    /**
     * @name lkProject
     * @uri /lkProject
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkProject();

    /**
     * @name lkProvince
     * @uri /lkProvince
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkProvince();

    /**
     * @name lkType
     * @uri /lkType
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkType();

    /**
     * @name lkGrade
     * @uri /lkGrade
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkGrade();

    /**
     * @name listsReserve
     * @uri /listsReserve
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function listsReserve();

    /**
     * @name listsReserveByIndex
     * @uri /listsReserveByIndex
     * @param apps\common\entity\ReserveList reserveList Description
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function listsReserveByIndex($reserveList);

    /**
     * @name listsRiceCanReserve
     * @uri /listsRiceCanReserve
     * @param String[] columns Description
     * @param integer draw Description
     * @param integer start Description
     * @param integer length Description
     * @return String[] draw Description
     * @description รายการสำรองข้าว
     */
    public function listsRiceCanReserve($columns, $draw, $start, $length);

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\ReserveList reserveList Description
     * @param apps\common\entity\RiceReserve riceReserve Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลจองข้าว
     */
    public function insert($reserveList, $riceReserve);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\ReserveList reserveList Description
     * @param apps\common\entity\RiceReserve riceReserve Description
     * @return boolean update Description
     * @description แก้ไขข้อมูลจองข้าว
     */
    public function update($reserveList, $riceReserve);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\ReserveList reserveList Description
     * @return boolean delete Description
     * @description ลบข้อมูลจองข้าว
     */
    public function delete($reserveList);
} 