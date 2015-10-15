<?php
set_time_limit(0);

$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");

$arrAssociate = array();
$arrGrade = array();
$arrProject = array();
$arrProvince = array();
$arrStatus = array();
$arrType = array();

$sqlAs = "SELECT * FROM dft_LK_Associate ORDER BY Id ASC";
$resAs = $link -> query($sqlAs);
while($dataAs = $resAs -> fetch(PDO::FETCH_ASSOC)){
    $arrAssociate[replaceString($dataAs["Associate"])] = $dataAs["Id"];
}

$sqlGd = "SELECT * FROM dft_LK_Grade ORDER BY Id ASC";
$resGd = $link -> query($sqlGd);
while($dataGd = $resGd -> fetch(PDO::FETCH_ASSOC)){
    $arrGrade[replaceString($dataGd["Grade"])] = $dataGd["Id"];
}

$sqlPj = "SELECT * FROM dft_LK_Project ORDER BY Id ASC";
$resPj = $link -> query($sqlPj);
while($dataPj = $resPj -> fetch(PDO::FETCH_ASSOC)){
    $arrProject[replaceString($dataPj["Project"])] = $dataPj["Id"];
}

$sqlPv = "SELECT * FROM dft_LK_Province ORDER BY Id ASC";
$resPv = $link -> query($sqlPv);
while($dataPv = $resPv -> fetch(PDO::FETCH_ASSOC)){
    $arrProvince[replaceString($dataPv["Province_Name_TH"])] = $dataPv["Id"];
}

$sqlSt = "SELECT * FROM dft_LK_Status ORDER BY Id ASC";
$resSt = $link -> query($sqlSt);
while($dataSt = $resSt -> fetch(PDO::FETCH_ASSOC)){
    $arrStatus[replaceString($dataSt["Status"])] = $dataSt["Keyword"];
}

$sqlTy = "SELECT * FROM dft_LK_Type ORDER BY Id ASC";
$resTy = $link -> query($sqlTy);
while($dataTy = $resTy -> fetch(PDO::FETCH_ASSOC)){
    $arrType[replaceString($dataTy["Type"])] = $dataTy["Id"];
}

