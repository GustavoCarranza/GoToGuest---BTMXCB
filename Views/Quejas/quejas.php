<?php
headerAdmin($data);
getModal('modalQuejas', $data);
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
                    <i class="fas fa-angry dance-icon"></i>
                    <div>
                        <?php if ($_SESSION['permisosModulo']['w']) { ?>
                            <button class="btn" id="btnQuejas" style="background: #006179;color:#fff;">
                                <i class="fas fa-plus"></i>
                                Create
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <table id="table_quejas" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Clasification</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Creation of date</th>
                                    <th class="text-center">Creation time</th>
                                    <th class="text-center">Actions</th>
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