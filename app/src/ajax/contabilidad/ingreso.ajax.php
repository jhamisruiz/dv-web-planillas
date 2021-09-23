<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxIngresos
{
/*=============================================
	SELECT TIPO INGRESOS
=============================================*/
    public $select;
    public $search;
    public function ajaxSelecIng()
    {
        $dnone = $this->select;
        $nombre = $this->search;
        $select = array(
            "C.id" => "",
            "C.tipo" => "",
            "C.id_tipo" => "id_tipo",
            "C.cantidad" => "",
            "C.fecha" => "",
            "C.descripcion" => "",
            "T.nombre" => "",
        );
        $tables = array(
            "contabilidad C" => "tipo_contabilidad T", #0-0
            "C.id_tipo" => "T.id", #0-0
        );
        if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
            $where = array(
                'C.tipo'=>"='INGRESO'"
            );
        } else {
            $where = array(
                "C.fecha" => " LIKE CONCAT('%" . $nombre . "%') AND C.tipo = 'INGRESO'",
            );
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $respuesta;
        $total="0.00";
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["tipo"] . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["cantidad"] . '</td>
                <td>' . $value["fecha"] . '</td>
                <td>' . $value["descripcion"] . '</td>';
            echo '<td class="text-right '.$dnone.'">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarIngres(' . $value["id"] . ",".  $value["id_tipo"] . ",'" .  $value["cantidad"] . "','" .  $value["fecha"] . "','" .  $value["descripcion"] . "'". ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarIng(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
            $total= $total+ $value["cantidad"];
        }
        echo '
        <tr>
        <td></td>
        <td></td>
        <td>total :</td>
        <td>'. number_format($total, 2) . '</td>
        <td></td>
        <td></td>
        <td></td>
        </tr>';
    }
/*=============================================
	CREAR/editar TIPO INGRESOS
=============================================*/
    public $tingreso;
    public function ajaxCrearIngeso()
    {

        $data = $this->tingreso;
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "contabilidad",
                "tipo" => 'INGRESO',
                "id_tipo" => $data['id_tipo'],
                "fecha" => $data['fecha'],
                "cantidad" => $data['cantidad'],
                "descripcion" => $data['descripcion'],
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "contabilidad",
                "tipo" => 'INGRESO',
                "id_tipo" => $data['id_tipo'],
                "fecha" => $data['fecha'],
                "cantidad" => $data['cantidad'],
                "descripcion" => $data['descripcion'],
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
                "sms" => "Ingreso " . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Ingreso no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
/*=============================================
    ELIMINAR
=============================================*/
    public $idEliminarI;
    public function ajaxeEliminarIngeso()
    {

        $data = $this->idEliminarI;
        $delate = array(
            "table" => "contabilidad",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Ingreso Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Ingreso",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
/*=============================================
	SELECT TIPO GASTOS
=============================================*/
    public $selectg;
    public $searchg;
    public function ajaxSelecGas()
    {
        $dnone = $this->selectg;
        $nombre = $this->searchg;
        $select = array(
                "C.id" => "",
                "C.tipo" => "",
                "C.id_tipo" => "id_tipo",
                "C.cantidad" => "",
                "C.fecha" => "",
                "C.descripcion" => "",
                "T.nombre" => "",
            );
        $tables = array(
                "contabilidad C" => "tipo_contabilidad T", #0-0
                "C.id_tipo" => "T.id", #0-0
            );
        if ($nombre == " " || $nombre == "  " || $nombre == "   " || $nombre == NULL) {
            $where = array(
                'C.tipo' => "='GASTO'"
            );
        } else {
            $where = array(
                "C.fecha" => " LIKE CONCAT('%" . $nombre . "%') AND C.tipo = 'GASTO'",
            );
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $respuesta;
        $total ='0.00';
        foreach ($respuesta as $key => $value) {
            echo '<tr>
                <td>' . $key = ($key + 1) . '</td>
                <td>' . $value["tipo"] . '</td>
                <td>' . $value["nombre"] . '</td>
                <td>' . $value["cantidad"] . '</td>
                <td>' . $value["fecha"] . '</td>
                <td>' . $value["descripcion"] . '</td>';
            echo '<td class="text-right ' . $dnone . '">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editarGasto(' . $value["id"] . "," .  $value["id_tipo"] . ",'" .  $value["cantidad"] . "','" .  $value["fecha"] . "','" .  $value["descripcion"] . "'" . ')">
                            <i class="bi bi-pen-fill text-success"></i> Edit</a>
                            <a class="dropdown-item" onclick="eliminarGasto(' . $value["id"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr>';
            $total = $total + $value["cantidad"];
        }
        echo '
        <tr>
        <td></td>
        <td></td>
        <td>total :</td>
        <td>' . number_format($total,2) . '</td>
        <td></td>
        <td></td>
        <td></td>
        </tr>';
    }
/*=============================================
	CREAR/editar TIPO gasto
=============================================*/
    public $tgasto;
    public function ajaxCrearGasto()
    {

        $data = $this->tgasto;
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "contabilidad",
                "tipo" => 'GASTO',
                "id_tipo" => $data['id_tipo'],
                "fecha" => $data['fecha'],
                "cantidad" => $data['cantidad'],
                "descripcion" => $data['descripcion'],
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            $sms = "Creado";
        } else {
            $update = array(
                "table" => "contabilidad",
                "tipo" => 'GASTO',
                "id_tipo" => $data['id_tipo'],
                "fecha" => $data['fecha'],
                "cantidad" => $data['cantidad'],
                "descripcion" => $data['descripcion'],
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
                "sms" => "Gasto " . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Gasto no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
/*=============================================
    ELIMINAR gasto
=============================================*/
    public $idEliminarG;
    public function ajaxeEliminarGasto()
    {

        $data = $this->idEliminarG;
        $delate = array(
            "table" => "contabilidad",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        //echo $data;
        if ($eliminar == "ok") {
            $swift = array(
                    "icon" => "success",
                    "sms" => "Gastos Eliminado",
                    "rForm" => "",
                );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Gastos",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
}
/* SELCT TIPO INGRESO */
if (isset($_POST['selectingreso'])) {
    $select = new ajaxIngresos();
    $select->select = $_POST['selectingreso'];
    $select->search = $_POST['search'];
    $select->ajaxSelecIng();
}
/*=============================================
OBJETO CREAR/EDITAR INGRESOS
=============================================*/
if (isset($_POST['Addingreso'])) {
    $ting = new ajaxIngresos();
    $ting->tingreso = $_POST['Addingreso'];
    $ting->ajaxCrearIngeso();
}
/*=============================================
OBJETO ELIMINAR  INGRESOS
=============================================*/
if (isset($_POST["idEliminarI"])) {
    $elimin = new ajaxIngresos();
    $elimin->idEliminarI = $_POST["idEliminarI"];
    $elimin->ajaxeEliminarIngeso();
}

/* SELCT TIPO GASTOS */
if (isset($_POST['selectgasto'])) {
    $select = new ajaxIngresos();
    $select->selectg = $_POST['selectgasto'];
    $select->searchg = $_POST['search'];
    $select->ajaxSelecGas();
}
/*=============================================
OBJETO CREAR/EDITAR GASTOS
=============================================*/
if (isset($_POST['Addgasto'])) {
    $ting = new ajaxIngresos();
    $ting->tgasto = $_POST['Addgasto'];
    $ting->ajaxCrearGasto();
}
/*=============================================
OBJETO ELIMINAR  GASTOS
=============================================*/
if (isset($_POST["idEliminarG"])) {
    $elimin = new ajaxIngresos();
    $elimin->idEliminarG = $_POST["idEliminarG"];
    $elimin->ajaxeEliminarGasto();
}