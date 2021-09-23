<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
?>
<?php
$fecha = "";
if (isset($_GET["idruta"])) {
    $fecha = $_GET['idruta'];
    
    
    //echo $cont;
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQleC-6M42E7SI0DmhuSf4zPCfYGIO9XJiq5TEPn8rqtoBFzxxeUpauYeveMiBMaUSKiqk&usqp=CAU" type="image/x-icon">
        <title>reporte-exel</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    </head>
<?php
    //establecemos el timezone para obtener la hora local
    date_default_timezone_set('America/Lima');
    //la fecha de exportación sera parte del nombre del archivo Excel
    $fdata = date("d-m-Y H:i:s");
    $namef =  date("m") . " " . $fdata;
    //Inicio de exportación en Excel
    header('Content-type: text/csv');
    header("Content-Disposition: attachment; filename=CONTA$namef.xls"); //Indica el nombre del archivo resultante
    header("Pragma: no-cache");
    header("Expires: 0");
    $seli = array(
        "DISTINCT id_tipo" => "id",
        "T.nombre" => "",
    );
    $tabi = array(
        "contabilidad C" => "tipo_contabilidad T", #0-0
        "C.id_tipo" => "T.id", #0-0
    );
    $whi = array(
        "C.fecha" => " LIKE CONCAT('%" . $fecha . "%')  AND C.tipo = 'INGRESO'",
    );

    $categi = ControllerQueryes::SELECT($seli, $tabi, $whi);
    //echo $historys;
    //print_r($historys);
    $selecti = array(
        "C.id" => "",
        "C.tipo" => "",
        "C.id_tipo" => "id_tipo",
        "C.cantidad" => "",
        "C.fecha" => "",
        "C.descripcion" => "",
        "T.nombre" => "",
    );
    $tablesi = array(
        "contabilidad C" => "tipo_contabilidad T", #0-0
        "C.id_tipo" => "T.id", #0-0
    );
    echo '<table>
    <tr></tr>
    <tr>
    <th></th>
    <th></th>
    <th style="background:#25dd78;"></th>
    <th style="background:#25dd78;"></th>
    <th style="background:#25dd78;">Reporte Ingresos al :'. $fdata. '</th>
    <th style="background:#25dd78;"></th>
    <th style="background:#25dd78;"></th>
    </tr>
    <tr></tr>
    </table>';
    foreach ($categi as $valuei) {
        $wherei = array(
            "C.fecha" => " LIKE CONCAT('%" . $fecha . "%') AND id_tipo=" . $valuei["id"] . " AND C.tipo = 'INGRESO'",
        );
        $ingreso = ControllerQueryes::SELECT($selecti, $tablesi, $wherei);
        echo "<table style='border-style: solid;border-color: #0d6efd;margin-bottom:5px'>
            <tr >
                <th></th>
                <th></th>
                <th></th>
                <td style='background:#25dd78;'>Tipo Ingreso:</td>
                <th style='background:#25dd78;color:#000;'>" . $valuei["nombre"] . "</th>
                <th></th>
                <th></th>
            </tr>
            <tr><td></td></tr>
            <tr>
            <th></th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Nro</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Tipo</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Categ. Ingreso</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Cantidad</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Fecha-Registro</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Descripcion</th>
            <th></th>
        </tr>
        ";
        $total = '0.00';
        foreach ($ingreso as $ky => $vali) {
            echo '<tr >
            <td></td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . ($ky + 1) . '</td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . $vali['tipo'] . '</td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . $vali['nombre'] . '</td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . $vali['cantidad'] . '</td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . $vali['fecha'] . '</td>
            <td style="border-style: solid;text:center;border-color: #000;margin-bottom:5px">' . $vali['descripcion'] . '</td>
            <td></td>
            </tr>';
            $total = $total + $vali["cantidad"];
        }
        echo '
        <tr>
        <th></th>
        <th></th>
        <th></th>
        <td style="background:#25dd78;;">total :</td>
        <th style="background:#25dd78;;">' . number_format($total, 2) . '</th>
        <th></th>
        <th></th>
        </tr></table><table><th></th></table>';
        //$cont .= $value['id']." ";

        //$cont = $cont+1;
    }
    /* ************************REPORTE DE GASTOS *************************/
    echo '<table>
    <tr></tr>
    <tr>
    <th></th>
    <th></th>
    <th style="background:#db5353;"></th>
    <th style="background:#db5353;"></th>
    <th style="background:#db5353;">Reporte Gastos al :' . $fdata . '</th>
    <th style="background:#db5353;"></th>
    <th style="background:#db5353;"></th>
    </tr>
    <tr></tr>
    </table>';
    $sel = array(
            "DISTINCT id_tipo" => "id",
            "T.nombre" => "",
        );
    $tab = array(
        "contabilidad C" => "tipo_contabilidad T", #0-0
        "C.id_tipo" => "T.id", #0-0
    );
    $wh = array(
        "C.fecha" => " LIKE CONCAT('%" . $fecha . "%')  AND C.tipo = 'GASTO'",
    );

    $categ = ControllerQueryes::SELECT($sel, $tab, $wh);
    //echo $historys;
    //print_r($historys);
    $select = array(
        "C.id" => "",
        "C.tipo" => "",
        "C.id_tipo" => "id_tipo",
        "C.cantidad" => "",
        "C.fecha" => "",
        "C.descripcion" => "",
        "T.nombre" => "",
    );
    $tables = array(
        "contabilidad C" => "tipo_contabilidad T", #0-0
        "C.id_tipo" => "T.id", #0-0
    );
    
    foreach ($categ as $value) {
        $where = array(
            "C.fecha" => " LIKE CONCAT('%" . $fecha . "%') AND id_tipo=" . $value["id"] . " AND C.tipo = 'GASTO'",
        );
        $gasto = ControllerQueryes::SELECT($select, $tables, $where);
        echo "<table style='border-style: solid;border-color: #0d6efd;margin-bottom:5px'>
            <tr >
                <th></th>
                <th></th>
                <th></th>
                <td style='background:#f0bb0f;'>Tipo Gasto:</td>
                <th style='background:#f0bb0f;color:#000;'>". $value["nombre"]."</th>
                <th></th>
                <th></th>
            </tr>
            <tr><td></td></tr>
            <tr>
            <th></th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Nro</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Tipo</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Categ. Gasto</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Cantidad</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Fecha-Registro</th>
            <th style='background:#CCC; color:#000;text:center;border-style: solid;border-color: #000'>Descripcion</th>
            <th></th>
        </tr>
        ";
        $total = '0.00';
        foreach ($gasto as $ky => $val) {
            echo '<tr >
            <td></td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . ($ky+1). '</td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . $val['tipo'] . '</td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . $val['nombre'] . '</td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . $val['cantidad'] . '</td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . $val['fecha'] . '</td>
            <td style="border-style: solid;border-color: #000;margin-bottom:5px">' . $val['descripcion'] . '</td>
            <td></td>
            </tr>';
            $total = $total + $val["cantidad"];
        }
        echo '
        <tr>
        <th></th>
        <th></th>
        <th></th>
        <td style="background:#db5353;">total :</td>
        <th style="background:#db5353;">' . number_format($total, 2) . '</th>
        <th></th>
        <th></th>
        </tr></table><table><th></th></table>';
        //$cont .= $value['id']." ";

        //$cont = $cont+1;
    }
    
}
