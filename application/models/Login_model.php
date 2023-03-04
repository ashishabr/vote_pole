<?php

class Login_model extends CI_Model {
	
	function get_user($mail,$pass){
		$password = base64_encode($pass);
		$this->db->select('*')->from('user_reg')->where('user_email',$mail)->where('user_pass',$password);
		$query = $this->db->get();
		$data['result'] = $query->row();
		$data['num'] = $query->num_rows();
		return $data;
	}
	
}


?>