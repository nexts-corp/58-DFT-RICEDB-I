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
public class RPT01_01_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;

    @Column
    private int riceTypeId;

    @Column
    private String riceType;

    @Column
    private int gradeId;

    @Column
    private String grade;

    @Column
    private double floorPrice;
    @Column
    private String groupId;

    public int getRiceTypeId() {
        return riceTypeId;
    }

    public void setRiceTypeId(int riceTypeId) {
        this.riceTypeId = riceTypeId;
    }

    public String getRiceType() {
        return riceType;
    }

    public void setRiceType(String riceType) {
        this.riceType = riceType;
    }

    public int getGradeId() {
        return gradeId;
    }

    public void setGradeId(int gradeId) {
        this.gradeId = gradeId;
    }

    public String getGrade() {
        return grade;
    }

    public void setGrade(String grade) {
        this.grade = grade;
    }

    public double getFloorPrice() {
        return floorPrice;
    }

    public void setFloorPrice(double floorPrice) {
        this.floorPrice = floorPrice;
    }

    public String getGroupId() {
        return groupId;
    }

    public void setGroupId(String groupId) {
        this.groupId = groupId;
    }

}
