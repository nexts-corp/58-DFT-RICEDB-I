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
public class RPT03_XX_model extends BaseModel implements Serializable {

    private static final long serialVersionUID = 2278232562840069477L;
    @Column
    private String groupId;
    @Column
    private String groupName;
    @Column
    private int captionId;
    @Column
    private String caption;

    public String getGroupId() {
        return groupId;
    }

    public void setGroupId(String groupId) {
        this.groupId = groupId;
    }

    public String getGroupName() {
        return groupName;
    }

    public void setGroupName(String groupName) {
        this.groupName = groupName;
    }

    public int getCaptionId() {
        return captionId;
    }

    public void setCaptionId(int captionId) {
        this.captionId = captionId;
    }

    public String getCaption() {
        return caption;
    }

    public void setCaption(String caption) {
        this.caption = caption;
    }
    
    
}
