<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function verification($data){
      //cek username
      $this->db->select('*');
      $this->db->from('user u');
      $this->db->join('employee e', 'e.nik=u.nik');
      $this->db->where('u.username',$data['username']);
      $query=$this->db->get();
      $result=$query->result_array();
      if(count($result)>0){
        if (password_verify($data['password'], $result[0]['password'])) {
            $sessiondata=array(
              'username'=>$result[0]['username'],
              'nik'=>$result[0]['nik'],
              'fullname'=> $this->getname($result[0]['nik']),
              'level'=>$result[0]['level'],
              'division'=>$result[0]['division'],
              'full_div'=>$result[0]['nik'].' - '.$result[0]['location'].' - '.$result[0]['division'].' - '.$result[0]['department'],
            );
            $this->session->set_userdata($sessiondata);
            return 2; //password benar
        } else {
            return 1; //password salah
        }
      }
      else{
        return 0; //email salah
      }
    }

    private function getname($nik){
      $this->db->select('first_name,last_name');
      $this->db->where('nik',$nik);
      $this->db->from('employee');
      $query=$this->db->get();
      $data=$query->result_array();
      return $data[0]['first_name']." ".$data[0]['last_name'];
    }

    public function update_password($where, $data){
      $this->db->update('user',$data, $where);
      return $this->db->affected_rows();

    }

}
