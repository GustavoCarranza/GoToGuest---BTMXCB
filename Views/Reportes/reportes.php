<?php
headerAdmin($data);
getModal('modalReportes', $data);
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

            <!--Filtro de fecha para los graficos-->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="mb-2"> Start date: </label>
                    <input onchange="Filtro()" type="date" name="startDate" id="startDate" class="form-control">
                </div>
                <div class="col-md-6 mb-4">
                    <label class="mb-2"> End date: </label>
                    <input onchange="Filtro()" type="date" name="endDate" id="endDate" class="form-control">
                </div>
            </div>

            <!--Clasificaciones-->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> # Classifications </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="ClasificacionOne" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> # Classifications </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="ClasificacionTwo" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <!-- bloque 1 -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> Top 5 most frequent opportunities </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="QuejasDiarias" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> Top 5 opportunities by department </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="QuejasxDepartamento" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!--fin-->

            <!-- bloque 2 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> Type of guest </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="TipoHuesped" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> Opportunity location with more incidents </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="Lugares" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"> Top 5 departments with the most opportunities </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="DepartamentosQuejas" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!--Fin-->

                <!-- bloque 3 -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> Total opportunities by departament </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="QuejasporDepartamento" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin-->

            </div>
    </main>
    <?php
    footerAdmin($data);
    ?>