$sqlOr = "SELECT * FROM dft_Rice_Info_Original ORDER BY Code ASC";
$resOr = $link -> query($sqlOr);
while($dataOr = $resOr -> fetch(PDO::FETCH_ASSOC)){
    //find associate
    if(isset($arrAssociate[replaceString($dataOr["Associate"])])) $associate = $arrAssociate[replaceString($dataOr["Associate"])];
    else $associate = '';

    //find grade
    if(isset($arrGrade[replaceString($dataOr["Grade"])])) $grade = $arrGrade[replaceString($dataOr["Grade"])];
    else $grade = '';

    //find project
    if(replaceString($dataOr["Project"]) == "2554/55" || replaceString($dataOr["Project"]) == "นาปี2554/55" || replaceString($dataOr["Project"]) == "ปี2554/55") $dataOr["Project"] = "นาปี2554/55";
    elseif(replaceString($dataOr["Project"]) == "2555/56" || replaceString($dataOr["Project"]) == "นาปี2555/56" || replaceString($dataOr["Project"]) == "นาปี2555/56(ร1)" || replaceString($dataOr["Project"]) == "นาปี2555/56(ร2)" || replaceString($dataOr["Project"]) == "นาปี2555/56(รอบ2)" || replaceString($dataOr["Project"]) == "ปี2555/56") $dataOr["Project"] = "ปี2555/56";
    elseif(replaceString($dataOr["Project"]) == "นาปี2556/57" || replaceString($dataOr["Project"]) == "ปี2556/57") $dataOr["Project"] = "ปี2556/57";

    if(isset($arrProject[replaceString($dataOr["Project"])])) $project = $arrProject[replaceString($dataOr["Project"])];
    else $project = '';

    //find province
    if(isset($arrProvince[replaceString($dataOr["Province"])])) $province = $arrProvince[replaceString($dataOr["Province"])];
    else $province = '';

    //find status
    if(isset($arrStatus[replaceString($dataOr["Status"])])) $status = $arrStatus[replaceString($dataOr["Status"])];
    else $status = '';

    //find type
    if(replaceString($dataOr["Type"]) == "ข้าวขาว10%(ร2)") $dataOr["Type"] = "ข้าวขาว10%";
    elseif(replaceString($dataOr["Type"]) == "ข้าวขาว5%(ร1)" || replaceString($dataOr["Type"]) == "ข้าวขาว5%(ร2)") $dataOr["Type"] = "ข้าวขาว5%";
    elseif(replaceString($dataOr["Type"]) == "ข้าวปทุมธานี(ร2)") $dataOr["Type"] = "ข้าวปทุมธานี";
    elseif(replaceString($dataOr["Type"]) == "ข้าวปทุมธานี5%(ร2)") $dataOr["Type"] = "ข้าวปทุมธานี5%";
    elseif(replaceString($dataOr["Type"]) == "ข้าวเหนียวขาว10%(ร1)" || replaceString($dataOr["Type"]) == "ข้าวเหนียวขาว10%(ร2)") $dataOr["Type"] = "ข้าวเหนียวขาว10%";
    elseif(replaceString($dataOr["Type"]) == "ปลายข้าวA1(ร1)" || replaceString($dataOr["Type"]) == "ปลายข้าวA1(ร2)") $dataOr["Type"] = "ปลายข้าวA1";
    elseif(replaceString($dataOr["Type"]) == "ปลายข้าวปทุมธานี(ร1)" || replaceString($dataOr["Type"]) == "ปลายข้าวปทุมธานี(ร2)") $dataOr["Type"] = "ปลายข้าวปทุมธานี";

    if(isset($arrType[replaceString($dataOr["Type"])])) $type = $arrType[replaceString($dataOr["Type"])];
    else $type = '';

    $sqlCk = "SELECT COUNT(*) AS Num FROM dft_Rice_Info"
        ." WHERE Code='".$dataOr["Code"]."' AND Bag_No='".$dataOr["Bag_No"]."' AND LK_Province_Id='".$province."' AND LK_Project_Id='".$project."' AND Silo='".$dataOr["Silo"]."' AND LK_Associate_Id='".$associate."' AND LK_Type_Id='".$type."' AND Warehouse='".$dataOr["Warehouse"]."' AND Stack='".$dataOr["Stack"]."' AND Weight='".$dataOr["Weight"]."' AND Sampling_Id='".$dataOr["Sampling_Id"]."' AND LK_Grade_Id='".$grade."' AND Discount_Rate='".$dataOr["Discount_Rate"]."' AND LK_Status_Keyword='".$status."'";

    print $sqlCk."<br>";
    $resCk = $link -> query($sqlCk);
    $dataCk = $resCk -> fetch(PDO::FETCH_ASSOC);

    if($dataCk["Num"] == 0){
        $sqlIn = "INSERT INTO dft_Rice_Info(Code, Bag_No, LK_Province_Id, LK_Project_Id, Silo, LK_Associate_Id, LK_Type_Id, Warehouse, Stack, Weight, Sampling_Id, LK_Grade_Id, Discount_Rate, LK_Status_Keyword)"
            ." VALUES('".$dataOr["Code"]."', '".$dataOr["Bag_No"]."', '".$province."', '".$project."', '".$dataOr["Silo"]."', '".$associate."', '".$type."', '".$dataOr["Warehouse"]."', '".$dataOr["Stack"]."', '".$dataOr["Weight"]."', '".$dataOr["Sampling_Id"]."', '".$grade."', '".$dataOr["Discount_Rate"]."', '".$status."')";
        //print $sqlIn."<br>";
        $resIn = $link -> query($sqlIn);
    }
    /*else{
        $sqlUp = "UPDATE dft_Rice_Info SET Code='".$dataOr["Code"]."' AND Bag_No='".$dataOr["Bag_No"]."' AND LK_Province_Id='".$province."' AND LK_Project_Id='".$project."' AND Silo='".$dataOr["Silo"]."' AND LK_Associate_Id='".$associate."' AND LK_Type_Id='".$type."' AND Warehouse='".$dataOr["Warehouse"]."' AND Stack='".$dataOr["Stack"]."' AND Weight='".$dataOr["Weight"]."' AND Sampling_Id='".$dataOr["Sampling_Id"]."' AND LK_Grade_Id='".$grade."' AND Discount_Rate='".$dataOr["Discount_Rate"]."' AND LK_Status_Keyword='".$status."' AND Date_Update=CURRENT_TIMESTAMP";
        $resUp = $link -> query($sqlUp);
    }*/
}

$link = null;

function replaceString($input){
    $output = str_replace( array( ' ', '.'), '', $input);
    return $output;
}
?>