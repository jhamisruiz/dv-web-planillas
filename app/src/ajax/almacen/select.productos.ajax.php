<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../controllers/almacen/productos.C.php');
class ajaxSelectProductos
{
    /*=============================================
    SELECT PRODUCTOS
    =============================================*/
    public $select;
    public $searchnom;
    public function ajaxSelect()
    {
        $idAlmac = $this->select;
        $search = $this->searchnom;
        $idProd="";
        $product = ControllerProductos::SELECTPRODS($idAlmac,$idProd, $search);
        foreach ($product as $key => $value) {
            echo '<tr>
                <td>' . ($key + 1) . '</td>
                <td><img width="45" class="rounded-circle" src="' . $value["Fimg"] . '">' . $value["Pnom"] . '</td>
                <td>' . $value["Pdesc"] . '</td>
                <td>' . $value["Pcant"] . '</td>
                <td>' . $value["Nmarca"] . '</td>
                <td>' . $value["Cnom"] . '</td>
                <td>' . $value["Anom"] . '</td>
                <td>' . $value["Unom"] . '-' . $value["Uasun"] . '</td>
                <td>' . $value["Pfini"] . '</td>
                <td>' . $value["Pfend"] . '</td>
                <td class="text-center">' . $value["Inom"] . '</td>
                <td class="text-center">' . $value["condicion"] . '</td>';
                if ($value["Pest"]!=0) {
                    echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarProducto" idproducto="' . $value["id"] . '" estadoproducto="0">Activado</button></td>';
                } else {
                    echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarProducto" idproducto="' . $value["id"] . '" estadoproducto="1">Desactivado</button></td>';
                }
                echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarProducto(' . $value["id"] . ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarProducto(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
    /*=============================================
    SELECT MARCAS
    =============================================*/
    public $marca;
    public function ajaxSelectMarca()
    {
        $tabla =$this->marca;
        $select =array(
            "*"=>"*"
        );
        $tables=array(
            $tabla=>""
        );

        $where="";
        
        $respuesta=ControllerQueryes::SELECT($select, $tables, $where);
        foreach ($respuesta as $value) {
            echo '<a onclick="'."addMarcaValue('". $value['nombre']."',". $value['id'].")".'"'." class='dropdown-item pb-0 pt-0 mb-0'>".$value['nombre']."</a>";
        }
    }

    /*=============================================
    SELECT PRODUCTOS para movimiento
    =============================================*/
    public $idmov;
    public $value;
    public function ajaxSelectProds()
    {
        $idAlmac = $this->idmov;

        $value=$this->value;

        $product = ControllerProductos::SEARCHPRODS($idAlmac, $value);
        foreach ( $product as $value) {
            echo '<a onclick="addcartmov(' . "'" . $value['nombre'] . "','" . $value['cantidad'] . "','" . $value['descripcion']."','" . $value['id'] ."'". ')" class="btn   btn-sm classprodmover w-100 text-left add-to-cart">
            '.$value['nombre']. ' - ' . $value['nombre'] . '<img class="ml-4 rounded-circle" width="20px" src="' . $value['imgUrl'] . '"></a>';
        }
    }

    public $idselectProd;
    public function ajaxIdSelectProducto(){
        $idAlmac="";
        $idProd = $this->idselectProd;
        $search='';
        $product = ControllerProductos::SELECTPRODS($idAlmac, $idProd,$search);
        echo json_encode($product[0]);
    }
}

 /*=============================================
    OBJETO SELECT PRODUCTOS
    =============================================*/
if (isset($_POST['selectProductos'])) {
    $select = new ajaxSelectProductos();
    $select->select = $_POST['selectProductos'];
    $select->searchnom = $_POST['search'];
    $select->ajaxSelect();
}

/*=============================================
    OBJETO GET EDITPRODUCTOS
    =============================================*/
if (isset($_POST['idSelectEditar'])) {
    $editar = new ajaxSelectProductos();
    $editar->idselectProd = $_POST['idSelectEditar'];
    $editar->ajaxIdSelectProducto();
}


/*=============================================
    OBJETO SELECT PRODUCTO MARCA
    =============================================*/
if (isset($_POST['selectMarca'])) {
    $marca = new ajaxSelectProductos();
    $marca->marca = $_POST['selectMarca'];
    $marca->ajaxSelectMarca();
}

/*=============================================
    OBJETO SELECT PRODUCTOS
    =============================================*/
if (isset($_POST['idselectMovProds'])) {
    $movimiento = new ajaxSelectProductos();
    $movimiento->idmov = $_POST['idselectMovProds'];
    $movimiento->value = $_POST['valueMovProds'];
    $movimiento->ajaxSelectProds();
}