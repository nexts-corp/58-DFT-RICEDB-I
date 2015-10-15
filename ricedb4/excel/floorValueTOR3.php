<?php

if (PHP_SAPI == "cli")
    die("This example should only be run from a Web Browser");

/** Include PHPExcel */
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel.php");
require(dirname(__FILE__) . "/PHPExcel/Classes/PHPExcel/IOFactory.php");
require(dirname(__FILE__) . "/configExcel.php");

$link = new PDO("sqlsrv:server=202.44.34.86 ; Database=RiceDB", "riceuser", "l2ice2015");
//$link = new PDO("dblib:host=202.44.34.86; dbname=RiceDB", "riceuser", "l2ice2015");

$sql = "exec sp_dft_floor_value ?,?,?,?,?";
$q = $link->prepare($sql);
$q->execute();
$nType = array();
$siloAddress = array();

while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
    //print $data["Id"]." ".$data["Silo"]."<br>";
    $pj = $data["Project"];
    $rt = $data["riceType"];
    $pv = $data["Province"];
    $sl = $data["Silo"];
    $ad = $data["Address"];
    $st = $data["Stack"];
    $wa = $data["Weight_All"];
    $fv2 = $data["FV2"];

    $siloAddress[$sl] = $ad;
    $nType[$pj][$rt][$pv][$sl][$st]["weight"] = $wa;
    $nType[$pj][$rt][$pv][$sl][$st]["fv2"] = $fv2;
}

$link = null;

print '<table border="1">';

foreach ($nType as $project => $projArr) {
    print '<tr><td>' . $project . '</td></tr>';
    foreach ($projArr as $riceType => $riceArr) {
        print '<tr><td>' . $riceType . '</td></tr>';
        $noPV = 1;
        foreach ($riceArr as $province => $provArr) {
            print '<tr><td>' . $noPV . "</td><td>" . $province . '</td></tr>';
            $noSilo = 1;
            foreach ($provArr as $silo => $siloArr) {
                print '<tr>';
                print '<td></td>';
                print '<td>' . $noPV . "." . $noSilo . '</td>';
                print '<td>' . $silo . '</td>';
                print '<td>' . $siloAddress[$silo] . '</td>';
                $i = 0;
                $sumW = 0;
                $sumFV2 = 0;
                foreach ($siloArr as $stack => $value) {
                    if ($i == 0) {
                        print '<td>' . $stack . '</td>';
                        print '<td>' . $value["weight"] . '</td>';
                    } else {
                        print '<tr>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td>' . $stack . '</td>';
                        print '<td>' . $value["weight"] . '</td>';
                        print '</tr>';
                    }
                    $sumW += (double) $value["weight"];
                    $sumFV2 += (double) $value["fv2"];

                    if ($i == count($siloArr) - 1) {
                        $sumRFV2 =0;
                        if ($sumFV2 % 100) {
                            $round = $sumFV2 % 100;
                            $sumRFV2 = ($sumFV2 - $round) + 100;
                        }
                        print '<tr>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td></td>';
                        print '<td>' . $sumW . '</td>';
                        print '<td>' . $sumRFV2 . '</td>';
                        print '</tr>';
                        $sumFV2 = 0;
                        $sumW = 0;
                    }
                    $i++;
                }
                print '</tr>';
                $noSilo++;
            }
            $noPV++;
        }
    }
}
print '</table>';
?>