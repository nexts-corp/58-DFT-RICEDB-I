<?php

namespace apps\reserve\interfaces;

/**
 * @name ConfirmService
 * @uri /confirm
 * @description reserve service
 */
interface IConfirmService {

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
     * @name export
     * @uri /export
     * @param String status_id
     * @return file export
     * @description export excel
     */
    public function export($status_id);

    /**
     * @name confirm
     * @uri /confirm
     * @param String status_id
     * @return boolean confirm
     * @description ยืนยันรายการสำรอง
     */
    public function confirm($status_id);

    /**
     * @name cancel
     * @uri /cancel
     * @param String status_id
     * @return boolean cancel
     * @description ลบรายการสำรอง
     */
    public function cancel($status_id);
}
