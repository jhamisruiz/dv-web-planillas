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
    public function ajaxSelect()
    {
        $idAlmac = $this->select;

        $product = ControllerProductos::SELECTPRODS($idAlmac);
        foreach ($product as $key => $value) {
            echo '<tr>
                <td>' . ($key + 1) . '</td>
                <td>' . $value["Pnom"] . '</td>
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
                            <a class="dropdown-item" href="edit-patient.html"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_patient ">
                                <i class="fa fa-times-circle text-primary"></i> Ress Password</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
}

 /*=============================================
    OBJETO SELECT PRODUCTOS
    =============================================*/
if (isset($_POST['selectProductos'])) {
    $select = new ajaxSelectProductos();
    $select->select = $_POST['selectProductos'];
    $select->ajaxSelect();
}
