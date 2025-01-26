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
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #007bff">
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
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #28a745">
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
                    <a href="<?= base_url(); ?>/Girs" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #ffc107">
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
                    <a href="<?= base_url(); ?>/Usuarios" class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #17a2b8">
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
                <div class="col-6">
                    <div class="card shadow-lg mb-4">
                        <div class="card-header py-3 bg-dark text-white">
                            <h6 class="m-0 font-weight-bold">Total by Level of Importance</h6>
                        </div>
                        <div class="card-body gap-3">
                            <!-- Fila 1 - Low and Medium Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-2">
                                    <a href="<?= base_url(); ?>/registros/low" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#269D00'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="font-weight-bold text-uppercase mb-1">Low</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">12</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/registros/medium" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#B9B700'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="font-weight-bold text-uppercase mb-1">Medium</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">8</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Fila 2 - High and In Stay Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/registros/high" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#800000'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">High</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">25</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/registros/instay" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#ea6b00'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">In Stay</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">3</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Fila 3 - Informative and Wow Moment Priority -->
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/registros/informative" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#00accb'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Informative</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">15</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="<?= base_url(); ?>/registros/wowmoment" class="card shadow h-100 text-decoration-none"
                                        style="transition: background-color 0.3s ease; color: #333;"
                                        onmouseover="this.style.backgroundColor='#3700c8'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#333';">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Wow Moment</div>
                                            <p class="h5 mb-0 font-weight-bold text-gray-800">5</p>
                                        </div>
                                    </a>
                                </div>
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