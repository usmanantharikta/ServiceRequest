<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //get list request by id
    public function getRequestByID($nik, $filter)
    {
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
      $this->db->select($sql,FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }

}
