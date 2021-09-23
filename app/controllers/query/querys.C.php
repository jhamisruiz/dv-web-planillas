<?php
class ControllerQueryes{
    /* ================================================================
    QUERY   ROWCOUNT
    ================================================================= */
    static public function ROWCOUNT($table)
    {
        $row='';
        $respuesta = ModelQueryes::ROWCOUNT($table);
        if (isset($respuesta['row'])){
            $row = $respuesta['row'];
        }
        if ($row>0){
            return $row;
        }
        return $respuesta;
    }
/* ================================================================
    QUERY SELECT
================================================================= */
    static public function SELECT($select, $tables, $where){

        $respuesta= ModelQueryes::SELECT($select, $tables, $where);
        return $respuesta;
    }
/* ================================================================
    QUERY INSERT
================================================================= */
    static public function INSERT($insert){

        $respuesta = ModelQueryes::INSERT($insert);
        return $respuesta;
    }
/* ================================================================
    QUERY UPDATE
================================================================= */
    static public function UPDATE($update,$where)
    {

        $respuesta = ModelQueryes::UPDATE($update,$where);
        return $respuesta;
    }
/* ================================================================
    QUERY DELATE
================================================================= */
    static public function DELATE($delate)
    {

        $respuesta = ModelQueryes::DELATE($delate);
        return $respuesta;
    }
}