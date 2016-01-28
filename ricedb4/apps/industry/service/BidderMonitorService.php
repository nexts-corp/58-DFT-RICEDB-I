<?php

namespace apps\industry\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry\interfaces\IBidderMonitorService;

class BidderMonitorService extends CServiceBase implements IBidderMonitorService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function getStatus() {
        $sql = "SELECT"
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "Y"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }

    public function listsProperty() {
        $return = [];

        $sql = "SELECT"
                . " bh.queue, bi.bidderName, bh.property1, bh.property2,"
                . " bh.property3, bh.property4, bh.property5, bh.checkIn"
                . " FROM " . $this->ent . "\\BidderHistory bh"
                . " JOIN " . $this->ent . "\\BidderInfo bi WITH bi.id = bh.bidderId"
                . " WHERE bh.statusKeyword = :statusKeyword"
                . " ORDER BY bh.queue ASC";
        $param = array(
            "statusKeyword" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->getObject($sql, $param);
        foreach ($data as $key => $value) {
            $property = 'Y';
            if ($value["property1"] == 'N' || $value["property2"] == 'N' || $value["property3"] == 'N' || $value["property4"] == 'N' || $value["property5"] == 'N') {
                $property = 'N';
            }

            array_push($return, array(
                "queue" => $value["queue"],
                "bidderName" => $value["bidderName"],
                "property" => $property,
                "checkIn" => $value["checkIn"]
            ));
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }

    public function maxPriceOne() {
        $return = [];

        $sql = "EXEC sp_RPT03_03 :auctionCode";
        $param = array(
            "auctionCode" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach ($data as $key => $value) {
            $return[$value["province"]][] = $value;
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }
    
    public function maxPriceOne2() {
        $return = [];

        $sql = "EXEC sp_RPT03_03 :auctionCode";
        $param = array(
            "auctionCode" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach ($data as $key => $value) {
            $return[$value["province"]][] = $value;
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }

    public function maxPriceMore() {
        $return = [];

        $sql = "EXEC sp_RPT03_04 :auctionCode";
        $param = array(
            "auctionCode" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach ($data as $key => $value) {
            $return[$value["province"]][$value["wareHouseCode"]][$value["associate"]][] = $value;
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }

    public function winner() {
        $return = [];

        $sql = "EXEC sp_RPT03_07_00 :auctionCode";
        $param = array(
            "auctionCode" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach ($data as $key => $value) {
            $return[$value["province"]][] = $value;
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }

    public function priceAll() {
        $return = [];

        $sql = "EXEC sp_RPT03_01 :auctionCode";
        $param = array(
            "auctionCode" => $this->getStatus()->keyword
        );
        $data = $this->datacontext->pdoQuery($sql, $param);
        foreach ($data as $key => $value) {
            $return[$value["province"]][$value["wareHouseCode"]][$value["associate"]][] = $value;
        }

        $this->getResponse()->add("auction", $this->getStatus());

        return $return;
    }

}
