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
    <title>Error - GoToGuest</title>
    <link href="<?= media(); ?>/css/style.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="layoutError">
        <div id="layoutError_content">
            <main class="verify-wrapper">
                <div class="verify-card">
                    <div class="verify-icon error">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>

                    <h1>Enlace inválido</h1>
                    <p class="verify-text">
                        Este enlace de verificación no existe o ha expirado.
                        Por favor solicita uno nuevo para continuar.
                    </p>

                    <a href="<?= base_url(); ?>/Login" class="btn-verify secondary">
                        Regresar al inicio de sesión
                    </a>

                    <p class="verify-footer">
                        Por tu seguridad, los enlaces de verificación tienen tiempo limitado.
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
    <script src="<?= media(); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= media(); ?>/js/scripts.js"></script>
</body>

</html>