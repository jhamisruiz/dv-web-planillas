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
            "A.fecha_cierre" => "fecha",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
        );

        $tables = array(
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
                if ($value["estado"] == 'ENDED') {
                    echo '<td class="text-center"><span class="badge bg-secondary">FINALIZADO</span></td>';
                }else{
                    echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="0">Activado</button></td>';
                }
            }
            if ($value["estado"] == 0) {
                if ($value["estado"] == 'ENDED') {
                    echo '<td class="text-center"><span class="badge bg-secondary">FINALIZADO</span></td>';
                } else {
                    echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarAlmacen" idalmacen="' . $value["id"] . '" estadoalmacen="1">Desactivado</button></td>';
                }                
            }
            
            echo '<td class="text-center ">
                <div class="d-flex flex-column">
                <p class="p-0 m-0 text-success">' . $value["tipo"] . '</p>
                <p class="p-0 m-0 text-primary">' . $value["fecha"] . '</p>
                </div>
                </td>';
            
            if ($value["estado"] == 'ENDED') {
                echo '<td></td>';
            } else {
                echo '<td class="text-right" >
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right border border-secondary">
                                <a class="dropdown-item" onclick="editarAlmacen(' . $value["id"] . ')"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                                <a class="dropdown-item"onclick="eliminarAlmacen(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>';
            }     
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
    /*=============================================
     SELECT DATA PARA EDITAR ALMACEN
    =============================================*/
    public $idEditarAlm;
    public function ajaxeEditarAlmacen()
    {

        $data = $this->idEditarAlm;
        $select = array(
            "A.id" => "",
            "A.nombre" => "",
            "A.direccion" => "",
            "A.referencia" => "",
            "A.estado" => "",
            "A.idSucursal" => "sucursal",
            "A.descripcion" => "descrip",
            "A.tipo" => "",
            "A.fecha_cierre" => "fecha",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
            "U.id_ubigeo" => "ubigeo",
        );

        $tables = array(
            "almacen A" => "ubigeo U", #0-0
            "A.idUbigeo" => "U.id_ubigeo", #1-1
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );

        $where = array(
            "A.id"=> "=".$data
        );
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        echo json_encode($respuesta[0]);
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
OBJETO SELECT PARA EDITAR ALMACEN
=============================================*/
if (isset($_POST["idSelectEditar"])) {
    $selecteditar = new ajaxSelectAlamacen();
    $selecteditar->idEditarAlm = $_POST["idSelectEditar"];
    $selecteditar->ajaxeEditarAlmacen();
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

