
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
/*.control-label{
  text-align: left;
}*/
/*.form-horizontal .control-label {
    text-align: left;
}*/
.table>thead:first-child>tr:first-child>th {
    border-top: 0;
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
  <?php $this->load->view('include/asside_gm')?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Receipt Task List
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Receipt</a></li>
        <li class="active">list</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- <div class="callout callout-info">
        <h4>Tip!</h4>

        <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
          is bigger than your content because it prevents extra unwanted scrolling.</p>
      </div> -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <!-- <?php var_dump($filter_data);?> -->
<!-- form start -->
<form  id='filter-form' class="form-horizontal" action="<?php echo site_url().'/manager/receipt'?>" method="get">
  <input type='hidden' name='export'>
  <div class="col-lg-6">
    <div class="form-group">
      <label for="inputPassword3"  class="col-sm-2 control-label">PIC name</label>

      <div class="col-sm-10">
        <select id='nik' name="nik_receipt" class="form-control select2" style="width: 100%;">
          <option value=""> Select one Recipient</option>
          <?php
            foreach ($pic as $key ) {
              if($_SESSION['division']!=$key['division'])
                continue;
              echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['location'].'-'.$key['division'].'-'.$key['department'].'-'.$key['first_name'].' '.$key['last_name'].'</option>';
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3"  class="col-sm-2 control-label">Request ID</label>

      <div class="col-sm-10">
        <input type="text" value="<?php echo $filter['r.id_request'];?>"name="id_request" class="form-control" id="inputEmail3" placeholder="Id Request">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Title</label>

      <div class="col-sm-10">
        <input type="text" name='title' value='<?php echo $filter['t.title'];?>' class="form-control" id="inputPassword3" placeholder="Title Task">
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Deadline</label>

      <div class="col-sm-10">
        <input type="text" name="deadline" value="<?php echo $filter['t.deadline'];?>" class="datepicker form-control" id="inputEmail" placeholder="Deadline ">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Status User</label>

      <div class="col-sm-10">
        <!-- <input type="text" name="status_user" class="form-control" id="inputPassword3" placeholder="Status User"> -->
        <select name="status_user" class="form-control" style="width: 100%;">
          <option value="">Select One</option>
          <option value="OPEN">OPEN</option>
          <option value="CANCEL">CANCEL</option>
          <option value="CLOSE">CLOSE</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3"  class="col-sm-2 control-label">Status PIC</label>

      <div class="col-sm-10">
        <!-- <input type="text" name="status_pic" class="form-control" id="inputEmail3" placeholder="Status PIC"> -->
        <select name="status_pic" class="form-control " style="width: 100%;">
          <option value="">Select One</option>
          <option value="unread">UNREAD</option>
          <option value="onprogress">ONPROGRESS</option>
          <option value="solved">SOLVED</option>
          <option value="unsolved">UNSOLVED</option>
        </select>
      </div>
    </div>
  </div>
  </form>
  <div style="border-top: 1px solid #ffffff" class="box-footer">
    <button onclick="reset_fo()" class="btn pull-right btn-warning">Reset</button>
    <button onclick="submit()" class="btn btn-info pull-right">Filter</button>
    <button onclick="export_file()" class="btn btn-primary pull-right">Export</button>
  </div>
  <!-- /.box-footer -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- Default box -->
      <div class="box result_view">
        <div class="box-header with-border">
          <h3 class="box-title">View Receipt</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body ">
          <!-- <button class="btn btn-primary" onclick="reload_table()">Reload</button> -->
          <!-- <h3>Toggle Column View</h3>
          <div class="btn-group">
            <button class="toggle-vis btn btn-flat btn-info" data-column='0'>NIK User</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='1'>Name User</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='2'>Division User</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='3'>NIK PIC</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='4'>Name PIC</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='5'>Division PIC</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='8'>Doc Type</button>
            <button class="toggle-vis btn btn-flat btn-info" data-column='16'>Transfer From</button>
          </div>
        </br>
        <br> -->
          <table id="table_report" class="table table-hover table-bordered">
            <thead >
              <!-- <tr style="text-align: center">
                <th colspan="3">User</th>
                <th colspan="3">PIC</th>
                <th colspan="11">Task Detail</th>
              </tr> -->
              <tr>
                <th>NIk USER</th>
                <th>Name User</th>
                <th>Division User </th>
                <th>NIk PIC</th>
                <th>Name PIC</th>
                <th>Division PIC</th>
                <!-- task detail  -->
                <th>Request ID</th>
                <th>Title</th>
                <th>Doc Type</th>
                <th>Order Date</th>
                <th>Deadline</th>
                <th>Transfer From</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <th>Close Date</th>
                <th>Status User</th>
                <th>Status PIC</th>
                <th>Action </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $class='';
              $dead='-';
              foreach ($list as $key) {
                //get dataType
                $deadline=date_create($key['deadline']);
                $finish=date_create($key['finish_date']);
                $now=date_create(date("Y-m-d"));
                $day=date_diff($deadline,$now);
                $dead=$day->days;
                $button='<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('.$key['id_request'].')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-info" title="Edit" onclick="show('.$key['id_request'].')"><i class="fa fa fa-info-circle"></i> More</a>';
                // echo $day->days;
                if($key['status_user']=='OPEN'){ //jika user open dan status pic masih kosong , waktu telah mendekati deadline
                  $sUser='<i class="fa fa-circle text-primary"></i>'; //kuning unread

                  if($key['status_pic']=='unread'){ //jika masih kosong atau progress
                    $sPic='<i class="fa fa-circle text-warning"></i>'; //kuning unread
                    if($deadline < $now){ //expire
                      $class='danger';
                      $dead='-'.$day->days;
                    }
                    elseif ($day->days<4&&$day->days>=0) {
                      $class='warning'; //mendekati deadline <3
                    }
                    else{
                      $class='';
                    }
                  }
                  elseif ($key['status_pic']=='onprogress') {
                    $sPic='<i class="fa fa-circle text-primary"></i>'; //kuning unread
                    if($deadline < $now){ //expire
                      $class='danger';
                      $dead='-'.$day->days;
                    }
                    elseif ($day->days<4&&$day->days>=0) {
                      $class='warning'; //mendekati deadline <3
                    }
                    else{
                      $class='info';
                    }
                  }
                  elseif($key['status_pic']=='solved'){
                    $sPic='<i class="fa fa-circle text-success"></i>'; //kuning unread
                    if(strtotime($key['deadline']) < strtotime($key['finish_date'])){ //expire
                      $dead='-'.$day->days;
                      $class='danger';
                    }else{
                    $class='success';
                    }
                  }
                  else{
                    $sPic='<i class="fa fa-circle text-danger"></i>'; //kuning unread
                    $class='danger';
                  }
                }
                elseif ($key['status_user']=='CLOSE') {
                  $sUser='<i class="fa fa-circle text-success"></i>'; //kuning unread
                  if($deadline < $finish){ //expire
                    $dead='-'.date_diff($deadline, $finish)->days;
                    $class='danger';
                  }else{
                  $class='success';
                  }
                  $button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('.$key['id_request'].')"><i class="fa fa fa-info-circle"></i> More</a>';

                  if($key['status_pic']=='solved'){
                    $sPic='<i class="fa fa-circle text-success"></i>'; //kuning unread
                  }elseif ($key['status_pic']=='onprogress') {
                    $sPic='<i class="fa fa-circle text-primary"></i>'; //kuning unread

                  }
                  elseif ($key['status_pic']=='unsolved') {
                    $sPic='<i class="fa fa-circle text-danger"></i>'; //kuning unread
                    $class='danger';

                  }
                  else{
                    $sPic='<i class="fa fa-circle text-warning"></i>'; //kuning unread

                  }
                }
                else{
                  $sUser='<i class="fa fa-circle text-success"></i>'; //kuning unread

                  $class='success';
                  $button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('.$key['id_request'].')"><i class="fa fa fa-info-circle"></i> More</a>';
                  if($key['status_pic']=='solved'){
                    $sPic='<i class="fa fa-circle text-success"></i>'; //kuning unread
                  }elseif ($key['status_pic']=='onprogress') {
                    $sPic='<i class="fa fa-circle text-primary"></i>'; //kuning unread

                  }
                  elseif ($key['status_pic']=='unsolved') {
                    $sPic='<i class="fa fa-circle text-danger"></i>'; //kuning unread

                  }
                  else{
                    $sPic='<i class="fa fa-circle text-warning"></i>'; //kuning unread

                  }
                }

                echo '
                <tr class="'.$class.'">
                <td class="sorting_1">'.$key['nik'].'</td>
                <td>'.$key['full_name'].'</td>
                <td>'.$key['div'].'</td>
                <td>'.$key['nik_receipt'].'</td>
                <td>'.$key['name_pic'].'</td>
                <td>'.$key['div_pic'].'</td>
                <td>'.$key['id_request'].'</td>
                <td>'.$key['title'].'</td>
                <td>'.$key['doc_type'].'</td>
                <td>'.date("d/m/Y", strtotime($key['order_date'])).'</td>
                <td>'.date("d/m/Y", strtotime($key['deadline'])).' ('.$dead.' days)'.'</td>
                <td>'.$key['transfer_from'].'</td>
                <td>'.$key['start_date'].'</td>
                <td>'.date("d/m/Y", strtotime($key['finish_date'])).'</td>
                <td>'.$key['close_date'].'</td>
                <td>'.$sUser.' '.$key['status_user'].'</td>
                <td>'.$sPic.' '.$key['status_pic'].'</td>
                <td>'.$button.'</td>
                </tr>';
              }
              ?>
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

  <!-- footer on here -->
  <?php $this->load->view('include/footer')?>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- modal edit -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <div class="modal-body">

        <form id='edit-form'  method="post" enctype="multipart/form-data">
          <input type="hidden" name="id_request" >
          <input type="hidden" name="id_task" >
          <input type="hidden" name="receipt" >
          <input type="hidden" name="sender" >
          <input type="hidden" name='nik_manager' value="<?php echo $_SESSION['nik']?>">
          <div class="form-group">
            <label>PIC</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
            <input disabled id='nik' name="nik_receipt" class="form-control " style="width: 100%;">
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
            <textarea disabled class="memo" id="memo" name="task_detail" placeholder="Place some text here"
                      style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
            <label>Transfer To</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
            <select id='nik' name="transfer_to" class="form-control select2" style="width: 100%;">
              <option value="0"> Select one </option>
              <?php
                foreach ($pic_div as $key ) {
                  // if($_SESSION['nik']==$key['nik'])
                    // continue;
                  echo '<option value="'.$key['nik'].'">'.$key['nik'].'-'.$key['location'].'-'.$key['division'].'-'.$key['department'].'-'.$key['first_name'].' '.$key['last_name'].'</option>';
                }
              ?>
            </select>
          </div>
          <span class="help-block"></span>
          </div>
          <div class="form-group myself">
            <label>Status</label>
            <div class="input-group ">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <select  id="stat_pic" name="status_pic" class="form-control select2" style="width: 100%;">
                <option value="1">Select One</option>
                <option value="onprogress">ONPROGRESS</option>
                <option value="solved">SOLVED</option>
                <option value="unsolved">UNSOLVED</option>
              </select>
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
          <!-- Date -->
          <div class="form-group myself">
            <label>Start Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="start_date" type="text" placeholder="Start date" class="form-control pull-right datepicker">
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
          <!-- Date -->
          <div class="form-group myself">
            <label>Finish Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input name="finish_date" type="text" placeholder="Finish date" class="form-control pull-right datepicker">
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label>Note</label>
            <textarea class="memo" name="pic_note" placeholder="Place some text here"
                      style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
          <!-- /.form-group -->
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
        <ul id="history" class="timeline">
          <!-- order -->

          <!-- timeline time label -->
          <!-- ./request send ============================================================================================================== -->
          <!-- solved kondisi_____________________________________________________________________________________________ -->
          <!-- unsolved condition ______________________________________________________________________________________________ -->
          <!-- calcel condition ________________________________________________________________________________________________ -->
<!-- user close condotion  ______________________________________________________________________________-->

          <!-- END timeline item -->

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
</div>		// foreach ($dat as $key =>$value) {
		//
		// }

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
var flag_manager=false;
var table;
var save_stat=''; //get status_pic from database
var nik='';
$(document).ready(function(){
  //asside active
  $("#receipt_menu").addClass('active');
  $("#receipt_menu").parent().parent().addClass('active menu-open');
  // parent().parent().addClass('active');
  var url='<?php echo site_url().'/request/get_all_request/'.$_SESSION['nik']?>';
  table = $('#table_report').DataTable({
    columnDefs: [
       { type: 'date-uk', targets: 9 }
     ],
    "order": [[ 9, "desc" ]],
    scrollY:        "700px",
    scrollX:        true,
    scrollCollapse: true,
    // paging:         false,
    fixedColumns:   {
        leftColumns: 0,
        rightColumns: 3
    }
  });

  $('[name="status_pic"]').val('<?php echo $filter['r.status_pic']?>');
  $('[name="status_user"]').val('<?php echo $filter['r.status_user']?>');

  //Initialize Select2 Elements
  $('.select2').select2({
    placeholder: "Please Select One",
    allowClear: true
  });

  //get nik from session
  nik=<?php echo $_SESSION['nik']?>;

});

// GetCellValues();
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
         console.log('nik sender: '+data.nik_request);
         save_stat=data.status_pic;
          $(".memo").wysihtml5();
           $('[name="nik_request"]').val(data.nik_request);
           $('[name="sender"]').val(data.nik_request);
           $('[name="receipt"]').val(data.nik_receipt);
           $('[name="id_request"]').val(data.id_request);
           $('[name="nik_from"]').val(data.nik_receipt);
           $('[name="id_task"]').val(data.id_task);
           $('[name="nik_receipt"]').val(data.nik_receipt+"-"+data.location+"-"+data.division+"-"+data.department+"-"+data.first_name+" "+data.last_name);
           $('[name="doc_type"]').val(data.doc_type);
           $('[name="title"]').val(data.title);
           $('#memo').html(data.task_detail);
          // $('#memo').data("wysihtml5").editor.setValue('new content');
           // $('.textarea').html('usman antharikta naik');
           $('[name="deadline"]').val(data.deadline);
           $('[name="pic_note"]').html(data.pic_note);
           $('[name="start_date"]').val(data.start_date);
           $('[name="finish_date"]').val(data.finish_date);
           $('#modal-default').modal('show'); // show bootstrap modal when complete loaded
           $('.modal-title').text("Edit Receipt"); // Set title to Bootstrap modal title
           nik=$('[name="nik_manager"]').val();
           console.log('nik login :'+nik);
           if(nik==data.nik_receipt){
             $('.myself').removeClass('hide');
             flag_manager=true; //
           }
           else{
             $('.myself').addClass('hide');
             flag_manager=false;
           }
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
           alert('Error get data from ajax');
       }
   });
}

