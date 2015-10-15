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
} 