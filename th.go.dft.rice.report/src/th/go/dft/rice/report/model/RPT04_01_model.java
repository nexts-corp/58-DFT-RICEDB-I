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
public class RPT04_01_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private String bidderWinner;

    @Column
    private String bidderPassFV;
    @Column
    private String bidderPriceDuplicate;
    @Column
    private String isReserved;
    @Column
    private String bidderRoundMaxprice;

    public String getBidderRoundMaxprice() {
        return bidderRoundMaxprice;
    }

    public void setBidderRoundMaxprice(String bidderRoundMaxprice) {
        this.bidderRoundMaxprice = bidderRoundMaxprice;
    }

    public String getBidderPriceDuplicate() {
        return bidderPriceDuplicate;
    }

    public void setBidderPriceDuplicate(String bidderPriceDuplicate) {
        this.bidderPriceDuplicate = bidderPriceDuplicate;
    }

    public String getBidderWinner() {
        return bidderWinner;
    }

    public void setBidderWinner(String bidderWinner) {
        this.bidderWinner = bidderWinner;
    }

    public String getBidderPassFV() {
        return bidderPassFV;
    }

    public void setBidderPassFV(String bidderPassFV) {
        this.bidderPassFV = bidderPassFV;
    }

    public String getIsReserved() {
        return isReserved;
    }

    public void setIsReserved(String isReserved) {
        this.isReserved = isReserved;
    }

}
