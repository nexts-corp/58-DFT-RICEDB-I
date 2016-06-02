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
     * @return FloorValue[] lists Description
     * @description hello
     */
    public function getFloorValue($auction);
    
    /**
     * @name getFloorValueSilo
     * @uri /getFloorValueSilo
     * @param String auction Description
     * @return FloorValue[] lists Description
     * @description hello
     */
    public function getFloorValueSilo($auction);

    /**
     * @name exportStack
     * @uri /exportStack
     * @param String auction Description
     * @return file export Description
     * @description  export excel
     */
    public function exportStack($auction);
    
     /**
     * @name exportWarehouse
     * @uri /exportWarehouse
     * @param String auction Description
     * @return file export Description
     * @description  export excel
     */
    public function exportWarehouse($auction);
} 