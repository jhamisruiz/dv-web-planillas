<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Areas</h5>
                        <button type="button" onclick="limpiarDepForm()" 
                        class="btn bg-primary text-white" data-bs-toggle="modal"
                         data-bs-target="#inlineForm">Add Area</button>
                    </div>
                    <div class="card-body">
                        <div class="row col-lg-4">
                            <div class="input-group mb-3 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input onkeyup="searchDepartamentos()" id="searchDepartamentos" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                <tbody id="mostrarDepartamentos">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Tipo de Empleos</h5>
                        <button type="button" onclick="limpiarEmpleoForm()" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineEmpForm">Add tipo Trabajo</button>
                    </div>
                    <div class="card-body">
                        <div class="row col-lg-4">
                            <div class="input-group mb-3 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input onkeyup="searchEmpleo()" id="searchEmpleo" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
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
                                <tbody id="mostrarEmpleos">

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
            <form action="#" id="addFormDepartamentos">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <label>Nombre: </label>
                            <div class="form-group">
                                <input type="text" id="nomDepartamentos" class="form-control border border-primary text-primary">
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="desDepartamentos" class="form-control border border-primary text-primary" cols="12" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="AddDepartamentos" idDepartamento="0" editarDepartamentos="NO">
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
                <h4 class="modal-title" id="myModalLabel33">Formulario Tipo de Empleos </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addFormEmpleo">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <label>Nombre: </label>
                            <div class="form-group">
                                <input type="text" id="nomEmpleo" class="form-control border border-primary text-primary">
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="desEmpleo" class="form-control border border-primary text-primary" cols="12" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" id="AddEmpleos" idEmpleo="0" editarEmpleo="NO">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>