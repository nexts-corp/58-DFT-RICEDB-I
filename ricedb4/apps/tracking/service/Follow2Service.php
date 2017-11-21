<?php

namespace apps\tracking\service;

set_time_limit(0);

use th\co\bpg\cde\core\CServiceBase;
use apps\tracking\interfaces\IFollow2Service;
use apps\common\entity\RiceFollow2;
use th\co\bpg\cde\data\CDataContext;

class Follow2Service extends CServiceBase implements IFollow2Service {

    public $datacontext;
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->datacontext = new CDataContext(NULL);
    }

    public function upload($file, $uploadDate) {
        $inputFileName = $file["tmp_name"];
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '":' . $e->getMessage());
        }
        if (strpos($file["name"], "อคส") !== false) {
            $associate = "อคส";
        } else {
            $associate = "อตก";
        }
        $sheetsCount = $objPHPExcel->getSheetCount();
        if ($sheetsCount > 0) {
            $sheetsName = $objPHPExcel->getSheetNames();
            $results = array();

            $sqlUpload = "SELECT count(*)+1 as upload_no
                                from dft_follow_upload
                                  where upload_date =:uploadDate";
            $paramUpload = array(
                "uploadDate" => $uploadDate
            );
            $uploadNo = $this->datacontext->pdoQuery($sqlUpload, $paramUpload)[0]["upload_no"];

            $upload = new \apps\common\entity\RiceFollowUpload();
            $upload->upload_date = $uploadDate;
            $upload->upload_no = $uploadNo;
            $upload->upload_file = $inputFileName;
            $this->datacontext->saveObject($upload);
            for ($sheetIndex = 0; $sheetIndex < $sheetsCount; $sheetIndex++) {
                $datas = array();
                $end = false;
                $sheetName = $sheetsName[$sheetIndex];
                $followCodeArr = explode(".", $sheetName);
                $followCodeQuery = $sheetName;
//                if ($associate === "อคส") {
//                    $followCodeQuery = $followCodeArr[0];
//                }
                $sql = "select * from dft_follow_pattern where associate_name= :associate "
                        . " and :followCodeQuery in (select value from dbo.fn_split(pattern_name,','))";
                $param = array(
                    "associate" => $associate,
                    "followCodeQuery" => $followCodeQuery
                );
                $patterns = $this->datacontext->pdoQuery($sql, $param);
//                 array_push($datas, $patterns);
                if (count($patterns) === 1) {
                    $columns = $patterns[0]["pattern_id"];
                    $sql = "select " . $columns . " as columns,fieldname,datatype  from dft_follow_config where " . $columns . "!=''";
                    $configs = $this->datacontext->pdoQuery($sql);
                    $sheet = $objPHPExcel->getSheet($sheetIndex);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    $bidderName = "";
                    $projectName = "";
                    $typericeName = "";
                    for ($row = 1; $row <= $highestRow; $row++) {
                        if ($end === false) {
                            //  Read a row of data into an array
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            //  Insert row data array into your database of choice here
                            $data = new RiceFollow2();
                            for ($c = 0; $c < count($configs); $c++) {
                                $colNumber = \PHPExcel_Cell::columnIndexFromString($configs[$c]["columns"]);
                                $val = $rowData[0][$colNumber - 1];
                                if ($val != null && $val != "") {
                                    if ($configs[$c]["datatype"] === "date") {
                                        $excel_date = $val;
                                        $unix_date = ($excel_date - 25569) * 86400;
                                        $excel_date = 25569 + ($unix_date / 86400);
                                        $unix_date = ($excel_date - 25569) * 86400;
                                        $data->$configs[$c]["fieldname"] = gmdate("Y-m-d", $unix_date);
                                    } else {
                                        if ($configs[$c]["datatype"] === "number") {
                                            $data->$configs[$c]["fieldname"] = (float) $val;
                                        } else {
                                            $data->$configs[$c]["fieldname"] = trim($val);
                                        }
                                    }
                                }
                            }
                            if (isset($data->weight_approve)) {
                                if ($data->weight_approve > 0) {
                                    if (isset($data->bidder_name)) {
                                        $bidderName = $data->bidder_name;
                                    }
                                    if (isset($data->project_name)) {
                                        $projectName = $data->project_name;
                                    }
                                    if (isset($data->typerice_name)) {
                                        $typericeName = $data->typerice_name;
                                    }
                                    $data->bidder_name = $bidderName;
                                    $data->project_name = $projectName;
                                    $data->typerice_name = $typericeName;
                                    $valid = true;
                                    foreach ($data as $key => $value) {
                                        if ($value === "รวม") {
                                            $valid = false;
                                        }
                                        if ($value === "รวมทั้งสิ้น") {
                                            $valid = false;
                                            $end = true;
                                        }
                                    }
                                    if ($valid == true && $end == false) {
                                        $uuid = new \apps\document\service\AuctionService();
                                        $data->id = $uuid->getGUID();
                                        $data->follow_code = $sheetName;
                                        $data->follow_type = $followCodeArr[0];
                                        $data->follow_no = $followCodeArr[1];
                                        $data->follow_year = $followCodeArr[2];
                                        $data->associate = $associate;
                                        $data->upload_date = $uploadDate;
                                        $data->upload_no = $uploadNo;
                                        $this->datacontext->saveObject($data);
                                        array_push($datas, $data);
                                    }
                                }
                            }
                        }
                    }
                    array_push($results, $datas);
                }
//                else {
//                    return $sheetsName[$sheetIndex]." -> ".$sheetName." pattern not found";
//                }
//                
            }
//            return $results;
            return "uploaded";
        } else {
            return "empty sheets";
        }
    }

    public function lists() {
        $sql = "select follow_type,follow_no,follow_year,associate,
sum(weight_approve) as weight_approve,
sum(weight_contract) as weight_contract,
isnull(sum(weight_received),0)  as weight_received,
isnull(sum(weight_balance),0) as weight_balance,
isnull(sum(weight_lost),0) as weight_lost,
isnull((sum(weight_received)/sum(weight_contract))*100,0) as percent_received
from fn_follow_lastest()
group by follow_type,follow_no,follow_year,associate
order by associate,follow_year,follow_type,follow_no";
        return $this->datacontext->pdoQuery($sql);
    }

}
