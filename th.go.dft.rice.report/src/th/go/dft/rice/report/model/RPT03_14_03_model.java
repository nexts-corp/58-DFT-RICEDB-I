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
public class RPT03_14_03_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private double stackFirstPrice;

    @Column
    private double stackLastPrice;

    @Column
    private double OFP2;

    @Column
    private double OFP3;

    @Column
    private double OFP4;

    @Column
    private String useFV;

    @Column
    private String bidderPassFV;

    public double getStackFirstPrice() {
        return stackFirstPrice;
    }

    public void setStackFirstPrice(double stackFirstPrice) {
        this.stackFirstPrice = stackFirstPrice;
    }

    public double getStackLastPrice() {
        return stackLastPrice;
    }

    public void setStackLastPrice(double stackLastPrice) {
        this.stackLastPrice = stackLastPrice;
    }

    public double getOFP2() {
        return OFP2;
    }

    public void setOFP2(double OFP2) {
        this.OFP2 = OFP2;
    }

    public double getOFP3() {
        return OFP3;
    }

    public void setOFP3(double OFP3) {
        this.OFP3 = OFP3;
    }

    public double getOFP4() {
        return OFP4;
    }

    public void setOFP4(double OFP4) {
        this.OFP4 = OFP4;
    }

    public String getUseFV() {
        return useFV;
    }

    public void setUseFV(String useFV) {
        this.useFV = useFV;
    }

    public String getBidderPassFV() {
        return bidderPassFV;
    }

    public void setBidderPassFV(String bidderPassFV) {
        this.bidderPassFV = bidderPassFV;
    }

}
