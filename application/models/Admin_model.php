<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function get_employ(){
      $sql="e.nik, e.first_name, e.last_name, e.location, e.division, e.department, u.username from employee e left join user u on u.nik=e.nik";
      $this->db->select($sql, FALSE);
      $query=$this->db->get();
      return $query->result_array();
    }
    public function save_user($data){
      $this->db->insert('user', $data);
      return $this->db->insert_id();
    }
    public function save_employee($data){
      $this->db->insert('employee', $data);
      return $this->db->insert_id();
    }
}
