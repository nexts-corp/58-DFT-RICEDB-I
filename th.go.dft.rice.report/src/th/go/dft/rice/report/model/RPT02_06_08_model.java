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
public class RPT02_06_08_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private String typeNames;

    @Column
    private String projects;

    @Column
    private String grades;
    @Column
    private double weightNormal;
    @Column
    private double weightBroken;
    @Column
    private double percentNormal;
    @Column
    private double percentBroken;
    @Column
    private String isSale;

    public String getIsSale() {
        return isSale;
    }

    public void setIsSale(String isSale) {
        this.isSale = isSale;
    }

    public String getTypeNames() {
        return typeNames;
    }

    public void setTypeNames(String typeNames) {
        this.typeNames = typeNames;
    }

    public String getProjects() {
        return projects;
    }

    public void setProjects(String projects) {
        this.projects = projects;
    }

    public String getGrades() {
        return grades;
    }

    public void setGrades(String grades) {
        this.grades = grades;
    }

    public double getWeightNormal() {
        return weightNormal;
    }

    public void setWeightNormal(double weightNormal) {
        this.weightNormal = weightNormal;
    }

    public double getWeightBroken() {
        return weightBroken;
    }

    public void setWeightBroken(double weightBroken) {
        this.weightBroken = weightBroken;
    }

    public double getPercentNormal() {
        return percentNormal;
    }

    public void setPercentNormal(double percentNormal) {
        this.percentNormal = percentNormal;
    }

    public double getPercentBroken() {
        return percentBroken;
    }

    public void setPercentBroken(double percentBroken) {
        this.percentBroken = percentBroken;
    }

}
