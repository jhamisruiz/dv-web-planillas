<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Asistencias</h5>
            </div>
            <div class="card-body ">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 d-flex ">
                        <div class="form-group">
                            <p>Buscar por DNI </p>
                            <div class="input-group mb-3 rounded border border-primary">
                                <input id="buscarXdni" value='47732559' type="text" class="form-control" onkeyup="buscarEmployDNI()" placeholder="ejem: 8745631" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                <button class="btn btn-primary" onclick="buscarEmployDNI()" type="button" id="button-addon1">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead>
                            <tr>
                                <th class="bg-ligth">DNI</th>
                                <th class="bg-ligth">Nombre</th>
                                <th class="bg-ligth">Apellidos</th>
                                <th class="bg-ligth">Fecha Ingreso</th>
                            </tr>
                        </thead>
                        <tbody id="mostrarEmployAsis" style="cursor:pointer">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="examplePayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Fhecha<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" onclick="onchangeDate(),onchangeDate2()" onblur="onchangeDate2()" onkeyup="onchangeDate2()" id="datetimeStart" class="form-control border border-primary">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center p-0">
                        <div class="">
                            <i id="eliminarasistencia" class="bi bi-trash m-r-5 text-danger d-none" onclick="eliminarasistencia()" style="cursor: pointer;font-size:28px"></i>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Hora Entrada<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" id="timeStar" onkeyup="onchangeDate2()" class="form-control border border-primary">
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="w-100 btn btn-outline-success asistencia" asistencia="ENTRADA" id="entrada">ENTRADA</button>
                                <p id="horaentrada" style="font-size:12px">00:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Hora Salida<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" id="timeStarDos" onkeyup="onchangeDate2()" class="form-control border border-primary">
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="w-100 btn btn-outline-warning asistencia" asistencia="SALIDA" id="salida">SALIDA</button>
                                <p id="horasalida" style="font-size:12px">00:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center pb-3">
                        <button class="w-50 btn btn-outline-danger asistencia" asistencia="FALTA" id="falta">FALTA</button>
                    </div>
                </div>
                <h6>Total de horas: <l id="horastotal">00:00</l>
                </h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>