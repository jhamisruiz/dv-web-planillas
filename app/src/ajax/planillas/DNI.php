<?php
if(isset($_POST['searchdni'])){
    if (strlen($_POST['searchdni'])==8) {
        $dni = "https://api.apis.net.pe/v1/dni?numero=" . $_POST['searchdni'];
        $return = file_get_contents($dni);
        echo $return;
    } else {
        echo 'error';
    }
    
}