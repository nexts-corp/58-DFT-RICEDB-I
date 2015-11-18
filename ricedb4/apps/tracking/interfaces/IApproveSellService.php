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
     * @name listsSell
     * @uri /listsSell
     * @param string releaseKeyword
     * @return String[] lists Description
     * @description รายชื่อคลังที่เสนอขายทั้งหมด
     */
    public function listsSell($releaseKeyword);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\ReleasePrice data Description
     * @param string isSale Description
     * @param string remark Description
     * @param string statusKeyword Description
     * @return string update Description
     * @description บันทึกการขาย
     */
    public function update($data, $isSale, $remark, $statusKeyword);

    /**
     * @name delete
     * @uri /delete
     * @param apps\common\entity\ReleasePrice releasePrice
     * @return string delete
     * @description บันทึกการขาย
     */
    public function delete($releasePrice);

}
