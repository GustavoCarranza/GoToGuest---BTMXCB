<div id="layoutSidenav" style="background:#FFFFFF">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion" id="sidenavAccordio" style="background: #005e75; color:#fff">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <!--Modulo Dashboard-->
                    <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
                        <!--Separacion-->
                        <div class="sb-sidenav-menu-heading">
                            Principal
                        </div>

                        <!--Opcion dashboard-->
                        <a class="nav-link" href="<?= base_url(); ?>/Dashboard">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                    <?php } ?>

                    <!--Separacion-->
                    <div class="sb-sidenav-menu-heading">
                        Interface
                    </div>

                    <!--Opcion de usuarios-->
                    <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                        <!--Opcion Usuarios-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            Users
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <!--Opciones de usuarios-->
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url(); ?>/Usuarios">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    Create user
                                </a>
                                <a class="nav-link" href="<?= base_url(); ?>/Roles">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    Roles and permissions
                                </a>
                            </nav>
                        </div>
                    <?php } ?>


                    <!--Opcion Catalogo-->
                    <?php if (!empty($_SESSION['permisos'][3]['r']) || !empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][5]['r']) || !empty($_SESSION['permisos'][10]['r'])) { ?>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Catalogo"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            Catalogue
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <!--Opciones de catalogo-->
                        <div class="collapse" id="Catalogo" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">

                                <!--opcion queja-->
                                <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                                    <a class="nav-link" href="<?= base_url(); ?>/Quejas">
                                        <div class="sb-nav-link-icon">
                                            <i class="fas fa-angry"></i>
                                        </div>
                                        Opportunity
                                    </a>
                                <?php } ?>

                                <!--Opcion de departamentos-->
                                <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
                                    <a class="nav-link" href="<?= base_url(); ?>/Departamentos">
                                        <div class="sb-nav-link-icon">
                                            <i class="fas fa-suitcase"></i>
                                        </div>
                                        Departments
                                    </a>
                                <?php } ?>

                                <!--Opcion de lugar de queja-->
                                <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                                    <a class="nav-link" href="<?= base_url(); ?>/Lugar">
                                        <div class="sb-nav-link-icon">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        Place of Opportunity
                                    </a>
                                <?php } ?>

                                <?php if(!empty($_SESSION['permisos'][10]['r'])){  ?>
                                <a class="nav-link" href="<?= base_url(); ?>/Compensations">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-balance-scale"></i>
                                    </div>
                                    Compensations
                                </a>
                                <?php } ?>

                            </nav>
                        </div>
                    <?php } ?>

                    <!--Opcion de Gir´s-->
                    <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
                        <a class=" nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Girs"
                                    aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-table"></i>
                                    </div>
                                    GIR'S
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <!--Opciones de usuarios-->
                                <div class="collapse" id="Girs" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="<?= base_url(); ?>/Girs">
                                            <div class="sb-nav-link-icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            GIR'S Open
                                        </a>
                                        <a class="nav-link" href="<?= base_url(); ?>/Girs/GirsPasados">
                                            <div class="sb-nav-link-icon">
                                                <i class="fas fa-history"></i>
                                            </div>
                                            GIR'S Closed
                                        </a>
                                    </nav>
                                </div>
                            <?php } ?>

                            <!--Opcion de Reportes-->
                            <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
                                <a class="nav-link" href="<?= base_url(); ?>/Reportes">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    Statistics
                                </a>
                            <?php } ?>

                    </div>
                </div>
                <div class="sb-sidenav-footer text-white">
                    <div class="medium">
                        <?= $_SESSION['UserData']['nombres'] . " " . $_SESSION['UserData']['apellidos'] ?>
                    </div>
                    <div class="small">
                        <?= $_SESSION['UserData']['nombre'] ?>
                    </div>
                </div>
        </nav>
    </div>