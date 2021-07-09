<?php
class ControllerAlmacen{

    static public function SELECT(){

        $select = array(
            "A.id" => "idalmacen",
            "A.nombre" => "",
            "A.direccion" => "direc",
            "A.idUbigeo" => "idubigeo",
            "A.estado" => "",
            "A.descripcion" => "descrip",
            "A.idSucursal " => "idsucursal",
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
        $where ="";
        $respuesta = CtrQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
}