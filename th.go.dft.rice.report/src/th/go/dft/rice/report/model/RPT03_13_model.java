/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import javax.persistence.Entity;

@Entity
public class RPT03_13_model extends BaseModel implements Serializable {
    private static final long serialVersionUID = 2278232562840069477L;
    
    private String Type;
    private Double       weightAuction;
    private Double        weightWinner;

    public String getType() {
        return Type;
    }

    public void setType(String Type) {
        this.Type = Type;
    }

    public Double getWeightAuction() {
        return weightAuction;
    }

    public void setWeightAuction(Double weightAuction) {
        this.weightAuction = weightAuction;
    }

    public Double getWeightWinner() {
        return weightWinner;
    }

    public void setWeightWinner(Double weightWinner) {
        this.weightWinner = weightWinner;
    }
    
}
