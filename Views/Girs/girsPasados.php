<?php
headerAdmin($data);
getModal('modalGirs', $data);
?>
<div id="layoutSidenav_content">
    <div class="topbar mb-4 shadow bg-white">
        <div class="container-xl ">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-content-center">
                    <div class="ml-4 text-center">
                        <h2 class="mt-2"><?= $data['page_main'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>

        <div class="container-fluid px-4">
            <!--CONTENIDO-->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center ">
                    <i class="fas fa-table dance-icon"></i>
                </div>

                <div class="card-header d-flex flex-wrap align-items-center gap-3 p-3">
                    <!-- Filtros -->
                    <label class="form-label fw-bold fs-6 mb-0 me-2">Filter by:</label>

                    <select class="form-select w-auto" id="filter-type">
                        <option value="default">Select Guest Type</option>
                        <option value="Due Out">Due Out</option>
                        <option value="In house">In house</option>
                        <option value="Special Care Guest">Special Care Guest</option>
                        <option value="Possible auditor">Possible auditor</option>
                    </select>

                    <select class="form-select w-auto" id="filter-category">
                        <option value="default">Select Classification</option>
                        <option value="Cleanliness & Condition">Cleanliness & Condition</option>
                        <option value="Courtesy">Courtesy</option>
                        <option value="Efficiency">Efficiency</option>
                        <option value="Food & Beverage Quality">Food & Beverage Quality</option>
                    </select>

                    <select class="form-select w-auto" id="filter-villa">
                        <?php
                        //definor los rangos de valores
                        $rangos = array(array(101, 112), array(200, 212), array(301, 311), array(401, 419), array(501, 526), array(601, 630), array(701, 708), array(801, 813), array(901, 941));

                        // Agregar "External" como la primera opción
                        echo " <option value='default'>Select Villa</option>";
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

                    <select class="form-select w-auto" id="filter-priority">
                        <option value="default">Select Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="In stay">In stay</option>
                        <option value="Informative">Informative</option>
                        <option value="Wow moment">Wow moment</option>
                    </select>

                    <select class="form-select w-auto" id="filter-department">
                        <!--Opciones cargadas desde Js-->
                    </select>

                    <select class="form-select w-auto" id="filter-oportunity">
                        <!--Quejas cargadas desde js-->
                    </select>

                </div>

                <div class=" d-flex flex-wrap justify-content-center align-items-center gap-3 mt-3">
                    <label class="form-label fw-bold fs-6 mb-0 me-2">Filter by date created</label>
                    <input class="form-control w-auto" type="date" id="filter-creation">
                    <label class="form-label fw-bold fs-6 mb-0 me-2">Filter by Check-in</label>
                    <input class="form-control w-auto" type="date" id="filter-entrada">
                    <label class="form-label fw-bold fs-6 mb-0 me-2">Filter by Check-out</label>
                    <input class="form-control w-auto" type="date" id="filter-salida">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_girs" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Opportunity</th>
                                    <th class="text-center">Clasificacion</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Hour</th>
                                    <th class="text-center">Surnames</th>
                                    <th class="text-center">Villa</th>
                                    <th class="text-center">CheckIn</th>
                                    <th class="text-center">CheckOut</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Level</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Compensacion</th>
                                    <th class="text-center">Photo</th>
                                    <th class="text-center">Actions</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Action Taken</th>
                                    <th class="text-center">Follow-up</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Datos cargados a través de ajax-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <?php
    footerAdmin($data);
    ?>