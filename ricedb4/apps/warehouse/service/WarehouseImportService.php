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

    function string_to_ascii($string){
        $num =  substr(hexdec(crc32($string)), 0, 7);
        return $num;
    }

    function createCode(){
        $return = true;
        //warehouse code
        $sql = "SELECT"
                ." pv.Code AS pCode, ri.LK_Province_Id, ac.Code AS aCode, ri.LK_Associate_Id, ri.Silo"
            ." FROM dft_Rice_Info ri"
            ." INNER JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
            ." INNER JOIN dft_LK_Associate ac ON ac.Id = ri.LK_Associate_Id"
            ." WHERE ri.Warehouse_Code is null"
            ." GROUP BY pv.Code, ri.LK_Province_Id, ac.Code, ri.LK_Associate_Id, ri.Silo"
            ." ORDER BY ri.Silo ASC";
        $data = $this->datacontext->pdoQuery($sql);

        $count = 0;
        $wCommand = [];
        foreach($data as $key => $value) {
            $conv = "R" . $value["pCode"] . $value["aCode"] . $this->string_to_ascii(str_replace(" ", "", $value["Silo"]));

            $wCommand[] = "UPDATE dft_Rice_Info SET Warehouse_Code='".$conv."' WHERE Silo='".$value["Silo"]."' AND LK_Associate_Id='".$value["LK_Associate_Id"]."' AND LK_Province_Id='".$value["LK_Province_Id"]."'";

            $count++;
            if($count == 10 || $key == count($data) - 1) {
                if (count($wCommand) > 0) {
                    $sql = "EXEC sp_batch_exce :cmd";

                    $param = array(
                        "cmd" => implode(";", $wCommand)
                    );

                    if (!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) {
                        return $this->datacontext->getLastMessage();
                    }

                    $wCommand = [];
                    $count = 0;
                }
            }
        }


        $wTmp = '';
        $cTmp = 0;
        //stack code
        $sql = "SELECT * FROM dft_Rice_Info WHERE Stack_Code IS NULL ORDER BY Warehouse_Code, Id ASC";
        $data = $this->datacontext->pdoQuery($sql);
        $sCommand = [];
        $start = 0;

        $count = 0;

        foreach($data as $key => $value) {
            if($wTmp != $value["Warehouse_Code"]){
                $sqlTop = "SELECT Running FROM dft_Warehouse_Code WHERE Warehouse_Code = :wCode";
                $paramTop = array(
                    "wCode" => $value["Warehouse_Code"]
                );
                $dataTop = $this->datacontext->pdoQuery($sqlTop, $paramTop)[0];

                $start = $dataTop["Running"];

            }

            $start++;
            $stackCode = $value["Warehouse_Code"] . str_pad($start, 4, "0", STR_PAD_LEFT);
            $sCommand[] = "UPDATE dft_Rice_Info SET Stack_Code='".$stackCode."' WHERE Id='".$value["Id"]."'";
            $count++;

            if(($wTmp != $value["Warehouse_Code"] || $key == count($data) - 1) && $wTmp != ''){
                if($key == count($data) - 1) $cTmp++;
                $sCommand[] = "UPDATE dft_Warehouse_Code SET Running = '" . $cTmp . "' WHERE Warehouse_Code = '" . $wTmp . "'";
                $count++;
            }

            $wTmp = $value["Warehouse_Code"];
            $cTmp = $start;

            if($count > 10 || $key == count($data) - 1) {
                if(count($sCommand) > 0){
                    $sql = "EXEC sp_batch_exce :cmd";

                    $param = array(
                        "cmd" =>  implode(";", $sCommand)
                    );

                    if(!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")){
                        return $this->datacontext->getLastMessage();
                    }


                    $sCommand = [];
                    $count = 0;
                }
            }
        }



        return $return;
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
                    $command[] = "('".$no."', '".$code."', '".$bag."', '".$prov."', '".$proj."', '".$silo."', '".$asso."', '".$type."', '".$warehouse."', '".$stack."', '".$weight."', '".$samp."', '".$grade."', '".$disc."', '".$status."', '".$weightAll."')";

                    $count++;
                    $this->logger->info("Row : ".$count);
                }

                if($count == 10 || $row == $highestRow){
                    if(count($command) > 0){
                        $insert = "INSERT INTO dft_Rice_Original(No, Code, Bag_No, Province, Project, Silo, Associate, Type, Warehouse, Stack, Weight, Sampling_Id, Grade, Discount_Rate, Status, Weight_All) VALUES ".implode(",", $command);
                        $sql = "EXEC sp_batch_insert :cmd";

                        $param = array(
                            "cmd" =>  $insert
                        );

                        if(!$this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")){
                            return $this->datacontext->getLastMessage();
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

        if($return == true){
            return $this->createCode();
        }
        else {
            return $return;
        }
    }
} 