function save_edit()
{
  if($('[name="transfer_to"]').val()!=0)
  {
    console.log('transfer');
  }
  else
  {
    var selected_stat=$('#stat_pic').val();

    if(selected_stat==1&&flag_manager){
      bootbox.alert({
        title: '<p class="text-danger">Error!!</p>',
        message: '<p class="text-danger">Status Cannot Empty !!!, Please Select One</p>' ,
      });
      return;
    }

    if(selected_stat=='solved'){
      if(save_stat!='onprogress'){
        bootbox.alert({
          title: '<p class="text-danger">Error!!</p>',
          message: '<p class="text-warning">Please change status PIC to ONPROGRESS first !!!</p>' ,
        });
        return;
      }
      if($('[name="finish_date"]').val()=='0000-00-00'||$('[name="finish_date"]').val()==''){
        $('[name="finish_date"]').parent().parent().addClass('has-error');
        bootbox.alert({
          title: '<p class="text-danger">Error!!</p>',
          message: '<p class="text-warning">Finish Date is Invalid !!!</p>' ,
        });
        return;
      }
    }

    if(selected_stat=='unsolved'){
      if(save_stat!='onprogress'){
        bootbox.alert({
          title: '<p class="text-danger">Error!!</p>',
          message: '<p class="text-warning">Please change status PIC to ONPROGRESS first !!!</p>' ,
        });
        return;
      }
    }

    if(selected_stat=='onprogress'){
      if($('[name="start_date"]').val()=='0000-00-00'||$('[name="start_date"]').val()==""){
        $('[name="start_date"]').parent().parent().addClass('has-error');
        bootbox.alert({
          title: '<p class="text-danger">Error!!</p>',
          message: '<p class="text-warning">Start Date is Invalid !!!</p>' ,
        });
        return;
      }
    }
  } //else
    var formdata = new FormData($('#edit-form')[0]);
    // event.preventDefault();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $.ajax({
      url : '<?php echo site_url('/receipt/save_edit') ?>',
      type: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      dataType: "JSON",
      success: function(data)
      {
        $('#modal-default').modal('hide'); // show bootstrap modal when complete loaded
        location.reload();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding / update data');
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
      }
    });
  }

  $('button .btn').click(function(event) {
       event.preventDefault(event);
  });

function show(id_request)
{
  $.ajax({
      url : "<?php echo site_url('request/ajax_show')?>/" + id_request,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#history').html(data.history);
        $('#modal-timeline').modal('show'); // show bootstrap modal when complete loade
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
  });
}
var dateToday = new Date();
$('.datepicker').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd',
  startDate: dateToday,
});

//reset
function reset_fo()
{
  $('[name="id_request"]').val('');
  $('[name="title"]').val('');
  $('[name="deadline"]').val('');
  $('[name="status_pic"]').val('');
  $('[name="status_user"]').val('');
  submit();
}

function submit()
{
    $('[name="export"]').val('');
  $('#filter-form').submit();
}

function export_file()
{
  $('[name="export"]').val('yes');
  console.log('test: '+$('[name="export"]').val());
  $('#filter-form').submit();
}

</script>
</body>
</html>
