<?php

include('./../../php/functions.php');
include('./../../controllers/query/querys.C.php');
include('./../../models/query/querys.M.php');

class ajaxSelectSucursal
{
    /*=============================================
    SELECT SUCURSALES
    =============================================*/
    public $select;
    public $idedit;
    public function ajaxSelectSucursales()
    {

        $nombre = $this->select;
        $id = $this->idedit;
        $select = array(
            "S.id" => "",
            "S.nombre" => "",
            "S.direccion" => "",
            "S.referencia" => "",
            "S.estado" => "",
            "S.idUbigeo" => "ubigeo",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
        );

        $tables = array(
            "sucursales S" => " ubigeo U", #0-0
            "S.idUbigeo" => "U.id_ubigeo", #1-1
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );

        if ($id==false) {
            if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
                $where = '';
            } else {
                $where = array(
                    "S.nombre" => " LIKE CONCAT('%" . $nombre . "%')",
                );
            }
        } else {
            $where = array(
                "id" => '='.$id
            );
        }
        

        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $respuesta;
        if ($id == false) {
            foreach ($respuesta as $key => $value) {
                echo '<tr>
                   <td>' . $key = ($key + 1) . '</td>
                   <td>' . $value["nombre"] . '</td>
                   <td>' . $value["depa"] . ' - ' . $value["provi"] . ' - ' . $value["dist"] . '</td>
                   <td>' . $value["direccion"] . '</td>
                   <td>' . $value["referencia"] . '</td>';

                echo '<td class="text-right" >
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                            <div class="dropdown-menu dropdown-menu-right border border-secondary">
                                <a class="dropdown-item" onclick="editarSucursal(' . $value["id"] . ')"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                                <a class="dropdown-item"onclick="eliminarSucursal(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            echo json_encode($respuesta[0]);
        }
        
    }
    /*=============================================
    CREAR/EDITAR SUCURSALES
    =============================================*/
    public $addsucursal;
    public function ajaxCrearEditarSucu()
    {

        $data = $this->addsucursal;
        if ($data['editar'] == "NO") { // edit=="no" insert

            $insert = array(
                "table" => "sucursales",
                "nombre" => $data['nombre'],
                "direccion" => $data['direccion'],
                "referencia" => $data['referencia'],
                "idUbigeo" => $data['ubigeo'],
            );
            $sucursal = ControllerQueryes::INSERT($insert);

        } else { //editar
            $update = array(
                "table" => "sucursales", #nombre de tabla
                "nombre" => $data['nombre'],
                "direccion" => $data['direccion'],
                "referencia" => $data['referencia'],
                "idUbigeo" => $data['ubigeo'],
            );

            $where = array(
                "id" => $data['id'], #condifion columna y valor
            );

            $sucursal = ControllerQueryes::UPDATE($update, $where);
        }

        if ($sucursal > 0 || $sucursal == 'ok') {

            $swift = array(
                "icon" => "success",
                "sms" => "Datos Sucursal guardado",
                "rForm" => "addFormSucursal",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "No se guardo los datos de la sucursal",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    UPDATE ALMACEN PERMISOS
    =============================================*/
    /*=============================================
    ELIMINAR 
    =============================================*/
    public $idEliminar;
    public function ajaxeEliminarSucursal()
    {

        $data = $this->idEliminar;
        $delate = array(
                "table" => "sucursales",
                "id" => $data,
            );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Datos Eliminados",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino la sucursal.",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }

}

/*=============================================
    OBJETO SELECT SUCURSAL
    =============================================*/
if (isset($_POST['selectSucursales'])) {
    $select = new ajaxSelectSucursal();
    $select->select = $_POST['search'];
    $select->idedit = false;
    $select->ajaxSelectSucursales();
}
/*=============================================
    OBJETO SELECT-edit SUCURSAL
    =============================================*/
if (isset($_POST['idSelectEditarSuc'])) {
    $select = new ajaxSelectSucursal();
    $select->select = '';
    $select->idedit = $_POST['idSelectEditarSuc'];
    $select->ajaxSelectSucursales();
}
/*=============================================
OBJETO CREAR/EDITAR SUCURSALES
=============================================*/
if (isset($_POST['addSucursal'])) {
    $addsucu = new ajaxSelectSucursal();
    $addsucu->addsucursal = $_POST['addSucursal'];
    $addsucu->ajaxCrearEditarSucu();
}
/*=============================================
OBJETO ELIMINAR 
=============================================*/
if (isset($_POST["idEliminar"])) {
    $eliminar = new ajaxSelectSucursal();
    $eliminar->idEliminar = $_POST["idEliminar"];
    $eliminar->ajaxeEliminarSucursal();
}