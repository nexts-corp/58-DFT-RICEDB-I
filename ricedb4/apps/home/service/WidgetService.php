<?php
namespace apps\home\service;

use apps\home\interfaces\IWidgetService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class WidgetService extends CServiceBase implements IWidgetService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
    
    public function projectGroup() {
        $sql = "SELECT"
            ." pj.project, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\Project pj WITH pj.id=ri.projectId"
        ." GROUP BY pj.project"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);
        
        return $data;
    }

    public function typeGroup() {
        $sql = "SELECT"
            ." tp.type, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\Type tp WITH tp.id=ri.typeId"
        ." GROUP BY tp.type"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function gradeGroup() {
        $sql = "SELECT"
            ." gd.grade, sum(ri.tWeight) AS weight"
        ." FROM ".$this->ent."\\RiceInfo ri"
        ." JOIN ".$this->ent."\\grade gd WITH gd.id=ri.gradeId"
        ." GROUP BY gd.grade"
        ." ORDER BY weight DESC";

        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function ricePrice(){
        $sql = "SELECT"
            ." pd.[Date], tp.Type,"
	        ." pd.OldPriceMin1, pd.OldPriceMax1, pd.NewPriceMin1, pd.NewPriceMax1,"
	        ." pd.OldPriceMin2, pd.OldPriceMax2, pd.NewPriceMin2, pd.NewPriceMax2"
        ." FROM dft_Price_Daily pd"
        ." INNER JOIN dft_LK_Type tp ON tp.Id = pd.LK_Type_Id"
        ." WHERE date ="
	        ." (SELECT TOP 1 date FROM dft_Price_Daily"
	        ." GROUP BY date"
	        ." ORDER BY date DESC)"
        ." AND"
            ." (pd.OldPriceMin1 != '0.0' OR pd.OldPriceMax1 != '0.0' OR pd.NewPriceMin1 != '0.0' OR pd.NewPriceMax1 != '0.0' OR"
            ." pd.OldPriceMin2 != '0.0' OR pd.OldPriceMax2 != '0.0' OR pd.NewPriceMin2 != '0.0' OR pd.NewPriceMax2 != '0.0')";

        $data = $this->datacontext->pdoQuery($sql);
        return $data;
    }
} 