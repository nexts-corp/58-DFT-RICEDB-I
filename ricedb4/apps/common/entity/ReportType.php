<?php
namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Report_Type")
 */
class ReportType extends EntityBase{
    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=150, name="Report_Type") */
    public $reportType;
    
    /** @Column(type="string",length=255, name="Report_Group") */
    public $reportGroup;

    function getId(){
        return $this->id;
    }

    function getReportType(){
        return $this->reportType;
    }

    function getReportGroup() {
        return $this->reportGroup;
    }

    function setId($id){
        $this->id = $id;
    }

    function setReportType($reportType){
        $this->reportType = $reportType;
    }
    
    function setReportGroup($reportGroup) {
        $this->reportGroup = $reportGroup;
    }
}