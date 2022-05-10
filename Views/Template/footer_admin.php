<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0-rc
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>

<script>
  const base_url = "<?= base_url(); ?>";
</script>
<!-- jQuery -->
<script src="<?= media(); ?>/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= media(); ?>/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= media(); ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Fontawesome 6 -->
<script src="<?= media(); ?>/js/plugins/fontawesome-free/js/all.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= media(); ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= media(); ?>/js/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Plugin bootstrap select -->
<!-- <script src="<?= media(); ?>/js/plugins/bootstrap-select.min.js"></script> -->
<!-- Select2 -->
<script src="<?= media(); ?>/js/plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= media(); ?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Moment -->
<script rel="stylesheet" href="<?= media(); ?>/js/plugins/moment/moment.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?= media(); ?>/js/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?= media(); ?>/js/plugins/toastr/toastr.min.js"></script>
<!-- ChartJS -->
<script src="<?= media(); ?>/js/plugins/chart.js/Chart.min.js"></script>
<script src="<?= media(); ?>/js/functions_admin.js"></script>
<!-- AdminLTE App -->
<script src="<?= media(); ?>/js/main.js"></script>
<script src="<?= media(); ?>/js/adminlte.min.js"></script>
<script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
<script>
  $(function() {
    var menues = $('.nav-links');
    menues.click(function() {
      menues.removeClass('active');
      $(this).addClass('active');
    })
  })
</script>
</body>

</html>