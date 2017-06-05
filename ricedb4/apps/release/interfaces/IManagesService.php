<?php

namespace apps\release\interfaces;

/**
 * @name ManagesService
 * @uri /manages
 * @description release service
 */
interface IManagesService {

    /**
     * @name lkStatusReserv
     * @uri /lkStatusReserv
     * @return String[] lists Description
     * @description รายการประเภทสำรองข้าว
     */
    public function lkStatusReserv();

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\Status status
     * @return boolean update
     * @description รายการประเภทสำรองข้าว
     */
    public function update($status);

    /**
     * @name close
     * @uri /close
     * @param string statusCode
     * @return boolean close
     * @description รายการประเภทสำรองข้าว
     */
    public function close($statusCode);
}
