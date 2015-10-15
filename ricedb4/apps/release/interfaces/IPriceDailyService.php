<?php
namespace apps\release\interfaces;

/**
 * @name PriceDailyService
 * @uri /priceDaily
 * @description priceDaily service
 */
interface IPriceDailyService {
    /**
     * @name select
     * @uri /select
     * @return PriceDaily[] datas Description
     * @description hello
     */
    public function select();

    /**
     * @name whereDate
     * @uri /whereDate
     * @param Date date Description
     * @return String[] lists Description
     * @description hello
     */
    public function whereDate($date);

    /**
     * @name whereMonth
     * @uri /whereMonth
     * @param Date date1 Description
     * @param Date date2 Description
     * @return String[] lists Description
     * @description hello
     */
    public function whereMonth($date1, $date2);


    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\PriceDaily prices Description
     * @return boolean save Description
     * @description hello
     */
    public function save($prices);
} 