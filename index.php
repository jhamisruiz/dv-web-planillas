<?php
/* ***** ******* CONFIG ****************** */
require './app/config/config.php';
require "./app/models/conexPDO.php";

/* =====================================================================
        MODEL ...
========================================================================*/
require_once "app/models/query/querys.M.php";

/* =====================================================================
        MODEL USUARIOS
========================================================================*/

/* =====================================================================
        CONTROLLER 
========================================================================*/
require_once "app/controllers/query/querys.C.php";
require_once "app/controllers/ubigeo/ubigeo.C.php";

/* =====================================================================
        ALMACEN CONTROLLER 
========================================================================*/
require_once "app/controllers/almacen/categorias.C.php";
require_once "app/controllers/almacen/productos.C.php";
require_once "app/controllers/almacen/almacen.C.php";
/* =====================================================================
        usaurios CONTROLLER 
========================================================================*/


/* ----------------------------------------------------------
   -----------------------FUNCTIONS----------------------------------- */
require_once "app/php/functions.php";


/* =====================================================================
        CONTROLLER main app
========================================================================*/
require_once "app/controllers/main.C.php";

$main = new ControllerMain();
$main->ctrMain();