<?php

include('./../../../php/functions.php');
include('./../../../controllers/querys.C.php');
include('./../../../models/querys.M.php');

class ajaxAlmacen{
    /*=============================================
 CREAR ALMACEN
=============================================*/
    public $almacen;
    public function ajaxCrearAlmacen(){

        $data = $this->almacen;
        $insert = array(
            "table" => "almacen",
            "nombre" => $data[1],
            "direccion" => $data[2],
            "idUbigeo" => $data[3],
            "descripcion" => $data[4],
            "idSucursal" => $data[0],
        );
        
        $almacen=CtrQueryes::INSERT($insert);
        if ($almacen == "ok") {
            $path = "../../../../public/img/". $insert['nombre'];
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

}
/*=============================================
OBJETO CREAR ALMACEN
=============================================*/
if (isset($_POST['addAlmacen'])) {
    $addalmacen = new ajaxAlmacen();
    $addalmacen->almacen = $_POST['addAlmacen'];
    $addalmacen->ajaxCrearAlmacen();
}
