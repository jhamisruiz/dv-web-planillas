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

        $repuesta=CtrQueryes::SELECT($select,$tables,$where);
        return $repuesta;
    }
    
}