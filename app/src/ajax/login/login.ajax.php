<?php

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

include('./../../../controllers/login/login.C.php');
class ajaxLogin{
    public $login;
    public function login(){
        $data = $this->login;

        $respuest=ControllerLogin::LOGIN($data);
        //print_r($respuest);
        echo $respuest;
        
    }
}

//objeto login

if (isset($_POST['usuerLogin'])) {
    $login = new ajaxLogin();
    $login->login= $_POST['usuerLogin'];
    $login->login();
}