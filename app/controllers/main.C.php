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
           
                $sgbd = Conexion::tryConex();

                if ($sgbd["error"] == "error") {

                    include "resources/error/sgbd.php";
                } else {
                    //  if (isset($_user['asddas'])) {

            ?>
                    <div id="app">
                        <div id="main" class='layout-navbar'>
                            <?php
                            include "resources/parts/header.php";
                            include "resources/parts/siderbar.php";

                            include "resources/main.php";
                            ?>
                        </div>
                    </div>

                    <div id="smsconfirmations"></div>
            <?php
                }

            //     }else{
            //     //include "login.php";
            // }
                include "resources/parts/script.php";
            
            ?>

        </body>

        </html>

<?php
    }
}
?>