<!DOCTYPE html>
<!-- <?php echo password_hash("antharikta", PASSWORD_DEFAULT);?> -->
<?php
// var_dump($_SESSION);
// if(isset($_SESSION['username'])){
//   echo 'you was login';
// }else{
//   echo 'you are not login';
// }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ServiceRequest | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- include css -->
  <?php $this->load->view('include/css') ;?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html">ServiceRequest</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to ServiceRequest</p>

    <form id="login-form" method="post">
      <div id='user' class="form-group">
        <select id='nik' name="username" class="form-control select2" style="width: 100%;">
          <option> ----------------------Select Your ID----------------------</option>
          <?php
            foreach ($pic as $key ) {
              echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['location'].'-'.$key['division'].'-'.$key['department'].'-'.$key['first_name'].' '.$key['last_name'].'</option>';
            }
          ?>
        </select>
          <span class="help-block"></span>
      </div>
      <div id='password' class="form-group">
        <input type="password" name='password' class="form-control" placeholder="Password">
          <span class="help-block"></span>
      </div>
      <!-- <div class="form-group has-success">
        <label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Input with success</label>
        <input type="text" class="form-control" id="inputSuccess" placeholder="Enter ...">
        <span class="help-block">Help block with success</span>
      </div>
      <div class="form-group has-warning">
        <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Input with
          warning</label>
        <input type="text" class="form-control" id="inputWarning" placeholder="Enter ...">
        <span class="help-block">Help block with warning</span>
      </div>
      <div class="form-group has-error">
        <label class="control-label" ><i class="fa fa-times-circle-o"></i> Input with
          error</label>
        <input type="text" class="form-control" placeholder="Enter ...">
        <span class="help-block">Help block with error</span>
      </div> -->
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br> -->
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- script javascript -->
<?php $this->load->view('include/js');?>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

  $(document).ready(function(){
    //Initialize Select2 Elements
    $('.select2').select2();

 	$("#login-form").submit(function()
       {
         event.preventDefault();
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
           $.ajax({
               url : '<?php echo site_url('/login/access') ?>',
               type: "POST",
               data: $('#login-form').serialize(),
               dataType: "JSON",
               success: function(data)
               {
                 if(data.status) //if success close modal and reload ajax table
                  {
                    // alert('sucsess login');
                    if(data.level=='directure'||data.level=='admin'){
                      window.location.href = '<?php echo site_url().'/directure'?>';
                    }else if (data.level=='manager') {
                      window.location.href = '<?php echo site_url().'/manager'?>';
                    }else{
                      window.location.href = '<?php echo site_url().'/request'?>';
                    }
                  }
                  else
                  {
                      for (var i = 0; i < data.inputerror.length; i++)
                      {
                          $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                          $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                      }
                  }
               },
               error: function (jqXHR, textStatus, errorThrown)
               {
                   alert('Error adding / update data');
                   $('#btnSave').text('save'); //change button text
                   $('#btnSave').attr('disabled',false); //set button enable
               }
           });
       }); //end ajax save
     }); //end dosumnt rrady
</script>
</body>
</html>
