<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_follow_upload")
 */
class RiceFollowUpload extends EntityBase {

    /** @Id @Column(type="string", name="upload_date") */
    public $upload_date;

    /** @Id @Column(type="integer", name="upload_no") */
    public $upload_no;

    /**  @Column(type="string",length=255, name="upload_file")  */
    public $upload_file;

    function getUpload_date() {
        return $this->upload_date;
    }

    function getUpload_no() {
        return $this->upload_no;
    }

    function getUpload_file() {
        return $this->upload_file;
    }

    function setUpload_date($upload_date) {
        $this->upload_date = $upload_date;
    }

    function setUpload_no($upload_no) {
        $this->upload_no = $upload_no;
    }

    function setUpload_file($upload_file) {
        $this->upload_file = $upload_file;
    }

}
