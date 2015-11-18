<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\tracking\interfaces\IApproveSellService;

class ApproveSellService extends CServiceBase implements IApproveSellService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext("default");
    }

    public function listsRelease() {
        $sql = "SELECT"
                ." st.id, st.status + ' - '+rs.detail as status, st.keyword"
            ." FROM ".$this->ent."\\Status st"
            ." JOIN ".$this->ent."\\Release rl WITH st.releaseCode = rl.releaseCode"
            ." JOIN ".$this->ent."\\ReserveList rs WITH st.reserveKeyword = rs.keyword"
            ." WHERE rl.releaseCode != 'AU'"
            ." ORDER BY st.id ASC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsSell($releaseKeyword){
        $sql = "SELECT"
                ." rp.Id as id, rp.LK_Status_Keyword as statusKeyword, rp.Warehouse_Code as warehouseCode,"
                ." pv.Province_Name_TH as province, ac.Associate as associate, rt.Silo as silo,"
                ." rp.Release_Price as releasePrice, rp.Is_Sale as isSale, rp.Remark as remark"
            ." FROM dft_Release_Price rp"
            ." JOIN dft_Rice_Tracking rt ON  rt.Id = ("
                 ." SELECT  TOP 1 tk.Id"
                 ." FROM dft_Rice_Tracking tk"
                 ." WHERE tk.Warehouse_Code = rp.Warehouse_Code"
            ." )"
            ." JOIN dft_LK_Province pv ON pv.Id = rt.LK_Province_Id"
            ." JOIN dft_LK_Associate ac ON ac.Id = rt.LK_Associate_Id"
            ." WHERE rp.LK_Status_Keyword = :keyword";
        $param = array(
            "keyword" => $releaseKeyword
        );

        $data = $this->datacontext->pdoQuery($sql, $param);

        return $data;
    }

    public function update($data, $isSale, $remark, $statusKeyword) {
        $return = true;
        foreach ($data as $key => $value) {
            $bps = new \apps\common\entity\ReleasePrice();
            $bps->id = $value->id;

            $result = $this->datacontext->getObject($bps)[0];

            $result->isSale = $isSale;
            if ($remark != "-") {
                $result->remark = $remark;
            }

            if($isSale == "Y"){
                $result->releasePrice = str_replace(",", "", $value->releasePrice);
            }
            else{
                $result->releasePrice = 0;
            }

            if ($this->datacontext->updateObject($result)) {
                $tracking = new \apps\common\entity\RiceTracking();
                $tracking->statusKeyword = $statusKeyword;
                $tracking->warehouseCode = $value->warehouseCode;
                $dataTracking = $this->datacontext->getObject($tracking);
                foreach ($dataTracking as $index => $valueData) {
                    $dataTracking[$index]->isSale = $isSale;
                    $dataTracking[$index]->remarkSale = $remark;
                }
                $this->datacontext->updateObject($dataTracking);
            }
            else {
                $return = $this->datacontext->getLastMessage();
            }
        }
        return $return;
    }

    public function delete($releasePrice){
        $return = true;
        $price = new \apps\common\entity\ReleasePrice();
        $price->id = $releasePrice->id;
        $price = $this->datacontext->getObject($price)[0];
        $price->isSale = 'N';
        $price->remark = NULL;
        $price->releasePrice = NULL;
        if ($this->datacontext->updateObject($price)) {
            $tracking = new \apps\common\entity\RiceTracking();
            $tracking->statusKeyword = $price->statusKeyword;
            $tracking->warehouseCode = $price->warehouseCode;
            $dataTracking = $this->datacontext->getObject($tracking);
            foreach ($dataTracking as $index => $valueData) {
                $dataTracking[$index]->isSale = "N";
                $dataTracking[$index]->remarkSale = NULL;
            }
            if(!$this->datacontext->updateObject($dataTracking)){
                $return = false;
            }
        } else {
            $return = false;
        }
        return $return;
    }

}

?>