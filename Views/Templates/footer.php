<footer class="py-4 mt-auto" style="background: #006179;">
    <div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-center small">
        <div class="text-white font-weight-bold">© <?= date('Y') ?> Gustavo Carranza Rivera. Todos los derechos reservados.</div>
    </div>
</div>
</footer>
</div>
</div>

<!--SweetAlerts-->
<script src="<?= media(); ?>/js/plugins/sweetalert2.all.min.js"></script>

<!--DataTable-->
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/jquery-3.7.1.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.bootstrap5.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/dataTables.responsive.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/responsive.bootstrap5.js"></script>

<!--DataTable para los botones de expotacion-->
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/Buttons/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/Buttons/jszip.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/Buttons/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/Buttons/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/DataTable/Buttons/buttons.html5.min.js"></script>

<script src="<?= media(); ?>/js/scripts/bootstrap.bundle.min.js"></script>
<script src="<?= media(); ?>/js/scripts/scripts.js"></script>

<script>
    var Base_URL = "<?php echo Base_URL; ?>";
    var Media = "<?php echo media(); ?>";
</script>

<script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
<script  src="<?= media(); ?>/js/functions_notify.js"></script>
<script  src="<?= media(); ?>/js/Notify_SSE.js"></script>
</body>

</html>