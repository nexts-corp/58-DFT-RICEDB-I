<?php

namespace apps\warehouse\interfaces;

/**
 * @name IWarehouseImportService
 * @uri /warehouseImport
 * @description ประมูล
 */
interface IWarehouseImportService {
    /**
     * @name view
     * @uri /view
     * @return String[] lists Description
     * @param file file Description
     * @param integer sheet Description
     * @param integer row Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function view($file, $sheet, $row);

    /**
     * @name import
     * @uri /import
     * @param file file Description
     * @param integer sheet Description
     * @param integer row Description
     * @param String[] column Description
     * @return boolean import Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function import($file, $sheet, $row, $column);
} 