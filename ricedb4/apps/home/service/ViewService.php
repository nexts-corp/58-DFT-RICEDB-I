<?php

namespace apps\home\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\home\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {
    
    public function inventory() {
        $view = new CJView("inventory", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
