<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Lista gastos</h5>
                        <input type="hidden" id="iddnone" value="d-block">
                        <button type="button" onclick="limpiarGasForm()" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add tipo gasto</button>
                    </div>
                    <div class="card-body">
                        <div class="row col-lg-4">
                            <div class="form-group">
                                <label>Buscar por Mes<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" id="dateStart" onblur="searchgasto()" onkeyup="searchgasto()" class="form-control border border-primary">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white">#</th>
                                        <th class="bg-primary text-white">Tipo</th>
                                        <th class="bg-primary text-white">Categ. Gasto</th>
                                        <th class="bg-primary text-white">Cantidad</th>
                                        <th class="bg-primary text-center text-white">Fecha-Registro</th>
                                        <th class="bg-primary text-center text-white">Descripcion</th>
                                        <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mostrargasto">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Add  -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulario Gastos </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addFormgasto">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <div class="form-group" id="sucuarlPrincipal">
                                <select id="idgastotipo" class="form-control border border-primary" name="">
                                    <option value="0">Seleccione Tipo gasto</option>
                                    <?php
                                    $select = array(
                                        "*" => "*"
                                    );
                                    $tables = array(
                                        'tipo_contabilidad' => ''
                                    );
                                    $where = array(
                                        'tipo' => "='G'"
                                    );
                                    $gastotipo = ControllerQueryes::SELECT($select, $tables, $where);
                                    foreach ($gastotipo as $key => $value) {
                                        echo '<option value="' . $value['id'] . '">' . $value['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="d-flex">
                                <div class="form-group">
                                    <label>Hora gasto </span></label>
                                    <div class="cal-icon">
                                        <input type="text" id="timeStar" class="form-control border border-primary">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Fhecha gasto </span></label>
                                    <div class="cal-icon">
                                        <input type="text" id="datetimeStart" class="form-control border border-primary">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group p-1">
                                <label>Cantidad<span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <button type="button" onclick="salario(-10)" class="btn bg-primary text-white">-</button>
                                    <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                                        <span class="input-group-text" id="basic-addon1"><i class=>S/</i></span>
                                        <input id="salTrabajador" class="form-control" type="number" min="0.00" step="0.010" value="0.00">
                                    </div>
                                    <button type="button" onclick="salario(10)" class="btn bg-primary text-white">+</button>
                                </div>
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="idescribeing" class="form-control border border-primary text-primary" cols="12" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="Addgasto" idgasto="0" editargasto="NO">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>