<?php

namespace apps\warehouse\interfaces;

/**
 * @name IWarehouseInfoService
 * @uri /warehouseInfo
 * @description ประมูล
 */
interface IWarehouseInfoService {
    /**
     * @name listsAllRice
     * @uri /listsAllRice
     * @param String[] columns Description
     * @param integer draw Description
     * @param integer start Description
     * @param integer length Description
     * @return String[] draw Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsAllRice($columns, $draw, $start, $length);

    /**
     * @name listsProject
     * @uri /listsProject
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsProject();

    /**
     * @name listsZone
     * @uri /listsZone
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsZone();

    /**
     * @name listsProvince
     * @uri /listsProvince
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsProvince();

    /**
     * @name listsType
     * @uri /listsType
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsType();

    /**
     * @name listsSilo
     * @uri /listsSilo
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsSilo();

    /**
     * @name listsGrade
     * @uri /listsGrade
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsGrade();

    /**
     * @name listsStatus
     * @uri /listsStatus
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsStatus();

    /**
     * @name listsAssociate
     * @uri /listsAssociate
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function listsAssociate();

    /**
     * @name riceInfo
     * @uri /riceInfo
     * @param integer id Description
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function riceInfo($id);

    /**
     * @name select
     * @uri /select
     * @param integer id Description
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function select($id);

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\RiceInfo riceInfo Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลผู้เสนอราคารายใหม่
     */
    public function insert($riceInfo);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\RiceInfo riceInfo Description
     * @return boolean update Description
     * @description เพิ่มข้อมูลผู้เสนอราคารายใหม่
     */
    public function update($riceInfo);

    /**
     * @name delete
     * @uri /delete
     * @param integer id Description
     * @return boolean delete Description
     * @description เพิ่มข้อมูลผู้เสนอราคารายใหม่
     */
    public function delete($id);
}