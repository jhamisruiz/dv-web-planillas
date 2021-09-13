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
    public $searchm;
    public function ajaxSelectAllMovimiento(){

        $data=$this->allmove;
        $search = $this->searchm;

        $idm='';
        $res=ControllerMovimientos::SELECMOVIMIENTOS($idm, $search);
        foreach ($res as $key => $value) {
            echo '<tr>
            <td>'.($key+1).'</td>
            <td>'. $value['usuario']. '</td>
            <td>' . $value['fecha'] . '</td>
            <td>' . $value['almSalida'] . '</td>
            <td>' . $value['almEntrada'] . '</td>';
            if ($value["estado"] == 0) {
                echo '<td class="text-center"><button id="cancelar' . $value['id'] . '" class="btn btn-danger btn-sm btnAceptarMovimiento" idMovimiento="' . $value['id'] . '" estado="2">CANCELAR</button>';
                echo '<button id="aceptar' . $value['id'] . '" class="btn btn-secondary btn-sm btnAceptarMovimiento" idMovimiento="' . $value['id'] . '" estado="1">ACEPTAR</button></td>';
            }elseif($value["estado"] == 2){
                echo '<td class="text-center"><button class="btn btn-warning btn-sm" >CANCELADO</button></td>';
            }else{
                echo '<td class="text-center"><button class="btn btn-success btn-sm" >INGRESADO</button></td>';
            }
            echo '<td>' . $value['accion'] . '</td>
                <td class="text-center">
                <button class="btn btn-primary btn-sm" onclick="detalleMovimiento('. $value['id'].')">VER DETALLE</button></td>
                <td>' . $value['motivo'] . '</td>
            </tr>';
        }

    }

    public $aceptMovimiento;
    public function ajaxAceptarMovimiento(){
        $data = $this->aceptMovimiento;
        
        /* validar si hay productos */
        $select=array(
            "P.id" => "",
            "P.nombre" => "",
            "P.cantidad" => "AA",
            "DM.cantidad" => "BB",
        );
        $tables=array(
            "detalle_movimiento DM"=> "productos P",
            "DM.id_producto" => "P.id"
        );
        $where=array(
            'DM.id_movimiento' => '='.$data['id']
        );
        $valid = ControllerQueryes::SELECT($select, $tables, $where);

        $sin ='';
        for ($i=0; $i < count($valid); $i++) {
            $res= ($valid[$i]['AA'] - $valid[$i]['BB']);
            if($res>0){
                //echo 'hay'.$res;
            }else{
                echo 'Producto '. $valid[$i]['nombre'] .' sin stock <br>';
                $sin = 0;
            }
        }
        if($sin ==''){
            if($data['estado'] == 1){
                for ($i = 0; $i < count($valid); $i++) {
                    $res = '';
                    $res = ($valid[$i]['AA'] - $valid[$i]['BB']);
                    $update = array(
                        'table' => 'productos',
                        'cantidad' => $res,
                    );

                    $where = array(
                        'id' => $valid[$i]['id']
                    );
                    //echo $res.'-';
                    $updata = ControllerQueryes::UPDATE($update, $where);
                }
            }
            
            $update = array(
                'table' => 'movimientos',
                'estado' => $data['estado']
            );

            $where = array(
                'id' => $data['id']
            );
            $update = ControllerQueryes::UPDATE($update, $where);

            if ($update == "ok") {
                echo $update;
            } else {
                echo 'error';
            }
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
    $allmove->searchm = $_POST['search'];
    $allmove->ajaxSelectAllMovimiento();
}

/*=============================================
    OBJETO ACEPTAR MOVIMIENTOS
    =============================================*/
if (isset($_POST['idMovimiento'])) {
    $aceptar = new ajaxMovimientos();
    $aceptar->aceptMovimiento = array(
        'estado'=> $_POST['estado'],
        'id'=> $_POST['idMovimiento']
    );
    $aceptar->ajaxAceptarMovimiento();
}