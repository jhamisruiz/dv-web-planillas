<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxDepa_Tipo_Empleo
{
    /*=============================================
	CREAR/editar DEPARTAMENTOS
    =============================================*/
    public $depas;
    public function ajaxCrearDepartamentos()
    {

        $datas = $this->depas;
        $data=$datas[0];
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "departamento",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion']
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "departamento",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion']
            );
            $where = array(
                "id" => $data['id']
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificado";
        }

        if ($respuesta == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Departamento" . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Departamento no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR
    =============================================*/
    public $idEliminarD;
    public function ajaxeEliminarDepa()
    {

        $data = $this->idEliminarD;
        $delate = array(
            "table" => "departamento",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Departamento Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Departamento",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=========== empleos */
    /*=============================================
	CREAR/editar EMPLEOS
    =============================================*/
    public $empleo;
    public function ajaxCrearEmpleos()
    {

        $datas = $this->empleo;
        $data = $datas[0];
        if ($data['editar'] == "NO"
        ) {
            $insert = array(
                "table" => "empleo",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion']
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "empleo",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion']
            );
            $where = array(
                "id" => $data['id']
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificado";
        }

        if ($respuesta == "ok"
        ) {
            $swift = array(
                "icon" => "success",
                "sms" => "Empleo" . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                    "color" => "error",
                    "sms" => "Empleo no " . $sms,
                );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR EMPLEO
    =============================================*/
    public $idEliminarE;
    public function ajaxeEliminarEmpleo()
    {

        $data = $this->idEliminarE;
        $delate = array(
            "table" => "empleo",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Empleo Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Empleo",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }

}

/*=============================================
OBJETO CREAR/EDITAR DEPARTAMENTOS
=============================================*/
if (isset($_POST['AddDepartamentos'])) {
    $depas = new ajaxDepa_Tipo_Empleo();
    $depas->depas = $_POST['AddDepartamentos'];
    $depas->ajaxCrearDepartamentos();
}
/*=============================================
OBJETO ELIMINAR DEPARTAMENTOS
=============================================*/
if (isset($_POST["idEliminarD"])) {
    $elimindardepa = new ajaxDepa_Tipo_Empleo();
    $elimindardepa->idEliminarD = $_POST["idEliminarD"];
    $elimindardepa->ajaxeEliminarDepa();
}

/* =========EMPLEOS========= */

/*=============================================
OBJETO CREAR/EDITAR Empleos
=============================================*/
if (isset($_POST['AddEmpleos'])) {
    $depas = new ajaxDepa_Tipo_Empleo();
    $depas->empleo = $_POST['AddEmpleos'];
    $depas->ajaxCrearEmpleos();
}
/*=============================================
OBJETO ELIMINAR Empleos
=============================================*/
if (isset($_POST["idEliminarE"])) {
    $eliminemp = new ajaxDepa_Tipo_Empleo();
    $eliminemp->idEliminarE = $_POST["idEliminarE"];
    $eliminemp->ajaxeEliminarEmpleo();
}