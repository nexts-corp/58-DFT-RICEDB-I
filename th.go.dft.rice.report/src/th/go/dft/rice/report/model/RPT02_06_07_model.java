/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Temporal;

@Entity
public class RPT02_06_07_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private String typeNames;

    @Column
    private String projects;

    @Column
    private String grades;
    @Column
    private double weightC;
    @Column
    private double weightWrong;
    @Column
    private double percentGood;
    @Column
    private double percentBad;
    @Column
    private double percentC;
    @Column
    private double percentWrong;

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

    public double getWeightC() {
        return weightC;
    }

    public void setWeightC(double weightC) {
        this.weightC = weightC;
    }

    public double getWeightWrong() {
        return weightWrong;
    }

    public void setWeightWrong(double weightWrong) {
        this.weightWrong = weightWrong;
    }

    public double getPercentGood() {
        return percentGood;
    }

    public void setPercentGood(double percentGood) {
        this.percentGood = percentGood;
    }

    public double getPercentBad() {
        return percentBad;
    }

    public void setPercentBad(double percentBad) {
        this.percentBad = percentBad;
    }

    public double getPercentC() {
        return percentC;
    }

    public void setPercentC(double percentC) {
        this.percentC = percentC;
    }

    public double getPercentWrong() {
        return percentWrong;
    }

    public void setPercentWrong(double percentWrong) {
        this.percentWrong = percentWrong;
    }

}
