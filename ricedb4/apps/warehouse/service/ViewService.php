<?php

namespace apps\warehouse\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\warehouse\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {
    
    public function warehouseinfo() {
        $view = new CJView("warehouseInfo", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function warehouseImport() {
        $view = new CJView("warehouseImport", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function viewRicePrice() {
        $view = new CJView("viewRicePrice", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function viewRicePriceAvg() {
        $view = new CJView("viewRicePriceAvg", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function viewInventory() {
        $view = new CJView("viewInventory", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
