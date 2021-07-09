<div id="main">
    <?php

    if (isset($_GET["ruta"])) {

        if ($_GET["ruta"] == "dashboard") {

            include "resources/views/" . $_GET["ruta"] . ".php";
        } else {

            if ($_GET["ruta"] == "usuarios") {

                include "resources/views/admin/" . $_GET["ruta"] . ".php";
            } else {

                if ($_GET["ruta"] == "admision") {
                    # code...
                } else {

                    if (
                        $_GET["ruta"] == "categorias" ||
                        $_GET["ruta"] == "productos" ||
                        $_GET["ruta"] == "almacen"
                    ) {

                        include "resources/views/almacen/" . $_GET["ruta"] . ".php";
                    } else {

                        include "resources/error/404.php";
                    }
                }
            }
        }
    } else {
    }
    ?>
</div>