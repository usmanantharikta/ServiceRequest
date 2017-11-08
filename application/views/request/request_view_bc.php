<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Service Request</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- load css  -->
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
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
  <?php
  if(isset($_SESSION['username'])){

?>
<!-- Site wrapper -->
<div class="wrapper">

  <!-- load header -->
  <?php $this->load->view('include/header');?>
  <!-- =============================================== -->
  <!-- load asside  -->
  <?php $this->load->view('include/asside')?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Request Task List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">helptaskmenu</a></li>
        <li class="active">list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- <div class="callout callout-info">
        <h4>Tip!</h4>

        <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
          is bigger than your content because it prevents extra unwanted scrolling.</p>
      </div> -->
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">View Request</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <button class="btn btn-primary" onclick="reload_table()">Reload</button>
          <table id="table_report" class="table table-hover table-bordered">
            <thead >
              <tr style="text-align:center">
                <th colspan="2">User</th>
                <th colspan="2">PIC</th>
                <th colspan="11">Task detail</th>
              </tr>
              <tr>
                <th>NIk</th>
                <th>Name User</th>
                <th>Division User </th>
                <th>NIk</th>
                <th>Name PIC</th>
                <th>Division PIC</th>
                <!-- task detail  -->
                <th>Task ID</th>
                <th>Title</th>
                <th> Doc Type</th>
                <th>Order Date</th>
                <th>Deadline</th>
                <th>Status PIC</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <th>Status User</th>
                <th>Close Date</th>
                <th>Transfer From</th>
                <th>Action </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- modal edit -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <div class="modal-body">

        <form id='edit-form'  method="post" enctype="multipart/form-data">
          <input type="hidden" name="nik_request" value="<?php echo $_SESSION['nik'];?>">
          <input type="hidden" name="id_request" >
          <input type="hidden" name="id_task" >
          <div class="form-group">
            <label>PIC</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
            <input disabled id='nik' name="nik_receipt" class="form-control select2" style="width: 100%;">
          </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Document Type</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-file"></i>
              </div>
              <select disabled name="doc_type" class="form-control select2" style="width: 100%;">
                <option value="SPED">SPED (SURAT PERMINTAAN EMAIL)</option>
                <option value="SPPK">SPPK (SURAT PERMINTAAN PERBAIKAN KOMPUTER)</option>
                <option value="SPP">SPP (SURAT PERMINTAAN PEMBELIAN)</option>
                <option value="IOM">IOM (INTER OFFICE MEMO)</option>
                <option value="other">other</option>
              </select>
          </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Task Title</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-tag"></i>
              </div>
            <input disabled name="title" type="text" class="form-control" placeholder="Task Title">
          </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Task Detail</label>
            <textarea class="memo" name="task_detail" placeholder="Place some text here"
                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
          <!-- /.form-group -->
          <!-- Date -->
          <div class="form-group">
            <label>Deadline</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input disabled name="deadline" type="text" class="form-control pull-right" id="datepicker">
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label class="text-danger">Status</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <select name="status_user" class="form-control select2" style="width: 100%;">
                <option value="OPEN">OPEN</option>
                <option value="CANCEL">CANCEL</option>
                <option value="CLOSE">CLOSE</option>
              </select>
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" onclick="save_edit()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ============================================================================================================== -->
<!-- modal timeline -->
<div class="modal fade" id="modal-timeline">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <div class="modal-body">
        <!-- The time line -->
        <ul class="timeline">
          <!-- timeline time label -->
          <li class="time-label">
                <span id="order_date" class="bg-red">
                  10 Feb. 2014
                </span>
          </li>
          <!-- /.timeline-label -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-envelope bg-blue"></i>

            <div class="timeline-item">
              <!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05</span> -->

              <h3 class="timeline-header"><a id="request" href="#">nama pembuat </a> create a request</h3>

              <div id="detail_task" class="timeline-body">
                <h4>Detail Request </h4>
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                quora plaxo ideeli hulu weebly balihoo...
              </div>
              <div class="timeline-footer">
                <!-- <a class="btn btn-primary btn-xs">Read more</a>
                <a class="btn btn-danger btn-xs">Delete</a> -->
              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-bell bg-aqua"></i>

            <div class="timeline-item">
              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

              <h3 class="timeline-header no-border">Status User is <a class="text-green" href="#">OPEN</a></h3>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li>
            <i class="fa fa-hourglass-o bg-yellow"></i>
            <div class="timeline-item">
              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

              <h3 class="timeline-header no-border">Waitting respons by <a class="receipt_name" class="text-green" href="#">OPEN</a></h3>
            </div>
          </li>
          <!-- timeline time label -->
          <li class="hide time-label">
                <span id="start_date" class="bg-green">
                  3 Jan. 2014
                </span>
          </li>
          <!-- /.timeline-label -->
          <!-- timeline item -->
          <li class="hide acc">
            <i class="fa fa-camera bg-purple"></i>

            <div class="timeline-item">
              <!-- <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span> -->

              <h3 class="timeline-header"><a class="receipt_name" href="#">Mina Lee</a> accepted the task and task is on prosess</h3>
              <div class="timeline-body">

              </div>
            </div>
          </li>
          <!-- END timeline item -->
          <!-- timeline item -->
          <li class="hide">
            <i class="fa fa-bell bg-aqua"></i>

            <div class="timeline-item">
              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->

              <h3 id='deadline' class="timeline-header no-border">Status User is </h3>
            </div>
          </li>
          <!-- END timeline item -->
          <li>
            <i class="fa fa-clock-o bg-gray"></i>
          </li>
        </ul>
        <!-- ./end timeline -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
  }else{
    echo 'you are not login';
  }
   ?>
