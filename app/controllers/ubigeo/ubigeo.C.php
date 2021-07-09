<?php
class ControllerUbigeo{

    static public function CtrUbigeo($provin, $distrito){

        $respuesta = ModelUbigeo::MdlUbigeo($provin, $distrito);
        return $respuesta;
    }
}