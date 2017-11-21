<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_Bidder_Document")
 */
class BidderDocument extends EntityBase {

    /**
     * @Id 
     * @Column(type="string",length=50,name="id")
     */
    public $id;

    /** @Column(type="string",length=50, name="auction_id") */
    public $auctionId;

    /** @Column(type="string",length=50, name="history_id") */
    public $historyId;

    /** @Column(type="string",length=50, name="type_doc_id") */
    public $typeDocId;

    /** @Column(type="string",length=255, name="doc_name") */
    public $docName;

    /** @Column(type="string",length=255, name="type_file") */
    public $typeFile;

    /** @Column(type="string",length=255, name="path_file") */
    public $pathFile;

    /** @Column(type="string",length=255, name="thumbnail") */
    public $thumbnail;

    /** @Column(type="integer",length=11, name="size_file") */
    public $sizeFile;

    function getId() {
        return $this->id;
    }

    function getAuctionId() {
        return $this->auctionId;
    }

    function getHistoryId() {
        return $this->historyId;
    }

    function getTypeDocId() {
        return $this->typeDocId;
    }

    function getDocName() {
        return $this->docName;
    }

    function getTypeFile() {
        return $this->typeFile;
    }

    function getPathFile() {
        return $this->pathFile;
    }

    function getThumbnail() {
        return $this->thumbnail;
    }

    function getSizeFile() {
        return $this->sizeFile;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAuctionId($auctionId) {
        $this->auctionId = $auctionId;
    }

    function setHistoryId($historyId) {
        $this->historyId = $historyId;
    }

    function setTypeDocId($typeDocId) {
        $this->typeDocId = $typeDocId;
    }

    function setDocName($docName) {
        $this->docName = $docName;
    }

    function setTypeFile($typeFile) {
        $this->typeFile = $typeFile;
    }

    function setPathFile($pathFile) {
        $this->pathFile = $pathFile;
    }

    function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    function setSizeFile($sizeFile) {
        $this->sizeFile = $sizeFile;
    }

}
