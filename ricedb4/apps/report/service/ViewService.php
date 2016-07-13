<?php

namespace apps\report\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\report\interfaces\IViewService;
class ViewService extends CServiceBase implements IViewService {


    public function reportAuction() {
         $view = new CJView("auction", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function reportIndustry() {
        $view = new CJView("industry", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function reportIndustry2() {
        $view = new CJView("industry2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function reportOrder() {
        $view = new CJView("order", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
