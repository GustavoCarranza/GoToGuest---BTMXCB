<?php
headerAdmin($data);
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

        <div class="container mb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?= media() ?>/images/Lobby_BTMXCB.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $_SESSION['UserData']['nombres'] . ' ' . $_SESSION['UserData']['apellidos']; ?></h5>
                            <p class="card-text"><?= $_SESSION['UserData']['nombre']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Personal information</h5>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 80px">Names: </td>
                                        <td><?= $_SESSION['UserData']['nombres']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80px">Surnames: </td>
                                        <td><?= $_SESSION['UserData']['apellidos']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80px">e-mail: </td>
                                        <td><?= $_SESSION['UserData']['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80px">User: </td>
                                        <td><?= $_SESSION['UserData']['usuario']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Password change</h5>
                            <form action="" name="formCambioPass" id="formCambioPass">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <label> Current password: </label>
                                            <input type="password" name="txtPasswordActual" id="txtPasswordActual" class="form-control w-50">
                                        </tr>
                                        <tr>
                                            <label> New password: </label>
                                            <input type="password" name="txtPasswordNew" id="txtPasswordNew" class="form-control w-50">
                                        </tr>
                                        <tr>
                                            <label> Confirm password: </label>
                                            <input type="password" name="txtPasswordNewConfirm" id="txtPasswordNewConfirm" class="form-control w-50">
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn" id="btn" style="background:#006179; color:#fff"><i class="fas fa-lock"></i> Change
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <?php
    footerAdmin($data);
    ?>