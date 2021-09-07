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
                <td>' . $value["descripcion"] .'</td>';
            if ($value["estado"] != 0) {

                echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarCategoria" idcategoria="' . $value["id"] . '" estadocategoria="0">Activado</button></td>';
            } else {

                echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarCategoria" idcategoria="' . $value["id"] . '" estadocategoria="1">Desactivado</button></td>';
            }  
                 echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarCategoria(' . $value["id"].",'".  $value["nombre"] . "'," . "'" .  $value["descripcion"] . "'". ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarCategoria(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
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