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
public class RPT02_09_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private int total;
    @Column
    private int totalWareHouse;
    @Column
    private String sweightAll;
    @Column
    private int tranferDay;

    @Column
    private int bidderTypeId;
    
     @Column
    private int bidderRegisterId;
    
    @Column
    private String bidderTypeName;
    
    public int getTotal() {
        return total;
    }

    public void setTotal(int total) {
        this.total = total;
    }

    public int getTotalWareHouse() {
        return totalWareHouse;
    }

    public void setTotalWareHouse(int totalWareHouse) {
        this.totalWareHouse = totalWareHouse;
    }

    public String getSweightAll() {
        return sweightAll;
    }

    public void setSweightAll(String sweightAll) {
        this.sweightAll = sweightAll;
    }

    public int getTranferDay() {
        return tranferDay;
    }

    public void setTranferDay(int tranferDay) {
        this.tranferDay = tranferDay;
    }

    public int getBidderTypeId() {
        return bidderTypeId;
    }

    public void setBidderTypeId(int bidderTypeId) {
        this.bidderTypeId = bidderTypeId;
    }

    public String getBidderTypeName() {
        return bidderTypeName;
    }

    public void setBidderTypeName(String bidderTypeName) {
        this.bidderTypeName = bidderTypeName;
    }

    public int getBidderRegisterId() {
        return bidderRegisterId;
    }

    public void setBidderRegisterId(int bidderRegisterId) {
        this.bidderRegisterId = bidderRegisterId;
    }

    
    
}
