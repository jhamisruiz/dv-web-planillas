<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');
include('./../../../models/query/SPquerys.M.php');

class ajaxSelectMovimientos{

    public $idMovimiento;
    public function selectDetalleMovimiento(){

        $id= $this->idMovimiento;

        $request = SPModelQueryes::SPDetalleMovimiento($id);
        echo json_encode($request);

    }
}

/*=============================================
    OBJETO ACEPTAR MOVIMIENTOS
    =============================================*/
if (isset($_POST['idMovimiento'])) {
    $aceptar = new ajaxSelectMovimientos();
    $aceptar->idMovimiento = $_POST['idMovimiento'];
    $aceptar->selectDetalleMovimiento();
}