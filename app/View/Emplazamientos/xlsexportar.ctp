<?php
$nemplazamientos = count($emplazamientos);
$totHabitantes = 0;

// Importamos la clase para generar el PDF
App::import('Vendor', 'Classes/PHPExcel');

//Creamos el Excel
date_default_timezone_set('Europe/Madrid');
$objPHPExcel = new PHPExcel();
$locale = 'Es';
$validLocale = PHPExcel_Settings::setLocale($locale);

// Set properties
$objPHPExcel->getProperties()->setCreator("Servici de Telecomunicacions");
$objPHPExcel->getProperties()->setLastModifiedBy("Servici de Telecomunicacions");
$objPHPExcel->getProperties()->setTitle(__("Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setSubject(__("Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setDescription(__("Emplazamientos de la Comunitat"));
$objPHPExcel->getProperties()->setKeywords(__("Emplazamientos Comunitat"));
$objPHPExcel->getProperties()->setCategory(__("Emplazamientos de la ComunitatA"));

// Creamos la primera hoja como hoja activa la primera y fijamos el título:
//$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Emplazamientos');

// Fijamos los estilos generales de la hoja:
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

// Estilos para la hoja:
$estiloTitulo = array(
    'font' => array('bold' => true, 'size' => 12),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);
$estiloRelleno = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('argb' => 'FFEFEFEF'),
    )
);
$estiloCelda = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
);
$estiloTh = array(
    'font' => array('bold' => true, 'size' => 10),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);
$estiloCentro = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
);

// Título de la Hoja:
$objPHPExcel->getActiveSheet()->setCellValue('A1', __('Emplazamientos de Telecomunicaciones de la Comunitat Valenciana'));
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');

// Número de registros:
$objPHPExcel->getActiveSheet()->setCellValue('A3', __('Total de Emplazamientos' . ': ' . $nemplazamientos));
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloTh);
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');

// Fila de títulos:
$objPHPExcel->getActiveSheet()->setCellValue("A5", __('ID'));
$objPHPExcel->getActiveSheet()->setCellValue("B5", __('Emplazamiento'));
$objPHPExcel->getActiveSheet()->setCellValue("C5", __('Provincia'));
$objPHPExcel->getActiveSheet()->setCellValue("D5", __('Comarca'));
$objPHPExcel->getActiveSheet()->setCellValue("E5", __('Municipio'));
$objPHPExcel->getActiveSheet()->setCellValue("F5", __('Titular'));
$objPHPExcel->getActiveSheet()->setCellValue("G5", __('Latitud'));
$objPHPExcel->getActiveSheet()->setCellValue("H5", __('Longitud'));
$objPHPExcel->getActiveSheet()->setCellValue("I5", __('COMDES'));
$objPHPExcel->getActiveSheet()->setCellValue("J5", __('TDT-GVA'));
$objPHPExcel->getActiveSheet()->setCellValue("K5", __('RTVV'));
$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($estiloTh);

// Imprimimos los registros:
$relleno = FALSE;
$fila = 5;
foreach ($emplazamientos as $emplazamiento) {
    $fila++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $emplazamiento['Emplazamiento']['id']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $emplazamiento['Emplazamiento']['centro']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $emplazamiento['Municipio']['provincia']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $emplazamiento['Comarca']['comarca']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $emplazamiento['Municipio']['nombre']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $emplazamiento['Emplazamiento']['titular']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $emplazamiento['Emplazamiento']['latitud']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $emplazamiento['Emplazamiento']['longitud']);
    $servicio = '-';
    if ($emplazamiento['Emplazamiento']['comdes'] == 'SI'){
        $servicio = 'X';
    }
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $servicio);
    $servicio = '-';
    if ($emplazamiento['Emplazamiento']['tdt-gva'] == 'SI'){
        $servicio = 'X';
    }
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $servicio);
    $servicio = '-';
    if ($emplazamiento['Emplazamiento']['rtvv'] == 'SI'){
        $servicio = 'X';
    }
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $servicio);
    if ($relleno){
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'K'.$fila)->applyFromArray($estiloRelleno);
    }
    $relleno = !($relleno);
}
// Bordes de Celda
$objPHPExcel->getActiveSheet()->getStyle('A5:K'.$fila)->applyFromArray($estiloCelda);
$objPHPExcel->getActiveSheet()->getStyle('I6:K'.$fila)->applyFromArray($estiloCentro);
// Ajustamos ancho
$columnas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
foreach ($columnas as $columna) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
}

// Generamos el fichero:
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Emplazamientos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
