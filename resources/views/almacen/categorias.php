<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Categorias</h5>
                <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Categoria</button>
            </div>
            <div class="card-body">
                <div class="row col-lg-4">
                    <div class="input-group mb-3 border border-primary rounded p-0">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Nombre</th>
                                <th class="bg-primary text-white">Descripción</th>
                                <th class="bg-primary text-center text-white">Status</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarCategorias">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>

<!--Add Categorias -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Nueva Categorias </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addFormCategorias">
                <div class="modal-body">
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <label>Nombre: </label>
                            <div class="form-group">
                                <input type="text" id="nomCategoria" placeholder="Nombre categoria" class="form-control">
                            </div>
                            <label>Descripción: </label>
                            <div class="form-group">
                                <textarea name="" id="desCategoria" class="form-control" cols="12" rows="3" placeholder="Descrip. categoria"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 AddCategoria">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>