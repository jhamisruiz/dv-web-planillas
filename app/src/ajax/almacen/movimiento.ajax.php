<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../controllers/almacen/movimientos.C.php');
class ajaxMovimientos{

    public $movimiento;
    public $detalle;
    public function ajaxDetalleMovimiento(){
        $movimiento = $this->movimiento;
        $detalle = $this->detalle;
        $insert=array(
            "table" => "movimientos",
            "id_almacen_salida"=>$movimiento[0],
            "id_almacen_entrada"=>$movimiento[2],
            "id_accion"=>$movimiento[1],
            "motivo"=>$movimiento[3],
            "LASTID" => "TRUE"
        );

        $mover=ControllerQueryes::INSERT($insert);
        if ($mover>0) {
            foreach ($detalle as $value) {
                $insert="";
                $insert = array(
                    "table" => "detalle_movimiento",
                    "id_movimiento" => $mover,
                    "id_producto" => $value['id'],
                    "cantidad" => $value['cant_env']
                );
                $detalle = ControllerQueryes::INSERT($insert);
            }
            $swift = array(
                "icon" => "success",
                "sms" => "Movimiento realizado",
                "rForm" => "addFormMovimiento",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        }else{
            $alertify = array(
                "color" => "error",
                "sms" => "Movimiento no realizado",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }
    public $allmove;
    public function ajaxSelectAllMovimiento(){

        $data=$this->allmove;
        $res=ControllerMovimientos::SELECMOVIMIENTOS();
        foreach ($res as $key => $value) {
            echo '<tr>
            <td>'.($key+1).'</td>
            <td>'. $value['usuario']. '</td>
            <td>' . $value['fecha'] . '</td>
            <td>' . $value['almSalida'] . '</td>
            <td>' . $value['almEntrada'] . '</td>';
            if ($value["estado"] == 0) {
                echo '<td class="text-center"><button class="btn btn-danger btn-sm" >ACEPTAR</button></td>';
            }else{
                echo '<td class="text-center"><button class="btn btn-seccess btn-sm" >INGRESADO</button></td>';
            }
            echo '<td>' . $value['accion'] . '</td>
                <td class="text-center">
                <button class="btn btn-primary btn-sm" >VER DETALLE</button></td>
                <td>' . $value['motivo'] . '</td>
            </tr>';
        }

    }

}

if (isset($_POST['datosMovimiento'])) {
    $movimiento = new ajaxMovimientos();
    $movimiento->movimiento = $_POST['datosMovimiento'];
    $movimiento->detalle = $_POST['detalleMovimiento'];
    $movimiento->ajaxDetalleMovimiento();
}
// if (isset($_POST['detalleMovimientos'])) {
//     $detalle = new ajaxMovimientos();
//     $detalle->detalle = $_POST['detalleMovimientos'];
//     $detalle->ajaxdetalleMovimientos();
// }

if (isset($_POST['selectAllmovimientos'])) {
    $allmove = new ajaxMovimientos();
    $allmove->allmove = $_POST['selectAllmovimientos'];
    $allmove->ajaxSelectAllMovimiento();
}