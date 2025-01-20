<?php
headerAdmin($data);
?>

<div id="layoutSidenav_content">
    <div class="topbar mb-4 shadow bg-white">
        <div class="container">
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

            <!--Contadores-->
            <div class="row">

                <!-- Contador de girs -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #212A3E">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        No. GIR´S
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="girs">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comment-alt fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de girs = SCG -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 10px solid #9BA4B5">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        SCG
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="scg">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-gavel fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de girs = Possible auditor -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #212A3E">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        POSSIBLE AUDITOR
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="posibleAuditor">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-balance-scale fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de usuarios -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Usuarios" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 10px solid #9BA4B5">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        USERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="usuarios">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Nivel de importancia y los contadores de porcentajes -->
                <div class="row d-flex align-items-center">
                    <!-- Gráfica de Nivel de Importancia -->
                    <div class="col-md-8 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"># Level of Importance</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="Nivel" width="400" height="160"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Conteo de niveles -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg py-3 px-4 text-decoration-none text-reset" style="border-left: 5px solid #212A3E; border-radius: 12px;">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Columna 1: Low, Medium, High -->
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-primary">Low</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="LowGirs">0</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-success">Medium</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="MediumGirs">0</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-danger">High</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="HighGirs">0</div>
                                    </div>
                                    <!-- Columna 2: Informative, In Stay, Woow Moment -->
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-info">Informative</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="InformativeGirs">0</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-warning">In Stay</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="InStayGirs">0</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="fs-5 font-weight-bold text-uppercase mb-1 text-muted">Woow Moment</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800" id="WoowMomentGirs">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Graficos (Estado de gir, categoria y tipo de huesped)-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> # Girs Status </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="Estados" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> # Category type </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="Categoria" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> # Type of guest </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="Huesped" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tabla de compensaciones-->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow mb-6">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> # Compensations </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-repsonsive">
                                    <table id="table_Compensacion" class="table table-striped nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Department</th>
                                                <th class="text-center">Total Compensation</th>
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

                    <!--Grafica para determinar la cantidad de dinero al mes por departamento-->
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold"> # Top 5 compensation by department </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="CalculoCompensacion" width="400" height="300"></canvas>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="mb-2"> Start date: </label>
                                        <input onchange="FiltroCompensacion()" type="date" name="startDate1" id="startDate1" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-2"> End date: </label>
                                        <input onchange="FiltroCompensacion()" type="date" name="endDate1" id="endDate1" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    </main>
    <?php
    footerAdmin($data);
    ?>