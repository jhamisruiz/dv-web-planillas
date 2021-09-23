<section class="list-group-button-badge">
    <div class="row match-height">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Configuraciones</h4>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Lista de Amacenes Temporales
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="list-group" id="listAlmacenPermiso">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                CONFIGURACION USUARIOS
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombres</th>
                                                <th scope="col">apellidos</th>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Fcha registro</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Passowrd</th>
                                                <th scope="col">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listadeusuarios">
                                            <?php
                                            $admins = ControllerLogin::listaAdmins();
                                            foreach ($admins as $key => $value) {
                                                $dn = "";
                                                echo '<tr id="idrow' . $value["id"] . '" >
                                        <th scope="row">' . ($key + 1) . '</th>
                                        <td>' . $value['nombres'] . '</td>
                                        <td>' . $value['apellidos'] . '</td>
                                        <td>' . $value['usuario'] . '</td>
                                        <td>' . $value['email'] . '</td>
                                        <td>' . $value['fecha_registro'] . '</td>';
                                                if ($value["id"] == 1) {
                                                    $dn = "d-none";
                                                    echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivaAdmin ' . $dn . '" >Activado</button></td>';
                                                } else {
                                                    if ($value['estado'] == 1) {
                                                        echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivaAdmin" idadmin="' . $value["id"] . '" estadoadmin="0">Activado</button></td>';
                                                    } else {
                                                        echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivaAdmin" idadmin="' . $value["id"] . '" estadoadmin="1">Desactivado</button></td>';
                                                    }
                                                }
                                                echo '<td><button class="btn bg-warning ' . $dn . '" onclick="openreset(' . $value["id"] . ')">Reset Password</button>
                                                </td>
                                                <td class="">
                                                <button onclick="getpermisos(' . $value["id"] . ')" class="btn bg-primary text-white ' . $dn . '">Permisos</button>
                                            <i class="bi bi-trash m-r-5 text-danger ' . $dn . '" style="cursor: pointer;font-size:25px" onclick="eliminarAdmin(' . $value["id"] . ')"></i>
                                        </td>
                                    </tr>
                                    <tr >
                                    <th></th>
                                    </tr>';
                                            }
                                            ?>
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
</section>
<!-- password -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nueva Passowrd:</label>
                        <input type="text" class="form-control" id="passwordA">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Repite Passowrd:</label>
                        <input type="text" class="form-control" id="passwordB">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="idbtnreset" iduser="0">CAMBIAR</button>
            </div>
        </div>
    </div>
</div>
<!-- permisos -->
<div class="modal fade" id="exampleModalPerms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lista de Permisos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox1" value="1"> Dashboard</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox2" value="2"> Contabilidad</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox3" value="3"> Sucursales</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox4" value="4"> Planillas</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox5" value="5"> Asistencias</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox6" value="6"> Almacen</label>
                </div>
                <div class="col-lg-12">
                    <label><input type="checkbox"name="permisos[]" id="cbox7" value="7"> Configuracion</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="svepermisos" iduser="0">GUARDAR</button>
            </div>
        </div>
    </div>
</div>