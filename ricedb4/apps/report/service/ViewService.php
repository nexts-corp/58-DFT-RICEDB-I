<?php

namespace apps\report\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\report\interfaces\IViewService;
class ViewService extends CServiceBase implements IViewService {


    public function reportAuction() {
         $view = new CJView("reportAuction", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }


}
