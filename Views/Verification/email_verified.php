<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="DQR" />
    <meta name="author" content="Ing. Gustavo Carranza Rivera" />
    <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="<?= media(); ?>/css/Error_Style.css">
    <title>Email Verified</title>
    <link href="<?= media(); ?>/css/style.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--Sweetalert2-->
    <link rel="stylesheet" href="<?= media(); ?>/css/plugins/sweetalert2.min.css">
</head>

<body>
    <div id="layoutError">
        <div id="layoutError_content">
            <main class="verify-wrapper">
                <div class="verify-card">
                    <div class="verify-icon">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                    </div>

                    <h1>Verifica tu cuenta</h1>
                    <p class="verify-text">
                        Para completar tu registro y activar tu cuenta, por favor confirma tu correo electrónico.
                    </p>

                    <button id="bntVerificar" class="btn-verify">
                        Verificar cuenta
                    </button>

                    <p class="verify-footer">
                        Si no solicitaste esta acción, puedes ignorar este mensaje.
                    </p>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                         <div class="fw-bold fs-6">© 2024 - <?= date('Y') ?> Gustavo Carranza Rivera. Todos los derechos reservados.</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= media(); ?>/js/plugins/sweetalert2.all.min.js"></script>
    <script>let Base_URL = "<?php echo Base_URL; ?>";</script>
    <script src="<?= media(); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= media(); ?>/js/scripts.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
    <!--SweetAlerts-->
</body>

</html>