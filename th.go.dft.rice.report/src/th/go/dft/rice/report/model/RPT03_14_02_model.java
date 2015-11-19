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
public class RPT03_14_02_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
  
    
    @Column
    private double stackLastPrice;

    @Column
    private double pweight;

    @Column
    private double pPrice;

  

    public double getStackLastPrice() {
        return stackLastPrice;
    }

    public void setStackLastPrice(double stackLastPrice) {
        this.stackLastPrice = stackLastPrice;
    }

    public double getPweight() {
        return pweight;
    }

    public void setPweight(double pweight) {
        this.pweight = pweight;
    }

    public double getpPrice() {
        return pPrice;
    }

    public void setpPrice(double pPrice) {
        this.pPrice = pPrice;
    }
    
    

}
