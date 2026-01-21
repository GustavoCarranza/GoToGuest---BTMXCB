<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="DQR" />
    <meta name="author" content="Gustavo Carranza Rivera" />
    <link rel="shortcut icon" href="<?= media(); ?>/images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="<?= media(); ?>/css/Login_Style.css">
    <link href="<?= media(); ?>/css/General_Style.css" rel="stylesheet" />
    <!--Fas fa-icons-->
    <link href="<?= media(); ?>/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!--Sweetalert2-->
    <link rel="stylesheet" href="<?= media(); ?>/css/plugins/sweetalert2.min.css">
    <title><?= $data['page_title'] ?></title>
</head>

<body>
    <style>
        .forget-password {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        a {
            margin: 7px;

            color: #fff;
            letter-spacing: 3px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: 0.5s;
        }

        .forget-password a:hover {
            color: cadetblue;
        }
    </style>
    <div id="divLoading">
        <div>
            <img src="<?= media(); ?>/images/svg/loading.svg" alt="Loading">
        </div>
    </div>

    <div class="container Font_General">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" name="formLogin" id="formLogin">
                    <h2 class="title">Login</h2>
                    <div class="input-field">
                        <i class="fas fa-camera"></i>
                        <input type="text" placeholder="Username" name="txtUser" id="txtUser" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="txtPassword" id="txtPassword" required />
                    </div>
                    <button type="submit" class="btn solid"><i class="fas fa-check-circle"></i> Start </button>
                </form>
                <div class="forget-password">
                    <a href="<?= base_url(); ?>/Login/ResetPassword">Forgot your password?</a>
                </div>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3> "GO TO GUEST" </h3>
                    <p>
                        We hope that your experience will be the best and that this tool will be useful to cover most of your needs.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!--SweetAlerts-->
    <script src="<?= media(); ?>/js/plugins/sweetalert2.all.min.js"></script>

    <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
    <script>
        var Base_URL = "<?php echo Base_URL; ?>";
    </script>
</body>

</html>