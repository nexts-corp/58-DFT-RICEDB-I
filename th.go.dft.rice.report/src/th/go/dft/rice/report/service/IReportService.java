/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.service;

import th.co.bpg.cde.annotation.CIOperation;
import th.co.bpg.cde.annotation.CIParam;
import th.co.bpg.cde.annotation.CIService;
import th.co.bpg.cde.collection.CJFile;

/**
 *
 * @author KhaengZai
 */
@CIService(Uri = "/report")
public interface IReportService {
    
    @CIOperation(Uri = "/export")
    public CJFile export(@CIParam(Name="reportcode") String reportCode
            ,@CIParam(Name="auccode") String auctionCode
            ,@CIParam(Name="export") String exportType);
    
    
     @CIOperation(Uri = "/checklist")
    public CJFile checklist(@CIParam(Name="auccode") String auctionCode
            ,@CIParam(Name="bidderqueue") String bidderQueue
            ,@CIParam(Name="export") String exportType);
    
    @CIOperation(Uri = "/priceAvg")
    public CJFile priceAvg(@CIParam(Name="startDate") String startDate
            ,@CIParam(Name="endDate") String endDate
            ,@CIParam(Name="export") String exportType);
}
