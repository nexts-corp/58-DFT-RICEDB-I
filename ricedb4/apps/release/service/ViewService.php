<?php
namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\release\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public function manageRelease() {
        $view = new CJView("manageRelease", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function createRelease() {
        $view = new CJView("createRelease", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function viewRelease() {
        $view = new CJView("viewRelease", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function manageDiscount() {
        $view = new CJView("manageDiscount", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function manageShippingCost() {
        $view = new CJView("manageShippingCost", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function floorPrice() {
        $view = new CJView("floorPrice", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function floorValue() {
        $view = new CJView("floorValue", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }
    
    public function floorValueSilo() {
        $view = new CJView("floorValueSilo", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function compareFloorPrice() {
        $view = new CJView("compareFloorPrice", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function chooseFloorValue() {
        $view = new CJView("chooseFloorValue", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
