<?php
include('./../../../config/config.php');
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../controllers/almacen/productos.C.php');

class ajaxAddProductos{
/*=============================================
	CREAR PRODUCTOS
=============================================*/
    public $producto;
    public $deposito;
    public $imageFile;
    public function ajaxAddProducto()
    {
        $produc=$this->producto;
        $depo = $this->deposito;
        $imagen = $this->imageFile;
         $respuesta = ControllerProductos::CtrAddProducts($produc, $depo, $imagen);
        echo $respuesta;
        if ($respuesta=="ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Producto guardado",
                "rForm" => "addFormProductos",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "No se guardo el producto",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
        
    }
/*=============================================
	SLECT DEPOSITOS POR ALMACEN
=============================================*/
    public $depoxalm;
    public function ajaxDepoXalmacen(){

        $data =$this->depoxalm;
        $select = array(
            "id" => "",
            "deposito" => "dep",
            "tipo" => "",
            "idAlmacen" => "idalm",
        );

        $tables = array(
            "infraestructura" => "" #select*from
        );

        $where = array(
            "idAlmacen" => "='" . $data . "'",
            "estado" => "='1'"
        );

        $deposito = ControllerQueryes::SELECT($select, $tables, $where);
        echo '<option value="0">Crear Nuevo Deposito</option>';
        foreach ($deposito as $value) {
            echo '<option value="' . $value["id"] . '">' . $value["dep"] . '</option>';
        }
    }
    /*=============================================
	    SLECT DEPOSITOS
    =============================================*/
    public $iddeposito;
    public function ajaxSelectDeposito(){

        $idDep=$this->iddeposito;
        $select = array(
            "id"=>"",
            "deposito" => "dep",
            "tipo" => "",
            "catidad_actual" => "cant_act",
            "catidad_max" => "cant_max",
            "descripcion" => "descrip",
        );

        $tables=array(
            "infraestructura"=>""#select*from
        );

        $where=array(
            "id"=>"='". $idDep."'",
        );

        $deposito=ControllerQueryes::SELECT($select, $tables, $where);
        /* print_r($deposito[0]); */
        echo json_encode($deposito[0]);
    }
    /*=============================================
    ELIMINAR CATEGORIA
    =============================================*/
    public $idEliminar;
    public function ajaxeEliminarProducto()
    {

        $data = $this->idEliminar;
        $delate = array(
            "table" => "productos",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok"
        ) {
            $swift = array(
                "icon" => "success",
                "sms" => "Producto Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                    "color" => "error",
                    "sms" => "No se elimino el Producto",
                );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
	    ACTIVAR  PRODUCTO
    =============================================*/
    public $activarProd;
    public function ajaxActivarProducto()
    {
        $data = $this->activarProd;
        $update = array(
            "table" => "productos", #nombre de tabla
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
//////////////////////////////////OBJETOS//////////////////////////////////////////////////

/*=============================================
OBJETO CREAR PRODUCTOS
=============================================*/
if (isset($_POST['addProducts'])) {
    if(isset($_FILES['imageFile'])){
        $image= $_FILES['imageFile'];
    }else{
        $image=array('noimg'=>"0",'imgemty'=>"1");
    }
    $producto = new ajaxAddProductos();
    $producto->producto= json_decode($_POST["addProducts"], true);
    $producto->deposito = json_decode($_POST["addidDeposit"], true);
    $producto->imageFile = $image;
    $producto->ajaxAddProducto();
}
/*=============================================
OBJETO SLECT DEPOSITOS
=============================================*/
if (isset($_POST["depositosXalmacen"])) {
    $depoxalm = new ajaxAddProductos();
    $depoxalm->depoxalm= $_POST["depositosXalmacen"];
    $depoxalm->ajaxDepoXalmacen();
}
/*=============================================
OBJETO SLECT DEPOSITOS
=============================================*/
if (isset($_POST["idDepositSelect"])) {
    $selecdepo = new ajaxAddProductos();
    $selecdepo->iddeposito = stripslashes($_POST["idDepositSelect"]);
    $selecdepo->ajaxSelectDeposito();
}
/*=============================================
OBJETO ELIMINAR PRODUCTO
=============================================*/
if (isset($_POST["idEliminarProd"])) {
    $eliminarprod = new ajaxAddProductos();
    $eliminarprod->idEliminar = $_POST["idEliminarProd"];
    $eliminarprod->ajaxeEliminarProducto();
}
/*=============================================
OBJETO ACTIVAR PRODUCTO
=============================================*/
if (isset($_POST["activarId"])) {

    $activarprod = new ajaxAddProductos();
    $activarprod->activarProd = array(
        "valor" => $_POST["estadoproducto"],
        "id" => $_POST["activarId"],
    );
    $activarprod->ajaxActivarProducto();
}