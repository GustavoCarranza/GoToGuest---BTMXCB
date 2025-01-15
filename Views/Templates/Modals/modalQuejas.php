<!--Agregar quejas-->
<div class="modal fade" id="modalQuejas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #006179; color:#fff;">
                <h5 class="modal-title"> New Opportunity </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none;" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formQuejas" name="formQuejas">
                    <p class="text-danger">All fields are required</p>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="txtNombre">Name: </label>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="txtDescripcion">Description: </label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Opportunity description" required></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="listStatus">Status: </label>
                            <select name="listStatus" id="listStatus" class="form-control">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #006179; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Add </span>
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

<!--Editar quejas-->
<div class="modal fade" id="modalUpdateQuejas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #d59b03; color:#fff;">
                <h5 class="modal-title"> Update information </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none;" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formQuejasUpdate" name="formQuejasUpdate">
                    <p class="text-danger">All fields are required</p>

                    <input type="hidden" name="idQueja" id="idQueja" required>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="txtNombreUpdate">Name: </label>
                            <input type="text" name="txtNombreUpdate" id="txtNombreUpdate" class="form-control valid validText" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="txtDescripcionUpdate">Description: </label>
                            <textarea class="form-control" id="txtDescripcionUpdate" name="txtDescripcionUpdate" rows="2" placeholder="Opportunity description" required></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="control-label" for="listStatusUpdate">Status: </label>
                            <select name="listStatusUpdate" id="listStatusUpdate" class="form-control">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #d59b03; color:#fff;">
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