<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="DQR" />
    <meta name="author" content="Ing. Gustavo Carranza Rivera" />
    <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
    <title><?= $data['page_title'] ?></title>
    <!--DataTable-->
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/bootstrapp.min.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/DataTable/responsive.bootstrap5.css">
    <!--Styles-->
    <link href="<?= media(); ?>/css/style.css" rel="stylesheet" />
    <link href="<?= media(); ?>/css/style-DQR.css" rel="stylesheet" />
    <!--Fas fa-icons-->
    <script src="<?= media(); ?>/js/scripts/fas-fa-icons.js"></script>
    <!--Sweetalert2-->
    <link rel="stylesheet" href="<?= media(); ?>/css/plugins/sweetalert2.min.css">
    <!--Chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--Libreria JQuery-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--Libreria push-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.min.js"></script>
    <script>
        var Base_URL = "<?php echo Base_URL; ?>";
        var Media = "<?php echo media(); ?>";
    </script>
   <!-- <script src="<?= media(); ?>/js/bb.js"></script>-->
    
</head>

<body class="sb-nav-fixed">
    <div id="divLoading">
        <div>
            <img src="<?= media(); ?>/images/svg/loading.svg" alt="Loading">
        </div>
    </div>
    <?php
        getModal('modalNotificaciones', $data);
    ?>
     <nav class="sb-topnav navbar navbar-expand" style="background: #006179 ;">
        <!--Boton de notificaciones flotante-->
        <div class="position-fixed bottom-0 end-0 p-3">
            <button class="btn btn-lg rounded-circle" style="background: #006179;  color: #fff;" id="btn-notificacion">
                <i class="fas fa-bell fa-fw dance-icon"></i>
            </button>
        </div>

        <!-- Titulo del sistema-->
        <span class="navbar-brand ps-3 text-white"><i class="fas fa-calendar-check dance-icon"></i> Daily Quality Report </span>
        <!-- Icono menu hamburguesa-->
        <button class="btn btn-md order-1 order-lg-0 me-4 me-lg-0 boton" id="sidebarToggle" href=""><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </div>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw dance-icon"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url(); ?>/Usuarios/Perfil">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>/Logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <?php require_once('nav.php'); ?>