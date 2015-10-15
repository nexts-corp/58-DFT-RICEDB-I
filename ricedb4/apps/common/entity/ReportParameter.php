<?php
namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Report_Parameter")
 */
class ReportParameter extends EntityBase{
    /**
     * @Id
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="integer",length=11, name="Report_Id") */
    public $reportId;

    /** @Column(type="string", length=255, name="Parameter" */
    public $parameter;

    function getId(){
        return $this->id;
    }

    function getParameter(){
        return $this->parameter;
    }

    function getReportId(){
        return $this->reportId;
    }

    function setId($id){
        $this->id = $id;
    }

    function setParameter($parameter){
        $this->parameter = $parameter;
    }

    function setReportId($reportId){
        $this->reportId = $reportId;
    }
} 