<?php

namespace apps\warehouse\interfaces;

/**
 * @name IViewRicePriceService
 * @uri /viewRicePrice
 * @description ประมูล
 */
interface IViewRicePriceService {
    /**
     * @name view
     * @uri /view
     * @param Date date Description
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     */
    public function view($date);
} 