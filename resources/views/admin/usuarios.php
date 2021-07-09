<div class="content">

    <div class="row">
        <div class="col-sm-8 col-8">
            <h4 class="page-title">Lista de Usuarios</h4>
        </div>
    </div>
    <div class="row d-flex flex-wrap-reverse">
        <div class="col-lg-5">
            <div class="form-group form-focus">
                <label class="focus-label">Buscar...</label>
                <input type="text" class="form-control floating">
            </div>
        </div>
        <div class="col-lg-6 text-right mb-2">
            <a href="#" class="btn btn-primary float-right btn-rounded" data-toggle="modal" data-target="#addUsser">
                <i class="fa fa-plus"></i> Add Employee</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="loadForm">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table datatable mb-0" id="loadForm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usuarios = CtrUsuarios::SELECT();
                                foreach ($usuarios as $key => $value) {
                                    echo '<tr>
                                    <td>' . ($key + 1) . '</td>
                                    <td>
                                        <img width="28" height="28" src="public/assets/img/user.jpg" class="rounded-circle m-r-5" alt="">
                                         <h2>' . $value["nombre"] . ' ' . $value["apellido"] . '</h2>
                                    </td>
                                    <td>' . $value["usuario"] . '</td>
                                    <td>' . $value["email"] . '</td>';
                                    if ($value["estado"] != 0) {

                                        echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivarUsuarios" idusuarios="' . $value["idUser"] . '" estadousuarios="0">Activado</button></td>';
                                    } else {

                                        echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivarUsuarios" idusuarios="' . $value["idUser"] . '" estadousuarios="1">Desactivado</button></td>';
                                    }
                                    echo '<td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-patient.html"><i class="fa fa-pencil m-r-5 text-success"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-trash-o m-r-5 text-danger"></i> Delete</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_patient ">
                                                <i class="fa fa-times-circle text-primary"></i> Ress Password</a>
                                        </div>
                                    </div>
                                </td>
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
<div id="delete_patient" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="public/assets/img/sent.png" alt="" width="50" height="46">
                <h3>Are you sure want to delete this Patient?</h3>
                <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ADD USSER -->
<div class="modal fade" id="addUsser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title ">Add Usuarios</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="col-lg-10 offset-lg-1 pt-3">
                <form method="post" action="/form" autocomplete="off" id="addFormUsuarios">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nombres </label>
                                <input class="form-control" name="addUsers" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Apellidos </label>
                                <input class="form-control" name="addUsers" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Usuario <span class="text-danger">*</span></label>
                                <input class="form-control" name="addUsers" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>email <span class="text-danger">*</span></label>
                                <input class="form-control" name="addUsers" type="email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input class="form-control" name="addUsers" type="password" id="password">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <input class="form-control" onkeyup="Password()" name="addUsers" type="password" id="rpassword">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-primary addUsuarios">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
            </div>

        </div>
    </div>
</div>