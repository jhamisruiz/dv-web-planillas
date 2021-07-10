<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxCategorias{
    /*=============================================
	CREAR CATEGORIAS
=============================================*/
    public $categorias;
    public function ajaxCrearCategorias(){

        $data = $this->categorias;
        $insert=array(
            "table"=>"categorias",
            "nombre"=> $data[0],
            "descripcion" => $data[1]
        );
        $respuesta=ControllerQueryes::INSERT($insert);
        if ($respuesta=="ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Categoria Creada",
                "rForm" => "addFormCategorias",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        }else {

            $alertify = array(
                "color" => "error",
                "sms" => "No se creo la Caegoria",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }

/*=============================================
	ACTIVAR CATEGORIAS
=============================================*/

    public $activarCategorias;
    public function ajaxActivarCategorias()
    {
        $data = $this->activarCategorias;
        $update = array(
            "table" => "categorias", #nombre de tabla
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

/*=============================================
OBJETO CREAR CATEGORIAS
=============================================*/
if (isset($_POST['addCategoria'])) {
    $categorias = new ajaxCategorias();
    $categorias->categorias = $_POST['addCategoria'];
    $categorias->ajaxCrearCategorias();
}

/*=============================================
OBJETO ACTIVAR CATEGORIAS
=============================================*/
if (isset($_POST["activarId"])) {

    $activarCategorias = new ajaxCategorias();
    $activarCategorias->activarCategorias = array(
        "valor" => $_POST["estadoCategoria"],
        "id" => $_POST["activarId"],
    );
    $activarCategorias->ajaxActivarCategorias();
}