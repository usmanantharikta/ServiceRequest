<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ServiceRequest | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- include css assets -->
  <?php $this->load->view('include/css');?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<!-- load header -->
<?php $this->load->view('include/header');?>
  <!-- Left side column. contains the logo and sidebar -->
  <!-- load asside  -->
  <?php
  if($_SESSION['level']=='manager'){
    $this->load->view('include/asside_gm');
  }
  if ($_SESSION['level']=='directure' || $_SESSION['level']=='admin') {
    $this->load->view('include/asside_su');
  }
  if ($_SESSION['level']=='staf'){
    $this->load->view('include/asside');
  }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Control panel</small> -->
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    <!-- TO DO List -->
      <div class="box box-primary">
        <div class="box-header">
          <i class="ion ion-clipboard"></i>

          <h3 class="box-title">Report Progress</h3>

          <div class="box-tools pull-right">
            <!-- <ul class="pagination pagination-sm inline">
              <li><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul> -->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
          <table id="table_activity" class="table table-hover table-bordered">
            <thead >
              <tr>
                <th>Nik</th>
                <th>Name</th>
                <th>Division</th>
                <th>Solved</th>
                <th>Unsolved</th>
                <th>Onprogress</th>
                <th>Unread</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <!-- <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button> -->
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
$this->load->view('include/footer');
?>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- include js assets -->
<?php $this->load->view('include/js');?>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url().'assets/dist/js/pages/dashboard.js'?>"></script> -->
<script>
$(document).ready(function(){
  $(".statistic").addClass('active');
  $(".statistic").parent().parent().addClass('active menu-open');

  var url='<?php echo site_url().'/manager/get_nik_same'?>';
  $table=$('#table_activity').DataTable( {
  "ajax":
  {
      "url": url,
      "type": "POST",
      "retrieve": true,
      keys: true,
  },
  "order" :
    [
      [3, 'desc'],
      [4, 'desc'],
      [5, 'desc'],
      [6, 'desc']
    ]
  });

});
</script>
</body>
</html>
