<?php

include('./../../php/functions.php');
include('./../../controllers/query/querys.C.php');
include('./../../models/query/querys.M.php');

class ajaxPermisos
{
    public $addperms;
    public $idadmin;
    public function ajaxCrearPerms()
    {
        $perms = $this->addperms;
        $id=$this->idadmin;
        //print_r($perms);
        $select = array(
            "*" => "*"
        );
        $tables = array(
            "detalle_permisos"=> "",
        );
        $where = array(
            'id_admin' => "=". $id
        );
        $detPers = ControllerQueryes::SELECT($select, $tables, $where);

        if(count($detPers)==0){
            for ($i = 0; $i < count($perms); $i++) {
                $insert = array(
                    "table" => "detalle_permisos",
                    "id_admin" => $id,
                    "id_permiso" => $perms[$i],
                );
                $respuesta = ControllerQueryes::INSERT($insert);
                if ($respuesta == "ok") {
                    $swift = array(
                        "icon" => "success",
                        "sms" => "Permiso actualziado",
                        "rForm" => "",
                    );
                    $succes = Functions::SwiftAlert($swift);
                    echo $succes;
                } else {

                    $alertify = array(
                        "color" => "error",
                        "sms" => "TPermiso no actualziado ",
                    );
                    $error = Functions::Alertify($alertify);
                    echo $error;
                }
            }
        }else{
            $delate = array(
                "table" => "detalle_permisos",
                "id_admin" => $id,
            );
            $eliminar = ControllerQueryes::DELATE($delate);
            if($eliminar == "ok"){
                for ($i = 0; $i < count($perms); $i++) {
                    $insert = array(
                        "table" => "detalle_permisos",
                        "id_admin" => $id,
                        "id_permiso" => $perms[$i],
                    );
                    $respuesta = ControllerQueryes::INSERT($insert);
                    if ($respuesta == "ok") {
                        $swift = array(
                            "icon" => "success",
                            "sms" => "Permiso actualziado",
                            "rForm" => "",
                        );
                        $succes = Functions::SwiftAlert($swift);
                        echo $succes;
                    } else {

                        $alertify = array(
                            "color" => "error",
                            "sms" => "TPermiso no actualziado ",
                        );
                        $error = Functions::Alertify($alertify);
                        echo $error;
                    }
                }
            }
        }
        
        
    }
    /* select Parametros */
    public $select;
    public function ajaxSelectPerms()
    {
        $id = $this->select;
        //print_r($perms);
        $select = array(
            "id_permiso" => ""
        );
        $tables = array(
            "detalle_permisos" => "",
        );
        $where = array(
            'id_admin' => "=" . $id
        );
        $detPers = ControllerQueryes::SELECT($select, $tables, $where);
        //echo $detPers;
        if(count($detPers)>0){
            $perms="";
            foreach ($detPers as $value) {
                $perms .= $value['id_permiso']." ";
            }
            echo $perms;
        }
    }
 
}
if (isset($_POST['addPermisos'])) {
    $perms = new ajaxPermisos();
    $perms->addperms = $_POST['addPermisos'];
    $perms->idadmin = $_POST['idadmin'];
    $perms->ajaxCrearPerms();
}
if (isset($_POST['selectpers'])) {
    $perms = new ajaxPermisos();
    $perms->select = $_POST['selectpers'];
    $perms->ajaxSelectPerms();
}