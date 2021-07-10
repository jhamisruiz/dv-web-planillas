<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Productos</h5>
                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Productos</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <select id="onloadAlmacen" class="form-control bg-primary text-white" onchange="AlmacenProds()">
                                <?php
                                $value = "";
                                #<select ng-model="select_prods" ng-change='fetchAlmacen()' id="onloadAlmacen" class="form-control bg-primary text-white">
                                $almacen = ControllerAlmacen::SELECT();
                                if (count($almacen) > 0) {
                                    echo '<option class="bg-white text-dark" value="0">Seleccione Almacén</option>';
                                    foreach ($almacen as $key => $value) {
                                        echo '<option class="bg-white text-dark " value="' . $value["idalmacen"] . '">' . $value["nombre"] . '</option>';
                                    }
                                } else {
                                    echo '<option class="bg-white text-dark" value="0">Sin Almacén</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-3 border border-primary rounded p-0">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Nombre</th>
                                <th class="bg-primary text-white">Descripción</th>
                                <th class="text-white bg-primary">Descripcion</th>
                                <th class="text-white bg-primary">Cantidad</th>
                                <th class="text-white bg-primary">Categoria</th>
                                <th class="text-white bg-primary">U.Medida</th>
                                <th class="text-white bg-primary">F.Ingreso</th>
                                <th class="text-white bg-primary">F.Vencimiento</th>
                                <th class="text-white bg-primary">Estado</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarProductos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
<!--Add Categorias -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title ">Add Productos</h4>
                <h3 class="float-right">Sucursal Trujillo</h3>
            </div>
            <!-- Modal body -->
            <div class="pl-4 pr-4 pt-3">
                <form method="post" enctype="multipart/form-data" autocomplete="off" id="addFormProductos">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label> Almacen </label>
                                <select class="form-control bg-primary text-white" id="addAlmacenProd" name="selectalmacen" onchange="ocDepositoAlm()">
                                    <option value="0">Select. Almacen</option>
                                    <?php
                                    $value = "";
                                    $almacen = ControllerAlmacen::SELECT();
                                    foreach ($almacen as $value) {
                                        echo '<option value="' . $value["idalmacen"] . '">' . $value["nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row ">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombre Producto </label>
                                        <input class="form-control border border-primary" name="addProducto" type="text" placeholder="Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Categoria </label>
                                        <select id="addCatProd" class="form-control bg-primary text-white">
                                            <option value="">Seleccione</option>
                                            <?php
                                            $value = "";
                                            $categorias = CtrCategorias::SELECT();
                                            foreach ($categorias as $value) {
                                                echo '
                                                    <option value="' . $value["id"] . '">' . $value["nombre"] . '</option>
                                                ';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input class="form-control border border-primary pr-2 catidadPd" onchange="onSumaCantProd()" id="idCantProd" name="addProducto" type="number" value="0" min="0" pattern="^[0-9]+">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Unidad Medida</label>
                                        <input class="form-control border border-primary" name="addProducto" type="text" placeholder="...">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Abrev Sunat</label>
                                        <input class="form-control border border-primary" name="addProducto" type="text" oninput="this.value = this.value.toUpperCase()" placeholder="...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Fhecha Ingreso</label>
                                                    <div class="cal-icon">
                                                        <input type="text" name="addProducto" id="datetimeStart" class="form-control border border-primary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Fecha Vencimiento</label>
                                                    <div class="cal-icon">
                                                        <input type="text" name="addProducto" id="datetimeEnd" class="form-control border border-primary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Descripción </label>
                                                    <textarea class="form-control border border-primary" id="addProdDescrip" rows="4" placeholder="Descripción..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-1 text-center">
                                            <label>Imagen </label>
                                            <div class="custom-input-file col-md-6 col-sm-6 col-xs-6">
                                                <input class="form-control input-file" type="file" id="cargarImg" onchange="mostrarImg()" accept="image/*">
                                                Subir fichero...
                                            </div>
                                        </div>
                                        <div class="row pt-0 mt-0">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-6" style="float: right;">
                                                <div class="product-thumbnail pt-2" id="imgProducto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row border border-primary">
                                <div class="col-lg-12">
                                    <h4>Deposito </h4>
                                    <div class="form-group">
                                        <select class="form-control border-secondary" id="idDepositoprod" onchange="mostrarDep()">
                                            <option value="0">Crear Nuevo Deposito</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input name="addDeposito" id="idaddDeposito" type="hidden" value="0">
                                        <input class="form-control pr-2 border-secondary" id="idNombreDp" name="addDeposito" type="text" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control pr-2 border-secondary" id="idTipoDep" name="addDeposito" type="text" placeholder="Tipo">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Cantidad Actual </label>
                                        <input type="hidden" value="0" id="montoactual">
                                        <input class="form-control pr-2" onchange="onSumaCantProd()" id="idCantactDep" name="addDeposito" type="number" placeholder="Capacidad Actual">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Capacidad Maxima</label>
                                        <input class="form-control pr-2" id="idCantmaxDep" name="addDeposito" type="number" placeholder="Capacidad Maxima" onkeyup="validmaxima()">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control pr-2 border-secondary" id="idDescripDep" name="addDeposito" type="text" placeholder="Descripción">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-primary" id="btnGuardarProducto">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>