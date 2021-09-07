<?php
class ControllerAlmacen{

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
            "A.ingreso" =>"='1'",
            "A.estado" => "='1'",
        );
        if ($all=="all") {
            $where = array(
                "A.estado" => "='1'",
            );
        }
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }

    static public function SELECTALL($tables)
    {
        $select = array("*" => "*");
        $tables = array(
            $tables=>""
        );
        $where = array(
            "tipo" => "='TEMPORAL'"
        );
        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
}
