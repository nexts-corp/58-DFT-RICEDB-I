<?php

namespace apps\tracking\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\tracking\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public function approveAuction() {
        $view = new CJView("approveAuction", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function approveSell() {
        $view = new CJView("approveSell", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function returns() {
        $view = new CJView("return", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function follow() {
        $view = new CJView("follow", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
