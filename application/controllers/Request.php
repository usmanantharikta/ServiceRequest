<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	/**
	 * This controller use for access to application like
	 * view login
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('request_model');
		$this->load->model('receipt_model');

	}

  public function index(){
		$filter_data=array(
			'r.nik_receipt'=>$this->input->post('nik_receipt'),
			'r.id_request'=>$this->input->post('id_request'),
			't.title'=>$this->input->post('title'),
			't.deadline'=>$this->input->post('deadline'),
			'r.status_user'=>$this->input->post('status_user'),
			'r.status_pic'=>$this->input->post('status_pic')
		);

		$da=$this->request_model->get_all_request($this->session->userdata('nik'), $filter_data);
		$new_data=array();
		foreach ($da as $key ) {
			array_push($new_data, array(
				'nik'=>$key['nik_request'],
				'full_name'=>$key['first_name'].' '.$key['last_name'],
				'div'=>$key['location'].'-'.$key['division'].'-'.$key['department'],
				'nik_receipt'=>$key['nik_receipt'],
				'name_pic'=>$this->request_model->get_name($key['nik_receipt']),
				'div_pic'=>$this->request_model->get_dept($key['nik_receipt']),
				'id_task'=>$key['id_task'],
				'title'=>$key['title'],
				'doc_type'=>$key['doc_type'],
				'order_date'=>$key['order_date'],
				'deadline'=>$key['deadline'],
				'status_pic'=>$key['status_pic'],
				'start_date'=>$key['start_date'],
				'finish_date'=>$key['finish_date'],
				'status_user'=>$key['status_user'],
				'close_date'=>$key['close_date'],
				'transfer_from'=>$key['transfer_from'],
				'id_request'=>$key['id_request'],
				));
		}
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;

		$data['list']=$new_data;
		$data['filter']=$filter_data;
    $this->load->view('request/request_view',$data);
  }

	//show page add request
	public function add_request(){
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;
		$this->load->view('request/add_request', $data);
	}
	//retrive data form from add request
	public function add(){
		$this->_validate();
		$request=array(
			'nik_request'=>$this->input->post('nik_request'),
			'nik_receipt'=>$this->input->post('nik_receipt'),
			'order_date'=>date("Y-m-d"),
			'status_user'=>'OPEN'
		);
		$task=array(
			'title'=>$this->input->post('title'),
			'task_detail'=>$this->input->post('task_detail'),
			'create_date'=>date("Y-m-d"),
			'deadline'=>$this->input->post('deadline'),
			'doc_type'=>$this->input->post('doc_type')
		);
		$result=$this->request_model->save_request($request, $task);
		echo json_encode(array('status'=>true, 'result'=>$result));
	}

	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nik_receipt') == '')
        {
            $data['inputerror'][] = 'nik_receipt';
            $data['error_string'][] = 'Recipient is required !!!';
            $data['status'] = FALSE;
        }
				if($this->input->post('title') == '')
				{
						$data['inputerror'][] = 'title';
						$data['error_string'][] = 'Title is required !!!';
						$data['status'] = FALSE;
				}
				if($this->input->post('deadline') == '')
				{
						$data['inputerror'][] = 'deadline';
						$data['error_string'][] = 'Deadline is required !!!';
						$data['status'] = FALSE;
				}

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

	public function get_last_request($id_request){
		$data=$this->request_model->get_last($id_request);
		$new_data=array();
		$status_u="";
		foreach ($data as $key) {
			if($key['status_user']=='OPEN'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			if($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
			}
			if($key['status_user']=='CANCEL'){
				$status_u='<p class="text-warning">CANCEL</p>';
			}
			array_push($new_data, array(
//        '<input type="checkbox" id="check-all" class="flat">',
				$key['nik_request'],
				$key['first_name'].' '.$key['last_name'],
				$key['location'].'-'.$key['division'].'-'.$key['department'],
				$key['nik_receipt'],
				$this->request_model->get_name($key['nik_receipt']),
				$this->request_model->get_dept($key['nik_receipt']),
				$key['id_task'],
				$key['title'],
				$key['doc_type'],
				$key['order_date'],
				$key['deadline'],
				$key['status_pic'],
				$key['start_date'],
				$key['finish_date'],
				$status_u,
				$key['close_date'],
				$key['transfer_from'],
				'<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Show More</a>',
			));
		}

		echo json_encode(array('data'=>$new_data));
	}

	public function get_all_request($id_request){
		$data=$this->request_model->get_all_request($id_request);
		$new_data=array();
		$status_u="";
		foreach ($data as $key) {
			$button='<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('."'".$key['id_request']."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
			<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa fa-info-circle"></i> Show More</a>';
			if($key['status_user']=='OPEN'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			elseif($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';
			}
			elseif($key['status_user']=='CANCEL'){
				$status_u='<p class="text-warning">CANCEL</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';

			}
			array_push($new_data, array(
//        '<input type="checkbox" id="check-all" class="flat">',
				$key['nik_request'],
				$key['first_name'].' '.$key['last_name'],
				$key['location'].'-'.$key['division'].'-'.$key['department'],
				$key['nik_receipt'],
				$this->request_model->get_name($key['nik_receipt']),
				$this->request_model->get_dept($key['nik_receipt']),
				$key['id_task'],
				$key['title'],
				$key['doc_type'],
				$key['order_date'],
				$key['deadline'],
				$key['status_pic'],
				$key['start_date'],
				$key['finish_date'],
				$status_u,
				$key['close_date'],
				$key['transfer_from'],
				$button,
			));
		}

		echo json_encode(array('data'=>$new_data));
	}

	public function ajax_edit($id_request)
	{
		$data=$this->request_model->get_data_byid($id_request);
		echo json_encode($data);
	}

	public function ajax_show($id_request)
	{
		$dat=$this->request_model->get_data_byid($id_request);
		$dep=$this->request_model->get_dept($dat->nik_receipt);
		$name=$this->request_model->get_name($dat->nik_receipt);
		$full=$name."-".$dep;
		$this->data_tempel($dat, $full);
		// echo json_encode(array('d'=>$data, 'name'=>$full));
	}

	private function data_tempel($data, $full){
		// was create
		$name_req=$data->first_name.' '.$data->last_name.'-'.$data->location.'-'.$data->division.'-'.$data->department;
		$time=strtotime($data->create_time);
		// echo date('h:i:s', $time);

		$time_line='
		<li class="time-label">
					<span class="order_date bg-red">';
		$time_line.=$data->order_date;
		$time_line.='</span>
		</li>
		<!-- ./end order -->
		<!-- deatil request -->
		<li>
			<i class="fa fa-envelope bg-blue"></i>
			<div class="timeline-item">
				<span id="create_time" class="time">';
		$time_line.=date('h:i:s', $time);
		$time_line.='</span>
				<h3 class="timeline-header"><a class="request_name" href="#">';
		$time_line.=$name_req;
		$time_line.='</a> create a request</h3>
				<div id="detail_task" class="timeline-body">
					<h4>Detail Request </h4>';
		$time_line.=$data->task_detail;
		$time_line.='</div>
				<div class="timeline-footer">
				</div>
			</div>
		</li>
		<!-- end detail request-->
		<!-- status user -->
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
				<h3 class="timeline-header no-border">Request is Send to  <a class="receipt_name" class="text-green" href="#">';
		$time_line.=$full.'nitip';
		$time_line.='</a></h3>
			</div>
		</li>
		';
		// var_dump($data);
			if($data->start_time!="0000-00-00 00:00:00"){

				$time_line.='
				<!-- recipient accept ________________________________________________________________________________________ -->
				<li class="time-label">
							<span id="start_date" class="bg-green">';
				$time_line.=date('Y-m-d', strtotime($data->start_time));
				$time_line.='
							</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li class="acc">
					<i class="fa fa-camera bg-purple"></i>
					<div class="timeline-item">
						<span id="respon" class="time"><i class="fa fa-clock-o"></i>';
				$time_line.=date('h:i:s', strtotime($data->start_time));
				$time_line.='</span>
<h3 class="timeline-header"><a class="receipt_name" href="#">';
				$time_line.=$full;
				$time_line.='</a> Change Status PIC to On Process</h3>
						<div id="start_detail" class="timeline-body"> This task will start at '.$data->start_date.'<p>PIC note :</p>';
				$time_line.=$data->pic_note;
				$time_line.='
						</div>
					</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li >
					<i class="fa fa-bell bg-aqua"></i>
					<div class="timeline-item">
						<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						<h3 class="timeline-header no-border">Status PIC is ';
				$time_line.='<a class="text-green">ONPROCESS</a>';
				$time_line.='</h3>
					</div>
				</li>
				<!-- END timeline item -->';
		}

		if($data->solved_time!="0000-00-00 00:00:00"){
			$time_line.='
			<li class=" time-label">
			       <span id="finish_time" class="bg-green">
			              '.date('Y-m-d',strtotime($data->solved_time)).'
			                </span>
			          </li>
			          <!-- /.timeline-label -->
			          <!-- timeline item -->
			          <li class=" solved">
			            <i class="fa fa-camera bg-purple"></i>

			            <div class="timeline-item">
			              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->solved_time)).	'</span>
			              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$full.'</a> Change Status PIC to Solved</h3>
			              <div id="finish-detail" class="timeline-body">
										<p>PIC Note :</p>
										'.$data->pic_note.'
			              </div>
			            </div>
			          </li>
			          <!-- END timeline item -->
			          <!-- timeline item -->
			          <li>
			            <i class="fa fa-bell bg-aqua"></i>

			            <div class="timeline-item">
			              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
			              <h3 class="timeline-header no-border">Status User is <a class="text-green">SOLVED </a> </h3>
			            </div>
			          </li>
			          <!-- END timeline item -->';
		}

		//if un solved
		if($data->unsoved_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->unsoved_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-cross bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->unsoved_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$full.'</a> Change Status PIC to Unsolved</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>PIC Note :</p>
													'.$data->pic_note.'
						              </div>
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-danger">UNSOLVED </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		//if cancel
		if($data->cancel_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->cancel_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-cross bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->cancel_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$name_req.'</a> Change Status PIC to CANCEL</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>Detail Task :</p>
													'.$data->task_detail.'
						              </div>
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-danger">CANCEL </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		//close condition

		if($data->close_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->close_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-cross bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->close_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$name_req.'</a> Change Status PIC to CLOSE</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>Detail Task :</p>
													'.$data->task_detail.'
						              </div>
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-green">CLOSE </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		$time_line.='   <li >
		            <i class="fa fa-clock-o bg-gray"></i>
		          </li>';

		echo json_encode(array('history'=>$time_line));
	}

	public function save_edit(){
		$id_request=$this->input->post('id_request');
		$status=$this->input->post('status_user');
		$close_date=Date('Y-m-d');
		if($status=='CLOSE'){
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('close_time'=>date('Y-m-d H:i:s')));
		}
		elseif($status=='CANCEL'){
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('cancel_time'=>date('Y-m-d H:i:s')));
		}
		$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_user'=>$status, 'close_date'=>$close_date));
		echo json_encode(array('status'=>false, 'request_id'=>$id_request, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
	}

}
