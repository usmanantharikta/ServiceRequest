<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Super_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_request($div,$filter){
      $sql="* from request r join Task t on t.id_task= r.task_id
            join employee e on e.nik=r.nik_request";
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
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

}
