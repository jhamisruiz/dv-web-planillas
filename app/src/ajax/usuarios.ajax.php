<?php

include('./../../php/functions.php');
include('./../../controllers/query/querys.C.php');
include('./../../models/query/querys.M.php');
class ajaxUsuarios{

/*=============================================
	CREAR USUARIOS
=============================================*/
    public $usuarios;
    public function ajaxCrearUsuarios(){
        
        $data = $this->usuarios;

        $insert=array(
            "table"=>"personas",
            "nombres"=> $data[0],
            "apellidos" => $data[1],
            "email" => $data[3],
            "LASTID"=>"TRUE",
        );
        $persona = ControllerQueryes::INSERT($insert);
        
        if ($persona == "error") {

            $alertify = array(
                "color" => "error",
                "sms" => "Usuario no guardado",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }else{

            $insert =NULL;
            $insert = array(
                "table" => "usuarios",
                "userNombre" => $data[2],
                "password" => password_hash($data[4], PASSWORD_DEFAULT),
                "idPersona"=> $persona,
                "LASTID" => "TRUE",
            );
            $usuario = ControllerQueryes::INSERT($insert);
            
            if ($usuario=="error") {

                $delate=array(
                    "table"=>"personas",
                    "id" => $persona,
                );
                $delpersona = ControllerQueryes::DELATE($delate);
                $alertify = array(
                    "color" => "error",
                    "sms" => "Usuario no guardado",
                );
                $error = Functions::Alertify($alertify);
                echo $error;
            }else{

                $swift = array(
                    "icon" => "success",
                    "sms" => "Usuario guardado",
                    "rForm" => "addFormUsuarios",
                );
                $succes = Functions::SwiftAlert($swift);
                echo $succes;
            }
        }
    }
/*=============================================
	ACTIVAR CATEGORIAS
=============================================*/

    public $activarUsuarios;

    public function ajaxActivarUsuarios()
    {
        $data = $this->activarUsuarios;
        $update=array(
            "table"=>"usuarios",#nombre de tabla
            "estado" => $data["valor"],#nombre de columna y valor
            #"columna"=>"valor",#nombre de columna y valor
        );
        $where=array(
            "id"=>$data["id"],#condifion columna y valor
        );

        $respuesta = ControllerQueryes::UPDATE($update, $where);
        echo $respuesta;

    }
}


/*=============================================
OBJETO CREAR USUARIOS
=============================================*/
if (isset($_POST['addUsuario'])) {
    $usuarios = new ajaxUsuarios();
    $usuarios->usuarios = $_POST['addUsuario'];
    $usuarios->ajaxCrearUsuarios();
}
/*=============================================
OBJETO ACTIVAR USUARIOS
=============================================*/
if (isset($_POST["activarId"])) {
    
    $activarusuario = new ajaxUsuarios();
    $activarusuario->activarUsuarios = array(
        "valor"=>$_POST["estadoUsuario"],
        "id"=> $_POST["activarId"],
    );
    $activarusuario->ajaxActivarUsuarios();
}