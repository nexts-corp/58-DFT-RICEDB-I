<?php

namespace apps\reserve\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\reserve\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function manageReserve() {
        $view = new CJView("manages", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

//    public function exportReserve() {
//        $view = new CJView("exportReserve", CJViewType::HTML_VIEW_ENGINE);
//        return $view;
//    }

    public function importReserve() {
        $status = new \apps\common\entity\Status();
        $status->id = $this->getRequest()->status;
        $data = $this->datacontext->getObject($status);
        if ((count($data) == 1) && ((strpos($data[0]->active, "W") > -1) || (strpos($data[0]->active, "R") > -1))) {
            $view = new CJView("importReserve", CJViewType::HTML_VIEW_ENGINE);
            $view->statusId = $this->getRequest()->status;
            $view->statusName = $data[0]->status;
            return $view;
        } else {
//            return 0;
            header("Location: /ricedb4/api/root/view/index");
            exit();
        }
    }

    public function filter() {
        $view = new CJView("filter", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function confirm() {
        $view = new CJView("confirm", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
