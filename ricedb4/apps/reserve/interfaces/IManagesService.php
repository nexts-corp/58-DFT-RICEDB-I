<?php

namespace apps\reserve\interfaces;

/**
 * @name ManagesService
 * @uri /manages
 * @description reserve service
 */
interface IManagesService {

    /**
     * @name lkReserve
     * @uri /lkReserve
     * @return String[] lists Description
     * @description รายการประเภทสำรองข้าว
     */
    public function lkReserve();

    /**
     * @name lkStatusReserv
     * @uri /lkStatusReserv
     * @return String[] lists Description
     * @description รายการประเภทสำรองข้าว
     */
    public function lkStatusReserv();

    /**
     * @name selectBook
     * @uri /select/book
     * @param String status_id
     * @param String book_id
     * @return boolean select
     * @description เลือกคลังสินค้า
     */
    public function selectBook($status_id, $book_id);

    /**
     * @name listsBook
     * @uri /lists/book
     * @param String status_id
     * @return boolean lists
     * @description คลังที่เลือกแล้ว
     */
    public function listsBook($status_id);

    /**
     * @name cancelBook
     * @uri /cancel/book
     * @param String book_id
     * @return boolean cancel
     * @description คลังที่เลือกแล้ว
     */
    public function cancelBook($book_id);

    /**
     * @name confirmStatus
     * @uri /confirm/status
     * @param String status_id
     * @return boolean confirm
     * @description ยืนยันรายการสำรอง
     */
    public function confirmStatus($status_id);

    /**
     * @name deleteStatus
     * @uri /delete/status
     * @param String status_id
     * @return boolean delete
     * @description ลบรายการสำรอง
     */
    public function deleteStatus($status_id);

    /**
     * @name insert
     * @uri /insert
     * @param apps\common\entity\Status status
     * @return boolean add Description
     * @description เพิ่มข้อมูลจองข้าว
     */
    public function insert($status);

    /**
     * @name export
     * @uri /export
     * @return file export Description
     * @description  export excel
     */
    public function export();
}
