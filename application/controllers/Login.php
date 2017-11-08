<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->view('main/login',$data);
	}

	public function access(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$result=$this->access_model->verification(array('username'=>$username,'password'=>$password));
		$this->_validate($result);
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
				if($result==0)
				{
						$data['inputerror'][] = 'password';
						$data['error_string'][] = 'Password is Invalid';
						$data['status'] = FALSE;
				}
				//password salah
				if($result==1){
					$data['inputerror'][] = 'password';
					$data['error_string'][] = 'Password is Invalid';
					$data['status'] = FALSE;
				}
				//jika password benar
				if($result==2){
					echo json_encode(array("status" => TRUE, 'level'=>$this->session->userdata('level')));
					exit();
				}

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}
