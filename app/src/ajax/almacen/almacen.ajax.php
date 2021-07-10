<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxAlmacen{
    /*=============================================
 CREAR ALMACEN
=============================================*/
    public $almacen;
    public function ajaxCrearAlmacen(){

        $data = $this->almacen;
        if($data[0]=="PRINCIPAL"){
            $val = '';
            $val= 'idSucursal';
        }else{
            $val = 'fecha_cierre';
        }
        
        $insert = array(
            "table" => "almacen",
            "tipo" => $data[0],
            "nombre" => $data[2],
            "direccion" => $data[3],
            "referencia" => $data[4],
            "descripcion" => $data[5],
            "idUbigeo" => $data[6],
            $val => $data[1],
        );
        $almacen=ControllerQueryes::INSERT($insert);
        if ($almacen == "ok") {
            $path = dirname(__FILE__)."/../../../../public/img/". $insert['nombre'];
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
