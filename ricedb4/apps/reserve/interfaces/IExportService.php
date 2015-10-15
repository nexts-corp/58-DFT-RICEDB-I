<?php
namespace apps\reserve\interfaces;

/**
 * @name ExportService
 * @uri /export
 * @description reserve service
 */
interface IExportService {
    
    /**
     * @name listsReserve
     * @uri /listsReserve
     * @return String[] lists Description
     * @description รายการสำรองข้าว
     */
    public function listsReserve();

    /**
     * @name export
     * @uri /export
     * @param apps\commom\entity\ReserveList reserveList Description
     * @return file export Description
     * @description รายการสำรองข้าว
     */
    public function export($reserveList);
} 