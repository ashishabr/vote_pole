<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('voting_model');
		// echo $_SESSION['user_id'];
		if(empty($_SESSION['user_id']))
            redirect('login/index');
	}
	
	public function index()
	{
		
		$this->load->view('header');
		$this->load->view('dashboard');
		$this->load->view('footer');
	}
	public function add_vote($v_id="")
	{
		$this->load->view('header');
		$this->load->view('add_vote',$v_id);
		$this->load->view('footer');
	}
	public function list_vote($v_id="")
	{
		$this->load->view('header');
		$this->load->view('list_vote',$v_id);
		$this->load->view('footer');
	}
	public function view_vote()
	{
		$this->load->view('header');
		$this->load->view('view_vote');
		$this->load->view('footer');
	}
	public function add_qun()
	{
		$ans = $this->input->post('ans');
		$question = $this->input->post('question');
		$expiry_date = $this->input->post('expiry_date');
		$data['ans'] = json_encode($ans);
		$data['question'] = $question;
		$data['expiry_date'] = strtotime($expiry_date);
		$data['user_id'] = $_SESSION['user_id'];

		$this->voting_model->add_vote($data);
	}
	public function set_vote()
	{
		$v_id = $this->input->post('v_id');
		$ans = $this->input->post('ans_val');
		$vote_detail = $this->load_vote_data($v_id);
		// var_dump($vote_detail);exit;
		$voted_users = ($vote_detail['result'][0]->voted_users) ? json_decode($vote_detail['result'][0]->voted_users,true) : array();
		$user_id = $_SESSION['user_id'];
		$voted_users[$ans][] = $user_id;
		
		$data['voted_users'] = json_encode($voted_users);
		$where['v_id'] = $v_id;

		// echo json_encode($data);exit;

		$this->voting_model->update_qry("votes",$data,$where);
	}
	public function update_qun()
	{
		$ans = $this->input->post('ans');
		$question = $this->input->post('question');
		$expiry_date = $this->input->post('expiry_date');
		$data['ans'] = json_encode($ans);
		$data['question'] = $question;
		$data['expiry_date'] = strtotime($expiry_date);
		$where['v_id'] = $this->input->post('v_id');

		$this->voting_model->update_qry("votes",$data,$where);
	}
	public function del_votes()
	{
		$data['v_id'] = $this->input->post('v_id');
		$votes = $this->voting_model->select_row_qry('votes',$data);
		// echo json_encode($votes);exit;
		if($votes->user_id == $_SESSION['user_id']){
			$this->voting_model->delete_qry('votes',$data);
		}
	}
	public function load_votes()
	{

		$v_id = $this->input->post('v_id');
		$userarr = $data = array();
		if($v_id){
			$data['v_id'] = $v_id;
		}
		
		$list_vote = $this->voting_model->fetch_vote($data);
		if($list_vote && $list_vote['num'] > 0){
			foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
				$list_vote['result'][$list_vote_key]->expiry = date("d M Y",$list_vote_value->expiry_date);
				$users[] = $list_vote_value->user_id;
			}
			$list_users = $this->voting_model->fetch_users($users);
			foreach ($list_users as $userkey => $uservalue) {
				$userarr[$uservalue->user_id] = $uservalue->user_name;
			}
			foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
				$userid = $list_vote_value->user_id;
				$list_vote['result'][$list_vote_key]->user_name = $userarr[$userid];
			}
			$list_vote['final_data'] = 0;
		}else{
			$list_vote['result'] = array();
			$list_vote['final_data'] = 1;
		
		}
		$list_vote['now'] = time();
		echo json_encode($list_vote);
	}
	public function load_dashboard_votes()
	{
		$startDate_timestamp = $this->input->post('startDate_timestamp');
		$endDate_timestamp = $this->input->post('endDate_timestamp');
		$data['user_id'] = $_SESSION['user_id'];
		$data['expiry_date >'] = $startDate_timestamp;
		$data['expiry_date <'] = $endDate_timestamp;
		$list_vote = $this->voting_model->fetch_vote($data);
		// echo json_encode($data);exit;
		$list_vote_data = array();
		if($list_vote && $list_vote['num'] > 0){
			foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
				$expiry_date_dmy = date("d M Y",$list_vote_value->expiry_date);
				$voted_ans = json_decode($list_vote_value->voted_users,true);
				$count = 0;
				foreach ($voted_ans as $voted_anskey => $voted_ansvalue) {
					$count += count($voted_ansvalue);
				}
				$list_vote_data[$expiry_date_dmy][$list_vote_value->question] = $count;
			}
		}else{
			$list_vote['result'] = array();
		
		}
		$list_vote['now'] = time();
		$list_vote['dashboard_data'] = $list_vote_data;
		echo json_encode($list_vote);
	}
	public function load_votes_with_pagination()
	{

		$v_id = $this->input->post('v_id');
		$page = $this->input->post('page');
		$start_from = ($page-1) * 15;  
		$userarr = $data = array();
		if($v_id){
			$data['v_id'] = $v_id;
		}
		// echo $start_from;exit;
		
		$list_vote = $this->voting_model->fetch_vote($data,$start_from);
		// echo json_encode($list_vote);exit;
		if($list_vote && $list_vote['num'] > 0){
			foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
				$list_vote['result'][$list_vote_key]->expiry = date("d M Y",$list_vote_value->expiry_date);
				$users[] = $list_vote_value->user_id;
			}
			$list_users = $this->voting_model->fetch_users($users);
			foreach ($list_users as $userkey => $uservalue) {
				$userarr[$uservalue->user_id] = $uservalue->user_name;
			}
			foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
				$userid = $list_vote_value->user_id;
				$list_vote['result'][$list_vote_key]->user_name = $userarr[$userid];
			}
			$list_vote['final_data'] = 0;
		}else{
			$list_vote['result'] = array();
			$list_vote['final_data'] = 1;
		
		}
		$list_vote['now'] = time();
		echo json_encode($list_vote);
	}
	public function load_vote_row($v_id="")
	{
		$userarr = array();
		$data['v_id'] = ($v_id) ? $v_id : $this->input->post('v_id');
		$list_vote = $this->voting_model->fetch_vote($data);
		foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
			$list_vote['result'][$list_vote_key]->expiry = date("m/d/Y",$list_vote_value->expiry_date);
			// $users[] = $list_vote_value->user_id;
		}
		
		echo json_encode($list_vote);
	}
	public function load_vote_data($v_id="")
	{
		$userarr = array();
		$data['v_id'] = ($v_id) ? $v_id : $this->input->post('v_id');
		$list_vote = $this->voting_model->fetch_vote($data);
		foreach ($list_vote['result'] as $list_vote_key => $list_vote_value) {
			$list_vote['result'][$list_vote_key]->expiry = date("m/d/Y",$list_vote_value->expiry_date);
			// $users[] = $list_vote_value->user_id;
		}
		
		return $list_vote;
	}
	
	
}
