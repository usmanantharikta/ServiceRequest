<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directure_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_request($div,$filter){
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_request ";
      $flag=true;
      if(count($filter)>0){
        foreach ($filter as $key => $value) {
          if($value!=''&&$key!='t.title'){
            if($flag){ //cek first not null
              $sql.=' where '.$key.'="'.$value.'"';
              $flag=false;
            }else{
              $sql.=' and '.$key.'="'.$value.'"';
            }
          }elseif($key=='t.title'&&$value!=''){
            if($flag){ //cek first not null or wmpty
              $sql.=' where '.$key.' like "%'.$value.'%"';
              $flag=false;
            }else{
              $sql.=' and '.$key.' like "%'.$value.'%"';

            }
          }
        }
      }
      $sql.=' order by r.id_request desc';
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

    public function get_nik_same()
    {
      // $this->db->distinct();
      // $this->db->select('e.ni k as "nik_receipt"');
      // $this->db->from('request r');
      // $this->db->join('employee e','e.nik=r.nik_receipt', 'left');
      // $this->db->where('e.division', $this->session->userdata('division'));
      $query=$this->db->query('SELECT DISTINCT e.nik as "nik_receipt" FROM employee e LEFT JOIN request r ON e.nik =r.nik_receipt');
      $result=$query->result_array();
      if(count($result)>0){
        return $result;
      }else{
        return "0";
      }
    }

    public function get_num($nik, $status){
      $query=$this->db->query('select count(status_pic) as "count" from request where nik_receipt='.$nik.' and status_pic="'.$status.'" group by status_pic');
      $result=$query->row();
      if(isset($result)){
        return $result->count;
      }else{
        return "0";
      }
    }

}
