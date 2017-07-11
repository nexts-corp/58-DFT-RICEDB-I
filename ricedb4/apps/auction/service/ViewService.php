<?php

namespace apps\auction\service;

use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\auction\interfaces\IViewService;

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
                . "where st.active = 'Y' or st.active = 'T' ";
        $data = $this->datacontext->getObject($status);
        if (count($data) > 0) {
            $view->auction = $data[0];
        } else {
            $view->auction = "";
        }

        return $view;
    }

    public function news($auctionCode) {
        $sql = "EXEC sp_auction_news :auctionNo";
        $param = array(
            "auctionNo" => $auctionCode
        );

        $data = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")[0];
        $res = "โดยผลจากการเปิดซองเสนอราคาซื้อในช่วงบ่ายปรากฏว่ามีผู้สนใจมายื่นซอง จำนวน "
                . $data->checkIn . " ราย <br>โดยมีผู้เสนอราคาซื้อสูงสุด จำนวน " . $data->winner . " ราย "
                . "ใน " . $data->warehouse . " คลัง ปริมาณ " . number_format($data->weightAuc, 2, '.', ',') . " ล้านตัน "
                . "(คิดเป็นร้อยละ " . number_format($data->weightPercent, 2, '.', ',') . " ของปริมาณที่เปิดประมูลทั้งหมด) <br>"
                . "มูลค่าที่เสนอซื้อประมาณ " . number_format($data->priceAuc, 2, '.', ',') . " ล้านบาท "
                . "โดยช่วงราคาเสนอซื้อสูงสุด " . number_format($data->minPrice, 2, '.', ',') . " – " . number_format($data->maxPrice, 2, '.', ',') . " บาท/ตัน "
                . "<br>สำหรับชนิดข้าวที่มีผู้เสนอราคาซื้อมากที่สุดเป็น <br>" . $data->detail;
        print $res;
        exit();
    }

}
