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
  if(isset($_SESSION['username'])&&$_SESSION['level']=='admin'){

?>
<!-- Site wrapper -->
<div class="wrapper">

  <!-- load header -->
  <?php $this->load->view('include/header');?>
  <!-- =============================================== -->
  <!-- load asside  -->
  <?php
  if($_SESSION['level']=='manager'){
    $this->load->view('include/asside_gm');
  }
  if ($_SESSION['level']=='directure'||$_SESSION['level']=='admin') {
    $this->load->view('include/asside_su');
  }
  if ($_SESSION['level']=='staf'){
    $this->load->view('include/asside');
  }
  ?>
  <script>
  var a='<?php echo $_SESSION['level']?>';
  console.log("level : "+a);
  </script>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New Employ
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
        <div class="col-lg-6">
        <div class="box box-primary collapsed-box">
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
              <div class="col-md-12">
                <form id='save-form'  method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>NIK</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-user-o"></i>
                      </div>
                      <input name='nik' type="text" class="form-control" placeholder="Input NIK">
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <div class="form-group">
                    <label>Firs Name</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-user-o"></i>
                      </div>
                      <input name='first_name' type="text" class="form-control" placeholder="Input First Name">
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <div class="form-group">
                    <label>Last Name</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-user-o"></i>
                      </div>
                      <input name='last_name' type="text" class="form-control" placeholder="Input Last Name">
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Location</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-map"></i>
                      </div>
                      <select  name="location" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value="Tangerang">Tangerang</option>
                        <option value="Balarajar">Balaraja</option>
                        <option value="Kebon Jeruk">Kebon Jeruk</option>
                        <option value="Surabaya">Surabaya</option>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <div class="form-group">
                    <label>Division</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-map-pin"></i>
                      </div>
                      <select id='location' name="division" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value="Energy">Energy</option>
                        <option value="Chemical">Chemical</option>
                        <option value="directure">Kebon Jeruk</option>
                        <option value="admin">Surabaya</option>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Department</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-map-signs"></i>
                      </div>
                      <select  name="department" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value="IT">IT</option>
                        <option value="Accounting">Accounting</option>
                        <option value="Production">Production</option>
                        <option value="Purchasing">Purchasing</option>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>

                  <div class="form-group">
                    <label>Phone</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input name="phone" type="text" class="form-control" placeholder="Input Phone Number">
                    </div>
                    <span class="help-block re_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                      </div>
                      <input name="email" type="email" class="form-control" placeholder="Input Email Address">
                    </div>
                    <span class="help-block re_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="dob" type="text" class=" datepicker form-control" placeholder="Birthday">
                    </div>
                    <span class="help-block re_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Gender</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-mars"></i>
                      </div>
                      <select  name="gender" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                </form>
                <!-- ./end form -->
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer ">
            <button type="submit" onclick="save()" class="btn bg-olive">Change</button>
            <button onclick="reset()" class="btn btn-warning">Reset</button>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
    <!-- ./col-lg-6 -->
    </div>
    <!-- ./col-lg-12 -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">List Employee</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-lg-12">
          <div class="table-responsive">
              <table id="table_list" class="table table-bordered table-hover ">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Location</th>
                    <th>Division </th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Gender</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div>
        </div>
        </div>
      </div>
    </div>
    <!-- ./box -->
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

//table
  var url='<?php echo site_url().'/admin/list_employ'?>';
  $table=$('#table_list').DataTable( {
  "ajax":
  {
      "url": url,
      "type": "POST",
      "retrieve": true,
      keys: true,
  },
  });


  $("#create").addClass('active');
  $("#create").parent().parent().addClass('active menu-open');
  // parent().parent().addClass('active');

  //Initialize Select2 Elements
  $('.select2').select2({
    placeholder: "Please Select One",
    allowClear: true
  });
  // editor $('.textarea').wysihtml5()
  $('.textarea').wysihtml5();
  // $('.textarea').html('usman antharikta naik');
  //Date picker
  var dateToday = new Date();
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    // startDate: dateToday,
  });
});
function save(){
         var formdata = new FormData($("#save-form")[0]);
         event.preventDefault();
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
           $.ajax({
               url : '<?php echo site_url('/admin/save_employee') ?>',
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
                   reset();
               }else{
                 var pesan="";
                 for (var i = 0; i < data.inputerror.length; i++)
                    {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('.'+data.inputerror[i]).text(data.error_string[i]); //select span help-block class set text error string
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

function reset()
{
  $('#save-form')[0].reset(); // reset form on modals
}


</script>
</body>
</html>
