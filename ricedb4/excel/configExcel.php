<?php
$columnArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'];
$styleBU = array( 'font' => array( 'bold' => true, 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE));
$styleB = array( 'font' => array( 'bold' => true));

function putWord($sheet, $index, $row, $column, $word, $rowWidth = 1, $columnWidth = 1, $align, $border = null){
    $columnArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Z'];

    $rowNew = $row + $rowWidth - 1;
    $keyNew = array_search($column, $columnArr) + $columnWidth - 1;

    if($rowWidth != 1 || $columnWidth != 1){
        $sheet -> setActiveSheetIndex($index)
            -> mergeCells($column.$row.":".$columnArr[$keyNew].$rowNew);
    }

    $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

    $sheet -> setActiveSheetIndex($index)
        -> setCellValue($column.$row, $word);

    $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setWrapText(true);

    if(strpos($word,"\n") !== false){
        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setWrapText(true);
    }

    if($align == "center"){
        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
    }
    if($align == "right"){
        $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
    }
    if($border == "border"){
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet -> getActiveSheet() -> getStyle($column.$row.":".$columnArr[$keyNew].$rowNew) -> applyFromArray($styleArray);
        unset($styleArray);
    }


    $sheet->getActiveSheet()->getStyle($column.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

}

function boxExcel($input){
    $output = str_replace("<BR>", "\n", $input);
    return $output;
}


function replacePrice($data){
    if($data == 0){
        $data = '-';
    }
    return $data;
}
?>