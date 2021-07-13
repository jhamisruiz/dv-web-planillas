<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/almacen/almacen.C.php');
class ajaxSelectAlamacen
{
    /*=============================================
    SELECT ALMACEN
    =============================================*/
    public $select;
    public function ajaxSelect()
    {

        $tabla = $this->select;
        $select = array(
            "A.id" => "",
            "A.nombre" => "",
            "A.direccion" => "",
            "A.referencia" => "",
            "A.estado" => "",
            "A.tipo" => "",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
        );

        $tables = array(
            $tabla . " A" => "",
            "almacen A" => "ubigeo U", #0-0
            "A.idUbigeo" => "U.id_ubigeo", #1-1
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );

        $where = "";
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                   <td>' . $key = ($key + 1) . '</td>
                   <td>' . $value["nombre"] . '</td>
                   <td>' . $value["depa"] . ' - ' . $value["provi"] . ' - ' . $value["dist"] . '</td>
                   <td>' . $value["direccion"] . '<br><strong>Ref:</strong>' . $value["referencia"] . '</td>';

            if ($value["estado"] == 1) {

                echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="0">Activado</button></td>';
            }
            if ($value["estado"] == 'ENDED') {
                echo '<td class="text-center"><span class="badge bg-secondary">FINALIZADO</span></td>';
            }
            if ($value["estado"] == 0) {

                echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="1">Desactivado</button></td>';
            }
                     

                echo '<td class="text-center"><select name="" 
                        class="form-control border border-primary selectChangeAlmacen" idalmacen="' . $value["id"] . '" tipoalmacen="TEMPORAL" style="font-size: 10px;">
                        <option value="'.$value["tipo"].'" selected>'.$value["tipo"].'</option>';
                if ($value["tipo"] == 'TEMPORAL') {
                    echo '<option value="PRINCIPAL">PRINCIPAL</option>';
                    }else{
                    echo '<option value="TEMPORAL">TEMPORAL</option>';
                    };     
                    echo '</select></td>';

            
            if ($value["estado"] != 'ENDED') {
                echo '<td class="text-right" >
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

                echo '<td></td>';
            
        }
    }
    /*=============================================
    SELECT ALMACEN PERMISOS
    =============================================*/
    public $permiso;
    public function ajaxSelectAlmacenPermisos()
    {

        $tables = $this->permiso;

        $respuesta = ControllerAlmacen::SELECTALL($tables);
        foreach ($respuesta as $value) {
            $valueid ="'". $value['id']. "'";
            if($value['ingreso']=="1"){
                $active= "active";
                $check="checked";
                $color= "bg-success";
            }else{
                $active="";
                $check="";
                $color = "";
            }
           echo '<button type="button" onclick="checkPermisos('. $valueid. ')" class="border border-' . $color . ' list-group-item list-group-item-action ' . $active. '">
                    <input class="form-check-input me-1 ' . $color . ' border border-success" type="checkbox" id="' . $value['id'] . 'permiso" value="' . $value['ingreso'] . '" aria-label="..." '. $check.'>
                    '. $value['nombre'].'
                </button>';
        }
    }
    /*=============================================
    UPDATE ALMACEN PERMISOS
    =============================================*/
    public $update;
    public function ajaxUpdateAlmacenPermisos()
    {

        $data = $this->update;
        $update = array(
            "table" => "almacen", #nombre de tabla
            "ingreso" => $data["value"], #nombre de columna y valor
            #"columna"=>"valor",#nombre de columna y valor
        );
        $where = array(
            "id" => $data["id"], #condifion columna y valor
        ); 
        $respuesta = ControllerQueryes::UPDATE($update,$where);
        if($respuesta=="ok"){
            $alertify = array(
                "color" => "success",
                "sms" => "Permiso actualizado.",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }else{
            $alertify = array(
                "color" => "error",
                "sms" => "No se actualizo el premiso Almacen",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
       
    }


}

/*=============================================
    OBJETO SELECT ALMACEN
    =============================================*/
if (isset($_POST['selectAlmacen'])) {
    $select = new ajaxSelectAlamacen();
    $select->select = $_POST['selectAlmacen'];
    $select->ajaxSelect();
}

/*=============================================
    OBJETO SELECT ALMACEN PERMISOS
    =============================================*/
if (isset($_POST['selectAlmacenPermisos'])) {
    $permiso = new ajaxSelectAlamacen();
    $permiso->permiso = $_POST['selectAlmacenPermisos'];
    $permiso->ajaxSelectAlmacenPermisos();
}

/*=============================================
    OBJETO UPDATE ALMACEN PERMISOS
    =============================================*/
if (isset($_POST['updateIDPermisos'])) {
    $update = new ajaxSelectAlamacen();
    $update->update = array(
        "id"=> $_POST['updateIDPermisos'],
        "value"=> $_POST['updateVauePermisos'],
    );
    $update->ajaxUpdateAlmacenPermisos();
}

