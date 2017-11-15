<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model('admin_model');
		$this->load->model('access_model');
		$this->load->library('excel');
	}

	public function create_user(){
		$all_data=$this->admin_model->get_employ();
		$filter_data=array();
		// print_r($all_data);
		foreach ($all_data as $key) {
			if($key['username']==''){
				array_push($filter_data, array(
					'nik'=>$key['nik'],
					'full_name'=>$key['first_name']." ".$key['last_name'],
					'division'=>$key['location'].'-'.$key['division'].'-'.$key['department'],
				));
			}
		}
		// print_r($filter_data);
		$data['user']=$filter_data;
		$this->load->view('admin/create_user', $data);
	}

	public function save_user(){
		$username=$this->input->post('username');
		$level=$this->input->post('level');
		$password=$this->input->post('new_password');
		$this->_validate();
		$insert=$this->admin_model->save_user(array('nik'=>$username, 'username'=>$username, 'level'=>$level, 'password'=>password_hash($password, PASSWORD_DEFAULT)));
		echo json_encode(array('status'=>true, 'id user'=>$insert));
	}

	private function _validate()
		{
				$data = array();
				$data['error_string'] = array();
				$data['inputerror'] = array();
				$data['status'] = TRUE;
				//password email salah
				// if($result==0)
				// {
				//     $data['inputerror'][] = 'username';
				//     $data['error_string'][] = 'Username is Invalid';
				//     $data['status'] = FALSE;
				// }
				if($this->input->post('new_password')=='')
				{
						$data['inputerror'][] = 'new_password';
						$data['error_string'][] = 'new Password cannot empty';
						$data['status'] = FALSE;
				}
				if($this->input->post('re_password')=='')
				{
						$data['inputerror'][] = 're_password';
						$data['error_string'][] = 'Please Re Type New Password';
						$data['status'] = FALSE;
				}
				if($this->input->post('username')=='')
				{
						$data['inputerror'][] = 'username';
						$data['error_string'][] = 'User ID cannot empty';
						$data['status'] = FALSE;
				}
				if($this->input->post('level')=='')
				{
						$data['inputerror'][] = 'level';
						$data['error_string'][] = 'Please Select One of Level user ';
						$data['status'] = FALSE;
				}
				if($this->input->post('new_password')!=$this->input->post('re_password'))
				{
						$data['inputerror'][] = 're_password';
						$data['error_string'][] = 'Password Does Not Match';
						$data['status'] = FALSE;
				}

				if($data['status'] === FALSE)
				{
						echo json_encode($data);
						exit();
				}
		}

		public function reset_password(){
			$pic=$this->request_model->getnik();
			$data['pic']=$pic;
			$this->load->view('admin/change_password', $data);
		}

		public function save_reset(){
			$this->_validate_reset();
			$this->update_password();
			}

		private function update_password(){
			$update=$this->access_model->update_password(array('nik'=>$this->input->post('nik')),array('password'=>password_hash($this->input->post('new_password'),PASSWORD_DEFAULT)));
			echo json_encode(array("status" => TRUE));
			exit();
		}

		private function _validate_reset()
			{
					$data = array();
					$data['error_string'] = array();
					$data['inputerror'] = array();
					$data['status'] = TRUE;
					if($this->input->post('new_password')=='')
					{
							$data['inputerror'][] = 'new_password';
							$data['error_string'][] = 'new Password cannot empty';
							$data['status'] = FALSE;
					}
					if($this->input->post('re_password')=='')
					{
							$data['inputerror'][] = 're_password';
							$data['error_string'][] = 'Please Re Type New Password';
							$data['status'] = FALSE;
					}
					if($this->input->post('nik')=='')
					{
							$data['inputerror'][] = 'nik';
							$data['error_string'][] = 'User ID cannot empty';
							$data['status'] = FALSE;
					}
					if($this->input->post('new_password')!=$this->input->post('re_password'))
					{
							$data['inputerror'][] = 're_password';
							$data['error_string'][] = 'Password Does Not Match';
							$data['status'] = FALSE;
					}

					if($data['status'] === FALSE)
					{
							echo json_encode($data);
							exit();
					}
			}

			public function add_employ(){
				$this->load->view('admin/add_employ');
			}

			public function save_employee(){
				$this->validate_employ();
				$dataInsert=array(
					'nik'=>$this->input->post('nik'),
					'first_name'=>$this->input->post('first_name'),
					'last_name'=>$this->input->post('last_name'),
					'location'=>$this->input->post('location'),
					'division'=>$this->input->post('division'),
					'department'=>$this->input->post('department'),
					'phone'=>$this->input->post('phone'),
					'email'=>$this->input->post('email'),
					'dob'=>$this->input->post('dob'),
					'gender'=>$this->input->post('gender'),
				);
				$insert=$this->admin_model->save_employee($dataInsert);
				echo json_encode(array('status'=>true));
			}

			private function validate_employ(){
					$data = array();
					$data['error_string'] = array();
					$data['inputerror'] = array();
					$data['status'] = TRUE;
					if($this->input->post('nik')=='')
					{
							$data['inputerror'][] = 'nik';
							$data['error_string'][] = 'User ID cannot empty';
							$data['status'] = FALSE;
					}
					if($this->input->post('first_name')=='')
					{
							$data['inputerror'][] = 'first_name';
							$data['error_string'][] = 'First Name cannot empty';
							$data['status'] = FALSE;
					}
					if($this->input->post('email')=='')
					{
							$data['inputerror'][] = 'email';
							$data['error_string'][] = 'Email cannot be Empty';
							$data['status'] = FALSE;
					}

					if($data['status'] === FALSE)
					{
							echo json_encode($data);
							exit();
					}
			}

			public function list_employ(){
				$this->db->select("*");
				$this->db->from('employee');
				$query=$this->db->get();
				$data=$query->result_array();

				$list=array();

				foreach ($data as $key) {
					array_push($list, array(
						$key['id'],
						$key['nik'],
						$key['first_name'],
						$key['last_name'],
						$key['location'],
						$key['division'],
						$key['department'],
						$key['phone'],
						$key['email'],
						date('Y')-date('Y', strtotime($key['dob'])),
						$key['gender']));
				}
				echo json_encode(array('data'=>$list));
			}


}
