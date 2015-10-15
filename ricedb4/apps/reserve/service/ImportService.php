<?php

namespace apps\reserve\service;


use apps\reserve\interfaces\IImportService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class ImportService extends CServiceBase implements IImportService{
    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function view($file, $sheet, $row){
        $inputFileName = $file["tmp_name"];

        $sheetActive = $sheet - 1; //start at 0
        $rowStart = $row; //start at 1

        $rowEnd = $rowStart + 19;

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);

        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME).'":'. $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet($sheetActive);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        if($rowEnd > $highestRow) $rowEnd = $highestRow;

        $data = [];
        for ($row = $rowStart; $row <= $rowEnd; $row++) {
            $list = [];
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $val = $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue();

                $list[] = $val;
            }

            array_push($data, $list);
        }

        return $data;
    }

    public function import($file, $sheet, $row, $column){
        $return = true;

        $time = date("YmdHis");
        $ext = explode(".", $file["name"]);
        $target_dir = "apps\\warehouse\\views\\import\\";
        $target_file = $target_dir."RS".$time.".".$ext[count($ext)-1];

        if(move_uploaded_file($file["tmp_name"], $target_file)){
            $inputFileName = $target_file;

            $sheetActive = $sheet - 1; //start at 0
            $rowStart = $row; //start at 1

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME).'":'. $e->getMessage());
            }

            // province
            $provArr = [];
            $prov = new \apps\common\entity\Province();
            $data1 = $this->datacontext->getObject($prov);
            foreach($data1 as $value){
                $provArr[str_replace(" ", "", $value->provinceNameTH)] = $value->id;
            }

            // project
            $projArr = [];
            $proj = new \apps\common\entity\Project();
            $data2 = $this->datacontext->getObject($proj);
            foreach($data2 as $value){
                $projArr[str_replace(" ", "", $value->project)] = $value->id;
            }

            // associate
            $assoArr = [];
            $asso = new \apps\common\entity\Associate();
            $data3 = $this->datacontext->getObject($asso);
            foreach($data3 as $value){
                $assoArr[str_replace(" ", "", $value->associate)] = $value->id;
            }

            // type
            $typeArr = [];
            $type = new \apps\common\entity\Type();
            $data4 = $this->datacontext->getObject($type);
            foreach($data4 as $value){
                $typeArr[str_replace(" ", "", $value->type)] = $value->id;
            }

            // grade
            $gradeArr = [];
            $grade = new \apps\common\entity\Grade();
            $data5 = $this->datacontext->getObject($grade);
            foreach($data5 as $value){
                $gradeArr[str_replace(" ", "", $value->grade)] = $value->id;
            }

            $sheet = $objPHPExcel->getSheet($sheetActive);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            $count = 0;
            $command = [];

            $reserveKeyword = $sheet->getCellByColumnAndRow(0, 3)->getFormattedValue();
            $reserveKeyword = str_replace("Code: ", "", $reserveKeyword);

            for ($row = $rowStart; $row <= $highestRow; $row++) {
                $code = $sheet->getCellByColumnAndRow($column["code"], $row)->getFormattedValue();
                $bag = $sheet->getCellByColumnAndRow($column["bagNo"], $row)->getFormattedValue();
                $prov = $sheet->getCellByColumnAndRow($column["province"], $row)->getFormattedValue();
                $proj = $sheet->getCellByColumnAndRow($column["project"], $row)->getFormattedValue();
                $round = $sheet->getCellByColumnAndRow($column["round"], $row)->getFormattedValue();
                $silo = $sheet->getCellByColumnAndRow($column["silo"], $row)->getFormattedValue();
                $addr = $sheet->getCellByColumnAndRow($column["address"], $row)->getFormattedValue();
                $asso = $sheet->getCellByColumnAndRow($column["associate"], $row)->getFormattedValue();
                $type = $sheet->getCellByColumnAndRow($column["type"], $row)->getFormattedValue();
                $warehouse = $sheet->getCellByColumnAndRow($column["warehouse"], $row)->getFormattedValue();
                $stack = $sheet->getCellByColumnAndRow($column["stack"], $row)->getFormattedValue();
                $weight = $sheet->getCellByColumnAndRow($column["weight"], $row)->getFormattedValue();
                $samp = $sheet->getCellByColumnAndRow($column["samplingId"], $row)->getFormattedValue();
                $grade = $sheet->getCellByColumnAndRow($column["grade"], $row)->getFormattedValue();
                $disc = $sheet->getCellByColumnAndRow($column["discount"], $row)->getFormattedValue();
                $weightAll = $sheet->getCellByColumnAndRow($column["weightAll"], $row)->getFormattedValue();

                if($code != ""){
                    //หาชื่อจังหวัด
                    $prov = $provArr[str_replace(" ", "", $prov)];

                    //หารอบการผลิต
                    if(str_replace(" ", "", $proj) == "ปี2554/55") $proj = "นาปี2554/55";
                    if(str_replace(" ", "", $proj) == "นาปี2555/56") $proj = "ปี2555/56";
                    if(str_replace(" ", "", $proj) == "นาปี2556/57") $proj = "ปี2556/57";
                    if(str_replace(" ", "", $proj) == "ปี2555/56"){
                        if($round == "1") $proj = "ปี 2555/56(1)";
                        if($round == "2") $proj = "ปี 2555/56(2)";
                    }
                    $proj = $projArr[str_replace(" ", "", $proj)];

                    //หาที่อยู่
                    if(str_replace(" ", "", $addr) == '"' || str_replace(" ", "", $addr) == ''){
                        $addr = '';
                    }

                    //หาผู้เข้าร่วม
                    $asso = $assoArr[str_replace(" ", "", $asso)];

                    //หาชนิดข้าว
                    if(str_replace(" ", "", $type) == "ปลายข้าวเหนียว" || str_replace(" ", "", $type) == "ปลายข้าวเหนียวA1") $type = "ปลายข้าว A1";
                    if(str_replace(" ", "", $type) == "ข้าวขาว5%(ร.1)") $type = "ข้าวขาว5%";
                    if(str_replace(" ", "", $type) == "ข้าวเหนียวขาว10%(ร1)") $type = "ข้าวเหนียวขาว10%";
                    $type = $typeArr[str_replace(" ", "", $type)];

                    //หาเกรดข้าว
                    $grade = $gradeArr[str_replace(" ", "", $grade)];

                    $command[] = "('".$code."', '".$bag."', '".$prov."', '".$proj."', '".$round."', '".$silo."', '".$addr."', '".$asso."', '".$type."', '".$warehouse."', '".$stack."', '".$weight."', '".$samp."', '".$grade."', '".$disc."', '".$reserveKeyword."', '".$weightAll."')";

                    $count++;
                    $this->logger->info("Row : ".$count);
                }

                if($count == 10 || $row == $highestRow){
                    if(count($command) > 0){
                        $insert = "INSERT INTO dft_Rice_Tracking(Code, Bag_No, LK_Province_Id, LK_Project_Id, Round, Silo, Address, LK_Associate_Id, LK_Type_Id, Warehouse, Stack, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate, LK_Status_Keyword, Weight_All) VALUES ".implode(",", $command);
                        $sql = "EXEC sp_batch_insert :cmd";
                        $param = array(
                            "cmd" =>  $insert
                        );

                        if(!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")){
                            return false;
                        }
                        $command = [];
                        $count = 0;
                    }

                    /*if($row == $highestRow){
                        $update = "UPDATE dft_Rice_Tracking SET Address = grouped.Address"
                            ." FROM (Select Silo, Address FROM dft_Rice_Tracking WHERE Address != '' AND LK_Status_Keyword = '".$reserveKeyword."'"
                            ." GROUP BY Silo, Address) grouped"
                            ." WHERE dft_Rice_Tracking.Silo=grouped.Silo AND dft_Rice_Tracking.LK_Status_Keyword = '".$reserveKeyword."'";
                        if(!$this->datacontext->pdoQuery($update)){
                            return $update;
                        }
                    }*/
                }
            }

            $return = true;
        }
        else{
            $return = "ไม่สามารถนำเข้าข้อมูลได้";
        }

        return $return;
    }
} 