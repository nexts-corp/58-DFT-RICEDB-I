<?php

namespace apps\document\interfaces;

/**
 * @name IAuctionService
 * @uri /auction
 * @description ประมูล
 */
interface IAuctionService {

    /**
     * @name listsAuction
     * @uri /listsAuction
     * @return String[] lists Description
     * @description รายการประมูล
     */
    public function listsAuction();

    /**
     * @name listsBidder
     * @uri /listsBidder
     * @param String auctionId
     * @return String[] lists Description
     * @description รายชื่อผู้เข้าประมูล
     */
    public function listsBidder($auctionId);

    /**
     * @name listsTypeDoc
     * @uri /listsTypeDoc
     * @return String[] lists Description
     * @description รายการประเภทเอกสาร
     */
    public function listsTypeDoc();

    /**
     * @name upload
     * @uri /upload
     * @param file files
     * @param string auctionId
     * @param string historyId
     * @param string taxId
     * @param string typeDoc
     * @return string files
     * @description อัพโหลดไฟล์
     */
    public function upload($files,$auctionId,$historyId,$taxId,$typeDoc);

    /**
     * @name listsFile
     * @uri /listsFile
     * @param string historyId
     * @param string typeDocId
     * @return string files
     * @description รายการไฟล์
     */
    public function listsFile($historyId,$typeDocId);
}
