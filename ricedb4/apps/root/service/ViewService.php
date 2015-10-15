<?php

namespace apps\root\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\root\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public function index() {
        $view = new CJView("home", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function logout() {
        unset($_COOKIE['token']);
        $view = new CJView("home", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
