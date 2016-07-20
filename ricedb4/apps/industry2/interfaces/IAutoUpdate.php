<?php
namespace apps\industry2\interfaces;

/**
 * @name IAutoUpdate
 * @uri /autoupdate
 * @description ประมวลผลการประมูล
 */
interface IAutoUpdate {
    
    /**
     * @name download
     * @uri /download
     * @return String lists
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function download();
    
   
	
	/**
     * @name upload
     * @uri /upload
	 * @param apps\common\model\SQLUpdate lists
     * @return string status
     * @description คลังที่ถูกเสนอซื้อ + FV
     */
    public function upload($lists);
	
	 /**
     * @name checkupdate
     * @uri /checkupdate
     * @return string status
     * @description คลังที่ถูกเสนอซื้อ + FV
     */
    public function checkupdate();
}
