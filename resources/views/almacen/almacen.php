<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Almacen</h5>
                <button type="button"  class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Almacen</button>
            </div>
            <div class="card-body">
                <div class="row col-lg-4">
                    <div class="input-group mb-3 border border-primary rounded p-0">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input onkeyup="searchAlmacen()" id="searchAlmacen" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Nombre</th>
                                <th class="bg-primary text-white">Ubigeo</th>
                                <th class="bg-primary text-white">Dirección</th>
                                <th class="bg-primary text-center text-white">Status</th>
                                <th class="bg-primary text-center text-white">Tipo</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarAlmacen">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>

<!--Add Categorias -->
<div class="modal fade" id="inlineForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulario Almacén</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="pl-3 pr-3 pt-3">
                <form method="post" autocomplete="off" id="addFormAlmacen">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row d-flex flex-wrap-reverse">
                                <div class="col-lg-4">
                                    <div class="form-group" id="sucuarlPrincipal">
                                        <select id="idSucursal" class="form-control border border-primary" name="">
                                            <option value="0">Seleccione Sucursal</option>
                                            <option value="1">Sucursal 1</option>
                                            <option value="2">Sucursal 2</option>
                                            <option value="3">Sucursal 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group d-none" id="sucuarlTemporal">
                                        <div class="cal-icon">
                                            <input type="text" name="addProducto" id="datetimeEnd" class="form-control border border-primary" placeholder="Fecha Termino">
                                        </div>
                                    </div>
                                </div>
                                <!-- checkbock switch -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input id="idcheckSucursal" class="form-check-input border border-primary" type="checkbox" id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">
                                                Almacen Temporal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Nombre Almacen <span class="text-danger">*</span></label>
                                <input id="nombreAlmacen" class="form-control border border-primary" name="addAlmacen" type="text" placeholder="Nombre...">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departamento <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="region">
                                    <option>Seleccione</option>
                                    <?php
                                    $provin = "";
                                    $distrito = "";
                                    $value = "";
                                    $depart = ControllerUbigeo::CtrUbigeo($provin, $distrito);
                                    foreach ($depart as $value) {

                                        echo '<option value="' . $value["id_ubigeo"] . '">' . $value["Departamento"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label>Provincias <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="provincia">
                                    <option id="editarProvincia">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label>Distrito <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="ubigeo">
                                    <option id="editarDistrito" value="0">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Direccion <span class="text-danger">*</span></label>
                                <input id="direcAlmacen" class="form-control border border-primary" name="addAlmacen" type="text" placeholder="Direccion...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Referencia </label>
                                <input id="referAlmacen" class="form-control border border-primary" name="addAlmacen" type="text" placeholder="Referencia...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripción </label>
                                <textarea class="form-control border border-primary" id="addDescripcion" rows="3" placeholder="Descripción..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" id="btnGuardarAlmacen" editaralmacen="NO" idalmacen="0" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>