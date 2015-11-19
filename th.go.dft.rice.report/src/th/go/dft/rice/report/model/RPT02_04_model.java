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
public class RPT02_04_model extends BaseModel implements Serializable {
    private static final long serialVersionUID = 2278232562840069477L;
    
    @Column
    private int bidderQueue;
    
    @Column
    private String bidderRegister;

    public int getBidderQueue() {
        return bidderQueue;
    }

    public void setBidderQueue(int bidderQueue) {
        this.bidderQueue = bidderQueue;
    }

    public String getBidderRegister() {
        return bidderRegister;
    }

    public void setBidderRegister(String bidderRegister) {
        this.bidderRegister = bidderRegister;
    }
    
}