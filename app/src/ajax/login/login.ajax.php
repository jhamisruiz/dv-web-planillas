<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxLogin{
    public $login;
    public function login(){
        $data = $this->login;
        print_r($data);
        $select= "";
        $table="";
        $where=array(
            "user"=>"='" . $data[0] . "'",
        );
        $respuest=ControllerQueryes::SELECT($select, $table, $where);
        foreach ($respuest as $value) {
            $sesionuser= $value['user'];
            $sesionpass = $value['password'];
        }
    }
}

//objeto login

if (isset($_POST['usuerLogin'])) {
    $login = new ajaxLogin();
    $login->login= $_POST['usuerLogin'];
    $login->login();
}