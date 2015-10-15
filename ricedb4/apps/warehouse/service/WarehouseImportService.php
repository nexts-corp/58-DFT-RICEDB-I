<?php

namespace apps\warehouse\service;


use apps\warehouse\interfaces\IWarehouseImportService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;

class WarehouseImportService extends CServiceBase implements IWarehouseImportService{
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
        $target_file = $target_dir."WH".$time.".".$ext[count($ext)-1];

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

            $sheet = $objPHPExcel->getSheet($sheetActive);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            $count = 0;
            $command = [];
            for ($row = $rowStart; $row <= $highestRow; $row++) {
                $no = $sheet->getCellByColumnAndRow($column["no"], $row)->getFormattedValue();
                $code = $sheet->getCellByColumnAndRow($column["code"], $row)->getFormattedValue();
                $bag = $sheet->getCellByColumnAndRow($column["bagNo"], $row)->getFormattedValue();
                $prov = $sheet->getCellByColumnAndRow($column["province"], $row)->getFormattedValue();
                $proj = $sheet->getCellByColumnAndRow($column["project"], $row)->getFormattedValue();
                $silo = $sheet->getCellByColumnAndRow($column["silo"], $row)->getFormattedValue();
                $asso = $sheet->getCellByColumnAndRow($column["associate"], $row)->getFormattedValue();
                $type = $sheet->getCellByColumnAndRow($column["type"], $row)->getFormattedValue();
                $warehouse = $sheet->getCellByColumnAndRow($column["warehouse"], $row)->getFormattedValue();
                $stack = $sheet->getCellByColumnAndRow($column["stack"], $row)->getFormattedValue();
                $weight = $sheet->getCellByColumnAndRow($column["weight"], $row)->getFormattedValue();
                $samp = $sheet->getCellByColumnAndRow($column["samplingId"], $row)->getFormattedValue();
                $grade = $sheet->getCellByColumnAndRow($column["grade"], $row)->getFormattedValue();
                $disc = $sheet->getCellByColumnAndRow($column["discount"], $row)->getFormattedValue();
                $status = $sheet->getCellByColumnAndRow($column["status"], $row)->getFormattedValue();
                $weightAll = $sheet->getCellByColumnAndRow($column["weightAll"], $row)->getFormattedValue();

                if($silo != ""){
                    $command[] = "('".$no."', '".$code."', '".$bag."', '".$prov."', '".$proj."', '".$silo."', '".$asso."', '".$type."', '".$warehouse."', '".$stack."', '".$weight."', '".$samp."', '".$grade."', '".$disc."', '".$status."', '".$time."', '".$weightAll."')";

                    $count++;
                    $this->logger->info("Row : ".$count);
                }

                if($count == 10 || $row == $highestRow){
                    if(count($command) > 0){
                        $insert = "INSERT INTO dft_Rice_Original_Extend(No, Code, Bag_No, Province, Project, Silo, Associate, Type, Warehouse, Stack, Weight, Sampling_Id, Grade, Discount_Rate, Status, Extend, Weight_All) VALUES ".implode(",", $command);
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