/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import javax.persistence.Column;
import javax.persistence.Entity;

@Entity
public class RPT02_03_02_model extends BaseReport {

    private static final long serialVersionUID = 1L;

    @Column
    private int bidderNo;

    @Column
    private String bidderTaxId;
    @Column
    private String bidderName;
    @Column
    private String bidderAgent;
    @Column
    private String bidderMobile;

    @Column
    private String bidderQueue;

    @Column
    private String bidderRegister;

    @Column
    private String property1;
    @Column
    private String property2;
    @Column
    private String property3;
    @Column
    private String property4;
    @Column
    private String property5;
    @Column
    private String bidderStatus;
    @Column
    private String bidderStatusCode;
    @Column
    private int totalBidder;
    @Column
    private int passBidder;
    @Column
    private int failBidder;
    @Column
    private String isCheckIn;
    @Column
    private String remark1;

    public int getBidderNo() {
        return bidderNo;
    }

    public void setBidderNo(int bidderNo) {
        this.bidderNo = bidderNo;
    }

    public String getBidderTaxId() {
        return bidderTaxId;
    }

    public void setBidderTaxId(String bidderTaxId) {
        this.bidderTaxId = bidderTaxId;
    }

    public String getBidderName() {
        return bidderName;
    }

    public void setBidderName(String bidderName) {
        this.bidderName = bidderName;
    }

    public String getBidderAgent() {
        return bidderAgent;
    }

    public void setBidderAgent(String bidderAgent) {
        this.bidderAgent = bidderAgent;
    }

    public String getBidderMobile() {
        return bidderMobile;
    }

    public void setBidderMobile(String bidderMobile) {
        this.bidderMobile = bidderMobile;
    }

    public String getBidderQueue() {
        return bidderQueue;
    }

    public void setBidderQueue(String bidderQueue) {
        this.bidderQueue = bidderQueue;
    }

    public String getBidderRegister() {
        return bidderRegister;
    }

    public void setBidderRegister(String bidderRegister) {
        this.bidderRegister = bidderRegister;
    }

    public String getProperty1() {
        return property1;
    }

    public void setProperty1(String property1) {
        this.property1 = property1;
    }

    public String getProperty2() {
        return property2;
    }

    public void setProperty2(String property2) {
        this.property2 = property2;
    }

    public String getProperty3() {
        return property3;
    }

    public void setProperty3(String property3) {
        this.property3 = property3;
    }

    public String getProperty4() {
        return property4;
    }

    public void setProperty4(String property4) {
        this.property4 = property4;
    }

    public String getProperty5() {
        return property5;
    }

    public void setProperty5(String property5) {
        this.property5 = property5;
    }

    public String getBidderStatus() {
        return bidderStatus;
    }

    public void setBidderStatus(String bidderStatus) {
        this.bidderStatus = bidderStatus;
    }

    public String getBidderStatusCode() {
        return bidderStatusCode;
    }

    public void setBidderStatusCode(String bidderStatusCode) {
        this.bidderStatusCode = bidderStatusCode;
    }

    public int getTotalBidder() {
        return totalBidder;
    }

    public void setTotalBidder(int totalBidder) {
        this.totalBidder = totalBidder;
    }

    public int getPassBidder() {
        return passBidder;
    }

    public void setPassBidder(int passBidder) {
        this.passBidder = passBidder;
    }

    public int getFailBidder() {
        return failBidder;
    }

    public void setFailBidder(int failBidder) {
        this.failBidder = failBidder;
    }

    public String getIsCheckIn() {
        return isCheckIn;
    }

    public void setIsCheckIn(String isCheckIn) {
        this.isCheckIn = isCheckIn;
    }

    public String getRemark1() {
        return remark1;
    }

    public void setRemark1(String remark1) {
        this.remark1 = remark1;
    }

}
