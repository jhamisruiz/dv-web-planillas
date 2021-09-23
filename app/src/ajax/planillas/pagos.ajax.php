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
        $data = $this->pagar;
        $select = array("*" => "*",);
        $tables = array("historial_pago" => "");
        $where = array(
            "dni" => '=' . $data['dni'],
            "mes" => " LIKE '" . $data['mes'] . "%'",
        );
        $pagos = ControllerQueryes::SELECT($select, $tables, $where);
        echo count($pagos);
        if ($data['editar'] == "NO") {
            if (count($pagos)==0) {
                $insert = array(
                    "table" => "historial_pago",
                    "dni" => $data['dni'],
                    "salario" => $data['salary'],
                    "total_horas" => $data['total_horas'],
                    "precio_hora" => $data['precio_hora'],
                    "monto_pagado" => $data['total_salary'],
                    "abono" => $data['remunera'],
                    "cometario" => $data['coment'],
                    "mes" => $data['mes'] . "-28",
                );
                $respuesta = ControllerQueryes::INSERT($insert);
                //echo $respuesta;
                $sms = "Realizado";
            }else{
                $swift = array(
                    "icon" => "warning",
                    "sms" => "Mes Pagado.",
                    "rForm" => "",
                );
                $succes = Functions::SwiftAlert($swift);
                echo $succes;
                return;
            }
        } else {
            $update = array(
                "table" => "departamento",
                "nombre" => $data['nombre'],
                "descripcion" => $data['descripcion']
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
        $select = array("*" => "*");
        $tables = array("detalle_asistencia" => "",);
        $where = array(
            "dni" => '=' . $data['dni'],
            "asistencia" => "='PRESENTE'  AND fecha_asistencia LIKE '" . $data['fecha'] . "%'",
        );
        $presente = ControllerQueryes::SELECT($select, $tables, $where);
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
        $tot_h= $horas.'.'.$cerm . $min;
        $total_h=round($tot_h);
        
        $select = array("*" => "*");
        $tables = array("trabajador" => "",);
        $where = array("dni" => '=' . $data['dni'],);
        $emsalary = ControllerQueryes::SELECT($select, $tables, $where);
        
        $salxh=$emsalary[0]['sal_hora'];
        //calculando salario con faltas

        $total= $salxh* $total_h;
        echo $total;
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
            "asistencia" => "='FALTA'  AND fecha_asistencia LIKE '". $data['fecha']."%'",
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
        $select = array(
            "*" => "*"
        );
        $tables = array(
            "detalle_asistencia" => "", #0-0
        );
        $where = array(
            "dni" => '=' . $data['dni'],
            "asistencia" => "='PRESENTE'  AND fecha_asistencia LIKE '" . $data['fecha'] . "%'",
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
            if(strlen($hor)==1){$hcerr=0;}
            if (strlen($min) ==1) {
                $cerm = 0;
            }
            if (strlen($seg) ==1) {
                $cers = 0;
            }
            echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Horas</td>
                <td><p id="idtotalhoras">' . $hcerr . $horas . ':' . $cerm . $min . ":" .  $cers . $seg . '</p></td>
                
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
            "H.dni" => "",
            "H.salario" => "",
            "H.total_horas" => "",
            "H.precio_hora" => "",
            "H.monto_pagado" => "",
            "H.abono" => "",
            "H.cometario" => "",
            "H.mes" => "",
        );
        $tables = array(
            "historial_pago H" => "trabajador T", #0-0
            "H.dni" => "T.dni", #0-0
            );
        $where='';
        if(strlen($data)==8){
            $where = array(
                "H.dni" => '=' . $data,
            );
        }else{
            $where = array(
                "H.mes" => " LIKE '" . $data . "%'",
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
                <th class="bg-primary text-white m-0 p-0">Fecha</th>
                <th class="bg-primary text-white m-0 p-0">Salario.</th>
                <th class="bg-primary text-white m-0 p-0">H. trabajadas</th>
                <th class="bg-primary text-white m-0 p-0">Costo hora.</th>
                <th class="bg-primary text-white m-0 p-0">M. pagado</th>
                <th class="bg-primary text-white m-0 p-0">Bono</th>
                <th class="bg-primary text-white m-0 p-0">Comentario</th>
            </tr>';
            foreach ($historys as $key => $value) {

                echo '<tr class="m-0 p-0">
                <td class="m-0 p-0">' . ($key + 1) . '</td>';
                if(strlen($data) == 8){
                    
                }else{
                    echo '<td class="m-0 p-0">' . $value['nombre'] . '</td>
                    <td class="m-0 p-0">' . $value['apellidos'] . '</td>';
                }
                echo'<td class="m-0 p-0">' . $value['dni'] . '</td>
                <td class="m-0 p-0">' . $value['mes'] . '</td>
                <td class="m-0 p-0">' . $value['salario'] . '</td>
                <td class="m-0 p-0">' . $value['total_horas'] . '</td>
                <td class="m-0 p-0">' . $value['precio_hora'] . '</td>
                <td class="m-0 p-0">' . $value['monto_pagado'] . '</td>
                <td class="m-0 p-0">' . $value['abono'] . '</td>
                <td class="m-0 p-0">' . $value['cometario'] . '</td>
            </tr>
            ';
            }
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
        "fecha" => $_POST['fechames'],
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
        "fecha"=>$_POST['fecha'],
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
        "fecha" => $_POST['fechaa'],
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