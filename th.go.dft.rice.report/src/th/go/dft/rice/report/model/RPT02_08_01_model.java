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
public class RPT02_08_01_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private String groupId;

    @Column
    private String guaranteeTypeName;

    @Column
    private String guaranteeBankName;

    @Column
    private String guaranteeNo;

    @Column
    private Double guaranteeAmount;

    @Column
    @Temporal(javax.persistence.TemporalType.DATE)
    private Date guaranteeDate;

    @Column
    @Temporal(javax.persistence.TemporalType.DATE)
    private Date guaranteeReturnDate;

    @Column
    private String isReserved;

    @Column
    private String bidderWinner;

    @Column
    private int bidderQueue;

    @Column
    private int gtotal;

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

    public Date getGuaranteeReturnDate() {
        return guaranteeReturnDate;
    }

    public void setGuaranteeReturnDate(Date guaranteeReturnDate) {
        this.guaranteeReturnDate = guaranteeReturnDate;
    }

    public String getGroupId() {
        return groupId;
    }

    public void setGroupId(String groupId) {
        this.groupId = groupId;
    }

    public String getIsReserved() {
        return isReserved;
    }

    public void setIsReserved(String isReserved) {
        this.isReserved = isReserved;
    }

    public String getBidderWinner() {
        return bidderWinner;
    }

    public void setBidderWinner(String bidderWinner) {
        this.bidderWinner = bidderWinner;
    }

    public int getBidderQueue() {
        return bidderQueue;
    }

    public void setBidderQueue(int bidderQueue) {
        this.bidderQueue = bidderQueue;
    }

    public int getGtotal() {
        return gtotal;
    }

    public void setGtotal(int gtotal) {
        this.gtotal = gtotal;
    }

}
