<?php

namespace apps\report\service;

use apps\report\interfaces\IReportService;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\core\CServiceBase;

class ReportService extends CServiceBase implements IReportService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function getReportURL() {
        //$url = "http://192.168.1.135:9999/api/rice/report/export";
        $url = "/reporter/api/rice/report/export";
        return $url;
    }

    function getReportAuction($reportName, $queue, $type) {
        $sql = "SELECT"
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "Y"
        );
        if ($type == "industry") {
            $param["active"] = "YA";
        }
        if ($type == "order") {
            $param["active"] = "YO";
        }
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        $url = $this->getReportURL() . "?reportcode=" . $reportName . "&auccode=" . $data[0]->keyword . "&export=view&p_1=" . $queue;

        return $url;
    }

    function getReportTracking($reportName, $queue, $type) {
        $sql = "SELECT"
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "Y"
        );
        if ($type == "industry") {
            $param["active"] = "YA";
        }
        if ($type == "order") {
            $param["active"] = "YO";
        }
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        $url = $this->getReportURL() . "?reportcode=" . $reportName . "&auccode=" . $data[0]->keyword . "&export=view&p_1=" . $queue;

        return $url;
    }

    function getReportTrackingAuccode($reportName, $report) {


        $url = $this->getReportURL() . "?reportcode=" . $reportName . "&auccode=" . $report->auccode . "&export=view&p_1=" . $report->queue;

        return $url;
    }

    public function listsReport($reportType) {
        $sql = "SELECT"
                . " rp.id, rp.reportName, rp.reportCode, rt.reportGroup,rp.permission "
                . " FROM " . $this->ent . "\\Report rp"
                . " JOIN " . $this->ent . "\\ReportType rt WITH rt.id=rp.reportTypeId"
                . " WHERE rt.reportType=:reportType ORDER BY rt.reportGroup, rp.reportCode ASC";
        $param = array(
            "reportType" => $reportType
        );

        $role = bindec($this->createBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->resources[0]);


        $dataReport = $this->datacontext->getObject($sql, $param);
        //print_r($dataReport);
        $dataReport_p = [];
        for ($i = 0; $i < count($dataReport); $i++) {
            $p = bindec($dataReport[$i]["permission"]);
            if (($role & $p) > 0) {
                $dataReport_p[] = $dataReport[$i];
            }
        }
        return $dataReport_p;
    }

    public function listsAuction() {
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE :keyword "
                . " and st.keyword NOT LIKE :keyword2 "
                . " and st.active is not null"
                . " ORDER BY st.id DESC";
        $param = array(
            "keyword" => "AU%",
            "keyword2" => "%-_"
        );
        $dataAuction = $this->datacontext->getObject($sql, $param);
        return $dataAuction;
    }

    public function export($report) {
        $url = $this->getReportURL() . "?reportcode=" . $report->reportCode . "&"
                . "auccode=" . $report->auCode . "&export=" . $report->reportType;

        return $url;
    }

    public function checkList($report) {
        $reportName = "RPT02_04";

        $url = $this->getReportAuction($reportName, $report->queue, $report->type);
        return $url;
    }

    public function payment($report) {
        $reportName = "RPT02_08_00";

        $url = $this->getReportAuction($reportName, $report->queue, $report->type);
        return $url;
    }

    public function returnPayment($report) {
        $reportName = "RPT02_08_01";


        $url = $this->getReportAuction($reportName, $report->queue, $report->type);
        return $url;
    }

    public function trackingPayment($report) {
        $reportName = "RPT02_08_02";
        $url = $this->getReportTrackingAuccode($reportName, $report, $report->type);
        return $url;
    }

    public function financePayment($report) {
        $reportName = "RPT02_08_05";
        $url = $this->getReportTrackingAuccode($reportName, $report, $report->type);
        return $url;
    }

    public function listsIndustry() {
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE :keyword "
                . " and st.keyword LIKE :keyword2 "
                . " and st.active is not null"
                . " ORDER BY st.id DESC";
        $param = array(
            "keyword" => "AU%",
            "keyword2" => "%-I"
        );
        $dataAuction = $this->datacontext->getObject($sql, $param);
        return $dataAuction;
    }

    public function listsIndustry2() {
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE :keyword "
                . " and st.keyword LIKE :keyword2 "
                . " and st.active is not null"
                . " ORDER BY st.id DESC";
        $param = array(
            "keyword" => "AU%",
            "keyword2" => "%-I2"
        );
        $dataAuction = $this->datacontext->getObject($sql, $param);
        return $dataAuction;
    }

    public function listsOrder() {
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE :keyword "
                . " and st.keyword LIKE :keyword2 "
                . " and st.active is not null"
                . " ORDER BY st.id DESC";
        $param = array(
            "keyword" => "AU%",
            "keyword2" => "%-O"
        );
        $dataAuction = $this->datacontext->getObject($sql, $param);
        return $dataAuction;
    }

}
