<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IFloorPriceService;

class FloorPriceService extends CServiceBase implements IFloorPriceService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsAuction() {
        $sql = "SELECT st.id, st.status, st.keyword, st.ageStop, st.dateStart"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.keyword like 'AU%'"
            ." ORDER BY st.id DESC";
        $data = $this->datacontext->getObject($sql);
        return $data;
    }

    public function getFloorPrice($stopDate,$startDate,$endDate,$projectId,$provinceId,$typeId,$gradeId) {
        $sql = "EXEC sp_floor_price :stopDate, :startDate, :endDate, :projectId, :provinceId, :typeId, :gradeId";
        $param = array(
            "stopDate" => $stopDate,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "projectId" => $projectId,
            "provinceId" => $provinceId,
            "typeId" => $typeId,
            "gradeId" => $gradeId
        );

        $result = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\FloorValue2");

        $provk=array();
        //$provs=array();

        $typek=array();
        // $types=array();

        $gradek=array();
        // $grades=array();

        $prj=array();

        for($i=0;$i<count($result);$i++){
            $pid=$result[$i]->LK_Province_Id;
            if(!array_key_exists($pid, $provk)) {
                $provk[$pid]=$result[$i]->Province;
                //  $provs[]=$result[$i];
            }

            $tid=$result[$i]->LK_Type_Id;
            if(!array_key_exists($tid, $typek)) {
                $typek[$tid]=$result[$i]->riceType;
                // $types[]=$result[$i];
            }


            $gid=$result[$i]->LK_Grade_Id;
            if(!array_key_exists($gid, $gradek)) {
                $gradek[$gid]=$result[$i]->Grade;
                //$grades[]=$result[$i];
            }

            $pjid=$result[$i]->LK_Project_Id;
            if(!array_key_exists($pjid, $prj)) {
                $prj[$pjid]=$result[$i]->Project;
                //$grades[]=$result[$i];
            }
        }

        $this->getResponse()->add("project", $prj);
        $this->getResponse()->add("province",$provk);
        $this->getResponse()->add("type",$typek);
        $this->getResponse()->add("grade",$gradek);
        return $result;
    }

}