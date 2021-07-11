<?php
class ControllerMain
{

    static public function ctrMain()
    { ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php
            include "resources/parts/head.php";
            ?>
        </head>

        <body>
            <?php
            $usuario= "prueba";
           
                $sgbd = Conexion::tryConex();

                if ($sgbd["error"] == "error") {

                    include "resources/error/sgbd.php";
                } else {
                    if ($usuario=="prueba") {

                    ?>
                    <div id="app">
                            <?php include "resources/parts/siderbar.php";?>
                        <div id="main" class='layout-navbar'>
                            <?php
                            include "resources/parts/header.php";
                            ?>
                            <div id="main-content">
                            <?php
                            include "resources/main.php";
                            ?>
                            </div>
                        </div>
                    </div>

                    <div id="smsconfirmations"></div>
                    <?php
                    
                }else{
                    if (isset($_GET["ruta"])) {
                        if ($_GET["ruta"] == "login" ||$_GET["ruta"] == "registro"){
                            include "resources/views/usuario/" . $_GET["ruta"] . ".php";
                        }else{
                            include "resources/views/usuario/login.php";
                        }
                    }else{
                        include "resources/views/usuario/login.php";
                    }
                    
                }
             }
                include "resources/parts/script.php";
            
            ?>

        </body>

        </html>

<?php
    }
}
?>