<?php

namespace apps\report\interfaces;

/**
 * @name IReportService
 * @uri /report
 * @description ประมูล
 */
interface IReportService {
    /**
     * @name listsReport
     * @uri /listsReport
     * @param string reportType Description
     * @return String[] lists Description
     * @description เมนูรายงาน
     */
    public function listsReport($reportType);

    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description เมนูรายงาน
     */
    public function listsAuction();
    
    /**
     * @name listsOrder
     * @uri /listsOrder
     * @return String[] lists Description
     * @description เมนูรายงาน
     */
    public function listsOrder();
    /**
     * @name listsIndustry
     * @uri /listsIndustry
     * @return String[] lists Description
     * @description เมนูรายงาน
     */
    public function listsIndustry();
    /**
     * @name listsIndustry2
     * @uri /listsIndustry2
     * @return String[] lists Description
     * @description เมนูรายงาน
     */
    public function listsIndustry2();

    /**
     * @name export
     * @uri /export
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function export($report);
    
    /**
     * @name checkList
     * @uri /checkList
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function checkList($report);
    
    /**
     * @name payment
     * @uri /payment
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function payment($report);
    
    /**
     * @name returnPayment
     * @uri /returnPayment
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function returnPayment($report);
    
    /**
     * @name trackingPayment
     * @uri /trackingPayment
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function trackingPayment($report);
    
     /**
     * @name financePayment
     * @uri /financePayment
     * @param String[] report Description
     * @return string export Description
     * @description เมนูรายงาน
     */
    public function financePayment($report);
} 