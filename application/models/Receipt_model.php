<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    //get list of pic from table employee
    public function getpic(){
      $this->db->select('*');
      $this->db->from('employee');
      $query=$this->db->get();
      return $query->result_array();
    }

    //get list of pic from table employee
    public function getnik(){
      $this->db->select('*');
      $this->db->from('employee');
      $this->db->join('user', 'user.nik = employee.nik');
      $query=$this->db->get();
      return $query->result_array();
    }

    //save request
    public function save_request($request, $task){
      //save task
      $idtask=$this->save_task($task);
      //save request
      $new_arr=array('task_id'=>$idtask);
      $arraymerge=array_merge($request, $new_arr);
      $this->db->insert('request',$arraymerge);
      return $this->db->insert_id();
    }

    private function save_task($data){
      $this->db->insert('Task', $data);
      return $this->db->insert_id();
    }

    public function get_last($id){
      $this->db->select('*');
      $this->db->from('request');
      $this->db->join('Task', 'Task.id_task=request.task_id');
      $this->db->join('employee', 'employee.nik = request.nik_request');
      $this->db->where('request.id_request',$id);
      $query=$this->db->get();
      return $query->result_array();
    }

    public function get_dept($nik){
      $this->db->select('*');
      $this->db->where('nik',$nik);
      $this->db->from('employee');
      $query=$this->db->get();
      $key=$query->result_array();
      return $key[0]['location'].'-'.$key[0]['division'].'-'.$key[0]['department'];
    }

    public function get_name($nik){
      $this->db->select('*');
      $this->db->where('nik',$nik);
      $this->db->from('employee');
      $query=$this->db->get();
      $key=$query->result_array();
      return $key[0]['first_name'].' '.$key[0]['last_name'];
    }

    public function get_data_byid($id){
      $this->db->select('*');
      $this->db->from('request');
      $this->db->join('Task', 'Task.id_task=request.task_id');
      $this->db->join('employee', 'employee.nik = request.nik_request');
      $this->db->where('request.id_request',$id);
      $query=$this->db->get();
      return $query->row();
    }

    public function get_all($nik,$filter){
      // $this->db->select('*');
      // $this->db->from('request');
      // $this->db->join('Task', 'Task.id_task=request.task_id');
      // $this->db->join('employee', 'employee.nik = request.nik_request');
      // $this->db->where('request.nik_receipt',$nik);
      // $query=$this->db->get();
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_request where r.nik_receipt=$nik";

      if(count($filter)>0){
        foreach ($filter as $key => $value) {
          if($value!=''&&$key!='t.title'){
            $sql.=' and '.$key.'="'.$value.'"';
          }elseif($key=='t.title'&&$value!=''){
            $sql.=' and '.$key.' like "%'.$value.'%"';
          }
        }
      }
      // if(count($filter)>0){
      //   foreach ($filter as $key => $value) {
      //     $sql.='and '.array_keys($filter, $value).'='.$value;
      //   }
      // }
      $this->db->select($sql,FALSE);
      $query=$this->db->get();

      return $query->result_array();
    }

    public function update_request($where, $data){
      $this->db->update('request', $data, $where);
      return $this->db->affected_rows();
    }

    public function save_log($where, $data){
      $this->db->update('log_activity', $data, $where);
      return $this->db->affected_rows();
    }


}
