<?php
namespace apps\release\interfaces;

/**
 * @name FloorValueService
 * @uri /floorValue
 * @description floorPrice service
 */
interface IFloorValueService {
    /**
     * @name select
     * @uri /listsAuction
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function listsAuction();

    /**
     * @name getFloorValue
     * @uri /getFloorValue
     * @param String auction Description
     * @param String projectId Description
     * @param String provinceId Description
     * @param String typeId Description
     * @param String gradeId Description
     * @return FloorValue[] lists Description
     * @description hello
     */
    public function getFloorValue($auction,$projectId,$provinceId,$typeId,$gradeId);
    
    /**
     * @name getFloorValueSilo
     * @uri /getFloorValueSilo
     * @param String auction Description
     * @param String projectId Description
     * @param String provinceId Description
     * @param String typeId Description
     * @param String gradeId Description
     * @return FloorValue[] lists Description
     * @description hello
     */
    public function getFloorValueSilo($auction,$projectId,$provinceId,$typeId,$gradeId);
} 