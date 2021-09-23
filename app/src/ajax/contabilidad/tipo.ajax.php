<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxDepa_Tipo_conta
{
    /*=============================================
	SELECT TIPO INGRESOS
    =============================================*/
    public $select;
    public $search;
    public function ajaxSelecTipoIng()
    {
        $tabla = $this->select;
        $nombre = $this->search;
        $select = array(
            "*" => "*"
        );
        $tables = array(
            $tabla  => "",
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );
        if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
            $where = array(
                'tipo'=>"='I'"
            );
        } else {
            $where = array(
                "nombre" => " LIKE CONCAT('%" . $nombre . "%') AND tipo = 'I'",
            );
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $respuesta;
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["descripcion"] . '</td>
                <td>' . $value["fecha"] . '</td>';
            echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarTipoIng(' . $value["id"] . ",'" .  $value["nombre"] . "'," . "'" .  $value["descripcion"] . "'" . ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarTipoIng(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
    /*=============================================
	CREAR/editar TIPO INGRESOS
    =============================================*/
    public $tingreso;
    public function ajaxCrearTipoIngeso()
    {

        $datas = $this->tingreso;
        $data=$datas[0];
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "tipo_contabilidad",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "tipo" => 'I',
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "tipo_contabilidad",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "tipo" => 'I',
            );
            $where = array(
                "id" => $data['id']
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificado";
        }

        if ($respuesta == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Tipo Ingreso " . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Tipo Ingreso no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR
    =============================================*/
    public $idEliminarI;
    public function ajaxeEliminarTipoIngeso()
    {

        $data = $this->idEliminarI;
        $delate = array(
            "table" => "tipo_contabilidad",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "DTipo ingreso Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Tipo ingreso",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
	CREAR/editar EGRESO
    =============================================*/
    public $selectg;
    public $searchg;
    public function ajaxSelecTipoGas()
    {
        $tabla = $this->selectg;
        $nombre = $this->searchg;
        $select = array(
            "*" => "*"
        );
        $tables = array(
            $tabla  => "",
            #"images F"=>"", #8-0
            #"F.idProducto" => "P.id",   # 9-1
        );
        if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
            $where = array(
                'tipo' => "='G'"
            );
        } else {
            $where = array(
                "nombre" => " LIKE CONCAT('%" . $nombre . "%') AND tipo = 'G'",
            );
        }
        
        $tipogas = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $tipogas;
        //print_r($tipogas);
        foreach ($tipogas as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["descripcion"] . '</td>
                <td>' . $value["fecha"] . '</td>';
            echo '<td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarTipoGas(' . $value["id"] . ",'" .  $value["nombre"] . "'," . "'" .  $value["descripcion"] . "'" . ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarTipoGas(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
    /*=============================================
	CREAR/editar TIPO INGRESOS
    =============================================*/
    public $tgasto;
    public function ajaxCrearTipoGas()
    {

        $datas = $this->tgasto;
        $data = $datas[0];
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "tipo_contabilidad",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "tipo" => 'G',
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "tipo_contabilidad",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion'],
                "tipo" => 'G',
            );
            $where = array(
                "id" => $data['id']
            );
            $respuesta = ControllerQueryes::UPDATE($update, $where);
            $sms = "Modificado";
        }

        if ($respuesta == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Tipo Gasto " . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Tipo Gasto no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    /*=============================================
    ELIMINAR
    =============================================*/
    public $idEliminarG;
    public function ajaxeEliminarTipoGas()
    {

        $data = $this->idEliminarG;
        $delate = array(
                "table" => "tipo_contabilidad",
                "id" => $data,
            );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Tipo gasto Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Tipo gasto",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
}
/* SELCT TIPO INGRESO */
if (isset($_POST['selecttipoingreso'])) {
    $select = new ajaxDepa_Tipo_conta();
    $select->select = $_POST['selecttipoingreso'];
    $select->search = $_POST['search'];
    $select->ajaxSelecTipoIng();
}
/*=============================================
OBJETO CREAR/EDITAR INGRESOS
=============================================*/
if (isset($_POST['Addtipoingreso'])) {
    $ting = new ajaxDepa_Tipo_conta();
    $ting->tingreso = $_POST['Addtipoingreso'];
    $ting->ajaxCrearTipoIngeso();
}
/*=============================================
OBJETO ELIMINAR  INGRESOS
=============================================*/
if (isset($_POST["idEliminarI"])) {
    $elimin = new ajaxDepa_Tipo_conta();
    $elimin->idEliminarI = $_POST["idEliminarI"];
    $elimin->ajaxeEliminarTipoIngeso();
}

/* =========egresos========= */

/* SELCT TIPO GASTOS*/
if (isset($_POST['selecttipogas'])) {
    $select = new ajaxDepa_Tipo_conta();
    $select->selectg = $_POST['selecttipogas'];
    $select->searchg = $_POST['search'];
    $select->ajaxSelecTipoGas();
}
/*=============================================
OBJETO CREAR/EDITAR GASTOS
=============================================*/
if (isset($_POST['Addtipogastos'])) {
    $ting = new ajaxDepa_Tipo_conta();
    $ting->tgasto = $_POST['Addtipogastos'];
    $ting->ajaxCrearTipoGas();
}
/*=============================================
OBJETO ELIMINAR  IGASTOS
=============================================*/
if (isset($_POST["idEliminarG"])) {
    $elimin = new ajaxDepa_Tipo_conta();
    $elimin->idEliminarG = $_POST["idEliminarG"];
    $elimin->ajaxeEliminarTipoGas();
}