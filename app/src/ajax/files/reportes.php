<?php
//establecemos el timezone para obtener la hora local
date_default_timezone_set('America/Lima');
//la fecha de exportaci贸n sera parte del nombre del archivo Excel
$fdata = date("d-m-Y H:i:s");
$namef =  date("m") . " " . $fdata;
//Inicio de exportaci贸n en Excel
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=CONTA$namef.xls"); //Indica el nombre del archivo resultante
header("Pragma: no-cache");
header("Expires: 0");

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
//establecemos el timezone para obtener la hora local

//la fecha de exportación sera parte del nombre del archivo Excel

?>
<?php
$fecha = "";
if (isset($_GET["idruta"])) {
    $dia1 = $_GET['idruta'];
    $dia2 = $_GET['nam'];
    $select = array(
        "T.nombre" => "",
        "T.apellidos" => "",
        "H.dni" => "",
        "H.salario" => "",
        "H.total_horas" => "",
        "H.precio_hora" => "",
        "H.monto_pagado" => "",
        "H.abono" => "",
        "H.cometario" => "",
        "H.mes" => "",
        "H.desde" => "",
        "H.hasta" => "",
        "H.dominic" => "",
        "H.dias" => "",
        "H.faltas" => "",
    );
    $tables = array(
        "historial_pago H" => "trabajador T", #0-0
        "H.dni" => "T.dni", #0-0
    );
    $where = array(
        "H.fecha" => " BETWEEN '" . $dia1 . "' AND '" . $dia2 . "'",
    );

    $historys = ControllerQueryes::SELECT($select, $tables, $where);
    //echo $historys;
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQleC-6M42E7SI0DmhuSf4zPCfYGIO9XJiq5TEPn8rqtoBFzxxeUpauYeveMiBMaUSKiqk&usqp=CAU" type="image/x-icon">
        <title>reporte-exel</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    </head>
<?php

    echo "<table style=''>
        <tr>
        <th></th>
        <th></th>
        <th></th>
        </tr>
        <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan='4' style='background:#0d6efd; color:#CCC'>REPORTE DE PAGOS - $fdata</th>
        <th></th>
        </tr>
        <tr></tr>
        <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan='4'>Periodo : $dia1 / $dia2</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        </tr>
        <tr></tr>
        <tr>
            <th></th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Nr</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Nombres</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Apellidos</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>DNI</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Fecha</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Desde</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Hasta</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>N.D</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>N.F</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000;'>Dmincl</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Salario</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>H. trabajos</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Costo H.</th>
            <th style='background:#CCC; color:#0d6efd;text:center;border-style: solid;border-color: #0d6efd'>Mnt. Pagdo</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Bono</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Comentario</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000;width: 100px;'>Firma trab.</th>
            <th></th>
        </tr>";
    foreach ($historys as $key => $value) {
        echo '<tr>
                <th></th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . ($key + 1) . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['nombre'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['apellidos'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['dni'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['mes'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['desde'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['hasta'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['dias'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['faltas'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['dominic'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['salario'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['total_horas'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['precio_hora'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #0d6efd">' . $value['monto_pagado'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['abono'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000">' . $value['cometario'] . '</th>
                <th style="text-align:center;border-style: solid;border-color: #000"></th>
        </tr>';
    }
    echo "
    <tr></tr></table>";
}
