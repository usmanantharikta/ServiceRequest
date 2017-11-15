<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	/**
	 * This controller use for access to application like
	 * view login
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('access_model');
		$this->load->model('request_model');
	}

	public function index()
	{
		$pic=$this->request_model->getnik();
		$data['pic']=$pic;
		$this->load->view('request/dashboard',$data);
	}

	public function sumMonthly(){
		$nik=$this->session->userdata('nik');
		$sql='status_pic, COUNT(status_pic) as "jumlah", MONTH(order_date) as "month" FROM request WHERE status_pic="solved" || status_pic="unsolved" GROUP BY status_pic, MONTH(order_date)';
		$sqli='status_pic, COUNT(status_pic) as "jumlah" FROM request where nik_receipt="'.$nik.'" GROUP BY status_pic'; // receipt
		$this->db->select($sqli,false);
		$query=$this->db->get();
		$status=$query->result_array();

		$json_status=array();
		$solved=array();
		$unsolved=array();
		$data=array();

		foreach ($status as $key) {
			if($key['status_pic']==''){
				array_push($json_status, array(
					'label'=>'UnRead',
					'value'=>$key['jumlah']
				));
			}else{
				array_push($json_status, array(
					'label'=>$key['status_pic'],
					'value'=>$key['jumlah']
				));
			}
		}

		//donut request
		$req=$this->count_request();
		$json_request=array();
		foreach ($req as $key) {
				array_push($json_request, array(
					'label'=>$key['status_user'],
					'value'=>$key['jumlah']
				));
		}

		echo json_encode(array('value'=>$data, 'donut'=>$json_status, 'donut_req'=>$json_request));
	}

	private function count_request(){
		$nik=$this->session->userdata('nik');
		$request='status_user, COUNT(status_pic) as "jumlah" FROM request where nik_receipt="'.$nik.'" GROUP BY status_user'; // request
		$this->db->select($request,false);
		$query=$this->db->get();
		$status=$query->result_array();
		return $status;
	}

}
