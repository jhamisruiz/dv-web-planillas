<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../controllers/almacen/movimientos.C.php');
class ajaxMovimientos{
/* crear movimiento */
    public $movimiento;
    public $detalle;
    public function ajaxDetalleMovimiento(){
        $movimiento = $this->movimiento;
        $detalle = $this->detalle;
        $identra=NULL;
        if ($movimiento['id_accion']==3 && $movimiento['id_entra']==0) {
            $identra = NULL;
        } else {
            $identra = $movimiento['id_entra'];
        }
        

        $insert=array(
            "table" => "movimientos",
            "id_almacen_salida"=>$movimiento['id_sal'],
            "id_almacen_entrada"=> $identra,
            "id_accion"=>$movimiento['id_accion'],
            "motivo"=>$movimiento['descripcion'],
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
/* seleccionar todos los mivimientos */
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
                echo '<button id="aceptar' . $value['id'] . '" class="btn btn-secondary btn-sm btnAceptarMovimiento" accion="' . $value['accion'] . '" idMovimiento="' . $value['id'] . '" estado="1">ACEPTAR</button></td>';
            }elseif($value["estado"] == 2){
                echo '<td class="text-center"><button class="btn btn-warning btn-sm" >CANCELADO</button></td>';
            }elseif($value['id_accion']==3){
                echo '<td class="text-center"><button class="btn btn-success btn-sm" >SALIDA</button></td>';
            } else{
                echo '<td class="text-center"><button class="btn btn-success btn-sm" >INGRESADO</button></td>';
            }
            echo '<td>' . $value['accion'] . '</td>
                <td class="text-center">
                <button class="btn btn-primary btn-sm" onclick="detalleMovimiento('. $value['id'].')">VER DETALLE</button></td>
                <td>' . $value['motivo'] . '</td>';
            if ($value["estado"] == 0) {
                echo '<td class="text-center"><button class="btn btn-danger btn-sm " onclick="elimnarMovimiento(' . $value['id'] . ')" >Eliminar</button>';
            }else{
                echo '<td></td>';
            }
            echo '</tr>';
        }

    }
/* aceptar movimientos */
    public $aceptMovimiento;
    public function ajaxAceptarMovimiento(){
        $data = $this->aceptMovimiento;
        
        /* validar si hay productos */
        $select=array(
            "P.id" => "",
            "P.nombre" => "",
            "P.descripcion" => "",
            "P.idCategoria" => "",
            "P.idUmedida" => "",
            "P.fecha_ingreso" => "",
            "P.fecha_end" => "",
            "P.idAlmacen" => "",
            "P.cantidad" => "AA",
            "P.condicion" => "",
            "P.id_marca" => "",
            "DM.cantidad" => "BB",
            "F.imgUrl" => "",
            "M.id_almacen_entrada" => "id_almacen",
        );
        $tables=array(
            "detalle_movimiento DM"=> "productos P",
            "DM.id_producto" => "P.id",
            "images F" => "", #8-0
            "P.id" => "F.idProducto",
            "movimientos M" => "", #8-0
            "DM.id_movimiento" => "M.id",
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
        //print_r($valid);
        if($sin ==''){
            if($data['estado'] == 1){ // si el estadoo es 1 actualiza la cantidad de productos
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
                if($data['estado'] !='SALIDA'){
                    $insert = "";
                    $insert = array(
                        "table" => "infraestructura",
                        "estado" => "0",
                        "LASTID" => "TRUE",
                    );
                    $deposito = ControllerQueryes::INSERT($insert);
                    if ($deposito > 0) {
                        $lastIdDepo = $deposito;
                    }
                    for ($p=0; $p < count($valid); $p++) {
                        $insert = "";
                        $insert = array(
                            "table" => "productos",
                            "nombre" => $valid[$p]['nombre'],
                            "descripcion" => $valid[$p]['descripcion'],
                            "idCategoria" => $valid[$p]['idCategoria'],
                            "idUmedida" => $valid[$p]['idUmedida'],
                            "fecha_ingreso" => $valid[$p]['fecha_ingreso'],
                            "fecha_end" => $valid[$p]['fecha_end'],
                            "cantidad" => $valid[$p]['BB'],
                            "condicion" => $valid[$p]['condicion'],
                            "idAlmacen" => $valid[$p]['id_almacen'],
                            "idInfraestructura" => $lastIdDepo,
                            "id_marca" => $valid[$p]['id_marca'],
                            "LASTID" => "TRUE",
                        );
                        $product = ControllerQueryes::INSERT($insert);
                        $insert = "";
                        $insert = array(
                            "table" => "images",
                            "nombre" =>  "false",
                            "imgUrl" =>  $valid[$p]['imgUrl'],
                            "idProducto" => $product,
                        );
                        $image = ControllerQueryes::INSERT($insert);
                    }
                    
                }
            }
            
            $update = array(
                'table' => 'movimientos',
                'estado' => $data['estado']
            );

            $where = array(
                'id' => $data['id']
            );
            $updata = ControllerQueryes::UPDATE($update, $where);

            if ($updata == "ok") {
                echo $updata;
            } else {
                echo 'error';
            }
        }
    }
    /* elimnar movimientos */
    public $eliminar;
    public function ajaxeEliminarMovimiento()
    {

        $data = $this->eliminar;
        $delate = array(
            "table" => "movimientos",
            "id" => $data,
        );

        $eliminar = ControllerQueryes::DELATE($delate);

        if ($eliminar == "ok") {
            $swift = array(
                "icon" => "success",
                "sms" => "Requerimiento Eliminado",
                "rForm" => "",
            );
            $succes = Functions::SwiftAlert($swift);
            echo $succes;
        } else {
            $alertify = array(
                "color" => "error",
                "sms" => "No se elimino el Requerimiento",
            );
            $error = Functions::Alertify($alertify);
            echo $error;
        }
    }

}

if (isset($_POST['datosMovimiento'])) {
    $movimiento = new ajaxMovimientos();
    $movimiento->movimiento = $_POST['datosMovimiento'];
    $movimiento->detalle = $_POST['detalleMovimiento'];
    $movimiento->ajaxDetalleMovimiento();
}
if (isset($_POST['idEliminarM'])) {
    $delate = new ajaxMovimientos();
    $delate->eliminar = $_POST['idEliminarM'];
    $delate->ajaxeEliminarMovimiento();
}

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
        'id'=> $_POST['idMovimiento'],
        'accion' => $_POST['accion'],
    );
    $aceptar->ajaxAceptarMovimiento();
}