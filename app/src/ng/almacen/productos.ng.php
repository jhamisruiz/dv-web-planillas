<?php
include('./../../../config/config.php');
include('./../../../php/functions.php');
include('./../../../controllers/querys.C.php');
include('./../../../models/querys.M.php');
include('./../../../controllers/almacen/productos.C.php');

$form_data = json_decode(file_get_contents("php://input"));

$select = array(
    "P.id" => "pid",
    "P.nombre" => "Pnom",
    "P.descripcion" => "Pdesc",
    "P.fecha_ingreso" => "Pfini",
    "P.fecha_end" => "Pfend",
    "P.cantidad" => "Pcant",
    "P.estado" => "Pest",
    "P.idCategoria" => "",
    "C.nombre" => "Cnom",
    "P.idUmedida" => "",
    "U.nombre" => "Unom",
    "U.abrev_sunat" => "Uasun",
    "P.idAlmacen" => "",
    "A.nombre" => "Anom",
    "P.idInfraestructura" => "",
    "I.deposito" => "Inom",
    "F.imgUrl" => "Fimg",
);

$tables = array(
    "productos P" => "almacen A", #0-0
    "P.idAlmacen" => "A.id", #1-1
    "categorias C" => "", #2-0
    "P.idCategoria" => "C.id", #3-1
    "unidadmedida U" => "", #4-0
    "P.idUmedida" => "U.id", #5-1
    "infraestructura I" => "", #6-0
    "P.idInfraestructura" => "I.id", #7-1
    "images F" => "", #8-0
    "P.id" => "F.idProducto", /**/   # 9-1
);

if (isset($form_data->select_prods)) {
    $prods=$form_data->select_prods;
    $where = array(
        "P.idAlmacen" => "=". $prods,
    );
} else {
    if (isset($form_data->search_prods)) {
        $where = "";
        $s_q = $form_data->search_prods;
        $id = $form_data->id_almacen;
        $where = array(
            "P.idAlmacen" => "=". $id,
            "(P.id LIKE '%$s_q%' OR P.descripcion LIKE '%$s_q%' OR P.cantidad LIKE '%$s_q%') OR P.nombre = '%$s_q%'" => ""
        );
    } else {
        $where = array(
            "P.idAlmacen" => ">0",
        );
    }
}


$products = ControllerQueryes::SELECT($select, $tables, $where);

echo json_encode($products);