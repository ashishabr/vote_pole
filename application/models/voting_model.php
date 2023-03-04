<?php

class Voting_model extends CI_Model {
	
	function get_user($mail,$pass){
		$password = base64_encode($pass);
		$this->db->select('*')->from('user_reg')->where('user_email',$mail)->where('user_pass',$password);
		$query = $this->db->get();
		$data['result'] = $query->row();
		$data['num'] = $query->num_rows();
		return $data;
	}
	function fetch_users($users){
		$this->db->select('*')->from('user_reg')->where_in('user_id',$users);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num > 0){
			$data = $query->result();
		}
		return $data;
	}
	function select_row_qry($table,$where='',$orderby='')
    {
        $this->db->select('*');
        $this->db->from($table);
        if($where != '')
        {
            $this->db->where($where);   
        }
        if($orderby != '')
        {
            $this->db->order_by($orderby['c_name'], $orderby['order']);
        }
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
        }
        else {
            return false;
        }
    }
    function update_qry($table,$data,$where)
    {
        $this->db->where($where);
        if($this->db->update($table,$data)){return 'success';}
    }
	function delete_qry($table,$where)
    {
        $this->db->where($where);
        if($this->db->delete($table)){return 'success';}
    }
	function fetch_vote($data="",$start_from=""){
		// echo json_encode($data);
		$this->db->select('*')->from('votes');
		if($data){
			$this->db->where($data);
		}
		if($start_from !== null){
			$this->db->limit(15,$start_from);
		}
		$this->db->order_by("expiry_date", "desc");
		$query = $this->db->get();
		$data1['num'] = $query->num_rows();
		if($data1['num'] > 0){
			$data1['result'] = $query->result();
		}
		return $data1;
	}
	function add_vote($data){
		$this->db->insert('votes',$data);
	}
	
}


?>