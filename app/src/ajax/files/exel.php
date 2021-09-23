<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../models/query/SPquerys.M.php');
include('./../../../controllers/almacen/movimientos.C.php');

?>
<?php
$id = "";
if (isset($_GET["idruta"])) {
    $id = $_GET['idruta'];
    $select = array("*" => "*");
    $tables = array("movimientos" => "");
    $where = array(
        'id' => '=' . $id
    );
    $idm = $id;
    $search = "";
    $movimiento = ControllerMovimientos::SELECMOVIMIENTOS($idm, $search);
    $request = SPModelQueryes::SPDetalleMovimiento($id);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="https://lh3.googleusercontent.com/oUukRV8x9WR5J68u9pAxzbDoesBqT3lvdsEip-c0RnsNnO9f-qcqmddWzl6AFuYDMbA=s180-rw" type="image/x-icon">
    <title>detalle-exel</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

</head>
<?php
//establecemos el timezone para obtener la hora local
date_default_timezone_set('America/Lima');

//la fecha de exportación sera parte del nombre del archivo Excel
$fecha = date("d-m-Y H:i:s");
$namef=$id."_". $movimiento[0]['fecha'];
//Inicio de exportación en Excel
header('Content-type: text/csv');
header("Content-Disposition: attachment; filename=MN0$namef.xls"); //Indica el nombre del archivo resultante
header("Pragma: no-cache");
header("Expires: 0");

echo "<table style='border-style: solid;border-color: #0d6efd'>
        <tr>
        </tr>
        <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th style='background:#0d6efd; color:#CCC'>LISTA DE MATERIALES - $fecha</th>
        <th></th>
        </tr>
        <tr></tr>
        <tr>
        <th></th>
            <th style='background:#CCC; color:#000'>Usuario</th>
            <th style='background:#CCC; color:#000'></th>
            <th style='background:#CCC; color:#000'>Fecha movimiento</th>
            <th style='background:#CCC; color:#000'>Solicitado a</th>
            <th style='background:#CCC; color:#000'>Accion</th>
            <th style='background:#CCC; color:#000'>Solicitado por</th>
            <th style='background:#CCC; color:#000'>Motivo</th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td>" . $movimiento[0]['usuario'] . "</td>
            <td></td>
            <td>".$movimiento[0]['fecha']. "</td>
            <td>". $movimiento[0]['almSalida']."</td>
            <td>". $movimiento[0]['accion']."</td>
            <td>". $movimiento[0]['almEntrada']."</td>
            <td>". $movimiento[0]['motivo']."</td>
        </tr>
        <tr></tr>
        <tr>  
            <th></th>
            <th style='background:#CCC; color:#000'>Nro</th>
            <th style='background:#CCC; color:#000'>Imagen</th>
            <th style='background:#CCC; color:#000'>Nombre</th>
            <th style='background:#CCC; color:#000'>Descripcion</th>
            <th style='background:#CCC; color:#000'>Categoria</th>
            <th style='background:#CCC; color:#000'>Cantidad</th>
            <th style='background:#CCC; color:#000'>Condicion</th>
            <th></th>
        </tr>";
        foreach ($request as $key => $value) {
            echo '<tr>
                <th></th>
                <th>' . ($key + 1) . '</th>
                <td><img width=30" src="' . $value['imgUrl'] . '"></td>
                <td>' . $value['nombre'] . '</td>
                <td>' . $value['descripcion'] . '</td>
                <td>' . $value['categoria'] . '</td>
                <td>' . $value['cantidad'] . '</td>
                <td>' . $value['condicion'] . '</td>
        </tr><tr></tr>';
        }
  echo "</table>";
}
