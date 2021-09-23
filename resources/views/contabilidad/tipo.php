<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Tipo de Ingresos</h5>
                        <button type="button" onclick="limpiarTINgForm()" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add tipo Ingreso</button>
                    </div>
                    <div class="card-body">
                        <div class="row col-lg-4">
                            <div class="input-group mb-3 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input onkeyup="searchtipoingreso()" id="searchtipoingreso" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white">#</th>
                                        <th class="bg-primary text-white">Nombre</th>
                                        <th class="bg-primary text-white">Descripción</th>
                                        <th class="bg-primary text-center text-white">Fecha-Registro</th>
                                        <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mostrartipoingreso">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Tipo de gastos</h5>
                        <button type="button" onclick="limpiarTipoGas()" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineEmpForm">Add tipo Egresos</button>
                    </div>
                    <div class="card-body">
                        <div class="row col-lg-4">
                            <div class="input-group mb-3 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input onkeyup="searchTipoGas()" id="searchTipoGas" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white">#</th>
                                        <th class="bg-primary text-white">Nombre</th>
                                        <th class="bg-primary text-white">Descripción</th>
                                        <th class="bg-primary text-center text-white">Fecha-Registro</th>
                                        <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="mostrartipogastos">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Add departamento-trabajador -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulario Area </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addFormtipoingreso">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <label>Nombre: </label>
                            <div class="form-group">
                                <input type="text" id="nomtipoingreso" class="form-control border border-primary text-primary">
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="destipoingreso" class="form-control border border-primary text-primary" cols="12" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="Addtipoingreso" idtipoingerso="0" editartipoingreso="NO">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Add tipo-trabajador -->
<div class="modal fade text-left" id="inlineEmpForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulario Tipo de Tipo gastos </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addtipogasto">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <label>Nombre: </label>
                            <div class="form-group">
                                <input type="text" id="nomtipogasto" class="form-control border border-primary text-primary">
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="destipogasto" class="form-control border border-primary text-primary" cols="12" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="Addtipogastos" idtipogasto="0" editartipogasto="NO">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>