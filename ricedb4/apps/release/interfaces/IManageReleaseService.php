<?php
namespace apps\release\interfaces;

/**
 * @name ManageReleaseService
 * @uri /manage
 * @description floorPrice service
 */
interface IManageReleaseService {

    /**
     * @name listsReserve
     * @uri /listsReserve
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function listsReserve();

    /**
     * @name lkRelease
     * @uri /lkRelease
     * @return String[] lists Description
     * @description รายการระบายข้าว
     */
    public function lkRelease();

    /**
     * @name listsRelease
     * @uri /listsRelease
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function listsRelease();

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\Status status Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลรายการระบายข้าว
     */
    public function insert($status);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Status status Description
     * @return boolean update Description
     * @description เพิ่มข้อมูลรายการระบายข้าว
     */
    public function update($status);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\Status status Description
     * @return boolean delete Description
     * @description เพิ่มข้อมูลรายการระบายข้าว
     */
    public function delete($status);
} 