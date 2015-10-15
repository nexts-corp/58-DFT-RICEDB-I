<?php
namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Report")
 */
class Report extends EntityBase{
    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Report_Name") */
    public $reportName;

    /** @Column(type="integer",length=11, name="Report_Type_Id") */
    public $reportTypeId;

    /** @Column(type="string",length=255, name="Report_Code") */
    public $reportCode;

    function getId(){
        return $this->id;
    }

    function getReportName(){
        return $this->reportName;
    }

    function getReportTypeId(){
        return $this->reportTypeId;
    }

    function getReportCode(){
        return $this->reportCode;
    }

    function setId($id){
        $this->id = $id;
    }

    function setReportName($reportName){
        $this->reportName = $reportName;
    }

    function setReportTypeId($reportTypeId){
        $this->reportTypeId = $reportTypeId;
    }

    function setReportCode($reportCode){
        $this->reportCode = $reportCode;
    }
} 