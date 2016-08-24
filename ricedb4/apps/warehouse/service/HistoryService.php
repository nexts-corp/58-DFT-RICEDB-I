<?php

namespace apps\warehouse\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\warehouse\interfaces\IHistoryService;

class HistoryService extends CServiceBase implements IHistoryService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function find($warehouse) {
        $object = "select wh.provinceId, "
                . "wh.province, "
                . "wh.associateId, "
                . "wh.associate, "
                . "wh.wareHouseCode "
                . "from " . $this->ent . "\\AuctionWarehouse wh "
                . "where wh.wareHouseCode like :warehouse "
                . "group by  wh.provinceId, "
                . "wh.province, "
                . "wh.associateId, "
                . "wh.associate, "
                . "wh.wareHouseCode ";
        $params = array(
            "warehouse" => "%" . $warehouse . "%"
        );
        return $this->datacontext->getObject($object, $params);
    }

    public function get($warehouse) {
        $object = "select wh.auctionNo, wh.wareHouseId from " . $this->ent . "\\AuctionWarehouse wh "
                . "where wh.wareHouseCode = :warehouse "
                . "group by wh.auctionNo, wh.wareHouseId ";
        $params = array(
            "warehouse" => $warehouse
        );
        $dataAuction = $this->datacontext->getObject($object, $params);
        $history = array();
        foreach ($dataAuction as $key => $value) {
            $query = "select "
                    . " auc.auctionNo, "
                    . " auc.auctionCode, "
                    . " auc.wareHouseId, "
                    . " auc.wareHouseCode, "
                    . " auc.weightAll, "
                    . " auc.FV, "
                    . " auc.FV2, "
                    . " auc.FV3, "
                    . " auc.FV4, "
                    . " auc.bidderNo, "
                    . " auc.bidderName, "
                    . " auc.bidderPrice, "
                    . " auc.remarkPrice, "
                    . " auc.bidderPassFV, "
                    . " auc.bidderWinner, "
                    . " auc.isSale "
                    . " from fn_auction_info(:auctionNo) auc"
                    . " where auc.wareHouseId = :wareHouseId "
                    . " and ( "
                    . " ( auc.bidderNo is not null and auc.bidderMaxPrice = 'Y') or (auc.bidderNo is null) "
                    . " )"
                    . " order by bidderPrice desc ";
            //  . " and auc.bidderMaxPrice = 'Y' ";
            $param = array(
                "auctionNo" => $value["auctionNo"],
                "wareHouseId" => $value["wareHouseId"]
            );
            array_push($history, $this->datacontext->pdoQuery($query, $param)[0]);
        }
        return $history;
    }

}
