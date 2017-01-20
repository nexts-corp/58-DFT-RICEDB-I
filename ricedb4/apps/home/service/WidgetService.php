<?php

namespace apps\home\service;

use apps\home\interfaces\IWidgetService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class WidgetService extends CServiceBase implements IWidgetService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function projectGroup() {
        //$sql = "SELECT project, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY project ORDER BY sum(tWeight) DESC";
        $sql = "SELECT project, sum(tWeight) AS weight FROM fn_product8() GROUP BY project ORDER BY sum(tWeight) DESC";
        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function typeGroup() {
        //$sql = "SELECT type, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY type ORDER BY sum(tWeight) DESC";
        $sql = "SELECT type, sum(tWeight) AS weight FROM fn_product8() GROUP BY type ORDER BY sum(tWeight) DESC";
        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function gradeGroup() {
        //$sql = "SELECT grade, sum(tWeight) AS weight FROM fn_rice_tracking() WHERE status IS NULL GROUP BY grade ORDER BY sum(tWeight) DESC";
        $sql = "SELECT grade, sum(tWeight) AS weight FROM fn_product8() GROUP BY grade ORDER BY sum(tWeight) DESC";

        $data = $this->datacontext->pdoQuery($sql);

        return $data;
    }

    public function ricePrice() {
        $sql = "SELECT"
                . " pd.[Date], tp.Type,"
                . " pd.OldPriceMin1, pd.OldPriceMax1, pd.NewPriceMin1, pd.NewPriceMax1,"
                . " pd.OldPriceMin2, pd.OldPriceMax2, pd.NewPriceMin2, pd.NewPriceMax2"
                . " FROM dft_Price_Daily pd"
                . " INNER JOIN dft_LK_Type tp ON tp.Id = pd.LK_Type_Id"
                . " WHERE date ="
                . " (SELECT TOP 1 date FROM dft_Price_Daily"
                . " GROUP BY date"
                . " ORDER BY date DESC)"
                . " AND"
                . " (pd.OldPriceMin1 != '0.0' OR pd.OldPriceMax1 != '0.0' OR pd.NewPriceMin1 != '0.0' OR pd.NewPriceMax1 != '0.0' OR"
                . " pd.OldPriceMin2 != '0.0' OR pd.OldPriceMax2 != '0.0' OR pd.NewPriceMin2 != '0.0' OR pd.NewPriceMax2 != '0.0')";

        $data = $this->datacontext->pdoQuery($sql);
        return $data;
    }

    public function auctionLatest() {
        $result = array();

        $sqlSt = "SELECT"
                . " st.status, st.auctionDate, st.keyword"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE 'AU%' AND st.active = :active "
                . " ORDER BY st.dateCreated DESC";
        $paramSt = array(
            "active" => "F"
        );

        $dataSt = $this->datacontext->getObject($sqlSt, $paramSt, 1); //get STATUS is Active

        if (count($dataSt) > 0) {
            $sqlSm = "SELECT"
                    . " sum(oweightAll) AS sumWeight, sum(bidderPrice) AS sumPrice"
                    . " FROM fn_auction_info(:auction)"
                    . " WHERE isSale = 'Y'";
            $paramSm = array(
                "auction" => $dataSt[0]["keyword"]
            );
            $dataSm = $this->datacontext->pdoQuery($sqlSm, $paramSm);

            $sql = "SELECT"
                    . " st.typeName, sum(st.oweightAll) AS weight"
                    . " FROM fn_auction_info(:auction) fn"
                    . " JOIN dft_auction_stack st ON st.wareHouseCode = fn.wareHouseCode AND st.associateId = fn.associateId AND st.auctionNo = fn.auctionNo"
                    . " WHERE isSale = 'Y'"
                    . " GROUP BY st.typeName";

            $param = array(
                "auction" => $dataSt[0]["keyword"]
            );
            $data = $this->datacontext->pdoQuery($sql, $param);

            $result["status"] = $dataSt[0]["status"];
            $result["auctionDate"] = $dataSt[0]["auctionDate"];
            $result["sumWeight"] = $dataSm[0]["sumWeight"];
            $result["sumPrice"] = $dataSm[0]["sumPrice"];
            $result["riceGroup"] = $data;
        }

        return $result;
    }

    public function viewReserve() {
        $sql = "SELECT"
                . " rs.reserveName, rl.detail, rl.keyword, rl.target"
                . " FROM " . $this->ent . "\\ReserveList rl"
                . " JOIN " . $this->ent . "\\Reserve rs WITH rs.reserveCode = rl.reserveCode"
                . " ORDER BY rl.id ASC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function tracking() {
        $sqlSt = "SELECT"
                . " st.status, st.auctionDate, st.keyword, st.auctionDate ,st.auctionDay2"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.keyword LIKE 'AU%' and st.keyword not like '%-%'"
                . " ORDER BY st.dateCreated DESC";

        $dataSt = $this->datacontext->getObject($sqlSt); //get list status

        $status = array();
        foreach ($dataSt as $key => $value) { //find rice_tracking is sale = Y by status_keyword
            $sqlCount = "select tr from " . $this->ent . "\\RiceTracking tr "
                    . "where tr.statusKeyword = :keyword and tr.isSale = 'Y'";
            $paramCount = array(
                "keyword" => $value['keyword']
            );
            $data = $this->datacontext->getObject($sqlCount, $paramCount);
            if (count($data) > 0) { // count rows data if > 0 break; (auction lastest!!)
                $status = $value;
                break;
            }
        }
        if (!empty($status)) { // if have data then to find weight
            $sql = "SELECT 
                        statusKeyword,
                        statusName,
                        associateId,
                        associate,
                        isnull(sum(weightApprove),0) as weightApprove,
                        isnull(sum(weightContract),0) as weightContract,
                        isnull(sum(weightReceived),0) as weightReceived,
                        isnull(sum(weightBalance),0) as weightBalance,
                        isnull(sum(weightLost),0) as weightLost
                    FROM dbo.view_rice_follow
                    WHERE statusKeyword = '" . $status["keyword"] . "'
                    group by
                        statusKeyword,
                        statusName,
                        associateId,
                        associate";
            $status["tracking"] = $this->datacontext->pdoQuery($sql);
            foreach ($status["tracking"] as $keyT => $valueT) {
                foreach ($valueT as $keyF => $valueF) {
                    if (substr($keyF, 0, 6) == "weight") {
                        if (!isset($status[$keyF]))
                            $status[$keyF] = 0;
                        $status[$keyF] += (float) $valueF;
                    }
                }
            }
            $day = explode(" ", $status["auctionDay2"]);
            $strMonthCut = Array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤภษาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $d = $day[0];
            $m = array_search($day[1], $strMonthCut);
            if ($m < 10)
                $m = "0" . $m;
            $y = (int) $day[2] - 543;

            $now = time(); // or your date as well
            $your_date = strtotime("$y-$m-$d");
            $datediff = $now - $your_date;

            $status["daysPass"] = floor($datediff / (60 * 60 * 24));
            return $status;
        } else {
            return "no data";
        }
    }

}
