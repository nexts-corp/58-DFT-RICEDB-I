<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Release")
 */
class Release extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Release_Name") */
    public $releaseName;

    /** @Column(type="string",length=255, name="Release_Code") */
    public $releaseCode;

    function getId(){
        return $this->id;
    }

    function getReleaseCode(){
        return $this->releaseCode;
    }

    function getReleaseName(){
        return $this->releaseName;
    }

    function setId($id){
        $this->id = $id;
    }

    function setReleaseCode($releaseCode){
        $this->releaseCode = $releaseCode;
    }

    function setReleaseName($releaseName){
        $this->releaseName = $releaseName;
    }
}
