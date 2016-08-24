/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.model;

import java.io.Serializable;
import javax.persistence.Column;
import javax.persistence.MappedSuperclass;

/**
 *
 * @author somchit
 */
@MappedSuperclass
public class BaseModel extends BaseReport implements Serializable {

    @Column
    private int wareHouseId;

    @Column
    private String wareHouseCode;

    // @Id
    @Column
    private int provinceId;
    @Column
    private String province;

    // @Id
    @Column
    private int associateId;
    @Column
    private String associate;

    @Column
    private int projectId;
    @Column
    private String project;

    @Column
    private int gradeId;
    @Column
    private String grade;

    @Column
    private int typeId;

    @Column
    private String typeName;

    @Column
    private String stack;

    @Column
    private double weightAll;
    @Column
    private double oweightAll;
    @Column
    private double weightGood;
    @Column
    private double weightBad;
    @Column
    private double RFV;
    @Column
    private double FV2;

    @Column
    private double FV3;

    @Column
    private double FV4;

    @Column
    private double RFV2;

    // @Id
    @Column
    private int bidderNo;
    @Column
    private String bidderTaxId;

    @Column
    private String bidderName;

    @Column
    private double bidderPrice;

    @Column
    private String bidderAgent;
    @Column
    private String bidderAgent2;
    @Column
    private String bidderAgent3;

    @Column
    private double bidderFirstPrice;

    @Column
    private double bidderLastPrice;

    public int getWareHouseId() {
        return wareHouseId;
    }

    public void setWareHouseId(int wareHouseId) {
        this.wareHouseId = wareHouseId;
    }

    public String getWareHouseCode() {
        return wareHouseCode;
    }

    public void setWareHouseCode(String wareHouseCode) {
        this.wareHouseCode = wareHouseCode;
    }

    public int getProvinceId() {
        return provinceId;
    }

    public void setProvinceId(int provinceId) {
        this.provinceId = provinceId;
    }

    public String getProvince() {
        return province;
    }

    public void setProvince(String province) {
        this.province = province;
    }

    public int getAssociateId() {
        return associateId;
    }

    public void setAssociateId(int associateId) {
        this.associateId = associateId;
    }

    public String getAssociate() {
        return associate;
    }

    public void setAssociate(String associate) {
        this.associate = associate;
    }

    public int getProjectId() {
        return projectId;
    }

    public void setProjectId(int projectId) {
        this.projectId = projectId;
    }

    public String getProject() {
        return project;
    }

    public void setProject(String project) {
        this.project = project;
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

    public int getTypeId() {
        return typeId;
    }

    public void setTypeId(int typeId) {
        this.typeId = typeId;
    }

    public String getTypeName() {
        return typeName;
    }

    public void setTypeName(String typeName) {
        this.typeName = typeName;
    }

    public String getStack() {
        return stack;
    }

    public void setStack(String stack) {
        this.stack = stack;
    }

    public double getWeightAll() {
        return weightAll;
    }

    public void setWeightAll(double weightAll) {
        this.weightAll = weightAll;
    }

    public double getOweightAll() {
        return oweightAll;
    }

    public void setOweightAll(double oweightAll) {
        this.oweightAll = oweightAll;
    }

    public double getWeightGood() {
        return weightGood;
    }

    public void setWeightGood(double weightGood) {
        this.weightGood = weightGood;
    }

    public double getWeightBad() {
        return weightBad;
    }

    public void setWeightBad(double weightBad) {
        this.weightBad = weightBad;
    }

    public double getRFV() {
        return RFV;
    }

    public void setRFV(double RFV) {
        this.RFV = RFV;
    }

    public double getFV2() {
        return FV2;
    }

    public void setFV2(double FV2) {
        this.FV2 = FV2;
    }

    public double getFV3() {
        return FV3;
    }

    public void setFV3(double FV3) {
        this.FV3 = FV3;
    }

    public double getFV4() {
        return FV4;
    }

    public void setFV4(double FV4) {
        this.FV4 = FV4;
    }

    public double getRFV2() {
        return RFV2;
    }

    public void setRFV2(double RFV2) {
        this.RFV2 = RFV2;
    }

    public int getBidderNo() {
        return bidderNo;
    }

    public void setBidderNo(int bidderNo) {
        this.bidderNo = bidderNo;
    }

    public String getBidderTaxId() {
        return bidderTaxId;
    }

    public void setBidderTaxId(String bidderTaxId) {
        this.bidderTaxId = bidderTaxId;
    }

    public String getBidderName() {
        return bidderName;
    }

    public void setBidderName(String bidderName) {
        this.bidderName = bidderName;
    }

    public double getBidderPrice() {
        return bidderPrice;
    }

    public void setBidderPrice(double bidderPrice) {
        this.bidderPrice = bidderPrice;
    }

    public String getBidderAgent() {
        return bidderAgent;
    }

    public void setBidderAgent(String bidderAgent) {
        this.bidderAgent = bidderAgent;
    }

    public String getBidderAgent2() {
        return bidderAgent2;
    }

    public void setBidderAgent2(String bidderAgent2) {
        this.bidderAgent2 = bidderAgent2;
    }

    public String getBidderAgent3() {
        return bidderAgent3;
    }

    public void setBidderAgent3(String bidderAgent3) {
        this.bidderAgent3 = bidderAgent3;
    }

    public double getBidderFirstPrice() {
        return bidderFirstPrice;
    }

    public void setBidderFirstPrice(double bidderFirstPrice) {
        this.bidderFirstPrice = bidderFirstPrice;
    }

    public double getBidderLastPrice() {
        return bidderLastPrice;
    }

    public void setBidderLastPrice(double bidderLastPrice) {
        this.bidderLastPrice = bidderLastPrice;
    }

}
