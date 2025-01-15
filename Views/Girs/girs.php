<?php
headerAdmin($data);
getModal('modalGirs', $data);
?>

<div id="layoutSidenav_content">
    <div class="topbar mb-4 shadow bg-white">
        <div class="container-xl ">
            <div class="row">
               <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="text-center flex-grow-1">
                        <h2 class="mt-2"><?= $data['page_main'] ?></h2>
                    </div>
                    <button class="btn" style="color:#9BA4B5;" id="btnQuejas">
                        <i class="fas fa-circle-plus fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main>

        <div class="container-fluid px-4">
            <!--CONTENIDO-->
    
            <!--Contadores-->
            <div class="row">
                <!--Contador de gir abiertos-->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #212A3E">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Open Gir´s
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="Opengirs">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Contador de girs Cerrados-->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 text-decoration-none text-reset" style="border-left: 5px solid #212A3E">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                                        Closed Gir´s
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="Closedgirs">
                                        <!--Calculo desde js-->
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300 dance-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center ">
                    <i class="fas fa-table dance-icon"></i>
                    <div class="d-flex flex-wrap gap-2 justify-content-center"> <!-- Añadida la clase justify-content-center -->
                        <?php if ($_SESSION['permisosModulo']['w']) { ?>
                            <button class="btn" id="btnGirs" style="background: #006179; color:#fff;">
                                <i class="fas fa-plus"></i>
                                Create
                            </button>
                        <?php } ?>
                        <form id="formAlergias">
                            <button class="btn" style="background: #00a42f; color:#fff;">
                                <i class="fas fa-allergies"></i>
                                Allergies
                            </button>
                        </form>
                        <button id="btnReporteFiltro" class="btn" style="background: #575757; color:#fff;">
                            <i class="fas fa-file-export"></i>
                            By date
                        </button>
                        <form id="formDQR">
                            <button class="btn" style="background: #800000; color:#fff;">
                                <i class="fas fa-file-pdf"></i>
                                DQR
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_girs" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Opportunity</th>
                                    <th class="text-center">Classification</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Hour</th>
                                    <th class="text-center">Surnames</th>
                                    <th class="text-center">Villa</th>
                                    <th class="text-center">Check-In</th>
                                    <th class="text-center">Check-Out</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Level</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Compensation</th>
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