
    <?php
    $perms = $_SESSION["perms"];
    $dashboard = 0; #1
    $contabilidad = 0; #2
    $sucursales = 0; #3
    $planillas = 0; #4
    $asistencia = 0; #5
    $almacen = 0; #6
    $config = 0; #7
    for ($i = 0; $i < count($perms); $i++) {
        if ($perms[$i]['id_permiso'] == 1) {
            $dashboard = 1;
        }
        if ($perms[$i]['id_permiso'] == 2) {
            $contabilidad = 2;
        }
        if ($perms[$i]['id_permiso'] == 3) {
            $sucursales = 3;
        }
        if ($perms[$i]['id_permiso'] == 4) {
            $planillas = 4;
        }
        if ($perms[$i]['id_permiso'] == 5) {
            $asistencia = 5;
        }
        if ($perms[$i]['id_permiso'] == 6) {
            $almacen = 6;
        }
        if ($perms[$i]['id_permiso'] == 7) {
            $config = 7;
        }
    }

    if (isset($_GET["ruta"])) {

        if ($_GET["ruta"] == "usuarios") {

            include "resources/views/admin/" . $_GET["ruta"] . ".php";
        } elseif ($_GET["ruta"] == "config-almacen") {
            if($config == 7){
                include "resources/views/config/" . $_GET["ruta"] . ".php";
            }else{
                include "resources/views/blank.php";
            }
        } elseif (
            $_GET["ruta"] == "contabilidad-tipo" ||
            $_GET["ruta"] == "contabilidad-ingreso" ||
            $_GET["ruta"] == "contabilidad-reporte" ||
            $_GET["ruta"] == "contabilidad-gasto" 
        ) {
            if($contabilidad == 2){
                $ruta = explode('-', $_GET["ruta"]);
                include "resources/views/contabilidad/" . $ruta[1] . ".php";
            } else {
                include "resources/views/blank.php";
            }
            
        }elseif (
            $_GET["ruta"] == "almacen-categorias" ||
            $_GET["ruta"] == "almacen-productos" ||
            $_GET["ruta"] == "almacen-movimientos" ||
            $_GET["ruta"] == "almacen-almacen"
        ) {
            if( $almacen == 6){
                $ruta = explode('-', $_GET["ruta"]);

                include "resources/views/almacen/" . $ruta[1] . ".php";
            }else{
                include "resources/views/blank.php";
            }
        } elseif ($_GET["ruta"] == "salir") {
            #salir login
            include "resources/views/login/salir.php";
        } elseif ($_GET["ruta"] == "dashboard") {
            if($dashboard == 1){
                include "resources/views/" . $_GET["ruta"] . ".php";
            }else{
                include "resources/views/blank.php";
            }
        } elseif (
            $_GET["ruta"] == "planillas-departamento-trabajador"||
            $_GET["ruta"] == "planillas-pagos" ||
            $_GET["ruta"] == "planillas-reportes" ||
            $_GET["ruta"] == "planillas-trabajador")
            {
                if($planillas == 4){
                    $ruta = explode('-', $_GET["ruta"]); //balidando ruta
                    $rt = '';
                    if (isset($ruta[2]) && $ruta[2] == 'trabajador') {
                        $rt = "-" . $ruta[2];
                    } //balidando ruta
                    include "resources/views/planillas/" . $ruta[1] .  $rt . ".php";
                }else{
                include "resources/views/blank.php";
                }
        } elseif ($_GET["ruta"] == "asistencias" ) {
            if($asistencia== 5){
                include "resources/views/planillas/" . $_GET["ruta"] . ".php";
            }else{
                include "resources/views/blank.php";
            }
            
        }elseif ($_GET["ruta"] == "sucursales") {
            if($sucursales == 3){

                include "resources/views/" . $_GET["ruta"] . ".php";
            }else{
                include "resources/views/blank.php";
            }
        } else {
            #si no hay ruta get error
            include "resources/error/404.php";
        }
    }else{
        include "resources/views/blank.php";
    }
    ?>
