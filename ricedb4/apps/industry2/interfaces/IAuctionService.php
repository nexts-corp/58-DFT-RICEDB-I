<?php

namespace apps\industry2\interfaces;

/**
 * @name IAuctionService
 * @uri /auction
 * @description ประมูล
 */
interface IAuctionService {

    /**
     * @name check
     * @uri /check
     * @return String check Description
     * @description ปิดการประมูล
     * @authen true
     */
    public function check();

    /**
     * @name close
     * @uri /close
     * @return String close Description
     * @description ปิดการประมูล
     * @authen true
     */
    public function close();
}
