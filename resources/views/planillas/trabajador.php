<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Trabajadores</h5>
                <?php
                try {
                    $num = 2;

                    $table = "trabajador";
                    $rows = ControllerQueryes::ROWCOUNT($table);
                    if ($rows > 0) {
                        $page = 2;

                        if ($page == false) {
                            $start = 0;
                            $page = 1;
                        } else {
                            $start = ($page - 1) * $num;
                        }
                        $total = ceil($rows / $num);
                    }
                } catch (\Throwable $th) {
                    $throw = $th->getMessage();
                }
                if (isset($rows['row']) && $rows['row'] == 0) {
                    $rows = '';
                }
                ?>

                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm" onclick="limpiarFormEmploye()">Add Trabajador</button>
            </div>
            <div class="card-body ">
                <div class="row colum-flex-rev">
                    <div class="col-lg-2 mb-0 pb-0">
                        <div class="mb-0  p-0 d-flex align-items-center">
                            <h6 class="mr-3">Ver </h6>
                            <select onchange="rowsemployes()" id="rowsemployes" class="form-control w-50">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <h6 class="ml-3">Filas</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-0 pb-0">
                        <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input onkeyup="searchTrabajador()" id="searchTrabajador" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                        </div>
                        <div id="smsearch" class="text-danger mb-0 pb-0"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Nombre</th>
                                <th class="bg-primary text-white">Apellidos</th>
                                <th class="text-white bg-primary">DNI</th>
                                <th class="text-white bg-primary">Fecha Nacimiento</th>
                                <th class="text-white bg-primary">Telef.</th>
                                <th class="text-white bg-primary">email</th>
                                <th class="text-white bg-primary">Ubigeo</th>
                                <th class="text-white bg-primary">Direccion</th>
                                <th class="text-white bg-primary">Sucursal</th>
                                <th class="text-white bg-primary">Area</th>
                                <th class="text-white bg-primary">Empleo</th>
                                <th class="text-white bg-primary">Salario</th>
                                <th class="text-white bg-primary">Precio hora</th>
                                <th class="bg-primary text-white" style="max-width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarTrabajador">

                        </tbody>
                    </table>
                    <h6>Total de filas <strong id="idtotal"><?= $rows ?></strong></h6>
                    <div class="card-body">
                        <nav aria-label="...">
                            <ul class="pagination" id="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<!--Add MODAL -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title ">Formulario Trabjador</h4>
            </div>
            <!-- Modal body -->
            <div class="pl-4 pr-4 pt-3">
                <form autocomplete="off" id="addFormTrabajador">
                    <div class="row ">
                        <div class="col-lg-4">
                            <div class="form-group" id="sucuarlPrincipal">
                                <select id="idSucursal" class="form-control bg-primary text-white" name="">
                                    <option value="0">Seleccione Sucursal</option>
                                    <?php
                                    $select = array(
                                        "*" => "*"
                                    );
                                    $tables = array("sucursales" => "");
                                    $where = '';
                                    $sucursal = ControllerQueryes::SELECT($select, $tables, $where);
                                    foreach ($sucursal as $key => $value) {
                                        echo '<option value="' . $value['id'] . '">' . $value['nombre'] . '</option>';
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
                                        <label>Nombres<span class="text-danger">*</span></label>
                                        <input type="hidden" id="idtrabajador" value="NO">
                                        <input id="nombTrabajador" class="form-control border border-primary" name="addTrabajador" type="text" placeholder="Nombre...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Apellidos<span class="text-danger">*</span></label>
                                        <input id="apellTrabajador" class="form-control border border-primary" name="addTrabajador" type="text" placeholder="Apellidos...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>DNI<span class="text-danger">*</span></label>
                                        <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                                            <input id="dniTrabajador" name="addTrabajador" class="form-control" type="text" placeholder="dni...">
                                            <span onclick="dataReniecDNI()" style="cursor:pointer" class="input-group-text bg-primary text-white" id="basic-addon1">
                                                <i class="bi bi-search"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input id="telfTrabajador" class="form-control border border-primary" type="text" placeholder="974... - 987...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id="emailTrabajador" class="form-control border border-primary" type="email" placeholder="ejemp@email.com">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Fecha Nacimiento</label>
                                        <div class="cal-icon">
                                            <input type="text" id="datetimeEnd" class="form-control border border-primary">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Fhecha Ingreso </span></label>
                                        <div class="cal-icon">
                                            <input type="text" id="datetimeStart" class="form-control border border-primary">
                                        </div>
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
                                        <label>Direccion</label>
                                        <input id="direcTrabajador" class="form-control border border-primary" name="" type="text" placeholder="Direccion...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    <div class="form-group" id="sucuarlPrincipal">
                                        <label>Area<span class="text-danger">*</span></label>
                                        <select id="idarea" class="form-control border border-primary" name="">
                                            <option value="0">Seleccione Area</option>
                                            <?php
                                            $select = array(
                                                "*" => "*"
                                            );
                                            $tables = array(
                                                'departamento' => ''
                                            );
                                            $where = '';
                                            $sucursal = ControllerQueryes::SELECT($select, $tables, $where);
                                            foreach ($sucursal as $key => $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['nombre'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group" id="sucuarlPrincipal">
                                        <label>Empleo<span class="text-danger">*</span></label>
                                        <select id="idempleo" class="form-control border border-primary" name="">
                                            <option value="0">Seleccione Empleo</option>
                                            <?php
                                            $select = array(
                                                "*" => "*"
                                            );
                                            $tables = array(
                                                'empleo' => ''
                                            );
                                            $where = '';
                                            $sucursal = ControllerQueryes::SELECT($select, $tables, $where);
                                            foreach ($sucursal as $key => $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['nombre'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="">
                                        <div class="form-group p-1">
                                            <label>Salario<span class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <button type="button" onclick="salario(-10)" class="btn bg-primary text-white">-</button>
                                                <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                                                    <span class="input-group-text" id="basic-addon1"><i class=>S/</i></span>
                                                    <input id="salTrabajador" class="form-control" type="number" min="0.00" step="0.010" value="0.00">
                                                </div>
                                                <button type="button" onclick="salario(10)" class="btn bg-primary text-white">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="div">
                                        <label class="text-primary">
                                            <input type="checkbox" onclick="activetareo()" id="idtareo" value=""> Trabajador tareo
                                        </label>
                                    </div>
                                    <div id="idpreciohora" class="form-group p-1 d-none">
                                        <label>Precio X Hora<span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <button type="button" onclick="salarioXHora(-10)" class="btn bg-primary text-white">-</button>
                                            <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                                                <span class="input-group-text" id="basic-addon1"><i class=>S/</i></span>
                                                <input id="salarioXH" class="form-control" type="number" min="0.00" step="0.010" value="0.00">
                                            </div>
                                            <button type="button" onclick="salarioXHora(10)" class="btn bg-primary text-white">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" id="btnTrabajador" idtrabajador="0" editarTrabajador="NO">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- <li class="page-item disabled">
    <a class="page-link" href="#" tabindex="-1">Previous</a>
</li>
<li class="page-item"><a class="page-link" href="#">1</a></li>
<li class="page-item active">
    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
</li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item">
    <a class="page-link" href="#">Next</a>
</li> -->