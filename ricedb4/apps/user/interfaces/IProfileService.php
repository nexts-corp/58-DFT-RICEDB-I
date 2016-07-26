<?php

namespace apps\user\interfaces;

/**
 * @name IProfileService
 * @uri /profile
 * @description ข้อมูลเจ้าหน้าที่
 */
interface IProfileService {
    /**
     * @name get
     * @uri /get
     * @param String username
     * @return apps\common\entity\User user
     * @description ข้อมูลส่วนตัว
     * @authen true
     **/
    public function get($username);
   
    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\User user Description
     * @return boolean update Description
     * @description อัพเดทข้อมูลเจ้าหน้าที่
     * @authen true
     **/
    public function update($user);

    
}
