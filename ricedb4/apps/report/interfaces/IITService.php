<?php

namespace apps\report\interfaces;

/**
 * @name IITService
 * @uri /it
 * @description ประมูล
 */
interface IITService {

    /**
     * @name warehouse
     * @uri /warehouse
     * @return string data Description
     * @description เมนูรายงาน
     */
    public function warehouse();

    /**
     * @name stack
     * @uri /stack
     * @return string data Description
     * @description เมนูรายงาน
     */
    public function stack();
}
