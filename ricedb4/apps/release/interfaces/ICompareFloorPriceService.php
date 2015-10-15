<?php
namespace apps\release\interfaces;

/**
 * @name CompareFloorPriceService
 * @uri /compareFP
 * @description floorPrice service
 */
interface ICompareFloorPriceService {
    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description รายชื่อการประมูล
     */
    public function listsAuction();

    /**
     * @name showFloorPrice
     * @uri /showFloorPrice
     * @param String auction Description
     * @return String[] lists Description
     * @description เปรียบเทียบราคา Floor Price
     */
    public function showFloorPrice($auction);
} 