<!-- load js ------------------------------------------------------------------>
<?php $this->load->view('include/js');?>
<script src="<?php echo base_url().'assets/moment/moment.js'?>"></script>
<script>
    moment().format();
</script>
<script>
var table;
$(document).ready(function(){
  $("#list").addClass('active');
  $("#list").parent().parent().addClass('active menu-open');
  // parent().parent().addClass('active');
  var url='<?php echo site_url().'/request/get_all_request/'.$_SESSION['nik']?>';
  table = $('#table_report').DataTable({
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": url,
        "type": "POST",
    },
    "drawCallback": function( settings ) {
    var api = this.api();
    // Output the data for the visible rows to the browser's console
    console.log( api.rows( {page:'current'} ).data() );

  },

});
});

GetCellValues();
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

//show modal
function edit(id_request){
   $('#edit-form')[0].reset(); // reset form on modals
   var content = $('.memo');
    var contentPar = content.parent()
    contentPar.find('.wysihtml5-toolbar').remove()
  //  $('.form-group').removeClass('has-error'); // clear error class
  //  $('.help-block').empty(); // clear error string
   //Ajax Load data from ajax
   $.ajax({
       url : "<?php echo site_url('request/ajax_edit')?>/" + id_request,
       type: "GET",
       dataType: "JSON",
       success: function(data)
       {
          $(".memo").wysihtml5();
           $('[name="id_request"]').val(data.id_request);
           $('[name="id_task"]').val(data.id_task);
           $('[name="nik_receipt"]').val(data.nik_receipt+"-"+data.location+"-"+data.division+"-"+data.department+"-"+data.first_name+" "+data.last_name);
           $('[name="doc_type"]').val(data.doc_type);
           $('[name="title"]').val(data.title);
           $('.memo').html(data.task_detail);
          // $('#memo').data("wysihtml5").editor.setValue('new content');
           // $('.textarea').html('usman antharikta naik');
           $('[name="deadline"]').val(data.deadline);
           $('#modal-default').modal('show'); // show bootstrap modal when complete loaded
           $('.modal-title').text("Edit Request"); // Set title to Bootstrap modal title
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
           alert('Error get data from ajax');
       }
   });
}

function save_edit()
{
        var formdata = new FormData($('#edit-form')[0]);
         event.preventDefault();
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
           $.ajax({
               url : '<?php echo site_url('/request/save_edit') ?>',
               type: "POST",
               data: formdata,
               processData: false,
               contentType: false,
               dataType: "JSON",
               success: function(data)
               {
                 $('#modal-default').modal('hide'); // show bootstrap modal when complete loaded
                 reload_table();
               },
               error: function (jqXHR, textStatus, errorThrown)
               {
                   alert('Error adding / update data');
                   $('#btnSave').text('save'); //change button text
                   $('#btnSave').attr('disabled',false); //set button enable
               }
           });
}
function show(id_request)
{
  $.ajax({
      url : "<?php echo site_url('request/ajax_show')?>/" + id_request,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          $('#order_date').text(data.d.order_date);
          $('#request').text(data.d.nik_request+"-"+data.d.location+"-"+data.d.division+"-"+data.d.department+"-"+data.d.first_name+" "+data.d.last_name);
          $('.receipt_name').text(data.d.nik_request+"-"+data.name);
          $('#detail_task').html("<h5>Detail Request: </h5>"+data.d.task_detail);
          $('#modal-timeline').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text("Time Line"); // Set title to Bootstrap modal title
          console.log(data.d.start_date);
          var deadline=moment(data.d.deadline);
          var start=moment(data.d.start_date);

          if(data.d.start_date!='0000-00-00'){
            $('#start_date').text(data.d.start_date).parent().removeClass('hide');
            $('.acc').removeClass('hide');
            $('#deadline').text("This Task need "+deadline.diff(start, "days")+" days "+"and "+deadline.diff(moment(),"days")+' day remaining to deadline').parent().parent().removeClass('hide');
          }
          else{
            $('#start_date').text(data.d.start_date).parent().addClass('hide');
            $('.acc').addClass('hide');
            $('#deadline').text("This Task need "+deadline.diff(start, "days")+" days "+"and "+deadline.diff(moment(),"days")+' day remaining to deadline').parent().parent.addClass('hide');
          }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
  });
}

function GetCellValues() {
    var table = document.getElementById('table_report');
    for (var r = 0, n = table.rows.length; r < n; r++) {
        for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
            console.log(table.rows[r].cells[c].innerHTML);
        }
    }
}


</script>
</body>
</html>
