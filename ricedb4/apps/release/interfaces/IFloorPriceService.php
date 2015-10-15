<?php
namespace apps\release\interfaces;

/**
 * @name FloorPriceService
 * @uri /floorPrice
 * @description floorPrice service
 */
interface IFloorPriceService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function listsAuction();

    /**
     * @name getFloorPrice
     * @uri /getFloorPrice
     * @param Date stopDate Description
     * @param Date startDate Description
     * @param Date endDate Description
     * @param String projectId Description
     * @param String provinceId Description
     * @param String typeId Description
     * @param String gradeId Description
     * @return FloorPrice[] lists Description
     * @description hello
     */
    public function getFloorPrice($stopDate,$startDate,$endDate,$projectId,$provinceId,$typeId,$gradeId);
} 