<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directure extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		$this->load->model('directure_model');
		$this->load->model('request_model');
		$this->load->model('receipt_model');
	}
	public function index()
	{
		$filter_data=array(
			'r.nik_request'=>$this->input->post('nik_request'),
			'r.id_request'=>$this->input->post('id_request'),
			't.title'=>$this->input->post('title'),
			't.deadline'=>$this->input->post('deadline'),
			'r.status_user'=>$this->input->post('status_user'),
			'r.status_pic'=>$this->input->post('status_pic')
		);

		$da=$this->directure_model->get_all_request($this->session->userdata('division'), $filter_data);
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
		$this->load->view('main/super_view',$data);
	}

	//show page add request
	public function add_request(){
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;
		$this->load->view('main/add_request_', $data);
	}

	public function receipt(){
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
		$this->load->view('main/receipt_view',$data);
		echo json_encode(array('nik'=>$this->session->userdata('nik')));
	}

}
