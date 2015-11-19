/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.parameter;

import java.util.Locale;

/**
 *
 * @author somchit
 */
public class BaseParameter {
    private String auctionNo;
    private String auctionCode;
    private String auctionDate;
    private int REPORT_MAX_COUNT;
    private String printBy;
    private Locale REPORT_LOCALE;

    public String getAuctionNo() {
        return auctionNo;
    }

    public void setAuctionNo(String auctionNo) {
        this.auctionNo = auctionNo;
    }

    public String getAuctionCode() {
        return auctionCode;
    }

    public void setAuctionCode(String auctionCode) {
        this.auctionCode = auctionCode;
    }

    public String getAuctionDate() {
        return auctionDate;
    }

    public void setAuctionDate(String auctionDate) {
        this.auctionDate = auctionDate;
    }

    public int getREPORT_MAX_COUNT() {
        return REPORT_MAX_COUNT;
    }

    public void setREPORT_MAX_COUNT(int REPORT_MAX_COUNT) {
        this.REPORT_MAX_COUNT = REPORT_MAX_COUNT;
    }

    public String getPrintBy() {
        return printBy;
    }

    public void setPrintBy(String printBy) {
        this.printBy = printBy;
    }

    public Locale getREPORT_LOCALE() {
        return REPORT_LOCALE;
    }

    public void setREPORT_LOCALE(Locale REPORT_LOCALE) {
        this.REPORT_LOCALE = REPORT_LOCALE;
    }
    
    

    
    
}
