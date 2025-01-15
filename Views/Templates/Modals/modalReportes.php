<!-- Generar reporte -->
<div class="modal fade" id="modalReporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #3A4D39; color:#fff;">
                <h5 class="modal-title"> Consultar Gráficos </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formReporte" name="formReporte" target="_blank">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Fecha inicial: </label>
                            <input type="date" name="txtFechaInicial" id="txtFechaInicial" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtDescripcion">Fecha final: </label>
                            <input type="date" class="form-control" name="txtFechaFinal" id="txtFechaFinal" required></input>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background:#3A4D39; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Generar </span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Cerrar
                </button>
            </div>
            </form>
        </div>
    </div>
</div>