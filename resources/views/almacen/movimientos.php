<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Movimientos</h5>
                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Movimiento</button>
            </div>
            <div class="card-body">
                <div class="row col-lg-4">
                    <div class="input-group mb-3 border border-primary rounded p-0">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input onkeyup="searchMovimiento()" id="searchMovimiento" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Usario</th>
                                <th class="bg-primary text-white">Fecha Reg.</th>
                                <th class="bg-primary text-white">Enviado por:</th>
                                <th class="bg-primary text-white">Recibido por:</th>
                                <th class="bg-primary text-center text-white">Status</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Detalle</th>
                                <th class="bg-primary text-white">MOTIVO</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarMovimientos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>

<table style="display:none" class="idtablaclase">
    <tr>
        <td></td>
        <td></td>
        <td>LISTA DE MATERIALES</td>
        <td></td>
        <td></td>
    </tr>
    <tr></tr>
</table>
<table style="display:none" class="idtablaclase" id="idtable1"></table>
<table style="display:none" class="idtablaclase" id="idtable2"></table>
<!--Add Categorias -->
<div class="modal fade" id="inlineForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Nuevo Movimiento </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="pl-3 pr-3 pt-3">
                <form method="post" action="/form" autocomplete="off" id="addFormMovimiento">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Enviado por: <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="id-alacen-salida" onchange="myFMovimiento()">
                                    <option value="0" selected>Seleccione</option>
                                    <?php
                                    $almacenP = ControllerMovimientos::SELECTALL();
                                    foreach ($almacenP as $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-center">
                            <div class="form-group col-lg-5">
                                <label>Acción: <span class="text-danger">*</span></label>
                                <select name="" class="form-control border text-white border-primary bg-success" id="idAccionMovimient">
                                    <option value="0" selected>Seleccione</option>
                                    <?php
                                    $acion = ControllerMovimientos::SELECTACCION();
                                    foreach ($acion as $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["accion"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label>Recibido por: <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="id-alacen-entrada">
                                    <option value="0" selected>Seleccione</option>
                                    <?php
                                    $almacenP = ControllerMovimientos::SELECTALL();
                                    var_dump($almacenP);
                                    foreach ($almacenP as $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group mb-3 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input onkeyup="buscarProductoAlmacen()" id="valueSearchProds" type="text" class="form-control" placeholder="Buscar producto..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="resSearchMov" class="d-flex align-items-start flex-column w-100">
                                </div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class="table table-striped" id="productosMovimiento">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white text-left">Nombre</th>
                                        <th class="bg-primary text-white text-left">Descripcion</th>
                                        <th class="bg-primary text-white text-left">Cant. Actual</th>
                                        <th class="bg-primary text-white">Cant. Enviar</th>
                                        <th class="bg-primary text-white text-left" onclick="">Accion</th>
                                    </tr>
                                </thead>
                                <tbody class="show-cart table">

                                </tbody>
                            </table>
                            <div class="form-group">
                                <textarea placeholder="Motivo..." class="form-control border border-primary" id="idmotivomove" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Main -->
                    <div class="modal-footer">
                        <button type="button" class="clear-cart btn btn-danger">Eliminar Productos</button>
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block" id="btnGuardarMovimiento">Enviar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>