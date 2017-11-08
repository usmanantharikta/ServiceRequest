<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends CI_Controller {

	/**
	 * This controller use for access to application like
	 * view login
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('receipt_model');
		$this->load->model('request_model');
		$this->load->model('manager_model');
	}

  public function index(){
		$filter_data=array(
			'r.nik_request'=>$this->input->post('nik_request'),
			'r.id_request'=>$this->input->post('id_request'),
			't.title'=>$this->input->post('title'),
			't.deadline'=>$this->input->post('deadline'),
			'r.status_user'=>$this->input->post('status_user'),
			'r.status_pic'=>$this->input->post('status_pic')
		);

		$da=$this->receipt_model->get_all($this->session->userdata('nik'), $filter_data);
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
    $this->load->view('request/receipt_view',$data);
		echo json_encode(array('nik'=>$this->session->userdata('nik')));
  }


	public function save_edit(){
		$id_request=$this->input->post('id_request');
		$status=$this->input->post('status_pic');
		$close_date=date('Y-m-d');
		$pic_note=$this->input->post('pic_note');
		$start_date=$this->input->post('start_date');
		$finish_date=$this->input->post('finish_date');
		$update='';
		//cek apakah itu manager atau bukan
		$transfer_to=$this->input->post('transfer_to');
		$nik_from=$this->input->post('nik_from');
		if($transfer_to!=''){
			$update=$this->manager_model->change_receipt(array('nik_receipt'=>$transfer_to,'transfer_from'=>$nik_from, 'pic_note'=>$pic_note),array('id_request'=>$id_request));
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('transfer-time'=>date('Y-m-d H:i:s')));
		}else{
			if($status=='solved'){
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'finish_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('solved_time'=>date('Y-m-d H:i:s')));
			}elseif ($status=='onprogress') {
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'start_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('start_time'=>date('Y-m-d H:i:s')));
			}elseif ($status=='unsolved') {
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'finish_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('unsoved_time'=>date('Y-m-d H:i:s')));
			}

			$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status,'start_date'=>$start_date, 'finish_date'=>$finish_date, 'pic_note'=>$pic_note));
		}
		echo json_encode(array('status'=>false, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
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
			'status_user'=>'open'
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
			if($key['status_user']=='open'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			if($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
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
			if($key['status_user']=='open'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			elseif($key['status_user']=='close'){
				$status_u='<p class="text-danger">CLOSE</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';
			}else{
				$status_u='';
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
		$data=$this->request_model->get_data_byid($id_request);
		$dep=$this->request_model->get_dept($data->nik_receipt);
		$name=$this->request_model->get_name($data->nik_receipt);
		$full=$dep."-".$name;
		echo json_encode(array('d'=>$data, 'name'=>$full));

	}

	// public function save_edit(){
	// 	$id_request=$this->input->post('id_request');
	// 	$status=$this->input->post('status_user');
	// 	$close_date=Date('Y-m-d');
	//
	// 	$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_user'=>$status, 'close_date'=>$close_date));
	// 	echo json_encode(array('status'=>false, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
	// }

}
