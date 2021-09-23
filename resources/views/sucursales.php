<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Sucursales</h5>
                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm" onclick="limpiarFormSucursal()">Add Sucursal</button>
            </div>
            <div class="card-body">
                <div class="row col-lg-4">
                    <div class="input-group mb-3 border border-primary rounded p-0">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input onkeyup="searchSucursal()" id="searchSucursal" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                <th class="bg-primary text-center text-white">Referencia</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarSucursal">

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
                <form method="post" autocomplete="off" id="addFormSucursal">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Nombre Sucursal <span class="text-danger">*</span></label>
                                <input id="nombreSucursal" class="form-control border border-primary" name="addSucursal" type="text" placeholder="Nombre...">
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
                                <input id="direcSucursal" class="form-control border border-primary" name="addSucursal" type="text" placeholder="Direccion...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Referencia </label>
                                <input id="referSucursal" class="form-control border border-primary" name="addSucursal" type="text" placeholder="Referencia...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" id="btnGuardarSucursal" editarSucursal="NO" idSucursal="0" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>