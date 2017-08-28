<?php

namespace apps\warehouse\interfaces;

/**
 * @name HistoryService
 * @uri /history
 * @description history service
 */
interface IHistoryService {

    /**
     * @name find
     * @uri /find
     * @param String warehouse
     * @return apps\common\entity\AuctionWarehouse warehouse
     * @description หาคลังที่ต้องการประวัติ
     * @authen true
     */
    public function find($warehouse);

    /**
     * @name get
     * @uri /get
     * @param String warehouse
     * @return apps\common\model\DataAuction auction
     * @description ประวัติคลังสินค้า
     * @authen true
     */
    public function get($warehouse);
    
    /**
     * @name export
     * @uri /export
     * @param string warehouse
     * @return file export
     * @description  exportExcel
     */
    public function export($warehouse);
}
