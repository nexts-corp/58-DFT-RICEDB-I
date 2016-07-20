<?php

namespace apps\industry2\service;

use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\industry2\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;

    public function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function bidderInfo() {
        $view = new CJView("bidderInfo", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderItem() {
        $view = new CJView("bidderItem", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderPrice() {
        $view = new CJView("bidderPrice", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderPayment() {
        $view = new CJView("bidderPayment", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderAuction() {
        $view = new CJView("bidderAuction", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderPriceCF() {
        $view = new CJView("bidderPriceCF", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderReturn() {
        $view = new CJView("bidderReturn", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderProperty() {
        $view = new CJView("monitor/bidderProperty", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderProperty2() {
        $view = new CJView("monitor/bidderProperty2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderPriceAll() {
        $view = new CJView("monitor/bidderPriceAll", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderMaxPriceOne() {
        $view = new CJView("monitor/bidderMaxPriceOne", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderMaxPriceOne2() {
        $view = new CJView("monitor/bidderMaxPriceOne2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderMaxPriceMore() {
        $view = new CJView("monitor/bidderMaxPriceMore", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderMaxPriceMore2() {
        $view = new CJView("monitor/bidderMaxPriceMore2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderWinner() {
        $view = new CJView("monitor/bidderWinner", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function bidderWinner2() {
        $view = new CJView("monitor/bidderWinner2", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function closeAuction() {
        $view = new CJView("closeAuction", CJViewType::HTML_VIEW_ENGINE);
        $status = "select st from apps\\common\\entity\\Status st "
                . "where st.active = 'YI2' or st.active = 'TI2' ";
        $data = $this->datacontext->getObject($status);
        if(count($data) > 0){
            $view->auction = $data[0];
        }
        else{
            $view->auction = "";
        }

        return $view;
    }

}
