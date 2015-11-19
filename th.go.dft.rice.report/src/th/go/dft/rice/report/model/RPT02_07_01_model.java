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
public class RPT02_07_01_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private String warehouse;

    @Column
    private String projectRound;

    @Column
    private double weight;

    public String getWarehouse() {
        return warehouse;
    }

    public void setWarehouse(String warehouse) {
        this.warehouse = warehouse;
    }

    public double getWeight() {
        return weight;
    }

    public void setWeight(double weight) {
        this.weight = weight;
    }

    public String getProjectRound() {
        return projectRound;
    }

    public void setProjectRound(String projectRound) {
        this.projectRound = projectRound;
    }

    
}
