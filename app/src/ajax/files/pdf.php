<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../models/query/SPquerys.M.php');
include('./../../../controllers/almacen/movimientos.C.php');

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="https://lh3.googleusercontent.com/oUukRV8x9WR5J68u9pAxzbDoesBqT3lvdsEip-c0RnsNnO9f-qcqmddWzl6AFuYDMbA=s180-rw" type="image/x-icon">
    <title>detalle-pdf</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

</head>

<body>
    <div class="container d-flex justify-content-center mt-50 mb-50">
        <div class="row">
            <div class="col-md-12 text-right mb-3 mt-3">
                <button class="btn btn-outline-warning" id="download">
                    <i class='fas fa-file-pdf' style='color:red'></i>
                    descargar pdf
                </button>
            </div>
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
            }
            ?>
            <div class="col-md-12">
                <div class="card border border-secondary" id="invoice">
                    <div class="card-header bg-transparent header-elements-inline">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title text-primary">Lista de productos - Movimiento #<strong>0-<?= $id ?></strong></h6>
                            <h6 class="card-title text-primary"><strong>Fecha: <?= $movimiento[0]['fecha'] ?></strong></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6>De: <strong><?= $movimiento[0]['almSalida'] ?></strong></h6>
                            <h6>Acción: <strong><?= $movimiento[0]['accion'] ?></strong></h6>
                            <h6>Para: <strong><?= $movimiento[0]['almEntrada'] ?></strong></h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">imagen</th>
                                                <th scope="col">Nombre Prod.</th>
                                                <th scope="col">Categoria</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Condición</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($request as $key => $value) {
                                                echo '<tr>
                                                        <th>' . ($key + 1) . '</th>
                                                        <td><img width=30" src="' . $value['imgUrl'] . '"></td>
                                                        <td>' . $value['nombre'] . '</td>
                                                        <td>' . $value['categoria'] . '</td>
                                                        <td>' . $value['descripcion'] . '</td>
                                                        <td>' . $value['cantidad'] . '</td>
                                                        <td>' . $value['condicion'] . '</td>
                                                        <td><input type="checkbox"></td>
                                                    </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="text-muted"><strong>Motivo: </strong></span>
                        <span class="text-muted"><?= $movimiento[0]['motivo'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
<script>
    window.onload = function() {
        document.getElementById("download")
            .addEventListener("click", () => {
                const invoice = this.document.getElementById("invoice");
                console.log(invoice);
                console.log(window);
                var opt = {
                    margin: 1,
                    filename: 'prueba.pdf',
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
</script>

</html>