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
                    <div class="verify-icon warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <h1>Página no encontrada</h1>
                    <p class="verify-text">
                        La ruta que intentas acceder no existe o fue movida.
                        Verifica la URL o regresa al panel principal.
                    </p>

                    <a href="<?= base_url(); ?>/dashboard" class="btn-verify secondary">
                        Regresar
                    </a>

                    <p class="verify-footer">
                        Error 404 · Recurso no disponible
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