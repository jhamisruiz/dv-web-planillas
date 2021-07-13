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
                        <input type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Usario</th>
                                <th class="bg-primary text-white">Enviado por:</th>
                                <th class="bg-primary text-white">Recibido por:</th>
                                <th class="bg-primary text-center text-white">Status</th>
                                <th class="bg-primary text-white" style="max-width: 50px;">Action</th>
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

<!--Add Categorias -->
<div class="modal fade" id="inlineForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Nuevo Movimiento </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="pl-3 pr-3 pt-3">
                <form method="post" action="/form" autocomplete="off" id="addFormAlmacen">
                    <div class="row">
                        
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Enviado por: <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="region">
                                    <option>Seleccione</option>
                                    <?php
                                    $almacenP = ControllerMovimientos::SELECTALL();
                                    var_dump($almacenP);
                                    foreach ($almacenP as $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="list-group">
                                  <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                                    Productos para enviar
                                  </button>
                                  <button type="button" class="list-group-item list-group-item-action">A second item</button>
                                  <button type="button" class="list-group-item list-group-item-action">A third button item</button>
                                  <button type="button" class="list-group-item list-group-item-action">A fourth button item</button>
                                  <button type="button" class="list-group-item list-group-item-action" disabled>A disabled button item</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Recibido por: <span class="text-danger">*</span></label>
                                <select name="" class="form-control border border-primary" id="region">
                                    <option>Seleccione</option>
                                    <?php
                                    $almacenP = ControllerMovimientos::SELECTALL();
                                    var_dump($almacenP);
                                    foreach ($almacenP as $value) {

                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                             <div class="form-group">
                                <div class="list-group">
                                  <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                                    Productos por recibir
                                  </button>
                                  <button type="button" class="list-group-item list-group-item-action">
                                        <div class="row "> 
                                            <div class="col-9 ">A second item</div>
                                            <div class="col-3 "><input type="text" class="form-control"  aria-label="Recipient's username" aria-describedby="button-addon2"></div>
                                        </div>                                        
                                </button>
                                <button type="button" class="list-group-item list-group-item-action">
                                        <div class="row "> 
                                            <div class="col-9 ">A second item</div>
                                            <div class="col-3 "><input type="text" class="form-control"  aria-label="Recipient's username" aria-describedby="button-addon2"></div>
                                        </div>                                        
                                </button>
                                <button type="button" class="list-group-item list-group-item-action">
                                        <div class="row "> 
                                            <div class="col-9 ">A second item</div>
                                            <div class="col-3 "><input type="text" class="form-control"  aria-label="Recipient's username" aria-describedby="button-addon2"></div>
                                        </div>                                        
                                </button>
                                  
                                </div>
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
                            <span class="d-none d-sm-block" id="btnGuardarAlmacen">Enviar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

