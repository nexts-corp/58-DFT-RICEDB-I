<?php

namespace apps\warehouse\interfaces;

/**
 * @name IViewRicePriceAvgService
 * @uri /viewRicePriceAvg
 * @description ประมูล
 */
interface IViewRicePriceAvgService {
    /**
     * @name view
     * @uri /view
     * @param Date date1 Description
     * @param Date date2 Description
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function view($date1, $date2);
} 