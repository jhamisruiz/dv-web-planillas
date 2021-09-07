<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxAlmacen{
    /*=============================================
    CREAR/EDITAR ALMACEN
    =============================================*/
    public $almacens;
    public function ajaxCrearAlmacen(){

        $data = $this->almacens;
        if ($data[8]=="NO") { // edit=="no" insert almacen
            $nomFil=$data[2];
            if ($data[0] == "PRINCIPAL") {
                $val = '';
                $ingreso=1;
            } else {
                $val = $data[1];
                $ingreso=0;
            }

            $insert = array(
                "table" => "almacen",
                "tipo" => $data[0],
                "nombre" => $data[2],
                "direccion" => $data[3],
                "referencia" => $data[4],
                "descripcion" => $data[5],
                "idUbigeo" => $data[6],
                'idSucursal' => $data[7],
                'fecha_cierre' => $val,
                'ingreso' => $ingreso,
                "LASTID" => "YES",
            );
            if ($val == "fecha_cierre") {
                $insert = $insert + ['idSucursal' => $data[7]]; //pushear key mas el valor al array insert
            } else {
                $insert = $insert + ['ingreso' => '1'];
            }
            $almacen = ControllerQueryes::INSERT($insert);
        } else { //editar
            $nomFil = $data[2];
            if ($data[0] == "PRINCIPAL") {
                $val = '';
                $ingreso = 1;
            } else {
                $val = $data[1];
                $ingreso = 0;
            }
            $update = array(
                "table" => "almacen", #nombre de tabla
                "tipo" => $data[0],
                "nombre" => $data[2],
                "direccion" => $data[3],
                "descripcion" => $data[5],
                "idUbigeo" => $data[6],
                'idSucursal' => $data[7],
                'fecha_cierre' => $val,
                'ingreso' => $ingreso
            );

            $where = array(
                "id" => $data[9], #condifion columna y valor
            );

            $almacen=ControllerQueryes::UPDATE($update,$where);
        }
        
        if ($almacen >0||$almacen =='ok') {
            $path = dirname(__FILE__)."/../../../../public/img/". $nomFil;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $swift = array(
                "icon" => "success",
                "sms" => "Almacen guardado",
                "rForm" => "addFormAlmacen",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "No se guardo los datos del Almacen",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
	    ACTIVAR CATEGORIAS
    =============================================*/

    public $activarAlmacen;

    public function ajaxActivarAlmacen()
    {
        $data = $this->activarAlmacen;
        $update = array(
            "table" => "almacen", #nombre de tabla
            "estado" => $data["valor"], #nombre de columna y valor
            #"columna"=>"valor",#nombre de columna y valor
        );
        $where = array(
            "id" => $data["id"], #condifion columna y valor
        );

        $respuesta = ControllerQueryes::UPDATE($update, $where);
        echo $respuesta;
    
    }
    /*=============================================
        ELIMINAR EDITADO ALMACEN
    =============================================*/
    public $idEliminar;
    public function ajaxeEliminarAlmacen()
    {

        $data = $this->idEliminar;
        $delate = array(
            "table" => "almacen",
            "id" => $data,
        );

        $eliminar=ControllerQueryes::DELATE($delate);
        if ($eliminar=="ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Almacen Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Almacen",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
        

    }
}
/*=============================================
OBJETO CREAR/EDITAR ALMACEN
=============================================*/
if (isset($_POST['addAlmacen'])) {
    $addalmacen = new ajaxAlmacen();
    $addalmacen->almacens = $_POST['addAlmacen'];
    $addalmacen->ajaxCrearAlmacen();
}

/*=============================================
OBJETO ACTIVAR ALMACEN
=============================================*/
if (isset($_POST["activarId"])) {

    $activarusuario = new ajaxAlmacen();
    $activarusuario->activarAlmacen = array(
        "valor" => $_POST["estadoAlmacen"],
        "id" => $_POST["activarId"],
    );
    $activarusuario->ajaxActivarAlmacen();
}
/*=============================================
OBJETO ELIMINAR ALMACEN
=============================================*/
if (isset($_POST["idEliminar"])) {
    $eliminaralmacen = new ajaxAlmacen();
    $eliminaralmacen->idEliminar = $_POST["idEliminar"];
    $eliminaralmacen->ajaxeEliminarAlmacen();
}