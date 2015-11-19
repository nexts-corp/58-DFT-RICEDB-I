/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Temporal;

@Entity
public class RPT01_02_00_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private int riceTypeCode;

    @Column
    private String riceType;

    @Column
    @Temporal(javax.persistence.TemporalType.DATE)
    private Date priceDate;

    @Column
    private double oldPriceMin1;
    @Column
    private double oldPriceMax1;
    @Column
    private double newPriceMin1;
    @Column
    private double newPriceMax1;
    @Column
    private double oldPriceMin2;
    @Column
    private double oldPriceMax2;
    @Column
    private double newPriceMin2;
    @Column
    private double newPriceMax2;

    public int getRiceTypeCode() {
        return riceTypeCode;
    }

    public void setRiceTypeCode(int riceTypeCode) {
        this.riceTypeCode = riceTypeCode;
    }

    public String getRiceType() {
        return riceType;
    }

    public void setRiceType(String riceType) {
        this.riceType = riceType;
    }

    public Date getPriceDate() {
        return priceDate;
    }

    public void setPriceDate(Date priceDate) {
        this.priceDate = priceDate;
    }

    public double getOldPriceMin1() {
        return oldPriceMin1;
    }

    public void setOldPriceMin1(double oldPriceMin1) {
        this.oldPriceMin1 = oldPriceMin1;
    }

    public double getOldPriceMax1() {
        return oldPriceMax1;
    }

    public void setOldPriceMax1(double oldPriceMax1) {
        this.oldPriceMax1 = oldPriceMax1;
    }

    public double getNewPriceMin1() {
        return newPriceMin1;
    }

    public void setNewPriceMin1(double newPriceMin1) {
        this.newPriceMin1 = newPriceMin1;
    }

    public double getNewPriceMax1() {
        return newPriceMax1;
    }

    public void setNewPriceMax1(double newPriceMax1) {
        this.newPriceMax1 = newPriceMax1;
    }

    public double getOldPriceMin2() {
        return oldPriceMin2;
    }

    public void setOldPriceMin2(double oldPriceMin2) {
        this.oldPriceMin2 = oldPriceMin2;
    }

    public double getOldPriceMax2() {
        return oldPriceMax2;
    }

    public void setOldPriceMax2(double oldPriceMax2) {
        this.oldPriceMax2 = oldPriceMax2;
    }

    public double getNewPriceMin2() {
        return newPriceMin2;
    }

    public void setNewPriceMin2(double newPriceMin2) {
        this.newPriceMin2 = newPriceMin2;
    }

    public double getNewPriceMax2() {
        return newPriceMax2;
    }

    public void setNewPriceMax2(double newPriceMax2) {
        this.newPriceMax2 = newPriceMax2;
    }

}
