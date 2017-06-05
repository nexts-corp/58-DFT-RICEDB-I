<?php

namespace apps\release\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\release\interfaces\IManagesService;

class ManagesService extends CServiceBase implements IManagesService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function lkStatusReserv() {
        $sql = " SELECT st.id,
            st.status,
            st.keyword,
            st.age_stop as ageStop,
            st.date_start as dateStart,
            st.date_end as dateEnd,
            st.active,
            st.activeBy,
            st.sale_by as saleBy,
            st.auctionDate,
            st.auctionDay1,
            st.auctionDay2,
            st.auctionDay3,
            st.auctionDay4,
            st.lengthDecimal,
            st.roundFun,
            st.weightDecimal,
            st.filename,
            st.date_created  as dateCreated,
            st.date_updated as dateUpdated,
            rt.weight
		FROM   dft_lk_Status st 
		left join (
				select lk_status_keyword,sum(tweight) as weight
				from dft_Rice_Tracking
				group by LK_Status_Keyword
                ) rt on st.keyword=rt.lk_status_keyword "
                . "where st.active like 'W%' "
                . "or st.active like 'Y%' "
                . "order by st.id asc";
        return $this->datacontext->pdoQuery($sql);
    }

    public function update($status) {
        if ($status->ageStop != null) {
            $status->ageStop = new \DateTime($status->ageStop);
        }
        if ($status->dateStart != null) {
            $status->dateStart = new \DateTime($status->dateStart);
        }
        if ($status->dateEnd != null) {
            $status->dateEnd = new \DateTime($status->dateEnd);
        }

        if ($this->datacontext->updateObject($status)) {
            if ($status->activeBy != null) {
                $s = new \apps\common\entity\Status();
                $s->setId($status->id);
                $data = $this->datacontext->getObject($s)[0];

                $sql = "select * from fn_rice_price_avg_auction(:auctionCode)";
                $param = array("auctionCode" => $data->getKeyword());
                $checkPrice = $this->datacontext->pdoQuery($sql, $param);

                if (count($checkPrice) > 0) {
                    return $this->updateFV($data->getKeyword());
                } else {
                    return "ไม่มีข้อมูลราคาข้าวประจำวัน";
                }
            } else {
                return true;
            }
        } else {
            return $this->datacontext->getLastMessage();
        }
    }

    function updateFV($auctionCode) {
        $up = "EXEC sp_floor_value_update :auctionId";
        $param = array(
            "auctionId" => $auctionCode
        );

        if (!$this->datacontext->pdoQuery($up, $param)) {
            return $this->datacontext->getLastMessage();
        } else {
            return true;
        }
    }

    public function close($statusCode) {
        $history = new \apps\common\entity\BidderHistory();
        $history->statusKeyword = $statusCode;
        $dataHistory = $this->datacontext->getObject($history);
        if (!$this->datacontext->removeObject($dataHistory)) {
            return $this->datacontext->getLastMessage();
        }
        $item = new \apps\common\entity\BidderItem();
        $item->statusKeyword = $statusCode;
        $dataItem = $this->datacontext->getObject($item);
        if (!$this->datacontext->removeObject($dataItem)) {
            return $this->datacontext->getLastMessage();
        }
        $price = new \apps\common\entity\BidderPriceSilo();
        $price->statusKeyword = $statusCode;
        $dataPrice = $this->datacontext->getObject($price);
        if (!$this->datacontext->removeObject($dataPrice)) {
            return $this->datacontext->getLastMessage();
        }
        $payment = new \apps\common\entity\BidderPayment();
        $payment->statusKeyword = $statusCode;
        $dataPayment = $this->datacontext->getObject($payment);
        if (!$this->datacontext->removeObject($dataPayment)) {
            return $this->datacontext->getLastMessage();
        }
        $status = new \apps\common\entity\Status();
        $status->keyword = $statusCode;
        $data = $this->datacontext->getObject($status)[0];
        $data->active = str_replace("Y", "W", $data->active);
        $data->activeBy = null;
        return $this->datacontext->updateObject($data);
    }

}
