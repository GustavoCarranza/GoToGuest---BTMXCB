<!--Editar informacion del perfil-->
<div class="modal fade" id="modalPerfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #006179; color:#fff;">
                <h5 class="modal-title"> Edit profile information </h5>
                <button type="button" style="border-radius: 50%; width: 30px; height: 30px; border:none;" data-bs-dismiss="modal" aria-label="Close">X</button>

            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formPerfil" name="formPerfil">
                    <p class="text-danger">All fields are required</p>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="txtNombreUpdate">Names: </label>
                            <input type="text" name="txtNombresUpdate" id="txtNombresUpdate" class="form-control valid validText" value="<?= $_SESSION['UserData']['nombres'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="txtApellidosUpdate">Surnames: </label>
                            <input type="text" name="txtApellidosUpdate" id="txtApellidosUpdate" class="form-control valid validText" value="<?= $_SESSION['UserData']['apellidos'] ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="txtCorreoUpdate">E-mail: </label>
                            <input type="email" name="txtCorreoUpdate" id="txtCorreoUpdate" class="form-control valid validEmail" value="<?= $_SESSION['UserData']['email'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group">
                            <label for="txtUsuarioUpdate">User: </label>
                            <input type="text" name="txtUsuarioUpdate" id="txtUsuarioUpdate" class="form-control" value="<?= $_SESSION['UserData']['usuario'] ?>" required>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #006179; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Update </span>
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