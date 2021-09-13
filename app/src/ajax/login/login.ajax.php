<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/login/login.C.php');
class ajaxLogin{
    public $registro;
    public function registro(){
        $data = $this->registro;

        $respuest=ControllerLogin::REGISTRO($data);
        print_r($respuest);
        //echo $data;
        
    }
    public $login;
    public function login()
    {
        $data = $this->login;

        $respuest = ControllerLogin::LOGIN($data);
        //print_r($respuest);
        echo $respuest;
    }
    /*=============================================
	    ACTIVAR eliminar
    =============================================*/
    public $eliminar;
    public function eliminar()
    {
        $data = $this->eliminar;
        $delate = array(
            'table'=>'admin',
            "id"=> $data
        );
        $respuest = ControllerQueryes::DELATE($delate);
        //print_r($respuest);
        //echo $respuest;
        if ($respuest == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Usuario Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Usuario",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
	    ACTIVAR CATEGORIAS
    =============================================*/

    public $activarUsuarios;

    public function ajaxActivarUsuarios()
    {
        $data = $this->activarUsuarios;
        $update = array(
            "table" => "admin", #nombre de tabla
            "estado" => $data["valor"], #nombre de columna y valor
            #"columna"=>"valor",#nombre de columna y valor
        );
        $where = array(
            "id" => $data["id"], #condifion columna y valor
        );

        $respuesta = ControllerQueryes::UPDATE($update, $where);
        echo $respuesta;
    }
}

//objeto REGISTRO
if (isset($_POST['userRegistro'])) {
    $registro = new ajaxLogin();
    $registro->registro = $_POST['userRegistro'];
    $registro->registro();
}

//objeto login

if (isset($_POST['usuerLogin'])) {
    $login = new ajaxLogin();
    $login->login= $_POST['usuerLogin'];
    $login->login();
}
//ACTIVAR
if (isset($_POST["activarId"])) {

    $activarusuario = new ajaxLogin();
    $activarusuario->activarUsuarios = array(
        "valor" => $_POST["estadoadmin"],
        "id" => $_POST["activarId"],
    );
    $activarusuario->ajaxActivarUsuarios();
}

//objeto eliminar
if (isset($_POST['idEliminar'])) {
    $admin = new ajaxLogin();
    $admin->eliminar = $_POST['idEliminar'];
    $admin->eliminar();
}