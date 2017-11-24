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
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 class='all_request'>0</h3>

              <p>All Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-compose"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 class="req-OPEN"> 0</h3>

              <p>Open Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-unlocked"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 class="req-CLOSE">0</h3>
              <p>Close Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-locked"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 class="req-CANCEL">0</h3>

              <p>Cancel Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-close-circled"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3 class='all_receipt'>0</h3>

              <p>All Receipt</p>
            </div>
            <div class="icon">
              <i class="ion ion-clipboard"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 class="rec-solved">0</h3>

              <p>Request Solved</p>
            </div>
            <div class="icon">
              <i class="ion ion-checkmark-round"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 class="rec-onprogress">0</h3>
              <p>Request Onprogress & Unread</p>
            </div>
            <div class="icon">
              <i class="ion ion-load-c"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 class="rec-unsolved">0</h3>

              <p>Request Unsolved</p>
            </div>
            <div class="icon">
              <i class="ion ion-minus-circled "></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <!-- request  -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <!-- <li><a href="#revenue-chart" data-toggle="tab">Area</a></li> -->
              <li class="active" ><a href="#sales-chart" data-toggle="tab"></a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Status Request</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
        </section>

        <!-- receipt  -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <!-- <li><a href="#sum-receipt-chart" data-toggle="tab">Area</a></li> -->
              <li class="active" ><a href="#status-chart" data-toggle="tab"></a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Status Receipt</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane " id="sum-receipt-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane active" id="status-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
        </section>
      </div>
      <!-- /.row (main row) -->

      <!-- TO DO List -->
      <div class="box box-primary">
        <div class="box-header">
          <i class="ion ion-clipboard"></i>

          <h3 class="box-title">Task Tracking</h3>

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
                <th>Times</th>
                <th>Name PIC</th>
                <th>Request ID</th>
                <th>Type</th>
                <th>Message</th>
                <th>Status</th>
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
<script src="<?php echo base_url().'assets/dist/js/pages/dashboard.js'?>"></script>
<script>
$(document).ready(function(){
  $(".dashboard").addClass('active');
  $(".dashboard").parent().parent().addClass('active menu-open');

  var url='<?php echo site_url().'/general/activity'?>';
  $table=$('#table_activity').DataTable( {
  "ajax":
  {
      "url": url,
      "type": "POST",
      "retrieve": true,
      keys: true,
  },
  });

});
</script>
</body>
</html>
