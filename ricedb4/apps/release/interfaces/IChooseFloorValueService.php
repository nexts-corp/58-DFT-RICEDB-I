<?php
namespace apps\release\interfaces;

/**
 * @name ChooseFloorValueService
 * @uri /chooseFV
 * @description floorPrice service
 */
interface IChooseFloorValueService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function listsAuction();

    /**
     * @name listsRiceType
     * @uri /listsRiceType
     * @param String auction Description
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function listsRiceType($auction);

    /**
     * @name previewFV
     * @uri /previewFV
     * @param String auction Description
     * @param String[] riceType Description
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function previewFV($auction, $riceType);

    /**
     * @name saveFV
     * @uri /saveFV
     * @param String auction Description
     * @param String[] riceType Description
     * @return boolean save Description
     * @description รายชื่อการประมูล
     */
    public function saveFV($auction, $riceType);

    /**
     * @name clearFV
     * @uri /clearFV
     * @param String auction Description
     * @return boolean save Description
     * @description รายชื่อการประมูล
     */
    public function clearFV($auction);
} 