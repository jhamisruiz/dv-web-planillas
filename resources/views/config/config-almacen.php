<section class="list-group-button-badge">
    <div class="row match-height">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lista de Amacenes Temporales</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="list-group" id="listAlmacenPermiso">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <button class="btn btn-success">
                        <h4 class="card-title text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop">ACTIVA USUARIOS</h4>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ACTIVA USUARIOS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="listadeusuarios">
                                <?php
                                $admins = ControllerLogin::listaAdmins();
                                foreach ($admins as $key => $value) {
                                    $dn="";
                                    echo '<tr id="idrow'.$value["id"].'">
                                        <th scope="row">' . ($key + 1) . '</th>
                                        <td>' . $value['nombres'] . '</td>
                                        <td>' . $value['apellidos'] . '</td>
                                        <td>' . $value['usuario'] . '</td>
                                        <td>' . $value['email'] . '</td>
                                        <td>' . $value['fecha_registro'] . '</td>';

                                        if ($value["id"]==1) {
                                            $dn = "d-none";
                                            echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivaAdmin" >Activado</button></td>';
                                        } else {
                                            if ($value['estado'] == 1) {
                                                echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivaAdmin" idadmin="' . $value["id"] . '" estadoadmin="0">Activado</button></td>';
                                            } else {
                                                echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivaAdmin" idadmin="' . $value["id"] . '" estadoadmin="1">Desactivado</button></td>';
                                            }
                                        }
                                        
                                        
                                        echo '<td class="text-right">
                                            <i class="bi bi-trash m-r-5 text-danger '.$dn. '" style="cursor: pointer;font-size:25px" onclick="eliminarAdmin(' . $value["id"] . ')"></i>
                                        </td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>