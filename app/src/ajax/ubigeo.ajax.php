<?php

include('./../../php/functions.php');
include('./../../controllers/ubigeo.C.php');
include('./../../controllers/querys.C.php');
include('./../../models/querys.M.php');
class ajaxControllerUbigeo
{

    public $provincia;
    public function ctrProvincia()
    {
        $provin = $this->provincia;
        $distrito="";
        $respuesta = ControllerUbigeo::CtrUbigeo($provin, $distrito);

        foreach ($respuesta as $val) {
            echo "<option value='" . $val['id_ubigeo'] . "'>" . $val['Provincia'] . "</option>";
        }
    }

    public $distrit;
    public function ctrDistrito()
    {
        $provin="";
        $distrito = $this->distrit;

        $respuesta = ControllerUbigeo::CtrUbigeo($provin, $distrito);

        foreach ($respuesta as $val) {
            echo "<option value='" . $val['id_ubigeo'] . "'>" . $val['Distrito'] . "</option>";
        }
    }
}

if (isset($_POST['id'])) {
    $ubigeo = new ajaxControllerUbigeo();
    $ubigeo->provincia = $_POST['id'];
    $ubigeo->ctrProvincia();
}

if (isset($_POST['idp'])) {
    $ubigeo = new ajaxControllerUbigeo();
    $ubigeo->distrit = $_POST['idp'];
    $ubigeo->ctrDistrito();
}
