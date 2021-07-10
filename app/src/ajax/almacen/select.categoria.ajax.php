<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
class ajaxSelectCategorias
{
    /*=============================================
    SELECT ALMACEN
    =============================================*/
    public $select;
    public function ajaxSelect()
    {
        $tabla = $this->select;
        $select = array(
            "*" => "*"
        );

        $tables = array(
            $tabla  => "",
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );
        $where = "";
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["descripcion"] . '</td>
                <td>' . $value["descripcion"] . '</td>
                <td class="text-right">
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
        }
    }
}

if (isset($_POST['selectCategoria'])) {
    $select = new ajaxSelectCategorias();
    $select->select = $_POST['selectCategoria'];
    $select->ajaxSelect();
}