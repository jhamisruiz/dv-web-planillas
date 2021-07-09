<?php
include('./../../php/functions.php');
include('./../../controllers/querys.C.php');
include('./../../models/querys.M.php');
include('./../../controllers/almacen/productos.C.php');
class ajaxPruebasProductsss{
    public $producto;
    public $deposito;
    public function ajaxAddProductsss()
    {
        $data = $this->producto;
        $depo = $this->deposito;

        $prueba = array(
            "a" => $data["idAlm"],
            "a" => $data["nom"],
        );
        echo $data["idAlm"];
        /* $depo = json_decode($produc); */

        #$respuesta = ControllerProductos::CtrAddProductos($produc, $depo);

    }

}

/*=============================================
OBJETO CREAR PRODUCTOS
=============================================*/

if (isset($_POST['addProdNom'])) {
    $producto = new ajaxPruebasProductsss();
    $producto->producto = array(
        "idAlm" => $_POST["addProdIdal"], "nom" => $_POST["addProdNom"],
        "cat" => $_POST["addProdCat"], "cant" => $_POST["addProdCant"],
        "uMed" => $_POST["addProdUmed"], "abrev" => $_POST["addProdAbre"],
        "fini" => $_POST["addProdFini"], "fend" => $_POST["addProdFend"],
        "desc" => $_POST["addProdDesc"], "reco" => $_POST["addProdReco"],
    );
    $producto->deposito = array(
        "idDep" => $_POST["addDepIddep"], "nom" => $_POST["addDepNom"],
        "tipo" => $_POST["addDepTip"], "cini" => $_POST["addDepCmin"],
        "cmax" => $_POST["addDepCmax"], "desc" => $_POST["addDepDesc"],
    );
    $producto->ajaxAddProductsss();
}