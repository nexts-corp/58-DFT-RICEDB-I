<?php

namespace apps\reserve\interfaces;

/**
 * @name FilterService
 * @uri /filter
 * @description reserve service
 */
interface IFilterService {

    /**
     * @name listsGrade
     * @uri /lkGrade
     * @return String[] lists
     * @description รายการระดับคุณภาพ
     * @authen true

     */
    public function listsGrade();

    /**
     * @name listsType
     * @uri /lkType
     * @return String[] lists
     * @description รายการชนิดข้าว
     * @authen true

     */
    public function listsType();

    /**
     * @name listsProject
     * @uri /lkProject
     * @return String[] lists
     * @description รายการปีโครงการ
     * @authen true

     */
    public function listsProject();

    /**
     * @name lists
     * @uri /lists
     * @return String[] lists
     * @description รายการคัดคลัง
     * @authen true

     */
    public function lists();

    /**
     * @name selector
     * @uri /selector
     * @param String[] selector
     * @param String status
     * @return boolean selector
     * @description คัดเลือกคลังสินค้า
     */
    public function selector($selector, $status);

    /**
     * @name detail
     * @uri /detail
     * @param String silo
     * @param String associateId
     * @param String provinceId
     * @param String book_id
     * @return boolean detail
     * @description ดูรายละเอียด
     */
    public function detail($silo, $associateId, $provinceId, $book_id);

    /**
     * @name get
     * @uri /get
     * @param String book_id
     * @return String get
     * @description get
     */
    public function get($book_id);

    /**
     * @name save
     * @uri /save
     * @param String book_id
     * @param String remark
     * @param String silo
     * @param String obj_query
     * @return boolean save
     * @description เพิ่มบันทึกการสำรอง
     */
    public function save($book_id, $remark, $silo, $obj_query);

    /**
     * @name delete
     * @uri /delete
     * @param String book_id
     * @return boolean delete
     * @description ลบบันทึกการสำรอง
     */
    public function delete($book_id);

    /**
     * @name export
     * @uri /export
     * @param String book_id
     * @return file export
     * @description export excel
     */
    public function export($book_id);

    /**
     * @name stack
     * @uri /stack
     * @param String book_id
     * @return String stack
     * @description รายการคลังสินค้าที่จองเป็นรายกอง
     */
    public function stack($book_id);

    /**
     * @name cut
     * @uri /cut
     * @param String book_id
     * @param String data_cut
     * @return boolean cut
     * @description ตัดกอง
     */
    public function cut($book_id, $data_cut);
}
