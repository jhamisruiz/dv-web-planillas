<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
class ajaxSelectAlamacen
{
    /*=============================================
    SELECT ALMACEN
    =============================================*/
    public $select;
    public function ajaxSelect()
    {

        $tabla = $this->select;
        $select = array(
            "A.id" => "",
            "A.nombre" => "",
            "A.direccion" => "",
            "A.referencia" => "",
            "A.estado" => "",
            "A.tipo" => "",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
        );

        $tables = array(
            $tabla . " A" => "",
            "almacen A" => "ubigeo U", #0-0
            "A.idUbigeo" => "U.id_ubigeo", #1-1
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );

        $where = "";
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                   <td>' . $key = ($key + 1) . '</td>
                   <td>' . $value["nombre"] . '</td>
                   <td>' . $value["depa"] . ' - ' . $value["provi"] . ' - ' . $value["dist"] . '</td>
                   <td>' . $value["direccion"] . '<br><strong>Ref:</strong>' . $value["referencia"] . '</td>';
            if ($value["estado"] == 1) {

                echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="0">Activado</button></td>';
            }
            if ($value["estado"] == 'ENDED') {
                echo '<td class="text-center"><span class="badge bg-secondary">FINALIZADO</span></td>';
            }
            if ($value["estado"] == 0) {

                echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="1">Desactivado</button></td>';
            }
            if ($value["estado"] != 'ENDED') {
                echo '<td class="text-right" >
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="edit-patient.html"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                                    <a class="dropdown-item" href="#"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_patient ">
                                        <i class="fa fa-times-circle text-primary"></i> Ress Password</a>
                                </div>
                            </div>
                        </td>
                </tr>';
            }else{
                echo '<td></td>';
            }
        }
    }
}

/*=============================================
    OBJETO SELECT ALMACEN
    =============================================*/
if (isset($_POST['selectAlmacen'])) {
    $select = new ajaxSelectAlamacen();
    $select->select = $_POST['selectAlmacen'];
    $select->ajaxSelect();
}
