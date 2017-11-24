<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model extends CI_Model {

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
      $id_task=$this->save_task($task);
      //save request
      $id_request=$this->save_req($id_task, $request);

      $this->db->insert('log_activity', array('request_id'=>$id_request, 'create_time'=>date('Y-m-d H:m:s')));
      return $id_request;
    }

    private function save_task($data){
      $this->db->insert('Task', $data);
      return $this->db->insert_id();
    }

    private function save_req($idtask, $request){
      $new_arr=array('task_id'=>$idtask);
      $arraymerge=array_merge($request, $new_arr);
      $this->db->insert('request',$arraymerge);
      return $this->db->insert_id();
    }

    public function createNotif($result, $receipt , $request){
      $this->db->insert('notification', array('times'=>Date('Y-m-d h:i:s'),'nik_receipt'=>$receipt, 'value'=>'New Request', 'status'=>'unread', 'request_id'=>$result, 'nik_request'=>$request));
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
      if(count($key)>0){
        return $key[0]['location'].'-'.$key[0]['division'].'-'.$key[0]['department'];
      // return $key[0]['first_name'].' '.$key[0]['last_name'];
      }else {
      return "";
      }
    }

    public function get_name($nik){
      $this->db->select('*');
      $this->db->where('nik',$nik);
      $this->db->from('employee');
      $query=$this->db->get();
      $key=$query->result_array();
      // print_r($key);
      // echo count($key);
      if(count($key)>0){
      return $key[0]['first_name'].' '.$key[0]['last_name'];
      }else {
      return "-";
      }

    }

    public function get_data_byid($id){
      $this->db->select('*');
      $this->db->from('request');
      $this->db->join('Task', 'Task.id_task=request.task_id');
      $this->db->join('employee', 'employee.nik = request.nik_request');
      $this->db->join('log_activity la', 'la.request_id = request.id_request');
      $this->db->where('request.id_request',$id);
      $query=$this->db->get();
      return $query->row();
    }

    public function get_all_request($nik,$filter){
      // $this->db->select('*');
      // $this->db->from('request');
      // $this->db->join('Task', 'Task.id_task=request.task_id');
      // $this->db->join('employee', 'employee.nik = request.nik_request');
      // $this->db->where('request.nik_request',$nik);
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_request where r.nik_request=$nik";

      if(count($filter)>0){
        foreach ($filter as $key => $value) {
          if($value!=''&&$key!='t.title'){
            $sql.=' and '.$key.'="'.$value.'"';
          }elseif($key=='t.title'&&$value!=''){
            $sql.=' and '.$key.' like "%'.$value.'%"';
          }
        }
      }
      $sql.=' order by r.id_request desc';
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

    public function update_request($where, $data){
      $this->db->update('request', $data, $where);
      return $this->db->affected_rows();
    }

    public function update_deadline($data, $where){
      $this->db->update('Task', $data, $where);
      return $this->db->affected_rows();

    }


}
