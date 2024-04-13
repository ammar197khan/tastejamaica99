<script src="<?= ADMIN_URL ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= ADMIN_URL ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= ADMIN_URL ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= ADMIN_URL ?>js/ruang-admin.min.js"></script>
<!-- <script src="<?php // echo  ADMIN_URL ?>vendor/chart.js/Chart.min.js"></script> -->
<!-- <script src="<?php // echo ADMIN_URL ?>js/demo/chart-area-demo.js"></script> -->
<!-- Select2 -->
<script src="<?= ADMIN_URL ?>vendor/select2/dist/js/select2.min.js"></script>
<!-- Bootstrap Datepicker -->
<script src="<?= ADMIN_URL ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap Touchspin -->
<script src="<?= ADMIN_URL ?>vendor/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
<!-- ClockPicker -->
<script src="<?= ADMIN_URL ?>vendor/clock-picker/clockpicker.js"></script>
<!-- Page level plugins -->
<script src="<?= ADMIN_URL ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= ADMIN_URL ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= ADMIN_URL ?>js/lightgallery.all.min.js"></script>

<script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
      "order": [0,'desc'],
      "pageLength": 50
    });
    $('#dataTableHover').DataTable({
      "order": [0,'desc'],
      "pageLength": 50
    });
  });
  $(document).ready(function() {


    $('.select2-single').select2();

    // Select2 Single  with Placeholder
    $('.select2-single-placeholder').select2({
      placeholder: "Select a Province",
      allowClear: true
    });

    // Select2 Multiple
    $('.select2-multiple').select2();

    // Bootstrap Date Picker
    $('#simple-date1 .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,
    });

    $('#simple-date2 .input-group.date').datepicker({
      startView: 1,
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    $('#simple-date3 .input-group.date').datepicker({
      startView: 2,
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    $('#simple-date4 .input-daterange').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    // TouchSpin

    $('#touchSpin1').TouchSpin({
      min: 0,
      max: 100,
      boostat: 5,
      maxboostedstep: 10,
      initval: 0
    });

    $('#touchSpin2').TouchSpin({
      min: 0,
      max: 100,
      decimals: 2,
      step: 0.1,
      postfix: '%',
      initval: 0,
      boostat: 5,
      maxboostedstep: 10
    });

    $('#touchSpin3').TouchSpin({
      min: 0,
      max: 100,
      initval: 0,
      boostat: 5,
      maxboostedstep: 10,
      verticalbuttons: true,
    });

    $('#clockPicker1').clockpicker({
      donetext: 'Done'
    });

    $('#clockPicker2').clockpicker({
      autoclose: true
    });

    let input = $('#clockPicker3').clockpicker({
      autoclose: true,
      'default': 'now',
      placement: 'top',
      align: 'left',
    });

    $('#check-minutes').click(function(e) {
      e.stopPropagation();
      input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });

  });
</script>