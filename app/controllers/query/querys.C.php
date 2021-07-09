<?php
class CtrQueryes{
/* ================================================================
    QUERY SELECT
================================================================= */
    static public function SELECT($select, $tables, $where){

        $respuesta= MdlQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
/* ================================================================
    QUERY INSERT
================================================================= */
    static public function INSERT($insert){

        $respuesta = MdlQueryes::INSERT($insert);
        return $respuesta;
    }
/* ================================================================
    QUERY UPDATE
================================================================= */
    static public function UPDATE($update,$where)
    {

        $respuesta = MdlQueryes::UPDATE($update,$where);
        return $respuesta;
    }
/* ================================================================
    QUERY DELATE
================================================================= */
    static public function DELATE($delate)
    {

        $respuesta = MdlQueryes::DELATE($delate);
        return $respuesta;
    }
}