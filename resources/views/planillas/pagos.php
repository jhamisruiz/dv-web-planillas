<div class="page-heading">
    <section class="section">
        <div class="row pl-2">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Desde <span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input type="text" id="datetimeStart" onblur="asisEmployDNI()" onkeyup="asisEmployDNI()" class="form-control border border-primary">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Hasta <span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input type="text" id="datetimeEnd" onblur="asisEmployDNI()" onkeyup="asisEmployDNI()" class="form-control border border-primary">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex ">
                <div class="form-group">
                    <label>Buscar por DNI<span class="text-danger">*</span></label>
                    <div class="input-group mb-3 rounded border border-primary">
                        <input id="buscarXdni" type="text" class="form-control" onkeyup="asisEmployDNI()" placeholder="ejem: 8745631" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <button class="btn btn-primary" onclick="asisEmployDNI()" type="button" id="button-addon1">Buscar</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex d-flex justify-content-center">
                <div class="card-header">
                    <button type="button" id="btncalcularp" onclick="calcularPago()" class="btn bg-primary text-white d-none">
                        <i style="font-size:20px" class="fas fa-funnel-dollar mr-2"></i>
                        Calcular Pago
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <tbody id="idemploye">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header collapsed" id="flush-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <h5 class="text-danger p-0 m-0">HISTORIAL DE FALTAS</h5>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover border border-danger">
                                                <tbody id="idfaltas">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                <h5 class="text-success p-0 m-0">HISTORIAL DE ASISTENCIAS</h5>
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover border border-success">
                                                <tbody id="idasistencias">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h5 class="text-success p-0 m-0">HISTORIAL DE PAGOS</h5>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover border border-primary">
                                                <tbody id="idhistorialpago">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Add calcular pago -->
<div class="modal fade text-left" id="calcularModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulario</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="#" id="addFormCategorias">
                <div class="modal-body">
                    <div class="row pl-4 pr-4">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>Remuneración s/.</label>
                                    <div class="form-group d-flex align-items-center">
                                        <button id="idnutonfin" type="button" onclick="remuneraFin(-10,0)" class="btn bg-primary text-white" disabled>-</button>
                                        <input id="idremunera" class="form-control border border-primary text-primary" type="number" min="0.00" step="0.010" value="0.00">
                                        <button type="button" onclick="remuneraFin(10,1)" class="btn bg-primary text-white">+</button>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Salario mensaual s/.</label>
                                    <div class="form-group d-flex align-items-center">
                                        <input type="text" id="idsalario" class="form-control border border-primary text-primary" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div id='idrespuestacal'>
                                        <label>Costo h. s/.<strong>
                                                <l id="idcostohora">0.00</l>
                                            </strong>
                                            x<strong>
                                                <l id="idhstrabaja">00:00</l>
                                            </strong>Horas T.
                                        </label>
                                    </div>
                                    <label>Monto total s/. </label>
                                    <div class="form-group d-flex align-items-center">
                                        <button id="idnutonsal" type="button" onclick="salarioFin(-10)" class="ml-2 btn bg-primary text-white">-</button>
                                        <input id="idpagomes" class="form-control border border-primary text-primary" type="number" min="0.00" step="0.010" value="0.00">
                                        <button type="button" onclick="salarioFin(10)" class="btn bg-primary text-white">+</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    <label><input type="checkbox" name="" id="iddominical"> Dominical</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="" id="comentario" class="form-control border border-primary text-primary" cols="12" rows="2" placeholder="Comentario..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-success" id="Addpagos" idpago="0" editar="NO">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>