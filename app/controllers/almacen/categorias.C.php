<?php

class CtrCategorias{

/*=============================================
	SELECT CATEGORIAS
=============================================*/
    static public function SELECT(){

        $select=array(
            "*"=>"*",
        );
        $tables=array(
            "categorias"=>""
        );
        $where="";

        $repuesta=ControllerQueryes::SELECT($select,$tables,$where);
        return $repuesta;
    }
    
}