<?php

namespace apps\warehouse\interfaces;

/**
 * @name IViewInventoryService
 * @uri /viewInventory
 * @description ประมูล
 */
interface IViewInventoryService {
    /**
     * @name project
     * @uri /project
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function project();

    /**
     * @name province
     * @uri /province
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function province();

    /**
     * @name type
     * @uri /type
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function type();

    /**
     * @name grade
     * @uri /grade
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function grade();

    /**
     * @name silo
     * @uri /silo
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function silo();

    /**
     * @name all
     * @uri /all
     * @param String[] columns Description
     * @param integer draw Description
     * @param integer start Description
     * @param integer length Description
     * @return String[] draw Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function all($columns, $draw, $start, $length);

    /**
     * @name lkProject
     * @uri /lkProject
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkProject();

    /**
     * @name lkProvince
     * @uri /lkProvince
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkProvince();

    /**
     * @name lkType
     * @uri /lkType
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkType();

    /**
     * @name lkGrade
     * @uri /lkGrade
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function lkGrade();
} 