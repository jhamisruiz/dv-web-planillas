<?php 
class ControllerMovimientos{


static public function SELECTALL()
    {
        $select = array("*" => "*");
        $tables = array(
            "almacen"=>"",
        );
        
        $where = "";
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
static public function SELECT($all){

        $select = array(
            "A.id" => "idalmacen",
            "A.nombre" => "",
            "A.direccion" => "direc",
            "A.idUbigeo" => "idubigeo",
            "A.estado" => "",
            "A.descripcion" => "descrip",
            "A.idSucursal " => "idsucursal",
            "A.tipo" => "",
            "U.id_ubigeo" => "",
            "U.Departamento" => "Depart",
            "U.Provincia" => "Prov",
            "U.Distrito" => "Dist",
            "S.id" => "",
            "S.nombre" => "sucursal",
        );
        $tables=array(
            "almacen A"=>"ubigeo U",
            "A.idUbigeo" => "U.id_ubigeo",
            "sucursales S" => "",
            "A.idSucursal" => "S.id",
        );

        $where =array(
            "A.ingreso" =>"='1'"
        );
        if ($all=="all") {
             $where ="";
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }

}

 ?>