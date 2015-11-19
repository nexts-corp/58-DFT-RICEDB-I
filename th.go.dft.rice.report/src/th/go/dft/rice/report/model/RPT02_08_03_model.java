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
public class RPT02_08_03_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private String guaranteeTypeName;

    @Column
    private String guaranteeBankName;

    @Column
    @Temporal(javax.persistence.TemporalType.DATE)
    private Date guaranteeDate;

    @Column
    private String guaranteeNo;

    @Column
    private Double guaranteeAmount;

    @Column
    private String isGuaranteeReturn;

    @Column
    private int bidderQueue;

    public String getIsGuaranteeReturn() {
        return isGuaranteeReturn;
    }

    public void setIsGuaranteeReturn(String isGuaranteeReturn) {
        this.isGuaranteeReturn = isGuaranteeReturn;
    }

    public String getGuaranteeTypeName() {
        return guaranteeTypeName;
    }

    public void setGuaranteeTypeName(String guaranteeTypeName) {
        this.guaranteeTypeName = guaranteeTypeName;
    }

    public String getGuaranteeBankName() {
        return guaranteeBankName;
    }

    public void setGuaranteeBankName(String guaranteeBankName) {
        this.guaranteeBankName = guaranteeBankName;
    }

    public String getGuaranteeNo() {
        return guaranteeNo;
    }

    public void setGuaranteeNo(String guaranteeNo) {
        this.guaranteeNo = guaranteeNo;
    }

    public Double getGuaranteeAmount() {
        return guaranteeAmount;
    }

    public void setGuaranteeAmount(Double guaranteeAmount) {
        this.guaranteeAmount = guaranteeAmount;
    }

    public Date getGuaranteeDate() {
        return guaranteeDate;
    }

    public void setGuaranteeDate(Date guaranteeDate) {
        this.guaranteeDate = guaranteeDate;
    }

    public int getBidderQueue() {
        return bidderQueue;
    }

    public void setBidderQueue(int bidderQueue) {
        this.bidderQueue = bidderQueue;
    }

}
