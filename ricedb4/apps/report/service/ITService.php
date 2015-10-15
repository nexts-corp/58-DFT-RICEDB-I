<?php

namespace apps\report\service;

use apps\report\interfaces\IITService;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\core\CServiceBase;

class ITService extends CServiceBase implements IITService {

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

    public function warehouse() {
        $sql = "select aw from " . $this->ent . "\\AuctionWarehouse aw"
                . " where aw.auctionNo = :auctionNo "
                . " order by  aw.province,aw.associate,aw.wareHouseCode";
        $param = array(
            "auctionNo" => $this->getStatus()->keyword
        );
        $arr = array();
        $arr["data"] = $this->datacontext->getObject($sql, $param);
        return $arr;
        //     return $this->datacontext->getObject($sql,$param);
    }

    public function stack() {
        $sql = "select ast from " . $this->ent . "\\AuctionStack ast"
                . " where ast.auctionNo = :auctionNo "
                . " order by  ast.province,ast.associate,ast.wareHouseCode";
        $param = array(
            "auctionNo" => $this->getStatus()->keyword
        );
        $arr = array();
        $arr["data"] = $this->datacontext->getObject($sql, $param);
        return $arr;
    }

}
