<?php
$perms = $_SESSION["perms"];
$active = '';
if (isset($_GET["ruta"])) {
    $ruta = explode('-', $_GET["ruta"]);

    $active = ' active';
}

?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="public/assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <?php
                $dashboard = 0;#1
                $contabilidad = 0;#2
                $sucursales = 0; #3
                $planillas=0;#4
                $asistencia = 0; #5
                $almacen = 0;#6
                $config = 0;#7
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
                if ($dashboard == 1) {
                ?>
                    <li class="sidebar-item <?php if (isset($ruta) && $ruta[0] == 'dashboard') echo $active ?> ">
                        <a href="dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                <?php
                }
                if ($contabilidad== 2) {
                ?>
                    <li class="sidebar-item  has-sub <?php if (isset($ruta) && $ruta[0] == 'contabilidad') echo $active ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Contabilidad</span>
                        </a>
                        <ul class="submenu <?php if (isset($ruta) && $ruta[0] == 'contabilidad') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'tipo') echo $active ?>">
                                <a href="contabilidad-tipo">Tipo</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'ingreso') echo $active ?>">
                                <a href="contabilidad-ingreso">Ingresos</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'gasto') echo $active ?>">
                                <a href="contabilidad-gasto">Gastos</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'reporte') echo $active ?>">
                                <a href="contabilidad-reporte">Reportes</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                if ($sucursales == 3) {
                ?>
                    <li class="sidebar-item  <?php if (isset($ruta) && $ruta[0] == 'sucursales') echo $active ?>">
                        <a href="sucursales" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>Sucursales</span>
                        </a>
                    </li>
                <?php
                }
                if ($planillas == 4) {
                ?>
                    <li class="sidebar-item  has-sub <?php if (isset($ruta) && $ruta[0] == 'planillas') echo $active ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Planillas</span>
                        </a>
                        <ul class="submenu <?php if (isset($ruta) && $ruta[0] == 'planillas') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'departamento') echo $active ?>">
                                <a href="planillas-departamento-trabajador">Departamento/Tipo Trabajador</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'trabajador') echo $active ?>">
                                <a href="planillas-trabajador">Trabajadores</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'pagos') echo $active ?>">
                                <a href="planillas-pagos">Pagos</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'reportes') echo $active ?>">
                                <a href="planillas-reportes">Reportes</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                if ($asistencia == 5) {
                ?>
                    <li class="sidebar-item  <?php if (isset($ruta) && $ruta[0] == 'asistencias') echo $active ?>">
                        <a href="asistencias" class='sidebar-link'>
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>Asistencias</span>
                        </a>
                    </li>
                <?php
                }?>
                <li class="sidebar-title">Extra UI</li>
                <?php
                if ($almacen == 6) {
                ?>
                    <li class="sidebar-item  has-sub <?php if (isset($ruta) && $ruta[0] == 'almacen') echo $active ?>">
                        <a class='sidebar-link'>
                            <i class="bi bi-pentagon-fill"></i>
                            <span>Almacen</span>
                        </a>
                        <ul class="submenu <?php if (isset($ruta) && $ruta[0] == 'almacen') echo $active ?>">
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'almacen') echo $active ?>">
                                <a href="almacen-almacen"> Almacenes </a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'categorias') echo $active ?>">
                                <a href="almacen-categorias">Categorias</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'productos') echo $active ?>">
                                <a href="almacen-productos">Productos</a>
                            </li>
                            <li class="submenu-item <?php if (isset($ruta) && $ruta[1] == 'movimientos') echo $active ?>">
                                <a href="almacen-movimientos"> Requerimientos </a>
                            </li>
                            <!-- <li class="submenu-item ">
                            <a href="#"> Stock Prod. por Almacen </a>
                        </li> -->
                        </ul>
                    </li>

                    <li class="sidebar-title">Raise Support</li>
                <?php
                }
                if ($config == 7) {
                ?>
                    <li class="sidebar-item has-sub  active">
                        <a class='sidebar-link' id="bsidebar-link" style="max-width: 120px;background:#57caeb">
                            <i class="bi bi-gear"></i>
                            <span>Config</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item">
                                <a href="config-almacen"> Almacenes </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <!-- <li class="sidebar-item  ">
                    <a href="/" class='sidebar-link'>
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Ayuda</span>
                    </a>
                </li> -->
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>