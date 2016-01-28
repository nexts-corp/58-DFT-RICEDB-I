<?php

namespace apps\industry\service;


use apps\industry\interfaces\IProcessService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class ProcessService extends CServiceBase implements IProcessService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    function getStatus() {
        $sqStatus = "SELECT s"
            ." FROM " . $this->ent . "\\Status s "
            ." WHERE s.active = :active";
        $paramS = array(
            "active" => "Y"
        );
        $dataStatus = $this->datacontext->getObject($sqStatus, $paramS); //get STATUS is Active
        return $dataStatus[0];
    }

    public function listsProcess(){
        $return = true;

        /*$sql1 = "select bt.silo, max(ps.auctionPrice) AS pMax, bh.id"
            ." FROM ".$this->ent."\\BidderPriceSilo ps"
		    ." JOIN ".$this->ent."\\BidderItem bt WITH ps.bidderItemId=bt.id"
            ." JOIN ".$this->ent."\\BidderHistory bh WITH bt.bidderHistoryId=bh.id"
            ." WHERE bh.statusKeyword=:keyword"
		    ." GROUP BY bt.silo, bh.id";
        $param1 = array(
            "keyword" => $this->getStatus()->keyword
        );
        $data1 = $this->datacontext->getObject($sql1, $param1);

        foreach($data1 as $key => $val){
            $sql2 = "SELECT"
		        ." bt.silo, bt.id as bidderItemId, ps.auctionPrice, bt.bidderHistoryId, bi.bidderName"
                ." FROM dft_Bidder_Price_Silo ps
	INNER JOIN dft_Bidder_Item bt ON ps.Bidder_Item_Id=bt.Id
	INNER JOIN dft_Bidder_History bh ON bt.Bidder_History_Id=bh.Id
	INNER JOIN dft_Bidder_Info bi ON bh.LK_Bidder_Id=bi.Id
	INNER JOIN"

        }*/
        // get silo
        $sql = "exec sp_floor_value_warehouse :auctionId, :pProjectId, :pProvinceId, :pTypeId, :pGradeId, :pSilo";
        $param = array(
            "auctionId" => $this->getStatus()->keyword,
            "pProjectId" => 0,
            "pProvinceId" => 0,
            "pTypeId" => 0,
            "pGradeId" => 0,
            "pSilo" => ""
        );
        $data = $this->datacontext->nativeQuery($sql, $param);
        $priceArr = [];
        $weightArr = [];
        foreach($data as $key => $value){
            $priceArr[$value["Silo"]] = $value["RFV2"];
            $weightArr[$value["Silo"]] = $value["Weight_All"];
        }

        $sql1 = "exec sp_auction_winner :auctionId";
        $param1 = array(
            "auctionId" => $this->getStatus()->keyword
        );
        $data2 = [];
        $data1 = $this->datacontext->nativeQuery($sql1, $param1);
        foreach($data1 as $key1 => $value1){
            $data2[$value1["silo"]][$value1["auctionPrice"]][] = $value1;
        }

        $data3 = [];
        foreach($data2 as $key2 => $value2){
            foreach($value2 as $key3 => $value3){
                $data3[] = array(
                    "silo" => $key2,
                    "weightAll" => $weightArr[$key2],
                    "rfv2" => $priceArr[$key2],
                    "bidder" => $value3
                );
            }
        }
        return $data3;
    }
} 