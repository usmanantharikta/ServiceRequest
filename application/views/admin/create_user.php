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
  if ($_SESSION['level']=='staff'){
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
        Create User
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
            <!-- <?php echo var_dump($pic)?> -->
            <div class="row">
              <div class="col-md-12">
                <form id='save-form'  method="post" enctype="multipart/form-data">
                  <!-- <input type="hidden" name="nik" value="<?php echo $_SESSION['nik'];?>"> -->
                  <!-- <div id='user' class="form-group">
                    <select id='nik' name="username" class="form-control select2" style="width: 100%;">
                      <option value=''> -----------------------Select One ID-----------------------</option>
                      <?php
                        foreach ($user as $key ) {
                          echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['full_name'].'-'.$key['division'].'</option>';
                        }
                      ?>
                    </select>
                      <span class="help-block"></span>
                  </div> -->
                  <div class="form-group">
                    <label>User ID </label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                      </div>
                      <select id='username' name="username" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value=''> -----------------------Select One ID-----------------------</option>
                        <?php
                          foreach ($user as $key ) {
                            echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['full_name'].'-'.$key['division'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <div class="form-group">
                    <label>Jenis User (Level)</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                      </div>
                      <select id='level' name="level" class="form-control select2" style="width: 100%;">
                        <!-- <option> -----------------------Select One -----------------------</option> -->
                        <option value="staff">STAFF</option>
                        <option value="manager">MANAGER</option>
                        <option value="directure">DIRECTURE</option>
                        <option value="admin">ADMIN</option>
                      </select>
                    </div>
                    <span class="help-block old_password"></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>New Password</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                      </div>
                      <input name="new_password" type="password" class="form-control" placeholder="Input New Password">
                    </div>
                    <span class="help-block new_password"></span>

                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Re-Password</label>
                    <div class="input-group ">
                      <div class="input-group-addon">
                        <i class="fa fa-lock"></i>
                      </div>
                      <input name="re_password" type="password" class="form-control" placeholder="Re Input New Password">
                    </div>
                    <span class="help-block re_password"></span>

                  </div>
                  <!-- /.form-group -->
                </form>
                <!-- ./end form -->
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer ">
            <button type="submit" onclick="create_user()" class="btn bg-olive">Change</button>
            <button onclick="reset()" class="btn btn-warning">Reset</button>
          </div>
          <!-- /.box-footer-->
        </div>
      <!-- /.box -->
      </div>
    <!-- ./col-lg-6 -->
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
  $('#datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    startDate: dateToday,
  });
});
function create_user(){
         var formdata = new FormData($("#save-form")[0]);
         event.preventDefault();
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
           $.ajax({
               url : '<?php echo site_url('/admin/save_user') ?>',
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
                   location.reload();
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
  $('#add-form')[0].reset(); // reset form on modals
}


</script>
</body>
</html>
