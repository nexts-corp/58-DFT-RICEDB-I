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
public class RPT05_01_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private double weightApprove;
    @Column
    private double weightContract;
    @Column
    private double weightReceived;
    @Column
    private double weightBalance;
    @Column
    private double weightLost;

    public double getWeightApprove() {
        return weightApprove;
    }

    public void setWeightApprove(double weightApprove) {
        this.weightApprove = weightApprove;
    }

    public double getWeightContract() {
        return weightContract;
    }

    public void setWeightContract(double weightContract) {
        this.weightContract = weightContract;
    }

    public double getWeightReceived() {
        return weightReceived;
    }

    public void setWeightReceived(double weightReceived) {
        this.weightReceived = weightReceived;
    }

    public double getWeightBalance() {
        return weightBalance;
    }

    public void setWeightBalance(double weightBalance) {
        this.weightBalance = weightBalance;
    }

    public double getWeightLost() {
        return weightLost;
    }

    public void setWeightLost(double weightLost) {
        this.weightLost = weightLost;
    }

}
