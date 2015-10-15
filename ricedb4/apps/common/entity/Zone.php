<?php
 namespace apps\common\entity;
/**
 * @Entity
 * @Table(name="dft_LK_Zone")
 */
class Zone extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Zone_Name_TH") */
    public $zoneNameTH;

    /** @Column(type="string",length=255, name="Zone_Name_EN") */
    public $zoneNameEN;

    function getId() {
        return $this->id;
    }

    function getZoneNameTH() {
        return $this->zoneNameTH;
    }

    function getZoneNameEN() {
        return $this->zoneNameEN;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setZoneNameTH($zoneNameTH) {
        $this->zoneNameTH = $zoneNameTH;
    }

    function setZoneNameEN($zoneNameEN) {
        $this->zoneNameEN = $zoneNameEN;
    }


}
