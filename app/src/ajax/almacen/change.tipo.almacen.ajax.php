<?php 
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');


class ajaxUpdateTipoAlamacen
{
    /*=============================================
    SELECT ALMACEN
    =============================================*/
    public $id;
    public $nowtype;
    public $newtype;
    public $update;
    public function ajaxUpdate()
    {

        $id = $this->id;
        $newtype = $this->nowtype;
        $update = array(
        	"table" => "almacen",
            "tipo" => $newtype,
        );        

        $where = array(
        	"id" => $id,
        );
        $respuesta = ControllerQueryes::UPDATE($update,$where);
        if ($respuesta=="ok") {
        	$swift = array(
                "icon" => "success",
                "sms" => "Tipo de almacen modificado.",
                "rForm" => "addFormAlmacen",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        }else{
        	$alertify = array(
                "color" => "error",
                "sms" => "No se modifico el tipo de almacen.",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
       
    }
}
/*=============================================
    OBJETO SELECT ALMACEN
    =============================================*/
if (isset($_POST['idalmacen'])) {
    $update = new ajaxUpdateTipoAlamacen();
    $update->id = $_POST['idalmacen'];
    $update->nowtype = $_POST['nowtype'];
    $update->ajaxUpdate();
}






 ?>