<style>
    .wrap-content {
        max-width: 200px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        text-align: justify;
    }
</style>

<!--Agregar Girs-->
<div class="modal fade" id="modalGirs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background:#005e75; color:#fff;">
                <h5 class="modal-title" id="staticBackdropLabel"> Create new GIR </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none;"
                    data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                <form class="form-horizontal" name="formGirs" id="formGirs">
                    <p class="text-danger">All fields are required</p>

                    <div class="container">
                        <div class="row mb-2">
                            <div class="form-group col-md-4">
                                <label for="listClasificacionNombre"> Classification: </label>
                                <input class="form-control" type="text" name="listClasificacionNombre"
                                    id="listClasificacionNombre" readonly required>
                            </div>
                            <input type="hidden" name="listClasificacion" id="listClasificacion" required>

                            <div class="form-group col-md-4">
                                <label for="compensacion"> Compensation: </label>
                                <input type="text" name="compensacion" id="compensacion" class="form-control"
                                    placeholder="Amount of expense $">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="form-group col-md-3">
                                <label for="txtFecha"> Date: </label>
                                <input type="datetime-local" class="form-control" name="txtFecha" id="txtFecha"
                                    required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="txtApellidos"> Surnames: </label>
                                <input type="text" class="form-control valid validText" name="txtApellidos"
                                    id="txtApellidos" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listVilla"> Villa: </label>
                                <select class="form-control" name="listVilla" id="listVilla" required>
                                    <?php
                                    //definor los rangos de valores
                                    $rangos = array(array(101, 112), array(200, 212), array(301, 311), array(401, 419), array(501, 526), array(601, 630), array(701, 708), array(801, 813), array(901, 941));

                                    // Agregar "External" como la primera opción
                                    echo "<option value='External'>External</option>";
                                    //Agregar suites conectadas
                                    echo "<option value='901A'>901A</option>";
                                    echo "<option value='905A'>905A</option>";
                                    echo "<option value='902A'>902A</option>";
                                    echo "<option value='906A'>906A</option>";
                                    echo "<option value='Several'>Several</option>";
                                    //iteramos sobre los rangos y generar las opciones
                                    foreach ($rangos as $rango) {
                                        list($inicio, $fin) = $rango;
                                        for ($i = $inicio; $i <= $fin; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="txtEntrada"> Check-In: </label>
                                <input type="date" class="form-control" name="txtEntrada" id="txtEntrada" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-3">
                                <label for="txtSalida"> Check-Out: </label>
                                <input type="date" class="form-control" name="txtSalida" id="txtSalida" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listEstado"> Status of gir: </label>
                                <select class="form-control" name="listEstado" id="listEstado" required>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listNivel"> Level of importance: </label>
                                <select class="form-control" name="listNivel" id="listNivel" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="In stay">In stay</option>
                                    <option value="Informative">Informative</option>
                                    <option value="Wow moment">Wow moment</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listCategoria"> Service/Product/Informative: </label>
                                <select class="form-control" name="listCategoria" id="listCategoria" required>
                                    <option value="Service"> Service </option>
                                    <option value="Product"> Product </option>
                                    <option value="Informative"> Informative </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-3">
                                <label for="listTipo"> Type of guest: </label>
                                <select class="form-control" name="listTipo" id="listTipo" required>
                                    <option value="Due Out">Due Out</option>
                                    <option value="In house">In house</option>
                                    <option value="Special Care Guest">Special Care Guest</option>
                                    <option value="Possible auditor">Possible auditor</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listQueja"> Opportunity: </label>
                                <select class="form-control" name="listQueja" id="listQueja" required>
                                    <!--Opciones desde ajax-->
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listLugar"> Place of Opportunity: </label>
                                <select class="form-control" name="listLugar" id="listLugar" required>
                                    <!--Opciones desde ajax-->
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="listDepartamento"> Department: </label>
                                <select class="form-control" name="listDepartamento" id="listDepartamento" required>
                                    <!--opciones desde ajax-->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-4">
                                <label for="txtDescripcion"> Description: </label>
                                <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" cols="30"
                                    rows="5" required></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtAccion"> Action taken: </label>
                                <textarea class="form-control" name="txtAccion" id="txtAccion" cols="30" rows="5"
                                    required></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtSeguimiento"> Follow-up: </label>
                                <textarea class="form-control" name="txtSeguimiento" id="txtSeguimiento" cols="30"
                                    rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="form-group col-md-5">
                                <div class="card-body">
                                    <label for="imagen" id="icon-image" class="btn mb-3"
                                        style="background:#006179; color:#fff">
                                        <i class="fas fa-image"></i>
                                        <input type="file" class="d-none" name="imagen" id="imagen"
                                            onchange="previsualizarImagen(event)">
                                    </label>
                                    <span id="icon-cerrar"></span>
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="" alt="Previsualización de imagen" id="imagen-preview"
                                                style="max-width: 70%; display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background:#006179; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            Add
                        </button>
                        <button type="button" class="btn" style="background-color: #800000; color:#ffffff"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Visualizar informacion de gir-->
<div class="modal fade" id="modalViewGir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #005e75; color:#fff">
                <h5 class="modal-title">General information about GIR</h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none;"
                    data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered border-dark " style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Classification:</td>
                                    <td style="font-weight: bold;" id="cellClasificacion"></td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td style="font-weight: bold;" id="cellFecha"></td>
                                </tr>
                                <tr>
                                    <td>Hour:</td>
                                    <td style="font-weight: bold;" id="cellHora"></td>
                                </tr>
                                <tr>
                                    <td>Surnames:</td>
                                    <td style="font-weight: bold;" id="cellApellidos"></td>
                                </tr>
                                <tr>
                                    <td>Villa:</td>
                                    <td style="font-weight: bold;" id="cellVilla"></td>
                                </tr>
                                <tr>
                                    <td>Check-In:</td>
                                    <td style="font-weight: bold;" id="cellEntrada"></td>
                                </tr>
                                <tr>
                                    <td>Check-Out:</td>
                                    <td style="font-weight: bold;" id="cellSalida"></td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td style="font-weight: bold;" id="cellEstado"></td>
                                </tr>
                                <tr>
                                    <td>Level:</td>
                                    <td style="font-weight: bold;" id="cellNivel"></td>
                                </tr>
                                <tr>
                                    <td>Category:</td>
                                    <td style="font-weight: bold;" id="cellCategoria"></td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td style="font-weight: bold;" id="cellTipo"></td>
                                </tr>
                                <tr>
                                    <td>Opportunity:</td>
                                    <td style="font-weight: bold;" id="cellQueja"></td>
                                </tr>
                                <tr>
                                    <td>Place of opportunity:</td>
                                    <td style="font-weight: bold;" id="cellLugar"></td>
                                </tr>
                                <tr>
                                    <td>Department:</td>
                                    <td style="font-weight: bold;" id="cellDepartamento"></td>
                                </tr>
                                <tr>
                                    <td>Description:</td>
                                    <td id="cellDescripcion" class="wrap-content" style="font-weight: bold;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered border-dark" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Action taken:</td>
                                    <td id="cellAccion" class="wrap-content" style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <td>Follow-up:</td>
                                    <td id="cellSeguimiento" class="wrap-content" style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <td>Date and time of creation:</td>
                                    <td style="font-weight: bold;" id="cellFechaCreacion"></td>
                                </tr>
                                <tr>
                                    <td>Creator of gir:</td>
                                    <td style="font-weight: bold;" id="cellCreador"></td>
                                </tr>
                                <tr>
                                    <td>Date and time of last edition:</td>
                                    <td style="font-weight: bold;" id="cellFechaEdicion"></td>
                                </tr>
                                <tr>
                                    <td>Editor of gir:</td>
                                    <td style="font-weight: bold;" id="cellEditor"></td>
                                </tr>
                                <tr>
                                    <td>Compensation:</td>
                                    <td style="font-weight: bold;" id="cellCompensacion"></td>
                                </tr>
                                <tr>
                                    <td>Photography:</td>
                                    <td><img id="cellImagen" style="width:200px; height: 200px;" src="" alt="Imagen">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #800000; color:#ffffff"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!--Editar Girs-->
<div class="modal fade" id="modalGirsUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background:#005e75; color:#fff;">
                <h5 class="modal-title" id="staticBackdropLabel"> Update information </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px; border:none;"
                    data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="formGirsUpdate" id="formGirsUpdate" enctype="multipart/form-data">
                    <p class="text-danger">All fields are required</p>

                    <input type="hidden" name="idGir" id="idGir">

                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="nombreClasificacionUpdate">Classification:</label>
                            <input class="form-control" type="text" id="nombreClasificacionUpdate" readonly>
                        </div>
                        <!-- Campo oculto que guarda el ID de la clasificación -->
                        <input type="hidden" name="listClasificacionUpdate" id="listClasificacionUpdate">
                        <div class="form-group col-md-4">
                            <label for="compensacionUpdate"> Compensation: </label>
                            <input type="text" name="compensacionUpdate" id="compensacionUpdate" class="form-control"
                                placeholder="Amount of expense $">
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-2">
                        <div class="form-group col-md-3">
                            <label for="txtFechaUpdate"> Date: </label>
                            <input type="datetime-local" class="form-control" name="txtFechaUpdate" id="txtFechaUpdate"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtApellidosUpdate"> Surnames: </label>
                            <input type="text" class="form-control valid validText" name="txtApellidosUpdate"
                                id="txtApellidosUpdate" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listVillaUpdate"> Villa: </label>
                            <select class="form-control" name="listVillaUpdate" id="listVillaUpdate" required>
                                <?php
                                //definor los rangos de valores
                                $rangos = array(array(101, 112), array(200, 213), array(301, 312), array(401, 419), array(501, 526), array(601, 630), array(701, 712), array(801, 813), array(901, 942));
                                //Imprimimos la palabra como primera opcion
                                echo "<option value='External'>External</option>";
                                //Agregar suites conectadas
                                echo "<option value='901A'>901A</option>";
                                echo "<option value='905A'>905A</option>";
                                echo "<option value='902A'>902A</option>";
                                echo "<option value='906A'>906A</option>";
                                echo "<option value='Several'>Several</option>";
                                //iteramos sobre los rangos y generar las opciones
                                foreach ($rangos as $rango) {
                                    list($inicio, $fin) = $rango;
                                    for ($i = $inicio; $i <= $fin; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="txtEntradaUpdate"> Check-In: </label>
                            <input type="date" class="form-control" name="txtEntradaUpdate" id="txtEntradaUpdate"
                                required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-md-3">
                            <label for="txtSalidaUpdate"> Check-Out: </label>
                            <input type="date" class="form-control" name="txtSalidaUpdate" id="txtSalidaUpdate"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listEstadoUpdate"> Status of gir: </label>
                            <select class="form-control" name="listEstadoUpdate" id="listEstadoUpdate" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listNivelUpdate"> Level of importance </label>
                            <select class="form-control" name="listNivelUpdate" id="listNivelUpdate" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="In stay">In stay</option>
                                <option value="Informative">Informative</option>
                                <option value="Wow moment">Wow moment</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listCategoriaUpdate"> Service/Product/Informative: </label>
                            <select class="form-control" name="listCategoriaUpdate" id="listCategoriaUpdate" required>
                                <option value="Service">Service</option>
                                <option value="Product">Product</option>
                                <option value="Informative">Informative</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-md-3">
                            <label for="listTipoUpdate"> Type of guest: </label>
                            <select class="form-control" name="listTipoUpdate" id="listTipoUpdate" required>
                                <option value="Due Out">Due Out</option>
                                <option value="In house">In house</option>
                                <option value="Special Care Guest">Special Care Guest</option>
                                <option value="Possible auditor">Possible auditor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listQuejaUpdate"> Opportunity: </label>
                            <select class="form-control" name="listQuejaUpdate" id="listQuejaUpdate" required>
                                <!--Opciones desde ajax-->
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listLugarUpdate"> Place of Opportunity: </label>
                            <select class="form-control" name="listLugarUpdate" id="listLugarUpdate" required>
                                <!--Opciones desde ajax-->
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="listDepartamentoUpdate"> Department: </label>
                            <select class="form-control" name="listDepartamentoUpdate" id="listDepartamentoUpdate"
                                required>
                                <!--opciones desde ajax-->
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="txtDescripcionUpdate"> Description: </label>
                            <textarea class="form-control" name="txtDescripcionUpdate" id="txtDescripcionUpdate"
                                cols="30" rows="5" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtAccionUpdate"> Action taken: </label>
                            <textarea class="form-control" name="txtAccionUpdate" id="txtAccionUpdate" cols="30"
                                rows="5" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtSeguimientoUpdate"> Follow-up: </label>
                            <textarea class="form-control" name="txtSeguimientoUpdate" id="txtSeguimientoUpdate"
                                cols="30" rows="5" required></textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-md-5">
                            <div class="card-body">
                                <label for="imagenUpdate" id="icon-imageU" class="btn mb-3"
                                    style="background:#3A4D39; color:#fff">
                                    <i class="fas fa-image"></i>
                                    <input type="file" class="d-none" name="imagenUpdate" id="imagenUpdate"
                                        onchange="previsualizarImagen(event)">
                                    <input type="hidden" name="foto_actual" id="foto_actual">
                                    <input type="hidden" name="foto_delete" id="foto_delete">
                                    <input type="hidden" name="foto_nueva" id="foto_nueva">

                                </label>
                                <span id="icon-cerrarU"></span>
                                <div class="card">
                                    <div class="card-body">
                                        <img src="" alt="" id="imagen-previewU" style="max-width: 70%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background:#005e75; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            Update
                        </button>
                        <button type="button" class="btn" style="background-color: #800000; color:#ffffff"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Reporte por filtro de fecha-->
<div class="modal fade" id="modalReporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #575757; color:#fff;">
                <h5 class="modal-title"> Generate report by data range </h5>
                <button type="button" class="btn-close btn-dark " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="formReporte" name="formReporte" target="_blank">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Start date: </label>
                            <input type="date" name="txtFechaInicial" id="txtFechaInicial" class="form-control"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtDescripcion">End date: </label>
                            <input type="date" class="form-control" name="txtFechaFinal" id="txtFechaFinal"
                                required></input>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn" style="background: #575757; color:#fff;">
                    <i class="fas fa-fw fa-check-circle"></i>
                    <span> Generate </span>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="fas fa-fw fa-times-circle"></i>
                    Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para ver el historial de seguimientos -->
<div class="modal fade" id="historialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header text-white" style="background:#005e75;">
                <h5 class="modal-title">History (description, follow-up and actions)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="border-radius:50%; width:30px; height:30px;"></button>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body p-3" style="max-height: 550px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle shadow-sm">
                        <thead style="background-color: #005e75;">
                            <tr>
                                <th scope="col" class="text-white fw-semibold fs-5 text-center">Description</th>
                                <th scope="col" class="text-white fw-semibold fs-5 text-center">Action Taken</th>
                                <th scope="col" class="text-white fw-semibold fs-5 text-center">Follow-Up</th>
                            </tr>
                        </thead>
                        <tbody id="historial_table_body">
                            <!-- Contenido dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn text-white" style="background-color: #800000;" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>