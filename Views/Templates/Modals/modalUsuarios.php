<!--Agregar usuarios-->
<div class="modal fade" id="modalUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#006179; color:#fff;">
                <h5 class="modal-title" id="staticBackdropLabel"> Create new user </h5>
                <button type="button" style="border-radius: 50%; width: 30px; height: 30px;" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="formUsuario" id="formUsuario">
                    <p class="text-danger">All fields are required</p>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="txtNombres"> Names: </label>
                            <input type="text" class="form-control valid validText" name="txtNombres" id="txtNombres"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidos"> Surnames: </label>
                            <input type="text" class="form-control valid validText" name="txtApellidos"
                                id="txtApellidos" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="txtCorreo"> E-mail: </label>
                            <input type="email" class="form-control valid validEmail" name="txtCorreo" id="txtCorreo"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUsuario"> User: </label>
                            <input class="form-control" name="txtUsuario" id="txtUsuario" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="txtPassword"> Password: </label>
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtPasswordConfirm"> Confirm password: </label>
                            <input type="password" class="form-control" name="txtPasswordConfirm"
                                id="txtPasswordConfirm" required>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="listDepartamento"> Department: </label>
                            <select class="form-control" name="listDepartamento" id="listDepartamento" required>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listTipoRol"> Type of user: </label>
                            <select class="form-control" name="listTipoRol" id="listTipoRol" required>

                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="listStatus"> Status: </label>
                            <select class="form-control" name="listStatus" id="listStatus" required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="num_colaborador"> No. Colaborador: </label>
                            <input type="text" class="form-control" name="num_colaborador" id="num_colaborador"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background:#006179; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            Add
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fas fa-close"></i>
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Ver la informacion del usuario-->
<div class="modal fade" id="modalViewUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #686868; color:#fff">
                <h5 class="modal-title"> User information </h5>
                <button type="button" style="border-radius: 50%; width: 30px; height: 30px;" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>No. Colaborador: </td>
                            <td id="cellColaborador"></td>
                        </tr>
                        <tr>
                            <td>Names: </td>
                            <td id="cellNombres"></td>
                        </tr>
                        <tr>
                            <td>Surnames: </td>
                            <td id="cellApellidos"></td>
                        </tr>
                        <tr>
                            <td>E-mail: </td>
                            <td id="cellCorreo"></td>
                        </tr>
                        <tr>
                            <td>User: </td>
                            <td id="cellUsuario"></td>
                        </tr>
                        <tr>
                            <td>Department: </td>
                            <td id="cellDepartamento"></td>
                        </tr>
                        <tr>
                            <td>Rol: </td>
                            <td id="cellRol"></td>
                        </tr>
                        <tr>
                            <td>Status: </td>
                            <td id="cellStatus"></td>
                        </tr>
                        <tr>
                            <td>Date of creation: </td>
                            <td id="cellDate"></td>
                        </tr>
                        <tr>
                            <td>Creation time: </td>
                            <td id="cellHour"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!--Cambiar la contraseña del usuario-->
<div class="modal fade" id="modalUpdatePass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header" style="background: #006179; color:#fff">
                <h5 class="modal-title">Change user password</h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formUpdatePass" name="formUpdatePass">
                    <input type="hidden" name="idUserPass" id="idUserPass">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtUpdatePassword"> New password </label>
                            <input type="password" name="txtUpdatePassword" id="txtUpdatePassword" class="form-control"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUpdatePasswordConfirm"> Confirm password: </label>
                            <input type="password" name="txtUpdatePasswordConfirm" id="txtUpdatePasswordConfirm"
                                class="form-control" required>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background:#006179; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Change </span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Actualizar informacion usuarios-->
<div class="modal fade" id="modalUpdateUsuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#d59b03; color:#fff;">
                <h5 class="modal-title" id="staticBackdropLabel"> Update information </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="formUsuarioUpdate" id="formUsuarioUpdate">
                    <p class="text-danger">All fields are required</p>

                    <input type="hidden" name="idUsuario" id="idUsuario">

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="txtNombresUpdate"> Names: </label>
                            <input type="text" class="form-control valid validText" name="txtNombresUpdate"
                                id="txtNombresUpdate" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidosUpdate"> Surnames: </label>
                            <input type="text" class="form-control valid validText" name="txtApellidosUpdate"
                                id="txtApellidosUpdate" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="txtCorreoUpdate"> E-mail: </label>
                            <input type="email" class="form-control valid validEmail" name="txtCorreoUpdate"
                                id="txtCorreoUpdate" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtUsuarioUpdate"> User: </label>
                            <input class="form-control" name="txtUsuarioUpdate" id="txtUsuarioUpdate" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="listDepartamentoUpdate"> Department: </label>
                            <select class="form-control" name="listDepartamentoUpdate" id="listDepartamentoUpdate"
                                required>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listTipoRolUpdate"> User type: </label>
                            <select class="form-control" name="listTipoRolUpdate" id="listTipoRolUpdate" required>

                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="listStatusUpdate"> Status: </label>
                            <select class="form-control" name="listStatusUpdate" id="listStatusUpdate" required>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="num_colaboradorUpdate"> No. Colaborador: </label>
                            <input type="text" class="form-control" name="num_colaboradorUpdate" id="num_colaboradorUpdate"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background:#d59b03; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            Update
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fas fa-close"></i>
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>