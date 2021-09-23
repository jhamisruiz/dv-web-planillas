<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Reportes de Pagos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Buscar por Mes<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" id="dateStart" onblur="searchMes()" onkeyup="searchMes()" class="form-control border border-primary">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-end align-items-center">
                        <div class="form-group">
                            <button onclick="exelreportes()" host="<?=URL_HOST_WEB?>" mes="" class="btn bg-success text-white">EXEL</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Nombres</th>
                                <th class="bg-primary text-white">Apellidos</th>
                                <th class="bg-primary text-white">DNI</th>
                                <th class="bg-primary text-white">Fecha</th>
                                <th class="bg-primary text-white">Salario.</th>
                                <th class="bg-primary text-white">H. trabajadas</th>
                                <th class="bg-primary text-white">Costo hora.</th>
                                <th class="bg-primary text-white">M. pagado</th>
                                <th class="bg-primary text-white">Bono</th>
                                <th class="bg-primary text-white">Comentario</th>
                            </tr>
                        </thead>
                        <tbody id="verhistorypagos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>