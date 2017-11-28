<!-- jQuery 3 -->
<script src="<?php echo base_url().'assets/bower_components/jquery/dist/jquery.min.js'?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url().'assets/bower_components/jquery-ui/jquery-ui.min.js'?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url().'assets/bower_components/bootstrap/dist/js/bootstrap.min.js'?>"></script>
<!-- iCheck -->
<!-- Morris.js charts -->
<script src="<?php echo base_url().'assets/bower_components/raphael/raphael.min.js'?>"></script>
<script src="<?php echo base_url().'assets/bower_components/morris.js/morris.min.js'?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url().'assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url().'assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url().'assets/bower_components/jquery-knob/dist/jquery.knob.min.js'?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url().'assets/bower_components/moment/min/moment.min.js'?>"></script>
<script src="<?php echo base_url().'assets/bower_components/bootstrap-daterangepicker/daterangepicker.js'?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js'?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url().'assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url().'assets/bower_components/fastclick/lib/fastclick.js'?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url().'assets/bower_components/select2/dist/js/select2.full.min.js'?>"></script>
<!-- InputMask -->
<script src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.date.extensions.js'?>"></script>
<script src="<?php echo base_url().'assets/plugins/input-mask/jquery.inputmask.extensions.js'?>"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url().'assets/bower_components/moment/min/moment.min.js'?>"></script>
<script src="<?php echo base_url().'assets/bower_components/bootstrap-daterangepicker/daterangepicker.js'?>"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url().'assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'?>"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url().'assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'?>"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.js'?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url().'assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'?>"></script>
<!-- CK Editor -->
<script src="<?php echo base_url().'assets/bower_components/ckeditor/ckeditor.js'?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url().'assets/bower_components/datatables.net/js/jquery.dataTables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'?>"></script>
<!-- bootbox -->
<script src="<?php echo base_url().'assets/bootbox/bootbox.js'?>"></script>
<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++= -->
<!-- dropzone -->
<script src="<?php echo base_url().'assets/dropzone/dist/dropzone.js'?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url().'assets/dist/js/adminlte.min.js'?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script>
<!-- custom view -->
<script src="<?php echo base_url().'assets/service-request/custom.js'?>"></script>
<!-- date sore -->
<!-- fixed datetables -->
<script src="<?php echo base_url().'assets/FixedColumns/js/dataTables.fixedColumns.js'?>"></script>
<script>
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
 "date-uk-pre": function ( a ) {
   if (a == null || a == "") {
     return 0;
   }
   var ukDatea = a.split('/');
   return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
 },

 "date-uk-asc": function ( a, b ) {
   return ((a < b) ? -1 : ((a > b) ? 1 : 0));
 },

 "date-uk-desc": function ( a, b ) {
   return ((a < b) ? 1 : ((a > b) ? -1 : 0));
 }
} );
</script>
<?php function level(){
  if(!isset($_SESSION)) {
    return $_SESSION['level'];
  }else{
    return "notlogin";
  }
} ?>
<script>
var a='';
a='<?php level(); ?>';
console.log("level : "+a);
</script>
