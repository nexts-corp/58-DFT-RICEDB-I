/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import javax.persistence.Column;
import javax.persistence.Id;
import javax.persistence.MappedSuperclass;

/**
 *
 * @author somchit
 */
@MappedSuperclass
public class BaseReport implements Serializable {
    private static final long serialVersionUID = -5210365131505874578L;

    @Id
    @Column
    private int rowNo;
    
       // @Id
    @Column
    private String auctionNo;
    @Column
    private String auctionCode;
    @Column
    private String auctionDate;
    
    @Column
    private String createWarehouseBy;
    
    @Column
    private String createPriceBy;

    public int getRowNo() {
        return rowNo;
    }

    public void setRowNo(int rowNo) {
        this.rowNo = rowNo;
    }

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

    public String getCreateWarehouseBy() {
        return createWarehouseBy;
    }

    public void setCreateWarehouseBy(String createWarehouseBy) {
        this.createWarehouseBy = createWarehouseBy;
    }

    public String getCreatePriceBy() {
        return createPriceBy;
    }

    public void setCreatePriceBy(String createPriceBy) {
        this.createPriceBy = createPriceBy;
    }
    
    

}
