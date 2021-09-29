<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxEmpleadoPagos
{  
/*=============================================
	CREAR/EDITAR
=============================================*/
    public $pagar;
    public function ajaxCreatePagos(){
        date_default_timezone_set('America/Lima');
        //la fecha de exportación sera parte del nombre del archivo Excel
        $fecha = date("d-M-Y");
        $mes = date("Y-m-d");

        $data = $this->pagar;
        echo $fecha;
        if ($data['editar'] == "NO") {
            $insert = array(
                "table" => "historial_pago",
                "dni" => $data['dni'],
                "salario" => $data['salary'],
                "total_horas" => $data['total_horas'],
                "precio_hora" => $data['precio_hora'],
                "monto_pagado" => $data['total_salary'],
                "abono" => $data['remunera'],
                "cometario" => $data['coment'],
                "mes" => $fecha,
                "fecha" => $mes,
                "desde" => $data['dia1'],
                "hasta" => $data['dia2'],
                "dominic" => $data['dominic'],
            );
            $respuesta = ControllerQueryes::INSERT($insert);
            //echo $respuesta;
            $sms = "Realizado";
        }

        if ($respuesta == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Pago" . $sms,
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {

            $alertify = array(
                "color" => "error",
                "sms" => "Pago no " . $sms,
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
/*=============================================
	CALCULAR PAGO MENSUAL
=============================================*/
    public $calcula;
    public function ajaxCalculaPago(){
        $data = $this->calcula;
        //faltas
        $selt = array("*" => "*");
        $tabt = array("trabajador" => "",);
        $whert = array("dni" => '=' . $data['dni'],);
        $trabjr = ControllerQueryes::SELECT($selt, $tabt, $whert);

        $select = array("*" => "*");
        $tables = array("detalle_asistencia" => "",);
        $where = array(
            "dni" => '=' . $data['dni'],
            "asistencia" => "='PRESENTE'  AND fecha_asistencia BETWEEN '". $data['dia1']. "' AND '" . $data['dia2'] . "'",
        );
        $presente = ControllerQueryes::SELECT($select, $tables, $where);

        if($trabjr[0]['sal_hora']=='MES'){
            $selectf = array("*" => "*");
            $tablesf = array("detalle_asistencia" => "", );
            $wheref = array(
                "dni" => '=' . $data['dni'],
                "asistencia" => "='FALTA'  AND fecha_asistencia BETWEEN '" . $data['dia1'] . "' AND '" . $data['dia2'] . "'",
            );
            $falta = ControllerQueryes::SELECT($selectf, $tablesf, $wheref);
            $salmes= $trabjr[0]['salario']/30;
            if(count($falta)>0){
                $descon= $salmes* count($falta);
                $total= $trabjr[0]['salario']- $descon;
                echo number_format($total, 2);
            }else{
                echo $trabjr[0]['salario'];
            }
        }else{
            $h = 0;
            foreach ($presente as $key => $value) {
                $parts = explode(":", $value['total_horas']);
                $h = $h + ($parts[0] * 3600) + ($parts[1] * 60) + ($parts[2]);
            }
            $horas = floor($h / 3600);
            $min = floor(($h - ($horas * 3600)) / 60);
            $seg = $h - ($horas * 3600) - ($min * 60);
            $hor = '';
            $cerm = '';
            if (strlen($hor) == 1) {
                $hcerr = 0;
            }
            if (strlen($min) == 1) {
                $cerm = 0;
            }
            $tot_h = $horas . '.' . $cerm . $min;
            $total_h = round($tot_h);

            $select = array("*" => "*");
            $tables = array("trabajador" => "",);
            $where = array("dni" => '=' . $data['dni'],);
            $emsalary = ControllerQueryes::SELECT($select, $tables, $where);

            $salxh = $emsalary[0]['sal_hora'];
            //calculando salario con faltas

            $total = $salxh * $total_h;
            echo $total;
    }
    }
/*=============================================
	SELECT FALTAS
=============================================*/
    public $faltas;
    public function ajaxSelectFaltas()
    {
        $data = $this->faltas;
        $select = array(
            "*" => "*"
        );
        $tables = array(
            "detalle_asistencia" => "", #0-0
        );
        $where = array(
            "dni" => '=' . $data['dni'],
            "asistencia" => "='FALTA'  AND fecha_asistencia BETWEEN '". $data['dia1']. "' AND '" . $data['dia2'] . "'",
        );
        $asist = ControllerQueryes::SELECT($select, $tables, $where);
        //echo count($asist);
        if (count($asist)==0) {
            echo '<p class="ml-5"> El Empleado no tiene faltas</p>';
        } else {
            echo '<tr>
                <th class="bg-danger text-white m-0 p-0">#</th>
                <th class="bg-danger text-white m-0 p-0">Asistencia</th>
                <th class="bg-danger text-white m-0 p-0">DNI</th>
                <th class="bg-danger text-white m-0 p-0">Fecha Asist.</th>
            </tr>';
            foreach ($asist as $key => $value) {

                echo '<tr class="m-0 p-0">
                <td class="m-0 p-0">' . ($key + 1) . '</td>
                <td class="text-danger">' . $value['asistencia'] . '</td>
                <td class="m-0 p-0">' . $value['dni'] . '</td>
                <td class="m-0 p-0">' . $value['fecha_asistencia'] . '</td>
            </tr>
            ';
            }
        }
        
    }
/*=============================================
	SELECT ASISTENCIAS PRESENTE
=============================================*/
    public $asistencia;
    public function ajaxSelectAsistencias()
    {
        $data = $this->asistencia;
        $selt = array("*" => "*");
        $tabt = array("trabajador" => "",);
        $whert = array("dni" => '=' . $data['dni'],);
        $trabjr = ControllerQueryes::SELECT($selt, $tabt, $whert);

        $select = array( "*" => "*");
        $tables = array( "detalle_asistencia" => "", );
        $where = array(
            "dni" => '=' . $data['dni'],
            "asistencia" => "='PRESENTE'  AND fecha_asistencia BETWEEN '". $data['dia1']. "' AND '" . $data['dia2'] . "'",
        );
        $asista = ControllerQueryes::SELECT($select, $tables, $where);
        //
        if(count($asista)==0){
            echo '<p class="ml-5"> No hay asistencia para este Empleado</p>';
        }else{
            echo '<tr>
                <th class="bg-success text-white m-0 p-0">#</th>
                <th class="bg-success border-bottom text-white m-0 p-0">Asistencia</th>
                <th class="bg-success text-white m-0 p-0">DNI</th>
                <th class="bg-success text-white m-0 p-0">Fecha Asist.</th>
                <th class="bg-success text-center text-white m-0 p-0">H. Entrada</th>
                <th class="bg-success text-center text-white m-0 p-0">H. Salida</th>
                <th class="bg-success text-white m-0 p-0">Total Horas</th>
            </tr>';
            $h="";
            foreach ($asista as $key => $value) {

                echo '<tr class="m-0 p-0">
                <td class="m-0 p-0">' . ($key + 1) . '</td>
                <td class="text-success m-0 p-0 ">' . $value['asistencia'] . '</td>
                <td class="m-0 p-0">' . $value['dni'] . '</td>
                <td class="m-0 p-0">' . $value['fecha_asistencia'] . '</td>
                <td class="m-0 p-0 text-center"><strong class="text-success">' . $value['entrada'] . '</strong>: ' . $value['hora_entrada'] . '</td>
                <td class="m-0 p-0 text-center"><strong class="text-warning">' . $value['salida'] . '</strong>: ' . $value['hora_salida'] . '</td>
                <td class="m-0 p-0">' . $value['total_horas'] . '</td>
            </tr>
            ';
                $parts = explode(":", $value['total_horas']);
                $h = $h+ ($parts[0] * 3600)+($parts[1]*60)+($parts[2]);
            }
            $horas = floor($h / 3600);
            $min = floor(($h - ($horas * 3600)) / 60);
            $seg = $h - ($horas * 3600) - ($min * 60);
            $hor = '';$cerm = '';$cers = '';
            $echo='';
            if(strlen($hor)==1){$hcerr=0;}
            if (strlen($min) ==1) {
                $cerm = 0;
            }
            if (strlen($seg) ==1) {
                $cers = 0;
            }
            if($trabjr[0]['sal_hora'] == 'MES'){
                $echo= $trabjr[0]['sal_hora'];
            }else{
                $echo= $hcerr . $horas . ':' . $cerm . $min . ":" .  $cers . $seg;
            }
            echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Horas</td>
                <td><p id="idtotalhoras">' . $echo . '</p></td>
                
            </tr>';
        }
    }
/*=============================================
	SELECT hostorial pago
=============================================*/
    public $historia;
    public function ajaxSelectHistorial()
    {
        $data = $this->historia;
        $select = array(
            "T.nombre" => "",
            "T.apellidos" => "",
            "H.id" => "",
            "H.dni" => "",
            "H.salario" => "",
            "H.total_horas" => "",
            "H.precio_hora" => "",
            "H.monto_pagado" => "",
            "H.abono" => "",
            "H.cometario" => "",
            "H.mes" => "",
            "H.desde" => "",
            "H.hasta" => "",
            "H.dominic" => "",
        );
        $tables = array(
            "historial_pago H" => "trabajador T", #0-0
            "H.dni" => "T.dni", #0-0
            );
        $where='';
        if(strlen($data['dni'])==8){
            $where = array(
                "H.dni" => '=' . $data['dni']. " ORDER BY H.id DESC",
            );
        }else{
            $where = array(
                "H.fecha" => " BETWEEN '". $data['dia1']. "' AND '" . $data['dia2'] . "' ORDER BY H.id DESC",
            ); 
        }
        
        $historys = ControllerQueryes::SELECT($select, $tables, $where);
        //print_r($historys) ;//
        if (count($historys) == 0) {
            echo '<p class="ml-5"> Sin registo de Pagos</p>';
        } else {
            echo '<tr id="idnonehis">
                <th class="bg-primary text-white m-0 p-0">#</th>
                <th class="bg-primary text-white m-0 p-0">DNI</th>
                <th class="bg-primary text-white m-0 p-0">Fecha Pago</th>
                <th class="bg-primary text-white m-0 p-0">Desde</th>
                <th class="bg-primary text-white m-0 p-0">Hasta</th>
                <th class="bg-primary text-white m-0 p-0">Salario.</th>
                <th class="bg-primary text-white m-0 p-0">H. trabajadas</th>
                <th class="bg-primary text-white m-0 p-0">Costo hora.</th>
                <th class="bg-primary text-white m-0 p-0">M. pagado</th>
                <th class="bg-primary text-white m-0 p-0">Dominical</th>
                <th class="bg-primary text-white m-0 p-0">Bono</th>
                <th class="bg-primary text-white m-0 p-0">Comentario</th>
                <th class="bg-primary text-white m-0 p-0">Accion</th>
            </tr>';
            foreach ($historys as $key => $value) {

                echo '<tr class="m-0 p-0">
                <td class="m-0 p-0">' . ($key + 1) . '</td>';
                if(strlen($data['dni']) == 8){
                    
                }else{
                    echo '<td class="m-0 p-0">' . $value['nombre'] . '</td>
                    <td class="m-0 p-0">' . $value['apellidos'] . '</td>';
                }
                echo'<td class="m-0 p-0">' . $value['dni'] . '</td>
                <td class="m-0 p-0">' . $value['mes'] . '</td>
                <td class="m-0 p-0">' . $value['desde'] . '</td>
                <td class="m-0 p-0">' . $value['hasta'] . '</td>
                <td class="m-0 p-0">' . $value['salario'] . '</td>
                <td class="m-0 p-0">' . $value['total_horas'] . '</td>
                <td class="m-0 p-0">' . $value['precio_hora'] . '</td>
                <td class="m-0 p-0">' . $value['monto_pagado'] . '</td>
                <td class="m-0 p-0">' . $value['dominic'] . '</td>
                <td class="m-0 p-0">' . $value['abono'] . '</td>
                <td class="m-0 p-0">' . $value['cometario'] . '</td>';
                if(strlen($data['dni']) == 8){
                    echo '<td>
                        <button onclick="pdfreportesCont(' . $value['id'] . ',' . "'" . URL_HOST_WEB ."'". ')" host="'.URL_HOST_WEB .'" mes="" class="btn btn-sm bg-warning text-white">
                            <i class="far fa-file-pdf" style="font-size:18px"></i>
                        </button>
                        <button onclick="eliminarPago(' . $value['id'] . ')" class="btn btn-sm bg-danger text-white">
                            <i class="bi bi-trash m-r-5"></i>
                        </button>
                    </td>';
                }
            echo '</tr>
            ';
            }
        }
    }
/*=============================================
    ELIMINAR
=============================================*/
    public $idEliminar;
    public function ajaxeEliminar()
    {

        $id = $this->idEliminar;
        $delate = array(
            "table" => "historial_pago",
            "id" => $id,
        );

        $eliminar = ControllerQueryes::DELATE($delate);
        //echo $eliminar;
        if ($eliminar == "ok"
        ) {
            $swift = array(
                "icon" => "success",
                "sms" => "Pago Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                    "color" => "error",
                    "sms" => "No se elimino el Pago",
                );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
}
/*=============================================
	CREAR/EDITAR
=============================================*/
if (isset($_POST['createpagos'])) {
    $pagos = new ajaxEmpleadoPagos();
    $pagos->pagar = $_POST['createpagos'];
    $pagos->ajaxCreatePagos();
}
/*=============================================
	CALCULAR PAGO MENSUAL
=============================================*/
if (isset($_POST['dniEmpleado'])) {
    $pago = new ajaxEmpleadoPagos();
    $pago->calcula = array(
        "dia1" => $_POST['fecha1'],
        "dia2" => $_POST['fecha2'],
        "dni" => $_POST['dniEmpleado'],
    );
    $pago->ajaxCalculaPago();
}
/*=============================================
SELECT FALTAS
=============================================*/
if (isset($_POST['dniEmployes'])) {
    $asit = new ajaxEmpleadoPagos();
    $asit->faltas = array(
        "dia1"=>$_POST['fecha1'],
        "dia2" => $_POST['fecha2'],
        "dni" => $_POST['dniEmployes'],
    );
    $asit->ajaxSelectFaltas();
}
/*=============================================
SELECT ASISTENCIAS
=============================================*/
if (isset($_POST['dniasistencia'])) {
    $asitir = new ajaxEmpleadoPagos();
    $asitir->asistencia = array(
        "dia1" => $_POST['fecha1'],
        "dia2" => $_POST['fecha2'],
        "dni" => $_POST['dniasistencia'],
    );
    $asitir->ajaxSelectAsistencias();
}
/*=============================================
	SELECT hostorial pago
=============================================*/
if (isset($_POST['historial'])) {
    $history = new ajaxEmpleadoPagos();
    $history->historia = $_POST['historial'];
    $history->ajaxSelectHistorial();
}
/*=============================================
	SELECT hostorial pago
=============================================*/
if (isset($_POST['idEliminar'])) {
    $del = new ajaxEmpleadoPagos();
    $del->idEliminar = $_POST['idEliminar'];
    $del->ajaxeEliminar();
}