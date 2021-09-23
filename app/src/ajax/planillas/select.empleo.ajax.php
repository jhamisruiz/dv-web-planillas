<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
class ajaxSelectEmpleo
{
    /*=============================================
    SELECT ALMACEN
    =============================================*/
    public $select;
    public $search;
    public function ajaxSelectEmpleos()
    {
        $tabla = $this->select;
        $nombre = $this->search;
        $select = array(
            "*" => "*"
        );
        $tables = array(
            $tabla  => "",
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );
        if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
            $where = '';
        } else {
            $where = array(
                "nombre" => " LIKE CONCAT('%" . $nombre . "%')",
            );
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["descripcion"] . '</td>
                <td>' . $value["fecha_registro"] . '</td>';
            echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarEmpleo(' . $value["id"] . ",'" .  $value["nombre"] . "'," . "'" .  $value["descripcion"] . "'" . ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarEmpleo(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
}

if (isset($_POST['selectEmpleo'])) {
    $select = new ajaxSelectEmpleo();
    $select->select = $_POST['selectEmpleo'];
    $select->search = $_POST['search'];
    $select->ajaxSelectEmpleos();
}
