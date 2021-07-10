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
                <td><img width="60" src="' . $value["Fimg"] . '">' . $value["Pnom"] . '</td>
                <td>' . $value["Pdesc"] . '</td>
                <td>' . $value["Pcant"] . '</td>
                <td>' . $value["Cnom"] . '</td>
                <td>' . $value["Unom"] . '-' . $value["Uasun"] . '</td>
                <td>' . $value["Pfini"] . '</td>
                <td>' . $value["Pfend"] . '</td>
                <td>' . $value["Inom"] . '</td>';
                if ($value["Pest"]==0) {
                echo '<td class="text-center"><span class="badge bg-danger">Desactivado</span></td>';
                } else {
                echo '<td class="text-center"><span class="badge bg-success">Activado</span></td>';
                }
                
                echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="edit-patient.html"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
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
