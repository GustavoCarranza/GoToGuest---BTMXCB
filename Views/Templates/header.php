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
    <link href="<?= media(); ?>/css/General_Style.css" rel="stylesheet" />
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
</head>

<body class="sb-nav-fixed Font_General">
    <div id="divLoading">
        <div>
            <img src="<?= media(); ?>/images/svg/loading.svg" alt="Loading">
        </div>
    </div>
    <nav class="sb-topnav navbar navbar-expand py-6" style="background: #008aac;">
        <!-- Titulo del sistema-->
        <span class="navbar-brand p-3 text-white fs-5 fw-bold System_Title"> "GO TO GUEST" </span>
        <!-- Icono menu hamburguesa-->
        <button class="btn btn-md order-1 order-lg-0 me-4 me-lg-0 boton" style="color:#FFFFFF" id="sidebarToggle" href=""><i class="fas fa-bars fs-5"></i></button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </div>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fs-4 fw-bold" style="color:#FFFFFF"></i> <!-- Asegúrate que el color es visible -->
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="color:#FFFFFF; background-color: #FFFFFF;" aria-labelledby="navbarDropdown">
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