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
<style>
table th {
   text-align: center;
}
</style>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
  <?php
  if(isset($_SESSION['username'])&&$_SESSION['level']=='manager'){

?>
<!-- Site wrapper -->
<div class="wrapper">

  <!-- load header -->
  <?php $this->load->view('include/header');?>
  <!-- =============================================== -->
  <!-- load asside  -->
  <?php $this->load->view('include/asside_gm')?> <!-- change on here -->
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New Request
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">service request</a></li>
        <li class="active">add</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- <div class="callout callout-info">
        <h4>Tip!</h4>

        <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
          is bigger than your content because it prevents extra unwanted scrolling.</p>
      </div> -->
      <!-- Default box -->
      <div class="row">
        <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Form Add New Request</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <!-- <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button> -->
            </div>
          </div>
          <div class="box-body">
            <div class="row">
                <form id='add-form'  method="post" enctype="multipart/form-data">
                  <div class="col-md-6">
                  <input type="hidden" name="nik_request" value="<?php echo $_SESSION['nik'];?>">
                  <div class="form-group">
                    <label>PIC</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                    <select id='nik' name="nik_receipt" class="form-control select2" style="width: 100%;">
                      <!-- <<option value=""> Select one Recipient</option> -->
                      <?php
                        foreach ($pic as $key ) {
                          if($_SESSION['nik']==$key['nik'])
                            continue;
                          echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['location'].'-'.$key['division'].'-'.$key['department'].'-'.$key['first_name'].' '.$key['last_name'].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <span class="help-block"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Document Type</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-file"></i>
                      </div>
                      <select name="doc_type" class="form-control select2" style="width: 100%;">
                        <!-- <option value="">Select one type </option> -->
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
                    <input name="title" type="text" class="form-control" placeholder="Input Task Title">


                  </div>
                  <span class="help-block"></span>
                  </div>
                  <!-- /.form-group -->
                  <!-- Date -->
                  <div class="form-group">
                    <label>Deadline</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="deadline" type="text" placeholder="deadline date" class="form-control pull-right" id="datepicker">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                  <div class="form-group">
                    <label>File</label>
                    <div class="bapak">
                      <div class="input-group entry">
                        <div class="input-group-addon" style="padding: 0px 0px;">
                          <button class="btn btn-success btn-plus">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                        <input name="file[]"  type="file" placeholder="deadline date" class="form-control pull-right" id="datepicker">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                  <!-- /.form group -->
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Task Detail</label>
                    <textarea name="task_detail" class="textarea" value="sdsfsfddsfd" placeholder="Place some detail about this task here"
                              style="width: 100%; height: 280px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                </form>
                <!-- ./end form -->
              <!-- ./col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer ">
            <button type="submit" onclick="add_req()" class="btn bg-olive">Request</button>
            <button onclick="reset()" class="btn btn-warning">Reset</button>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
    <!-- ./col-lg-6 -->
    <div class="col-lg-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Last stored request</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
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
              <!-- <th>Action </th> -->
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer ">
        </div>
        <!-- /.box-footer-->
        </form>
        <!-- ./end form -->
      </div>
    <!-- /.box -->
    </div>
    <!-- ./col-lg-12 -->
    </div>
    <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- footer on here -->
  <?php $this->load->view('include/footer')?>

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
          <input type="hidden" name="id_task" >
          <div class="form-group">
            <label>PIC</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
            <select id='nik' name="nik_receipt" class="form-control select2" style="width: 100%;">
              <?php
                foreach ($pic as $key ) {
                  if($_SESSION['nik']==$key['nik'])
                    continue;
                  echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['location'].'-'.$key['division'].'-'.$key['department'].'-'.$key['first_name'].' '.$key['last_name'].'</option>';
                }
              ?>
            </select>
          </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label>Document Type</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-file"></i>
              </div>
              <select name="doc_type" class="form-control select2" style="width: 100%;">
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
            <input name="title" type="text" class="form-control" placeholder="Task Title">
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
              <input name="deadline" type="text" class="form-control pull-right" id="deadline">
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
        </form>
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
<script>
var $table=$('#table_report').DataTable();
$(document).ready(function(){
  $("#add").addClass('active');
  $("#add").parent().parent().addClass('active menu-open');
  // parent().parent().addClass('active');

  //Initialize Select2 Elements
  $('.select2').select2({
    placeholder: "Please Select One",
    allowClear: true
  });
  // editor $('.textarea').wysihtml5()
  // $('.textarea').wysihtml5();
  // $('.textarea').html('usman antharikta naik');
  //Date picker
  var dateToday = new Date();
  $('#datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    startDate: dateToday,
  });
});

$('button .bg-olive').click(function(event) {
     event.preventDefault(event);
});

function add_req(){
         var formdata = new FormData($("#add-form")[0]);
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
           $.ajax({
               url : '<?php echo site_url('/request/add') ?>',
               type: "POST",
               data: formdata,
               processData: false,
               contentType: false,
               dataType: "JSON",
               success: function(data)
               {
                 if(data.status){
                   bootbox.alert({
                     title: '<p class="text-success">Success</p>',
                     message: 'Your request has been sent',
                   });

                   $table.destroy();
                   url='<?php echo site_url().'/request/get_last_request/'?>'+data.result;
                   $table=$('#table_report').DataTable( {
                   "ajax":
                   {
                       "url": url,
                       "type": "POST",
                       "retrieve": true,
                       keys: true,
                   },
                 });
               }else{
                 var pesan="";
                 for (var i = 0; i < data.inputerror.length; i++)
                    {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      // $('[name="'+data.inputerror[i]+'"]').next().next().text(data.error_string[i]); //select span help-block class set text error string
                      pesan+=data.error_string[i]+"<br>";
                    }

                    bootbox.alert({
                      title: '<p class="text-danger">Error!!</p>',
                      message: pesan,
                    });

                  }
               },
               error: function (jqXHR, textStatus, errorThrown)
               {
                   alert('Error adding / update data');
                   $('#btnSave').text('save'); //change button text
                   $('#btnSave').attr('disabled',false); //set button enable
               }
           });
       } //end ajax save


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
       url : "<?php echo site_url('request/ajax_edit/')?>/" + id_request,
       type: "GET",
       dataType: "JSON",
       success: function(data)
       {
          // $(".memo").wysihtml5();
           $('[name="id_task"]').val(data.id_task);
           $('[name="nik_receipt"]').val(data.nik_receipt);
           $('[name="doc_type"]').val(data.doc_type);
           $('[name="title"]').val(data.title);
           $('.memo').html(data.task_detail);
          // $('#memo').data("wysihtml5").editor.setValue('new content');
           // $('.textarea').html('usman antharikta naik');
           $('[name="deadline"]').val(data.deadline);
           $('#modal-default').modal('show'); // show bootstrap modal when complete loaded
           $('.modal-title').text(data.title); // Set title to Bootstrap modal title
           var d=data.deadline;
           var arr=new Array();
           arr=d.split("-");
           console.log(arr);
           var da = new Date(arr[0], arr[1], arr[2]);
           console.log(typeof d);
           $('#deadline').datepicker({
             autoclose: true,
             format: 'yyyy-mm-dd',
             startDate: da,
           });

       },
       error: function (jqXHR, textStatus, errorThrown)
       {
           alert('Error get data from ajax');
       }
   });
}

function reset()
{
  $('#add-form')[0].reset(); // reset form on modals
}


</script>
</body>
</html>
