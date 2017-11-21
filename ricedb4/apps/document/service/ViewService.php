<?php

namespace apps\document\service;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\document\interfaces\IViewService;
class ViewService extends CServiceBase implements IViewService {


    public function auction() {
         $view = new CJView("auction", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function industry() {
        $view = new CJView("industry", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function industry2() {
        $view = new CJView("industry2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function order() {
        $view = new CJView("order", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
