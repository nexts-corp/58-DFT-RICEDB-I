<?php

namespace apps\industry\interfaces;

/**
 * @name IBidderInfoService
 * @uri /bidderInfo
 * @description ข้อมูลผู้เสนอซื้อ
 */
interface IBidderInfoService {

    /**
     * @name listsBidderType
     * @uri /listsBidderType
     * @return String[] lists Description
     * @description ประเภทผู้เสนอซื้อ
     * @authen true
     * @resource 1111
     */
    public function listsBidderType();

    /**
     * @name listsRegister
     * @uri /listsRegister
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     * @resource 1100
     */
    
    public function listsRegister();

    /**
     * @name listsPass
     * @uri /listsPass
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     * @resource 1111
     */
    public function listsPass();

    /**
     * @name search
     * @uri /search
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอราคาที่ลงทะเบียนแล้ว ณ การประมูลล่าสุด
     * @authen true
     * @resource 1100
     */
    public function search($bidderInfo);

    /**
     * @name insert
     * @uri /insert
     * @param String[] bidderInfo Description
     * @param String[] bidderHistory Description
     * @param file file Description
     * @return boolean add Description
     * @description เพิ่มข้อมูลผู้เสนอราคารายใหม่
     * @authen true
     * @resource 1100
     */
    public function insert($bidderInfo, $bidderHistory, $file);

    /**
     * @name update
     * @uri /update
     * @param String[] bidderInfo Description
     * @param String[] bidderHistory Description
     * @param file file Description
     * @param String fileUpload Description
     * @return boolean update Description
     * @description อัพเดทข้อมูลผู้เสนอราคา
     * @authen true
     * @resource 1100
     **/
    public function update($bidderInfo, $bidderHistory, $file, $fileUpload);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\BidderInfo bidderInfo Description
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return boolean delete Description
     * @description ลบข้อมูลผู้เสนอราคา
     * @authen true
     * @resource 1100
     **/
    public function delete($bidderInfo, $bidderHistory);
    
    /**
     * @name changeCheckIn
     * @uri /changeCheckIn
     * @param apps\common\entity\BidderHistory bidderHistory Description
     * @return boolean save Description
     * @description อัพเดทข้อมูลผู้เสนอราคา
     * @authen true
     * @resource 1100
     **/
    public function changeCheckIn($bidderHistory);
}
