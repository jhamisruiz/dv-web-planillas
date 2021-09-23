<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxEmpleadoAsistencia
{
/*=============================================
	SELECT
=============================================*/
    public $asistir;
    public function ajaxSelectEmploye()
    {

        $dni = $this->asistir;
        $select = array(
            "id" => "",
            "nombre" => "",
            "apellidos" => "",
            "dni" => "",
            "fecha_ingreso" => "",
            "salario" => "",
            "sal_hora" => "",
        );
        $tables = array(
            "trabajador" => "", #0-0
        );
        $where = array(
            "dni" => '=' . $dni
        );
        $asist=ControllerQueryes::SELECT($select, $tables, $where);
        
        foreach ($asist as $value) {
            echo '<tr id="nombreenploy" class="d-none">
                <th class="m-0 p-0">DNI <input id="idsalaryt" type="hidden" value="' . $value['salario'] . '"></th>
                <th class="m-0 p-0">Nombre <input id="idsalhorat" type="hidden" value="' . $value['sal_hora'] . '"></th>
                <th class="m-0 p-0">Apellidos</th>
                <th class="m-0 p-0">Fecha Inicio</th>
            </tr>';
            echo '<tr class="bg-primary text-white" onclick="asistEmploye(' . $value["id"] . ')">
                <td class="bg-primary text-white">'. $value['dni'].'</td>
                <td class="bg-primary text-white">'. $value['nombre'].'</td>
                <td class="bg-primary text-white">'. $value['apellidos'].'</td>
                <td class="bg-primary text-white">'. $value['fecha_ingreso']. '</td>
            </tr>
            <input id="idemploy" type="hidden" value="' . $value['dni'] . '">
            ';
        }
    }
/*=============================================
	SELECT ASISTENCIA POR FECHA
=============================================*/
    public $porfecha;
    public function ajaxSelectAsistencia(){
        $data = $this->porfecha;
        $select = array(
            "*" => "*" #select*from
        );
        $tables = array(
            "detalle_asistencia" => "",
        );
        $where = array(
            "dni" => "=" . $data["dni"], #condifion columna y valor
            "fecha_asistencia" => "='" . $data['fecha'] . "'",
        );
        $select = ControllerQueryes::SELECT($select, $tables, $where);
        //print_r($data);
        echo json_encode($select[0]);
    }
/*=============================================
	REGISTRAR ASISTENCIAS
=============================================*/
    public $registrar;
    public function ajaxRegistrarAsistencias()
    {
        $data = $this->registrar;
        $select = array(
            "*" => "*" #select*from
        );
        $tables = array(
            "detalle_asistencia" => "",
        );
        $where = array(
            "dni" => "=" . $data["dni"], #condifion columna y valor
            "fecha_asistencia" => "='" . $data['fecha'] . "'",
        );
        $select = ControllerQueryes::SELECT($select, $tables, $where);
        //print_r($select);
        if($data['asist']== 'ENTRADA'){
            if (count($select) == 0) {
                $insert = array(
                    "table" => "detalle_asistencia",
                    "dni" => $data['dni'],
                    "fecha_asistencia" => $data['fecha'],
                    "entrada" => $data['asist'],
                    "hora_entrada" => $data['hora']
                );
                $respuesta = ControllerQueryes::INSERT($insert);
                //insertado salida
                $alertify = array(
                    "color" => "success",
                    "sms" => "Entrada registrada.",
                );
                $error = Functions::Alertify($alertify);
                echo $error;
            }else if($select[0]['entrada']==''|| $select[0]['entrada'] == NULL){
                $update = array(
                    "table" => "detalle_asistencia",
                    "asistencia" => 'PRESENTE',
                    "entrada" => $data['asist'],
                    "hora_entrada" => $data['hora']
                );
                $where = array(
                    "dni" => $data["dni"], #condifion columna y valor
                    "fecha_asistencia" => "'" . $data['fecha'] . "'",
                );
                $respuesta = ControllerQueryes::UPDATE($update, $where);
                if ($respuesta == "ok") {
                    $alertify = array(
                        "color" => "success",
                        "sms" => "Entrada registrada.",
                    );
                    $error = Functions::Alertify($alertify);
                    echo $error;
                } else {
                    $swift = array(
                        "icon" => "warning",
                        "sms" => "Entrada ya registarda.",
                        "rForm" => "",
                    );
                    $succes = Functions::SwiftAlert($swift);
                    echo $succes;
                }
            }else{
                $swift = array(
                    "icon" => "warning",
                    "sms" => "Entrada ya registrada.",
                    "rForm" => "",
                );
                $succes = Functions::SwiftAlert($swift);
                echo $succes;
            }
            
        }
        if ($data['asist'] == 'SALIDA') {
            if (count($select) ==1 && $select[0]['hora_entrada'] != '00:00:00'){
                $xpa= explode(':', $select[0]['hora_entrada']);
                $xpb = explode(':', $data['hora']);
                $t1 = mktime($xpa[0], $xpa[1], $xpa[2]);
                $t2 = mktime($xpb[0], $xpb[1], $xpb[2]);
                //Obtener la diferencia de ambos valores:
                $dif = $t2 - $t1;
                //Obtener las horas, minutos y segundos a partir de la diferencia:
                $horas = intval($dif / 3600);
                $min = intval(($dif - $horas * 3600) / 60);
                $seg = $dif - $horas * 3600 - $min * 60;
                $thime="$horas:$min:$seg";
                $update = array(
                    "table" => "detalle_asistencia",
                    "asistencia" => 'PRESENTE',
                    "salida" => $data['asist'],
                    "hora_salida" => $data['hora'],
                    "total_horas" => $thime,
                );
                $where = array(
                    "dni" => $data["dni"], #condifion columna y valor
                    "fecha_asistencia" => "'" . $data['fecha'] . "'",
                );
                $respuesta = ControllerQueryes::UPDATE($update, $where);
                if($respuesta=="ok"){
                    $alertify = array(
                        "color" => "success",
                        "sms" => "Salida registrada.",
                    );
                    $error = Functions::Alertify($alertify);
                    echo $error;
                }else{
                    $swift = array(
                        "icon" => "warning",
                        "sms" => "Salida ya registarda.",
                        "rForm" => "",
                    );
                    $succes = Functions::SwiftAlert($swift);
                    echo $succes;
                }
            }else{
                $swift = array(
                    "icon" => "warning",
                    "sms" => "No registro una entrada para esta fecha.",
                    "rForm" => "",
                );
                $succes = Functions::SwiftAlert($swift);
                echo $succes;
            }
        }
        if ($data['asist'] == 'FALTA') {
            if (count($select) == 0) {
                $insert = array(
                    "table" => "detalle_asistencia",
                    "asistencia" => $data['asist'],
                    "dni" => $data['dni'],
                    "fecha_asistencia" => $data['fecha'],
                );
                $respuesta = ControllerQueryes::INSERT($insert);
                //insertado salida
                $alertify = array(
                    "color" => "success",
                    "sms" => "Falta registrada.",
                );
                $error = Functions::Alertify($alertify);
                echo $error;
            }else if (count($select) == 1&& $select[0]['asistencia']!='FALTA'){
                $update = array(
                    "table" => "detalle_asistencia",
                    "asistencia" => $data['asist'],
                    "entrada" => NULL,
                    "hora_entrada" => NULL,
                    "salida" => NULL,
                    "total_horas" => NULL,
                    "hora_salida" => NULL
                );
                $where = array(
                    "dni" => $data["dni"], #condifion columna y valor
                    "fecha_asistencia" => "'" . $data['fecha'] . "'",
                );

                $respuesta = ControllerQueryes::UPDATE($update, $where);
                if ($respuesta == "ok") {
                    $alertify = array(
                        "color" => "success",
                        "sms" => "Falta registrada.",
                    );
                    $error = Functions::Alertify($alertify);
                    echo $error;
                } else {
                    $swift = array(
                        "icon" => "warning",
                        "sms" => "Falta ya registarda.",
                        "rForm" => "",
                    );
                    $succes = Functions::SwiftAlert($swift);
                    echo $succes;
                }
            }else{
                $swift = array(
                    "icon" => "warning",
                    "sms" => "Falta ya registarda.",
                    "rForm" => "",
                );
                $succes = Functions::SwiftAlert($swift);
                echo $succes;
            }
        }
        
    }
}

/*=============================================
SELECT
=============================================*/
    if (isset($_POST['idEmployes'])) {
        $asistencia = new ajaxEmpleadoAsistencia();
        $asistencia->asistir = $_POST['idEmployes'];
        $asistencia->ajaxSelectEmploye();
    }
/*=============================================
SELECT ASISTENCIA POR FECHA
=============================================*/
if (isset($_POST['selecporfecha'])) {
    $selct = new ajaxEmpleadoAsistencia();
    $selct->porfecha = array(
        "fecha"=> $_POST['selecporfecha'],
        "dni" => $_POST['dni'],
    );
    $selct->ajaxSelectAsistencia();
}

/*=============================================
OBJETO REGISTRAR ASISTENCIAS
=============================================*/
if (isset($_POST['addAsistencia'])) {
    $reg = new ajaxEmpleadoAsistencia();
    $reg->registrar = $_POST['addAsistencia'];
    $reg->ajaxRegistrarAsistencias();
}