<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

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
		$this->load->view('main/change_password',$data);
	}

	public function access(){
		$username=$this->input->post('nik');
		$password=$this->input->post('old_password');
		$result=$this->access_model->verification(array('username'=>$username,'password'=>$password));
		$this->_validate($result);
		//jika password benar
		if($result==2){
			$this->update_password();
		}
	}

	private function _validate($result)
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
				if($this->input->post('new_password')!=$this->input->post('re_password'))
				{
						$data['inputerror'][] = 're_password';
						$data['error_string'][] = 'Password Does Not Match';
						$data['status'] = FALSE;
				}

				if($result==0)
				{
						$data['inputerror'][] = 'old_password';
						$data['error_string'][] = 'Old Password is Invalid';
						$data['status'] = FALSE;
				}
				//password salah
				if($result==1){
					$data['inputerror'][] = 'old_password';
					$data['error_string'][] = 'Please Insert Old Password';
					$data['status'] = FALSE;
				}

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

		private function update_password(){
			$update=$this->access_model->update_password(array('nik'=>$this->session->userdata['nik']),array('password'=>password_hash($this->input->post('new_password'),PASSWORD_DEFAULT)));
			echo json_encode(array("status" => TRUE, 'level'=>$this->session->userdata('level')));
			exit();
		}

		public function logout(){
			$sessiondata=array(
				'username'=>'',
				'nik'=>'',
				'fullname'=> '',
				'level'=>'',
				'division'=>'',
				'full_div'=>'',
			);
				$this->session->unset_userdata($sessiondata);
				$this->session->sess_destroy();
				redirect('/login', 'location');
		}

		public function get_notif(){
			$controller='';
			if($_SESSION['level']=='manager'){
				$controller='manager';
			}
			if ($_SESSION['level']=='directure' || $_SESSION['level']=='admin') {
				$controller='directure';
			}
			if ($_SESSION['level']=='staf'){
				$controller='request';
			}
			$this->db->select('*');
			$this->db->where('nik_receipt', $this->session->userdata('nik'));
			$this->db->where('status', 'unread');
			$this->db->from('notification');
			$query=$this->db->get();
			$result=$query->result_array();
			$notif='';
			if(count($result)>0){
				foreach ($result as $key ) {
					if($key['value']!='New Request')
					{
						if($key['value']=='Canceled'){
							if($_SESSION['level']=='staf'){
								$notif.='<li>
												<a href="'.site_url().'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
													<i class="fa fa-user text-green"></i>Request ID '.$key['request_id'].' it was '.$key['value'].'
												</a>
											</li>';
							}else{
								$notif.='<li>
												<a href="'.site_url().'/'.$controller.'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
													<i class="fa fa-user text-green"></i>Request ID '.$key['request_id'].' it was '.$key['value'].'
												</a>
											</li>';
							}
						}
						else { //unsolved
						$notif.='<li>
										<a href="'.site_url().'/'.$controller.'/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
											<i class="fa fa-user text-green"></i> Request ID '.$key['request_id'].' it was '.$key['value'].'
										</a>
									</li>';
						}
					}
					else
					{
						if($_SESSION['level']=='staf'){
							$notif.='<li>
											<a href="'.site_url().'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
												<i class="fa fa-user text-green"></i>'.$this->request_model->get_name($key['nik_request']).' Sent Service Request to you
											</a>
										</li>';
						}else{
							$notif.='<li>
											<a href="'.site_url().'/'.$controller.'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
												<i class="fa fa-user text-green"></i>'.$this->request_model->get_name($key['nik_request']).' Sent Service Request to you
											</a>
										</li>';
						}
					}
				}
			}
			// echo 'notif :'.$notif;
			echo json_encode(array('all'=>count($result), 'notif'=>$notif));
		}

		public function activity()
		{
			$controller='';
			if($_SESSION['level']=='manager'){
				$controller='manager';
			}
			if ($_SESSION['level']=='directure' || $_SESSION['level']=='admin') {
				$controller='directure';
			}
			if ($_SESSION['level']=='staf'){
				$controller='request';
			}

			$this->db->select('*');
			$this->db->from('notification n');
			$this->db->join('request r', 'r.id_request=n.request_id');
			$this->db->where('n.nik_receipt', $this->session->userdata('nik'));
			$query=$this->db->get();
			$result=$query->result_array();

			//create new Array
			$newArray=array();

			//manipulate Array
			foreach ($result as $key) {
				//cek jeni
				if($key['value']!='New Request')
				{
					if($key['value']=='Canceled'){
						if($_SESSION['level']=='staf'){
							$link='<a href="'.site_url().'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
												<i class="fa fa-user text-green"></i>Request ID '.$key['request_id'].' it was '.$key['value'].'
											</a>';
						}else{
							$link='<a href="'.site_url().'/'.$controller.'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
												<i class="fa fa-user text-green"></i>Request ID '.$key['request_id'].' it was '.$key['value'].'
											</a>';
						}
					}
					else { //unsolved
					$link='<a href="'.site_url().'/'.$controller.'/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
										<i class="fa fa-user text-green"></i> Request ID '.$key['request_id'].' it was '.$key['value'].'
									</a>';
					}
				}
				else
				{
					if($_SESSION['level']=='staf'){
						$link='<a href="'.site_url().'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
											<i class="fa fa-user text-green"></i>'.$this->request_model->get_name($key['nik_request']).' Sent Service Request to you
										</a>';
					}else{
						$link='<a href="'.site_url().'/'.$controller.'/receipt/?notif='.$key['id'].'&export=&id_request='.$key['request_id'].'">
											<i class="fa fa-user text-green"></i>'.$this->request_model->get_name($key['nik_request']).' Sent Service Request to you
										</a>';
					}
				}
				array_push($newArray, array(
					$key['times'],
					$this->request_model->get_name($key['nik_request']).'-'.$this->request_model->get_dept($key['nik_request']),
					$key['request_id'],
					$key['value'],
					$link,
					$key['status'],
				));
			}
			echo json_encode(array('data'=>$newArray));

		}
}
