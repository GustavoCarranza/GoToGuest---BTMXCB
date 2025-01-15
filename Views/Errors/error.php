<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="DQR" />
    <meta name="author" content="Ing. Gustavo Carranza Rivera" />
    <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
    <title>404 Error - DQR</title>
    <link href="<?= media(); ?>/css/style.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="mb-4 img-error" src="<?= media(); ?>/images/svg/error.svg" />
                                <p class="lead">Esta ruta no existe, verifica por favor.</p>
                                <a href="<?= base_url(); ?>/dashboard">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Regresar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; Gustavo Carranza <?= date('Y'); ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= media(); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= media(); ?>/js/scripts.js"></script>
</body>

</html>