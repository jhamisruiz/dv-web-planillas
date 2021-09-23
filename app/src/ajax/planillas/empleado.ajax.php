<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxEmpleado
{
    /*=============================================
        CREAR/EDITAR
    =============================================*/
    public $empleado;
    public function ajaxCrearEditEmpleado()
    {

        $data = $this->empleado;
        //print_r($data);
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "trabajador",
                "nombre" => $data['nombres'],
                "apellidos" => $data['apellidos'],
                "dni" => $data['dni'],
                "fecha_nacimiento" => $data['f_nacimiento'],
                "telefonos" => $data['telefono'],
                "email" => $data['email'],
                "direccion" => $data['direccion'],
                "id_ubigeo" => $data['ubigeo'],
                "id_sucursal" => $data['id_sucursal'],
                "id_departamento" => $data['id_area'],
                "id_empleo" => $data['id_empleo'],
                "salario" => $data['salario'],
                "sal_hora" => $data['sal_hora'],

            );
            $respuesta = ControllerQueryes::INSERT($insert);
            //echo $respuesta;
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "trabajador",
                "nombre" => $data['nombres'],
                "apellidos" => $data['apellidos'],
                "dni" => $data['dni'],
                "fecha_nacimiento" => $data['f_nacimiento'],
                "telefonos" => $data['telefono'],
                "email" => $data['email'],
                "direccion" => $data['direccion'],
                "id_ubigeo" => $data['ubigeo'],
                "id_sucursal" => $data['id_sucursal'],
                "id_departamento" => $data['id_area'],
                "id_empleo" => $data['id_empleo'],
                "salario" => $data['salario'],
                "sal_hora" => $data['sal_hora'],
            );
            $where = array(
                "id" => $data['id']
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificado";
        }

        if ( $respuesta == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Empleado" . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } elseif ($respuesta == "error") {
            $alertify = array(
                "color" => "error",
                "sms" => "Empleado no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }else{
            $dups = explode(':', $respuesta);
            $dup = explode(' ', $dups[2]);
            $alertify = array(
                "color" => "error",
                "sms" => "Empleado con " . $dup[7] . " : " . $dup[4]." ya existe.",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR
    =============================================*/
    public $idEliminarT;
    public function ajaxeEliminarTrabajador()
    {

        $data = $this->idEliminarT;
        $delate = array(
            "table" => "trabajador",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Empleado Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Empleado",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
}
/*=============================================
OBJETO CREAR/EDITAR EMPLEADOS
=============================================*/
if (isset($_POST['addEmpleados'])) {
    $employe = new ajaxEmpleado();
    $employe->empleado = $_POST['addEmpleados'];
    $employe->ajaxCrearEditEmpleado();
}
/*=============================================
OBJETO ELIMINAR 
=============================================*/
if (isset($_POST["idEliminarT"])) {
    $delemploye = new ajaxEmpleado();
    $delemploye->idEliminarT = $_POST["idEliminarT"];
    $delemploye->ajaxeEliminarTrabajador();
}