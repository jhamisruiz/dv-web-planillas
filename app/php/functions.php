<?php

class Functions{

    static public function Alertify($alertify){

        return "<script>
        alertify.". $alertify["color"]."('". $alertify["sms"]."');
        </script>";
    }

    static public function SwiftAlert($swift)
    {
        $form ="";
        if ($swift["rForm"] != "") {
            $form = "$('#". $swift["rForm"]."')[0].reset();";
        }
        return "<script>
        Swal.fire({
            position: 'center',
            icon: '" . $swift["icon"] . "',
            title: '". $swift["sms"]."',
            showConfirmButton: false,
            timer: 1500
        });". $form."
        </script>";
    }
}