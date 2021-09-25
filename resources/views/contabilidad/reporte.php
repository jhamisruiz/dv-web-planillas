<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <input type="hidden" id="iddnone" value="d-none">
                    <label>Buscar por Mes<span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input type="text" id="dateStart" onblur="searchingreso()" onkeyup="searchingreso()" class="form-control border border-primary">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-end align-items-center">
                <div class="d-flex justify-content-center mr-3">
                    <div class="text-center">
                        <h3 class="p-0 m-0">Total de Ingresos</h3>
                        <p class="p-0 m-0">s/.<stron id="idtotalingresos">0.00</stron>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <button onclick="exelreportesConta()" host="<?= URL_HOST_WEB ?>" mes="" class="btn bg-success text-white">EXEL</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header collapsed" id="flush-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <h5 class="text-success p-0 m-0">HISTORIAL INGRESOS</h5>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-primary text-white">#</th>
                                                        <th class="bg-primary text-white">Tipo</th>
                                                        <th class="bg-primary text-white">Categ. Ingreso</th>
                                                        <th class="bg-primary  text-white">Descripcion</th>
                                                        <th class="bg-primary text-white">Documento</th>
                                                        <th class="bg-primary text-white">Caantidad</th>
                                                        <th class="bg-primary text-center text-white">Fecha-Registro</th>
                                                        <th class="bg-primary text-center text-white">Observacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="mostraringreso">
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
                                <h5 class="text-danger p-0 m-0">HISTORIAL DE GASTOS</h5>
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-primary text-white">#</th>
                                                        <th class="bg-primary text-white">Tipo</th>
                                                        <th class="bg-primary text-white">Categ. Gasto</th>
                                                        <th class="bg-primary  text-white">Descripcion</th>
                                                        <th class="bg-primary text-white">Documento</th>
                                                        <th class="bg-primary text-white">Caantidad</th>
                                                        <th class="bg-primary text-center text-white">Fecha-Registro</th>
                                                        <th class="bg-primary text-center text-white">Observacion</th>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>