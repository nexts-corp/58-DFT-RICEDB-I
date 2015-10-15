<?php
namespace apps\auction\interfaces;

/**
 * @name IAutoUpdate
 * @uri /autoupdate
 * @description ประมวลผลการประมูล
 */
interface IAutoUpdate {
    
    /**
     * @name update
     * @uri /update
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function update();
    
    /**
     * @name checkupdate
     * @uri /checkupdate
     * @return string[] lists Description
     * @description คลังที่ถูกเสนอซื้อ + FV
     */
    public function checkupdate();
}
