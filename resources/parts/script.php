<!-- js para peticion ajaxs o funciones-->
<script type="text/javascript" src="app/src/js/almacen/almacen.js"></script>
<script type="text/javascript" src="app/src/js/almacen/categorias.js"></script>
<script type="text/javascript" src="app/src/js/almacen/productos.js"></script>
<script type="text/javascript" src="app/src/js/almacen/movimiento.js"></script>

<script type="text/javascript" src="app/src/js/config/config.js"></script>

<script type="text/javascript" src="app/src/js/login/login.js"></script>
<!-- conta -->
<script type="text/javascript" src="app/src/js/contabilidad/tipo.js"></script>
<script type="text/javascript" src="app/src/js/contabilidad/ingreso.js"></script>
<script type="text/javascript" src="app/src/js/contabilidad/gasto.js"></script>
<!-- planillas -->
<script type="text/javascript" src="app/src/js/planillas/depa-empleo.js"></script>
<script type="text/javascript" src="app/src/js/planillas/empleado.js"></script>
<script type="text/javascript" src="app/src/js/planillas/pagos.js"></script>
<script type="text/javascript" src="app/src/js/planillas/asistencias.js"></script>
<script type="text/javascript" src="app/src/js/sucursales.js"></script>
<!-- js peticion ubigeo -->
<script type="text/javascript" src="app/src/js/ubigeo.js"></script>
<!-- js -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

<!-- script de panel maquetado -->
<script src="public/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="public/assets/js/bootstrap.bundle.min.js"></script>


<script src="public/assets/js/moment.min.js"></script>
<script src="public/assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Include Choices JavaScript -->
<script src="public/assets/vendors/choices.js/choices.min.js"></script>

<?php

if (isset($_SESSION["logSession"]) && $_SESSION["logSession"] == "ok") {
    echo '<script src="public/assets/js/main.js"></script>';
}

if (isset($_GET["ruta"])) {

    if ($_GET["ruta"] == "dashboard") {

        echo '
        <script src="public/assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="public/assets/js/pages/dashboard.js"></script>
        ';
    }
}
?>

<script>
    $(function() {
        $('#timeStar').datetimepicker({
            format: 'HH:mm:ss'
        });
        $('#timeStarDos').datetimepicker({
            format: 'HH:mm:ss'
        });
        $('#datetimeStart').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimeEnd').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dateStart').datetimepicker({
            format: 'YYYY-MM'
        });
    });
</script>