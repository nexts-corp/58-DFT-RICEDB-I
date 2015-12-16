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

        foreach($data as $key => $value) {
            $conv = "R" . $value["pCode"] . $value["aCode"] . $this->string_to_ascii(str_replace(" ", "", $data["Silo"]));

            $sqlUp = "UPDATE dft_Rice_Info SET Warehouse_Code = :code WHERE Silo = :silo AND LK_Associate_Id = :associate AND LK_Province_Id = :province";
            $paramUp = array(
                "code" => $conv,
                "silo" => $data["Silo"],
                "associate" => $data["LK_Associate_Id"],
                "province" => $data["LK_Province_Id"]
            );
            if (!$this->datacontext->pdoQuery($sqlUp, $paramUp)) {
                return false;
            }
        }

        //stack code
        $sql = "SELECT * FROM"
            ."("
                ."SELECT"
                    ."Warehouse_Code,"
                    ."COUNT(*) AS cAll,"
                    ."SUM("
                        ."CASE"
                            ."WHEN Stack_Code IS NULL THEN 1"
                            ."ELSE 0"
                        ."END"
                    .") AS cNull"
                ."FROM dft_Rice_Info"
                ."GROUP BY Warehouse_Code"
            .") data"
            ."WHERE cNull > 0";
        $data = $this->datacontext->pdoQuery($sql);
        foreach($data as $key => $value){
            if($value["cAll"] != $value["cNull"]){
                //select top 1
                $sqlTop = "SELECT TOP 1 Stack_Code FROM dft_Rice_Info WHERE Warehouse_Code = :wCode ORDER BY Stack_Code DESC";
                $paramTop = array(
                    "wCode" => $value["Warehouse_Code"]
                );
                $dataTop = $this->datacontext->pdoQuery($sqlTop, $paramTop);

                $start = (int) substr($dataTop["Stack_Code"], 12, 4);
            }
            else{
                $start = 0;
            }

            $sqlFetch = "SELECT Id FROM dft_Rice_Info WHERE Warehouse_Code = :wCode AND Stack_Code IS NULL";
            $paramFetch = array(
                "wCode" => $value["Warehouse_Code"]
            );
            $dataFetch = $this->datacontext->pdoQuery($sqlFetch, $paramFetch);
            foreach($dataFetch as $key2 => $value2){
                $stackCode = $value["Warehouse_Code"].str_pad(++$start, 4, "0", STR_PAD_LEFT);
                $sqlUp = "UPDATE dft_Rice_Info SET Stack_Code = :stackCode WHERE Id = :id";
                $paramUp = array(
                    "stackCode" => $stackCode,
                    "id" => $value2["Id"]
                );
                if(!$this->datacontext->pdoQuery($sqlUp, $paramUp)){
                    return $this->datacontext->getLastMessage();
                }
            }
        }
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

        if($return == true){
            return $this->createCode();
        }
        else {
            return $return;
        }
    }
} 