<?php

set_time_limit(0);
$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB2", "riceuser", "l2ice2015");

//insert silo code
$sql = "SELECT"
        . " pv.Code AS pCode, ri.LK_Province_Id, ac.Code AS aCode, ri.LK_Associate_Id, ri.Silo"
        . " FROM dft_Rice_Info_20160314 ri"
        . " INNER JOIN dft_LK_Province pv ON pv.Id = ri.LK_Province_Id"
        . " INNER JOIN dft_LK_Associate ac ON ac.Id = ri.LK_Associate_Id"
        . " WHERE ri.Warehouse_Code is null "
        . " GROUP BY pv.Code, ri.LK_Province_Id, ac.Code, ri.LK_Associate_Id, ri.Silo"
        . " ORDER BY ri.Silo ASC";
$res = $link->query($sql);

print $sql;
//
$gArr = [];
print '<table border="1" style="border: 1px solid black;">';
while ($data = $res->fetch(PDO::FETCH_ASSOC)) {
    $conv = "R" . $data["pCode"] . $data["aCode"] . string_to_ascii(str_replace(" ", "", $data["Silo"]));

    $isHave = "No";
    if (in_array($conv, $gArr)) {
        $isHave = "Yes";
    }
    //if($isHave == "Yes") {
//    print '<tr>'
//            . '<td>' . $data["pCode"] . '</td>'
//            . '<td>' . $data["aCode"] . '</td>'
//            . '<td>' . $data["Silo"] . '</td>'
//            . '<td>' . $conv . '</td>'
//            . '<td>' . $isHave . '</td>'
//            . '</tr>';
    //}

    $gArr[] = $conv;

    //update field
    $sqlUp = "UPDATE dft_Rice_Info_20160314 SET Warehouse_Code='" . $conv . "' WHERE Silo='" . $data["Silo"] . "' AND LK_Associate_Id='" . $data["LK_Associate_Id"] . "' AND LK_Province_Id='" . $data["LK_Province_Id"] . "'";
//    if ($resUp = $link->query($sqlUp)) {
//        print $sqlUp . "<br>";
//    }
}
print '</table>';


//end insert silo code
/* */
//insert identity code
$sql2 = "UPDATE ri SET ri.Stack_Code = ri.New_Code
  FROM(
  SELECT Warehouse_Code, Stack_Code, Warehouse_Code + REPLACE(STR(ROW_NUMBER() OVER (PARTITION BY Warehouse_Code ORDER By Warehouse_Code, Id), 4), SPACE(1), '0') as New_Code
  FROM dft_Rice_Info
  WHERE Stack_Code is null
  ) ri";
print $sql2;
//$res2 = $link->query($sql2);
//end identity code
//print $html;


$link = null;

function string_to_ascii($string) {
    $num = substr(hexdec(crc32($string)), 0, 7);
    return $num;
}

/*
  -- UPDATE dft_Rice_Tracking2
  -- SET
  -- 	Warehouse_Code = dt.Warehouse_Code,
  -- 	Stack_Code = dt.Stack_Code
  -- FROM
  -- 	(SELECT ri.Warehouse_Code, ri.Stack_Code, ri.Code, ri.Bag_No FROM dft_Rice_Info ri) dt
  -- WHERE
  -- 	dft_Rice_Tracking2.Code = dt.Code AND
  -- 	dft_Rice_Tracking2.Bag_No = dt.Bag_No AND
  -- 	LK_Status_Keyword='AU7/2558'
 */
?>