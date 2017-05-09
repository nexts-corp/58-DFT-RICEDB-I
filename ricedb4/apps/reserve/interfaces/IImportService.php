<?php

namespace apps\reserve\interfaces;

/**
 * @name IImportService
 * @uri /import
 * @description ประมูล
 */
interface IImportService {

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
     * @param integer statusId
     * @param String[] column Description
     * @return boolean import Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function import($file, $sheet, $row, $statusId, $column);
}
