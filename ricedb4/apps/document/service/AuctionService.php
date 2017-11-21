<?php

namespace apps\document\service;

use apps\document\interfaces\IAuctionService;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\core\CServiceBase;

class AuctionService extends CServiceBase implements IAuctionService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";
    public $upload;

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT st "
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE :keyword "
                . " and st.keyword NOT LIKE :keyword2 "
                . " and st.active in ('Y','F') "
                . " ORDER BY st.id DESC";
        $param = array(
            "keyword" => "AU%",
            "keyword2" => "%-%"
        );
        $dataAuction = $this->datacontext->getObject($sql, $param);
        return $dataAuction;
    }

    public function listsBidder($auctionId) {
        $sql = "select
                    auctionNo,
                    bidderRegisterId as bidderHistoryId,
                    bidderQueue,
                    bidderTaxId,
                    bidderName,
                    bidderTypeName,
                    bidderAgent,
                    bidderStatusCode,
                    isCheckIn
                from fn_auction_bidder_info(:auctionId)";
        $param = array(
            "auctionId" => $auctionId
        );
        return $this->datacontext->pdoQuery($sql, $param);
    }

    public function listsTypeDoc() {
        $listDoc = new \apps\common\entity\TypeDoc();
        return $this->datacontext->getObject($listDoc);
    }

    function getGUID() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = ""//chr(123)// "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
            //. chr(125); // "}"
            return $uuid;
        }
    }

    public function listsFile($historyId, $typeDocId) {
        $sql = "select "
                . " bd.id,"
                . " bd.historyId,"
                . " bd.typeDocId,"
                . " td.typeDocName,"
                . " bd.docName as name,"
                . " bd.typeFile as type,"
                . " bd.pathFile as url,"
                . " bd.thumbnail as thumbnailUrl,"
                . " '../delete/'+bd.id as deleteUrl,"
                . " bd.sizeFile as size,"
                . " 'DELETE' as deleteType"
                . " from " . $this->ent . "\\BidderDocument bd "
                . " join " . $this->ent . "\\TypeDoc td with td.id = bd.typeDocId "
                . " where bd.historyId = :historyId ";
        $param = array(
            "historyId" => $historyId
        );
        if ($typeDocId != "ALL") {
            $sql .= " and bd.typeDocId = :typeDocId ";
            $param['typeDocId'] = $typeDocId;
        }
        return $this->datacontext->getObject($sql, $param);
    }

    public function upload($files, $auctionId, $historyId, $taxId, $typeDoc) {
//        var_dump($files);
        $auc = str_replace("-", "_", str_replace("/", "_", $auctionId));
        $dir = './public/auction/' . $auc . '/' . $taxId;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $target = $dir . '/' . $files['name'][0];
        $arr[] = array(
            "name" => $files['name'][0],
            "size" => (int) $files['size'][0]
        );
//        return $files;
        if (move_uploaded_file($files["tmp_name"][0], $target)) {
            $bidderDoc = new \apps\common\entity\BidderDocument();
            $bidderDoc->id = $this->getGUID();
            $bidderDoc->historyId = $historyId;
            $bidderDoc->auctionId = $auctionId;
            $bidderDoc->typeDocId = $typeDoc;
            $bidderDoc->docName = $files['name'][0];
            $bidderDoc->sizeFile = (int) $files['size'][0];
            $bidderDoc->pathFile = '../../.' . $dir . '/' . $bidderDoc->docName;
            $bidderDoc->thumbnail = '../../.' . $dir . '/' . $bidderDoc->docName;
            $bidderDoc->typeFile = $files['type'][0];
            if ($files['type'][0] == "application/pdf") {
                $bidderDoc->thumbnail = '../../../public/auction/pdf.png';
            } else if (($files['type'][0] == "application/vnd.ms-excel") || ($files['type'][0] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
                $bidderDoc->thumbnail = '../../../public/auction/excel.png';
            } else if ($files['type'][0] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                $bidderDoc->thumbnail = '../../../public/auction/word.png';
            }
            if ($this->datacontext->saveObject($bidderDoc)) {
                $arr[0]["url"] = $bidderDoc->pathFile;
                $arr[0]["thumbnailUrl"] = $bidderDoc->thumbnail;
                $arr[0]["deleteUrl"] = "/delete/" . $bidderDoc->id;
                $arr[0]["deleteType"] = "DELETE";
                $td = new \apps\common\entity\TypeDoc();
                $td->id = $typeDoc;
                $arr[0]["typeDocName"] = $this->datacontext->getObject($td)[0]->typeDocName;
                return $arr;
            }
        } else {
            $arr[0]["error"] = "File cann't upload.";
            return $arr;
        }
    }

}
