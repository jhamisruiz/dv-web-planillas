<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
date_default_timezone_set('America/Lima');

//la fecha de exportación sera parte del nombre del archivo Excel
//$fecha = date("d-m-Y H:i:s");

$id = "";
$dni = '';
$nombres = '';
if (isset($_GET["idruta"])) {
    $fecha = $_GET['idruta'];
    $dni = $_GET['nam'];

    $select = array(
        "T.nombre" => "",
        "T.apellidos" => "",
        "T.fecha_ingreso" => "f_in",
        "H.dni" => "",
        "H.salario" => "",
        "H.total_horas" => "",
        "H.precio_hora" => "",
        "H.monto_pagado" => "",
        "H.abono" => "",
        "H.cometario" => "",
        "H.mes" => "",
        "E.nombre" => "nom_emp",
    );
    $tables = array(
        "historial_pago H" => "trabajador T", #0-0
        "H.dni" => "T.dni", #0-0
        "empleo E" => "", #0-0
        "T.id_empleo" => "E.id", #0-0
    );
    $where = array(
        "H.mes" => " LIKE '" . $fecha . "%' AND T.dni=" . $dni,
    );
    $pay = ControllerQueryes::SELECT($select, $tables, $where);
    if (isset($pay[0]['nombre'])) {

        $nombres = $pay[0]['nombre'] . " " . $pay[0]['apellidos'];
    } else {
        $url = URL_HOST_WEB;
        header('Location: ' . $url);
    }

    $selectfal = array(
        "*" => "*"
    );
    $tablesfal = array(
        "detalle_asistencia" => "", #0-0
    );
    $wherefal = array(
        "dni" => '=' . $dni,
        "asistencia" => "='FALTA'  AND fecha_asistencia LIKE '" . $fecha . "%'",
    );
    $faltas = ControllerQueryes::SELECT($selectfal, $tablesfal, $wherefal);
    $tot_fal = count($faltas);

?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="https://lh3.googleusercontent.com/oUukRV8x9WR5J68u9pAxzbDoesBqT3lvdsEip-c0RnsNnO9f-qcqmddWzl6AFuYDMbA=s180-rw" type="image/x-icon">
        <title>Detalle-pdf</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    </head>

    <body>
        <div class="container d-flex justify-content-center mt-40 mb-40">
            <div class="row">
                <div class="col-md-12 text-right mb-3 mt-3">
                    <button class="btn btn-outline-warning" id="download">
                        <i class='fas fa-file-pdf' style='color:red'></i>
                        descargar pdf
                    </button>
                </div>

                <div class="col-md-12">
                    <div class=" pt-0" id="invoice">
                        <div class="card-header bg-transparent header-elements-inline p-">
                            <div class="text-center">
                                <h4 class="card-title text-primary"><strong>RO<?= $fecha ?>:Trabajador - Reporte Individual</strong></h4>
                                <h6 class="card-title text-primary p-0 m-0">(Contiene datos mínimos de una Boleta de Pago)</strong></h6>
                            </div>
                        </div>
                        <div class="card-body border border-secondary mb-2">
                            <h6>RUC:</h6>
                            <h6>Empleador :</h6>
                            <h6>Periodo : <strong><?= $fecha ?></strong></h6>
                        </div>
                        <div class="p-0 mb-2">
                            <table class="w-100">
                                <tr>
                                    <th colspan="2" class="text-center bg-info border border-secondary">Documento de Identidad</th>
                                    <th rowspan="2" colspan="4" class="text-center bg-info border border-secondary">Nombres y apellidos</th>
                                    <th rowspan="2" colspan="4" class="text-center bg-info border border-secondary">Situación</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-info border border border-secondary">Tipo</th>
                                    <th class="text-center bg-info border border border-secondary">Numero</th>
                                </tr>
                                <tr>
                                    <td class="text-center border border-secondary">DNI</td>
                                    <td class="text-center border border-secondary"><?= $dni ?></td>
                                    <td colspan="4" class="text-center border border-secondary"><?= $nombres ?></td>
                                    <td colspan="4" class="text-center border border-secondary">ACTIVO O SUBSIDIADO</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-center bg-info border border-secondary">Fecha de Ingreso</th>
                                    <th colspan="2" class="text-center bg-info border border-secondary">Tipo de Trabajador</th>
                                    <th colspan="2" class="text-center bg-info border border-secondary">Regimen Pensionario</th>
                                    <th colspan="4" class="text-center bg-info border border-secondary">CUSPP</th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center border border-secondary"><?= $pay[0]['f_in'] ?></td>
                                    <td colspan="2" class="text-center border border-secondary"><?= $pay[0]['nom_emp'] ?></td>
                                    <td colspan="2" class="text-center border border-secondary"></td>
                                    <td colspan="4" class="text-center border border-secondary"></td>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center bg-info border border-secondary">Días Laborables</th>
                                    <th rowspan="2" class="text-center bg-info border border-secondary">Días No Laborados</th>
                                    <th rowspan="2" class="text-center bg-info border border-secondary">Días subsidias</th>
                                    <th rowspan="2" class="text-center bg-info border border-secondary">Condición</th>
                                    <th colspan="2" class="text-center bg-info border border-secondary">Jornada Ordinaria</th>
                                    <th colspan="4" class="text-center bg-info border border-secondary">Sobretiempo</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-info border border-secondary">Total Horas</th>
                                    <th class="text-center bg-info border border-secondary">Minutos</th>
                                    <th class="text-center bg-info border border-secondary">Total Horas</th>
                                    <th class="text-center bg-info border border-secondary">Minutos</th>
                                </tr>
                                <tr>
                                    <td class="text-center border border-secondary">30</td>
                                    <td class="text-center border border-secondary"><?= $tot_fal ?></td>
                                    <td class="text-center border border-secondary"></td>
                                    <td class="text-center border border-secondary"></td>
                                    <?php
                                    $dias = '';
                                    $mins = '';
                                    if (isset($pay[0]['total_horas'])) {
                                        $data = $pay[0]['total_horas'];
                                        $days = explode(':', $data);
                                        if (count($days) > 0) {
                                            $dias = $days[0];
                                            $mins = $days[1];
                                        }
                                    }
                                    ?>
                                    <td class="text-center border border-secondary"><?= $dias ?></td>
                                    <td class="text-center border border-secondary"><?= $mins ?></td>
                                    <td class="text-center border border-secondary"></td>
                                    <td class="text-center border border-secondary"></td>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-center bg-info border border-secondary">Motivo de Suspensión de Labores</th>
                                    <th colspan="2" rowspan="2" class="text-center bg-info border border-secondary">Otros empleadores por
                                        Rentas de 5ta categoría
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-info border border-secondary">Tipo</th>
                                    <th colspan="4" class="text-center bg-info border border-secondary">Motivo</th>
                                    <th class="text-center bg-info border border-secondary">N.º Días</th>
                                </tr>
                                <tr>
                                    <td class="text-center  border border-secondary"></td>
                                    <td colspan="4" class="text-center  border border-secondary"></td>
                                    <td class="text-center  border border-secondary"></td>
                                    <td colspan="4" class="border border-secondary">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="p-0 mb-2">
                            <table class="w-100">
                                <tr>
                                    <td class="text-center bg-info border border-secondary">Codigo</td>
                                    <td colspan="4" class="text-center bg-info border border-secondary">Conceptos</td>
                                    <td class="text-center bg-info border border-secondary">Ingresos S/.</td>
                                    <td class="text-center bg-info border border-secondary">Descuentos S/.</td>
                                    <td class="text-center bg-info border border-secondary">Neto S/.</td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="bg-info border border-secondary">Ingresos</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="border border-secondary">REMUNERACIÓN PERMANENTE</td>
                                    <td colspan="4" class="border border-secondary"><?= $pay[0]['salario'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="bg-info border border-secondary">Neto a Pagar</td>
                                    <td colspan="1" class="bg-info border border-secondary"><?= $pay[0]['monto_pagado'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="p-0 mb-2">
                            <table class="w-100">
                                <tr>
                                    <td colspan="8" class="bg-info border border-secondary">Aportes de Empleador</td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="border border-secondary">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="p-0 mt-5 d-flex justify-content-center">
                            <h6 class="pl-5 pr-5 mr-5" style=" border-top: 1px solid #000;">Firma del Empleador</h6>
                            <h6 class="pl-5 pr-5 ml-5" style=" border-top: 1px solid #000;">Firma del Trabajador</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </body>
    <?php
    echo "<script>
        window.onload = function() {
            document.getElementById('download')
                .addEventListener('click', () => {
                    const invoice = this.document.getElementById('invoice');
                    console.log(invoice);
                    console.log(window);
                    var opt = {
                        margin: 1,
                        filename: '" . $nombres . ".pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 2
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'letter',
                            orientation: 'portrait'
                        }
                    };
                    html2pdf().from(invoice).set(opt).save();
                })
        }
    </script>";
    ?>

    </html>

<?php

}
