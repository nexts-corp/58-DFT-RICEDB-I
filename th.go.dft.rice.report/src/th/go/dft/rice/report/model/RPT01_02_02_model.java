/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import javax.persistence.Column;
import javax.persistence.Entity;

@Entity
public class RPT01_02_02_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private int riceTypeId;
    @Column
    private String riceType;
    @Column
    private String startDate;
    @Column
    private String endDate;
    @Column
    private double newMean1;
    @Column
    private double newMean2;
    @Column
    private double avgNewPrice;
    @Column
    private double oldNewMean1;
    @Column
    private double oldNewMean2;
    @Column
    private double avgOldNewPrice;
    @Column
    private double oldMean1;
    @Column
    private double oldMean2;
    @Column
    private double avgOldPrice;

    public int getRiceTypeId() {
        return riceTypeId;
    }

    public void setRiceTypeId(int riceTypeId) {
        this.riceTypeId = riceTypeId;
    }

    public String getRiceType() {
        return riceType;
    }

    public void setRiceType(String riceType) {
        this.riceType = riceType;
    }

    public String getStartDate() {
        return startDate;
    }

    public void setStartDate(String startDate) {
        this.startDate = startDate;
    }

    public String getEndDate() {
        return endDate;
    }

    public void setEndDate(String endDate) {
        this.endDate = endDate;
    }

    public double getNewMean1() {
        return newMean1;
    }

    public void setNewMean1(double newMean1) {
        this.newMean1 = newMean1;
    }

    public double getNewMean2() {
        return newMean2;
    }

    public void setNewMean2(double newMean2) {
        this.newMean2 = newMean2;
    }

    public double getOldNewMean1() {
        return oldNewMean1;
    }

    public void setOldNewMean1(double oldNewMean1) {
        this.oldNewMean1 = oldNewMean1;
    }

    public double getOldNewMean2() {
        return oldNewMean2;
    }

    public void setOldNewMean2(double oldNewMean2) {
        this.oldNewMean2 = oldNewMean2;
    }

    public double getAvgOldNewPrice() {
        return avgOldNewPrice;
    }

    public void setAvgOldNewPrice(double avgOldNewPrice) {
        this.avgOldNewPrice = avgOldNewPrice;
    }

    public double getOldMean1() {
        return oldMean1;
    }

    public void setOldMean1(double oldMean1) {
        this.oldMean1 = oldMean1;
    }

    public double getOldMean2() {
        return oldMean2;
    }

    public void setOldMean2(double oldMean2) {
        this.oldMean2 = oldMean2;
    }

    public double getAvgOldPrice() {
        return avgOldPrice;
    }

    public void setAvgOldPrice(double avgOldPrice) {
        this.avgOldPrice = avgOldPrice;
    }

    public double getAvgNewPrice() {
        return avgNewPrice;
    }

    public void setAvgNewPrice(double avgNewPrice) {
        this.avgNewPrice = avgNewPrice;
    }

}
