<?php

namespace apps\reserve\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\reserve\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public function manageReserve() {
        $view = new CJView("manages", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function exportReserve() {
        $view = new CJView("exportReserve", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function importReserve() {
        $view = new CJView("importReserve", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function filter() {
        $view = new CJView("filter", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
