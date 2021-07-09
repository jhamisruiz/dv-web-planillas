<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Almacen</h5>
                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Almacen</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Graiden</td>
                            <td>vehicula.aliquet@semconsequat.co.uk</td>
                            <td>076 4820 8838</td>
                            <td>Offenburg</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Harding</td>
                            <td>Lorem.ipsum.dolor@etnetuset.com</td>
                            <td>0800 1111</td>
                            <td>Obaix</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Emmanuel</td>
                            <td>eget.lacus.Mauris@feugiatSednec.org</td>
                            <td>(016977) 8208</td>
                            <td>Saint-Remy-Geest</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<!--Add Categorias -->
<div class="modal fade" id="inlineForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Nuevo Almacén </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="pl-3 pr-3 pt-3">
                <form method="post" action="/form" autocomplete="off" id="addFormAlmacen">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row d-flex flex-wrap-reverse">
                                <div class="col-lg-8">
                                    <div class="form-group" id="sucuarlPrincipal">
                                        <select id="my-select" class="form-control border border-primary" name="">
                                            <option>Seleccione Sucursal</option>
                                            <option>Sucursal 1</option>
                                            <option>Sucursal 2</option>
                                            <option>Sucursal 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-none" id="sucuarlTemporal">
                                        <label>Nombre Sucursal Temporal <span class="text-danger">*</span></label>
                                        <input class="form-control" name="addAlmacen" type="text" placeholder="Nombre temporal...">
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
                                <input class="form-control" name="addAlmacen" type="text" placeholder="Nombre...">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departamento <span class="text-danger">*</span></label>
                                <select name="" class="form-control" id="region">
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
                                <select name="" class="form-control" id="provincia">
                                    <!-- // -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label>Distrito <span class="text-danger">*</span></label>
                                <select name="" class="form-control" id="ubigeo">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Direccion <span class="text-danger">*</span></label>
                                <input class="form-control" name="addAlmacen" type="text" placeholder="Direccion...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Referencia <span class="text-danger">*</span></label>
                                <input class="form-control" name="addAlmacen" type="text" placeholder="Referencia...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripción </label>
                                <textarea class="form-control" id="addDescripcion" rows="3" placeholder="Descripción..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block" id="btnGuardarAlmacen">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>