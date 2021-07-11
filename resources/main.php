
    <?php

    if (isset($_GET["ruta"])) {

        if ($_GET["ruta"] == "usuarios") {

            include "resources/views/admin/" . $_GET["ruta"] . ".php";
        } elseif ($_GET["ruta"] == "...") {
            //...
        } elseif (
            $_GET["ruta"] == "categorias" ||
            $_GET["ruta"] == "productos" ||
            $_GET["ruta"] == "almacen"
        ) {
            include "resources/views/almacen/" . $_GET["ruta"] . ".php";
        } elseif ($_GET["ruta"] == "salir") {
            #salir login
            include "resources/views/login/salir.php";
        } elseif ($_GET["ruta"] == "dashboard") {
            include "resources/views/" . $_GET["ruta"] . ".php";
        } else {
            #si no hay ruta get error
            include "resources/error/404.php";
        }
    }else{
        include "resources/views/dashboard.php";
    }
    ?>
