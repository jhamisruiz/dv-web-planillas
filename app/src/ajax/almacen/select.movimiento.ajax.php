<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../models/query/SPquerys.M.php');
include('./../../../controllers/almacen/movimientos.C.php');

class ajaxSelectMovimientos{

    public $idMovimiento;
    public $searchm;
    public function selectDetalleMovimiento(){

        $id= $this->idMovimiento;
        $search = $this->searchm;

        $idm = $id;
        $movimiento = ControllerMovimientos::SELECMOVIMIENTOS($idm, $search);

        $request = SPModelQueryes::SPDetalleMovimiento($id);
        $res = [$request, array('web'=> URL_HOST_WEB), $movimiento];
        echo json_encode($res);
        //echo json_encode(URL_HOST_WEB);

    }
}

/*=============================================
    OBJETO ACEPTAR MOVIMIENTOS
    =============================================*/
if (isset($_POST['idMovimiento'])) {
    $aceptar = new ajaxSelectMovimientos();
    $aceptar->idMovimiento = $_POST['idMovimiento'];
    $aceptar->searchm = '';
    $aceptar->selectDetalleMovimiento();
}