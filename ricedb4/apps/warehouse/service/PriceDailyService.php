<?php

namespace apps\warehouse\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\warehouse\interfaces\IPriceDailyService;

class PriceDailyService extends CServiceBase implements IPriceDailyService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function select() {
        /*$sql = "SELECT * FROM dft_Price_Daily";
        $res = $this->link->query($sql);
        while ($data = $res->fetch(PDO::FETCH_ASSOC)) {
            array_push($this->result, array(
                "Id" => $data["Id"],
                "LK_Type_Id" => $data["LK_Type_Id"],
                "Date" => $data["Date"],
                "OldPriceMin1" => $data["OldPriceMin1"],
                "OldPriceMax1" => $data["OldPriceMax1"],
                "NewPriceMin1" => $data["NewPriceMin1"],
                "NewPriceMax1" => $data["NewPriceMax1"],
                "OldPriceMin2" => $data["OldPriceMin2"],
                "OldPriceMax2" => $data["OldPriceMax2"],
                "NewPriceMin2" => $data["NewPriceMin2"],
                "NewPriceMax2" => $data["NewPriceMax2"]
            ));
        }
        return $this->result;*/
    }

    public function whereDate($date){
        $sql = "SELECT"
	            ." CASE WHEN  pd.id IS NULL THEN 0 ELSE pd.id END AS id,"
                ." t.id as typeId,"
                ." t.type,"
                ." CASE WHEN pd.date IS NULL THEN :Date1 ELSE pd.date AS date,"
                ." CASE WHEN pd.oldPriceMin1 IS NULL THEN 0 ELSE pd.oldPriceMin1 AS oldPriceMin1,"
                ." CASE WHEN pd.oldPriceMax1 IS NULL THEN 0 ELSE pd.oldPriceMax1 AS oldPriceMax1,"
                ." CASE WHEN pd.newPriceMin1 IS NULL THEN 0 ELSE pd.newPriceMin1 AS newPriceMin1,"
                ." CASE WHEN pd.newPriceMax1 IS NULL THEN 0 ELSE pd.newPriceMax1 AS newPriceMax1,"
                ." CASE WHEN pd.oldPriceMin2 IS NULL THEN 0 ELSE pd.oldPriceMin2 AS oldPriceMin2,"
                ." CASE WHEN pd.oldPriceMax2 IS NULL THEN 0 ELSE pd.oldPriceMax2 AS oldPriceMax2,"
                ." CASE WHEN pd.newPriceMin2 IS NULL THEN 0 ELSE pd.newPriceMin2 AS newPriceMin2,"
                ." CASE WHEN pd.newPriceMax2 IS NULL THEN 0 ELSE pd.newPriceMax2 AS newPriceMax2"
            ." FROM  ".$this->ent."\\Type t"
            ." LEFT JOIN ".$this->ent."\\PriceDaily pd WITH t.id = pd.typeId AND pd.date = :Date2";

        $param = array(
            "Date1" => $date,
            "Date2" => $date
        );

        $data = $this->datacontext->getObject($sql, $param);

        return $data;

    }

    public function whereMonth($date1, $date2) {
        $sql = "SELECT"
                ." pd.date AS start,"
                ." count(pd) AS num"
            ." FROM ".$this->ent."\\PriceDaily pd"
            ." WHERE pd.date >= :Date1 AND pd.date <= :Date2"
            ." GROUP BY pd.date";
        $param = array(
            "Date1" => $date1,
            "Date2" => $date2);
        $data = $this->datacontext->getObject($sql, $param);

        return $data;
    }

    public function save($prices) {
        //print_r($prices);
        $return = true;
        foreach ($prices as $key => $price) {
            if($price->id == 0){
                $price->date = new \DateTime($price->date);
                if(!$this->datacontext->saveObject($price)){
                    $return = $this->datacontext->getLastMessage();
                }
            }
            else{
                $daily = new \apps\common\entity\PriceDaily();
                $daily->id = $price->id;
                $data = $this->datacontext->getObject($daily);
                $data[0]->oldPriceMin1 = $price->oldPriceMin1;
                $data[0]->oldPriceMax1 = $price->oldPriceMax1;
                $data[0]->newPriceMin1 = $price->newPriceMin1;
                $data[0]->newPriceMax1 = $price->newPriceMax1;
                $data[0]->oldPriceMin2 = $price->oldPriceMin2;
                $data[0]->oldPriceMax2 = $price->oldPriceMax2;
                $data[0]->newPriceMin2 = $price->newPriceMin2;
                $data[0]->newPriceMax2 = $price->newPriceMax2;

                if(!$this->datacontext->updateObject($data)){
                    $return = false;
                }
            }
        }
        return $return;
    }

}