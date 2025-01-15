<!--Otorgar permisos a roles-->
<div class="modal fade" id="modalPermisos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header" style="background: #5F5F5F ; color:#fff;">
                <h5 class="modal-title"> Grant permissions to roles </h5>
                <button type="button" style="border-radius:50%; width:30px; height:30px: border:none;" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formPermisos" name="formPermisos">
                    <input type="hidden" name="idRol" id="idRol" value="<?= $data['idRol']; ?>" required>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Module</th>
                                    <th class="text-center">See</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $modulos = $data['modulos'];
                                foreach ($modulos as $modulo) {
                                    $permisos = $modulo['permisos'];
                                    $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                    $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                    $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                    $dCheck = $permisos['d'] == 1 ? " checked " : "";

                                    $idmod = $modulo['idmodulo'];
                                ?>
                                    <tr>
                                        <!--Numero del modulo-->
                                        <td class="text-center">
                                            <?= $no; ?>
                                            <input type="hidden" name="modulos[<?= $idmod; ?>][idmodulo]" value="<?= $idmod ?>" required>
                                        </td>

                                        <!--Titulo del modulo-->
                                        <td class="text-center">
                                            <?= $modulo['nombre']; ?>
                                        </td>

                                        <!--Tipo R-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip1_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][r]" <?= $rCheck ?>>
                                                <label class="form-check-label" for="toggleFlip1_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo W-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip2_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][w]" <?= $wCheck ?>>
                                                <label class="form-check-label" for="toggleFlip2_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo U-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip3_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][u]" <?= $uCheck ?>>
                                                <label class="form-check-label" for="toggleFlip3_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>

                                        <!--Tipo D-->
                                        <td class="text-center">
                                            <div class="toggle-flip">
                                                <input class="form-check-input" type="checkbox" id="toggleFlip4_<?= $idmod ?>" name="modulos[<?= $idmod; ?>][d]" <?= $dCheck ?>>
                                                <label class="form-check-label" for="toggleFlip4_<?= $idmod ?>" data-toggle-on="" data-toggle-off="">
                                                    <span class="flip-indicator"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn" style="background: #5F5F5F; color:#fff;">
                            <i class="fas fa-fw fa-check-circle"></i>
                            <span> Assign </span>
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fas fa-fw fa-times-circle"></i>
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>