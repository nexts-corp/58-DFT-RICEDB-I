/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import javax.persistence.Column;
import javax.persistence.Entity;

@Entity
public class RPT02_03_01_02_01_model extends BaseReport {

    @Column
    private int bidderNo;
    @Column
    private String bidderTaxId;
    @Column
    private String bidderName;
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
    private String propertyFactory1;
    @Column
    private String propertyFactory2;
    @Column
    private String propertyFactory3;

    @Column
    private String remarkFactory1;
    @Column
    private String remarkFactory2;
    @Column
    private String remarkFactory3;

    @Column
    private String typeOptional;

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

    public String getPropertyFactory1() {
        return propertyFactory1;
    }

    public void setPropertyFactory1(String propertyFactory1) {
        this.propertyFactory1 = propertyFactory1;
    }

    public String getPropertyFactory2() {
        return propertyFactory2;
    }

    public void setPropertyFactory2(String propertyFactory2) {
        this.propertyFactory2 = propertyFactory2;
    }

    public String getPropertyFactory3() {
        return propertyFactory3;
    }

    public void setPropertyFactory3(String propertyFactory3) {
        this.propertyFactory3 = propertyFactory3;
    }

    public String getRemarkFactory1() {
        return remarkFactory1;
    }

    public void setRemarkFactory1(String remarkFactory1) {
        this.remarkFactory1 = remarkFactory1;
    }

    public String getRemarkFactory2() {
        return remarkFactory2;
    }

    public void setRemarkFactory2(String remarkFactory2) {
        this.remarkFactory2 = remarkFactory2;
    }

    public String getRemarkFactory3() {
        return remarkFactory3;
    }

    public void setRemarkFactory3(String remarkFactory3) {
        this.remarkFactory3 = remarkFactory3;
    }

    public String getTypeOptional() {
        return typeOptional;
    }

    public void setTypeOptional(String typeOptional) {
        this.typeOptional = typeOptional;
    }

}
