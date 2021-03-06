<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IChooseFloorValueService;

class ChooseFloorValueService extends CServiceBase implements IChooseFloorValueService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT"
                . " st.id, st.status, st.keyword"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword like 'AU%'"
                . " AND st.active like 'Y%' "
                . " ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function listsRiceType($auction) {
        $sql = "SELECT"
                . " rt.useType as typeId, tp.type, rt.useFV "
                . " FROM " . $this->ent . "\\RiceTracking rt"
                . " JOIN " . $this->ent . "\\Type tp WITH tp.id = rt.useType"
                . " WHERE rt.statusKeyword = :auction"
                . " GROUP BY rt.useType, tp.type, rt.useFV";
        $param = array(
            "auction" => $auction
        );
        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function previewFV($auction, $riceType) {
        $rArr = [];
        foreach ($riceType as $key => $val) {
            $rArr[$val->typeId] = strtolower($val->value);
        }

        $st = new \apps\common\entity\AuctionStack();
        $st->auctionNo = $auction;
        $data = $this->datacontext->getObject($st);
        //return $rArr;
        $sArr = [];
        foreach ($data as $key => $val) {
            $fv = $val->fv;
            if ($rArr[$val->typeId] == "fv2") {
                $fv = $val->fv2;
            } else if ($rArr[$val->typeId] == "fv3") {
                $fv = $val->fv3;
            } else if ($rArr[$val->typeId] == "fv4") {
                $fv = $val->fv4;
            }
            $sArr[$val->province][$val->wareHouseCode][$val->associate][] = array(
                "warehouse" => $val->warehouse,
                "stack" => $val->stack,
                "typeName" => $val->typeName,
                "oweightAll" => $val->oweightAll,
                "useFV" => strtoupper($rArr[$val->typeId]),
                "FV" => $fv
            );
        }

        //get bidder max
        $bMax = [];
        $sql = "SELECT * FROM fn_auction_info(:auction)"
                . " WHERE bidderMaxPrice = :isMax";
        $param = array(
            "auction" => $auction,
            "isMax" => 'Y'
        );
        $data2 = $this->datacontext->pdoQuery($sql, $param);

        foreach ($data2 as $key => $val) {
            $bMax[$val["province"]][$val["wareHouseCode"]][$val["associate"]] = array(
                "bidderName" => $val["bidderName"],
                "bidderPrice" => $val["bidderPrice"]
            );
        }

        $result = [];

        foreach ($sArr as $prov => $val1) {
            foreach ($val1 as $wh => $val2) {
                foreach ($val2 as $ac => $val3) {
                    $stArr = [];
                    $sWeight = 0;
                    $sFV = 0;

                    foreach ($val3 as $key => $val4) {
                        $stArr[] = $val4;

                        $sWeight += $val4["oweightAll"];
                        $sFV += $val4["FV"];
                    }

                    $bName = '';
                    $bPrice = '';
                    if (isset($bMax[$prov][$wh][$ac])) {
                        $bName = $bMax[$prov][$wh][$ac]["bidderName"];
                        $bPrice = $bMax[$prov][$wh][$ac]["bidderPrice"];
                    }

                    $result[] = array(
                        "silo" => $wh,
                        "associate" => $ac,
                        "province" => $prov,
                        "sOWeightAll" => $sWeight,
                        "sFV" => $sFV,
                        "bidderName" => $bName,
                        "bidderPrice" => $bPrice,
                        "stackArr" => $stArr
                    );
                }
            }
        }

        return $result;
    }

    public function saveFV($auction, $riceType) {
        foreach ($riceType as $key => $val) {
            $sql = "UPDATE"
                    . " dft_Rice_Tracking"
                    . " SET UseFV = '" . strtoupper($val->value) . "'"
                    . " WHERE useType = '" . $val->typeId . "'"
                    . " AND LK_Status_Keyword = '" . $auction . "'";

            $cmd = "EXEC sp_batch_exce :cmd";
            $param = array(
                "cmd" => $sql
            );

            if (!$this->datacontext->pdoQuery($cmd, $param, "apps\\common\\model\\SQLUpdate")) {
                return $this->datacontext->getLastMessage();
            }
        }

        $up = "EXEC sp_floor_value_update :auctionId";
        $param = array(
            "auctionId" => $auction
        );
        if (!$this->datacontext->pdoQuery($up, $param)) {
            return $this->datacontext->getLastMessage();
        }

        return true;
    }

    public function clearFV($auction) {
        $sql = "UPDATE"
                . " dft_Rice_Tracking"
                . " SET UseFV = ''"
                . " WHERE LK_Status_Keyword = '" . $auction . "'";

        $cmd = "EXEC sp_batch_exce :cmd";
        $param = array(
            "cmd" => $sql
        );

        if (!$this->datacontext->pdoQuery($cmd, $param, "apps\\common\\model\\SQLUpdate")) {
            return $this->datacontext->getLastMessage();
        }

        $up = "EXEC sp_floor_value_update :auctionId";
        $param = array(
            "auctionId" => $auction
        );
        if (!$this->datacontext->pdoQuery($up, $param)) {
            return $this->datacontext->getLastMessage();
        }

        return true;
    }

    public function siloHistory($silo) {
        $sql = "SELECT rt.silo,rt.statusKeyword "
                . "FROM " . $this->ent . "\\RiceTracking rt "
                . "WHERE rt.silo = :silo "
                . "AND rt.statusKeyword not like '%_BAK' "
                . "AND rt.statusKeyword not like '%_CUT' "
                . "GROUP BY rt.silo,rt.statusKeyword ";
        $param = array(
            "silo" => $silo
        );

        return $this->datacontext->getObject($sql, $param);
    }

}
