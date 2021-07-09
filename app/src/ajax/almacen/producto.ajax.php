<?php
include('./../../../config/config.php');
include('./../../../php/functions.php');
include('./../../../controllers/querys.C.php');
include('./../../../models/querys.M.php');
include('./../../../controllers/almacen/productos.C.php');

class ajaxAddProductos{
/*=============================================
     SELECT PRODUCTOS
=============================================*/
    public $idalmacen;
    public function ajaxSelectProducts(){

        $idAlmac = $this->idalmacen;
        
        $product = ControllerProductos::SELECTPRODS($idAlmac);
        foreach ($product as $key => $value) {
            echo '<tr>
                <td>'.($key+1).'</td>
                <td>'. $value["Pnom"].'</td>
                <td>' . $value["Pdesc"] . '</td>
                <td>' . $value["Pcant"] . '</td>
                <td>' . $value["Cnom"] . '</td>
                <td>' . $value["Unom"] . '-' . $value["Uasun"] . '</td>
                <td>' . $value["Pfini"] . '</td>
                <td>' . $value["Pfend"] . '</td>
                <td>' . $value["Pest"] . '</td>
                <td>' . $value["Inom"] . '</td>
                <td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-patient.html"><i class="fa fa-pencil m-r-5 text-success"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-trash-o m-r-5 text-danger"></i> Delete</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_patient ">
                                <i class="fa fa-times-circle text-primary"></i> Ress Password</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }

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
    ...
=============================================*/
}
//////////////////////////////////OBJETOS//////////////////////////////////////////////////
/*=============================================
OBJETO SELECT PRODUCTOS
=============================================*/
if (isset($_POST["selectIdAlmProds"])) {
    $idalmacen = new ajaxAddProductos();
    $idalmacen->idalmacen = $_POST["selectIdAlmProds"];
    $idalmacen->ajaxSelectProducts();
}
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
    $producto->producto=explode(",",$_POST["addProducts"]);
    $producto->deposito = explode(",",$_POST["addidDeposit"]);
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