<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_LK_Province")
 */
class Province extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer",length=11,name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string",length=255, name="Province_Name_TH") */
    public $provinceNameTH;

    /** @Column(type="string",length=255, name="Province_Name_EN") */
    public $provinceNameEN;

    /** @Column(type="integer",length=11, name="LK_Zone_Id") */
    public $zoneId;

    function getId() {
        return $this->id;
    }

    function getProvinceNameTH() {
        return $this->provinceNameTH;
    }

    function getProvinceNameEN() {
        return $this->provinceNameEN;
    }

    function getZoneId() {
        return $this->zoneId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProvinceNameTH($provinceNameTH) {
        $this->provinceNameTH = $provinceNameTH;
    }

    function setProvinceNameEN($provinceNameEN) {
        $this->provinceNameEN = $provinceNameEN;
    }

    function setZoneId($zoneId) {
        $this->zoneId = $zoneId;
    }

}
