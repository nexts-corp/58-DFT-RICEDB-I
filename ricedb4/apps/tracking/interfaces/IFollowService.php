<?php

namespace apps\tracking\interfaces;

/**
 * @name FollowService
 * @uri /follow
 * @description FollowService
 */
interface IFollowService {

    /**
     * @name export
     * @uri /export
     * @param string auccode
     * @param string associateId
     * @return string export
     * @description  export excel
     */
    public function export($auccode,$associateId);
    
     /**
     * @name get
     * @uri /get
     * @param string auccode
     * @param string associateId
     * @return string get
     * @description  get excel
     */
    public function get($auccode,$associateId);


}
