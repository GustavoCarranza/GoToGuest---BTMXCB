<?php
headerAdmin($data);
?>

<div id="layoutSidenav_content">
    <div class="topbar mb-4 shadow bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <div class="ml-4 text-center">
                        <h2 class="mt-2 fw-bold"><?= $data['page_main'] ?></h2>
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
                    <a href="<?= base_url(); ?>/Girs" class="card shadow-sm h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #005e75">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">No. GIR´S</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="girs"> <!-- Calculo desde JS --> </div>
                                </div>
                                <div class="col-auto">
                                    <i class="dance-icon fas fa-comment-alt fa-2x text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de girs = SCG -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Girs" class="card shadow-sm h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #005e75">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">SCG</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="scg"> <!-- Calculo desde JS --> </div>
                                </div>
                                <div class="col-auto">
                                    <i class="dance-icon fa fa-gavel fa-2x text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de girs = Possible auditor -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Girs" class="card shadow-sm h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #005e75">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">POSSIBLE AUDITOR</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="posibleAuditor"> <!-- Calculo desde JS --> </div>
                                </div>
                                <div class="col-auto">
                                    <i class="dance-icon fa fa-balance-scale fa-2x text-yellow-500"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Contador de usuarios -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="<?= base_url(); ?>/Usuarios" class="card shadow-sm h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #005e75">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">USERS</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="usuarios"> <!-- Calculo desde JS --> </div>
                                </div>
                                <div class="col-auto">
                                    <i class="dance-icon fas fa-users fa-2x text-teal-500"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Calculo de prioridad -->
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card shadow-lg mb-4">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 fw-bold">Total by Level of Importance</h6>
                        </div>
                        <div class="card-body gap-3">
                            <!-- Fila 1 - Low and Medium Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-2">
                                    <a href="<?= base_url(); ?>/Registros/Low" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#269D00'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="font-weight-bold text-uppercase mb-1">Low</div>
                                            <p id="Low" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/Registros/Medium" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#B9B700'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="font-weight-bold text-uppercase mb-1">Medium</div>
                                            <p id="Medium" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Fila 2 - High and In Stay Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/Registros/High" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#800000'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">High</div>
                                            <p id="High" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/Registros/InStay" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#ea6b00'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">In Stay</div>
                                            <p id="InStay" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Fila 3 - Informative and Wow Moment Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/Registros/Informative" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#00accb'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Informative</div>
                                            <p id="Informative" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/Registros/WowMoment" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#3700c8'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Wow Moment</div>
                                            <p id="WowMoment" class="h5 mb-0 font-weight-bold text-gray-800"> </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila 2 - Total number of guest in house and Due Out -->
                <div class="col-12 col-md-3 d-flex flex-column justify-content-around">
                    <!-- Primer div (arriba) -->
                    <a href="<?= base_url(); ?>/Registros/InHouse" class="card shadow-lg mb-1 text-decoration-none" style="transition: transform 0.3s ease; color: #333;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 fw-bold fs-5">In house</h6>
                        </div>
                        <div class="card-body text-center">
                            <p id="InHouse" style="font-size: 3rem; font-weight: bold;"> </p>
                        </div>
                    </a>

                    <!-- Segundo div (abajo) -->
                    <a href="<?= base_url(); ?>/Registros/DueOut" class="card shadow-lg mb-1 text-decoration-none" style="transition: transform 0.3s ease; color: #333;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 fw-bold fs-5">Due Out</h6>
                        </div>
                        <div class="card-body text-center">
                            <p id="dueOut" style="font-size: 3rem; font-weight: bold;"></p>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-3 d-flex flex-column justify-content-around">
                    <a href="<?= base_url(); ?>/Registros/SpecialGuest" class="card shadow-lg mb-1 text-decoration-none" style="transition: transform 0.3s ease; color: #333;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 fw-bold fs-5">Special Care Guest</h6>
                        </div>
                        <div class="card-body text-center">
                            <p id="specialGuest" style="font-size: 3rem; font-weight: bold;"></p>
                        </div>
                    </a>
                    <a href="<?= base_url(); ?>/Registros/PossibleAuditor" class="card shadow-lg mb-1 text-decoration-none" style="transition: transform 0.3s ease; color: #333;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 fw-bold fs-5">Possible Auditor</h6>
                        </div>
                        <div class="card-body text-center">
                            <p id="PossibleAuditor" style="font-size: 3rem; font-weight: bold;"> </p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Total de Girs Por mes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-white" style="background-color: #005e75;">
                            <h6 class="m-0 font-weight-bold">Total GIRS by Month and Level</h6>
                        </div>
                        <div class="card-body">
                            <div style="width: 100%; overflow-x: auto;">
                                <canvas id="totalGirs" height="300"  style="min-width: 700px; max-width: 100%;"></canvas>
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