<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_request($nik,$filter,$div){
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_request where e.division ='".$div."'";
      $flag=true;
      if(count($filter)>0){
        foreach ($filter as $key => $value) {
          if($value!=''&&$key!='t.title'){
            if($flag){ //cek first not null
              $sql.=' and '.$key.'="'.$value.'"';
              $flag=false;
            }else{
              $sql.=' and '.$key.'="'.$value.'"';
            }
          }elseif($key=='t.title'&&$value!=''){
            if($flag){ //cek first not null or wmpty
              $sql.=' and '.$key.' like "%'.$value.'%"';
              $flag=false;
            }else{
              $sql.=' and '.$key.' like "%'.$value.'%"';

            }
          }
        }
      }
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

    public function get_all_receipt($nik,$filter,$div){
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_receipt where e.division ='".$div."'";
      $flag=true;
      if(count($filter)>0){
        foreach ($filter as $key => $value) {
          if($value!=''&&$key!='t.title'){
            if($flag){ //cek first not null
              $sql.=' and '.$key.'="'.$value.'"';
              $flag=false;
            }else{
              $sql.=' and '.$key.'="'.$value.'"';
            }
          }elseif($key=='t.title'&&$value!=''){
            if($flag){ //cek first not null or wmpty
              $sql.=' and '.$key.' like "%'.$value.'%"';
              $flag=false;
            }else{
              $sql.=' and '.$key.' like "%'.$value.'%"';

            }
          }
        }
      }
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

    //change receipt by manager or transfer to
    public function change_receipt($data, $where){
      $this->db->update('request', $data,$where);
      // echo json_encode($data);
      return $this->db->affected_rows();

    }
  //get pic by division
  public function getpic_div($div){
    $this->db->select('*');
    $this->db->where('division',$div);
    $this->db->from('employee');
    $query=$this->db->get();
    return $query->result_array();
  }

}
