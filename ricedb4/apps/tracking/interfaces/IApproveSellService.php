<?php

namespace apps\tracking\interfaces;

/**
 * @name IApproveSellService
 * @uri /approveSell
 * @description จำหน่ายรูปแบบอื่นๆ
 */
interface IApproveSellService {

    /**
     * @name listsRelease
     * @uri /listsRelease
     * @return String[] lists Description
     * @description การประมูล
     */
    public function listsRelease();

    /**
     * @name listsBidder
     * @uri /listsBidder
     *  @param string auccode
     * @return String[] lists Description
     * @description รายชื่อผู้เสนอซื้อพร้อมคลังที่ชนะการประมูล
     */
    public function listsBidder($auccode);

    /**
     * @name listsApprove
     * @uri /listsApprove
     * @param string auccode
     * @return String[] lists Description
     * @description รายชื่อคลังที่มีการอนุมัติแล้ว
     */
    public function listsApprove($auccode);

    /**
     * @name update
     * @uri /update
     * @param apps\common\model\DataAuction data Description
     * @param string isSale Description
     * @param string remark Description
     * @param string auccode
     * @return string update Description
     * @description บันทึกการขาย
     */
    public function update($data, $isSale, $remark,$auccode);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\model\DataAuction dataAuction
     * @return string delete
     * @description บันทึกการขาย
     */
    public function delete($dataAuction);
}
