<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxCategorias{
    /*=============================================
	CREAR/editar CATEGORIAS
    =============================================*/
    public $categorias;
    public function ajaxCrearCategorias(){

        $data = $this->categorias;
        if ($data[2]=="NO") {
            $insert = array(
                "table" => "categorias",
                "nombre" => $data[0],
                "descripcion" => $data[1]
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms="Careada";
        } else {
            $update = array(
                "table" => "categorias",
                "nombre" => $data[0],
                "descripcion" => $data[1]
            );
            $where=array(
                "id" => $data[3]
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificada";
        }
        
        if ($respuesta=="ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Categoria". $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        }else {

            $alertify = array(
                "color" => "error",
                "sms" => "Categoria no ".$sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR CATEGORIA
    =============================================*/
    public $idEliminar;
    public function ajaxeEliminarCategoria()
    {

        $data = $this->idEliminar;
        $delate = array(
            "table" => "categorias",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Almacen categorias",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el categorias",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
	    ACTIVAR CATEGORIAS
    =============================================*/

    public $activarCat;
    public function ajaxActivarCategorias()
    {
        $data = $this->activarCat;
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
OBJETO CREAR/EDITAR CATEGORIAS
=============================================*/
if (isset($_POST['addCategoria'])) {
    $categorias = new ajaxCategorias();
    $categorias->categorias = $_POST['addCategoria'];
    $categorias->ajaxCrearCategorias();
}
/*=============================================
OBJETO ELIMINAR categoria
=============================================*/
if (isset($_POST["idEliminar"])) {
    $eliminarcategoria = new ajaxCategorias();
    $eliminarcategoria->idEliminar = $_POST["idEliminar"];
    $eliminarcategoria->ajaxeEliminarCategoria();
}
/*=============================================
OBJETO ACTIVAR CATEGORIAS
=============================================*/
if (isset($_POST["activarId"])) {

    $activarCategorias = new ajaxCategorias();
    $activarCategorias->activarCat = array(
        "valor" => $_POST["estadoCategoria"],
        "id" => $_POST["activarId"],
    );
    $activarCategorias->ajaxActivarCategorias();
}