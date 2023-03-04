<?php

class Reg_model extends CI_Model {
	
	function add_user($data){
		$this->db->insert('user_reg',$data);
	}
	function add_multiple_user($data){
		$this->db->insert_batch('user_reg',$data);
	}
	function add_multiple_votes($data){
		$this->db->insert_batch('votes',$data);
	}
	function check_user($mail){
		$this->db->select('user_email')->from('user_reg')->where('user_email',$mail);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
}


?>