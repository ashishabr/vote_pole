<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
		$this->load->model('reg_model');
		/*if($this->session->userdata("user_name") == ''){
			redirect('login');
		}*/
	}
	
	public function index()
	{
		$sessionclr = array('success','error');
		$this->session->unset_userdata($sessionclr);
		if($this->input->post('submit') != ''){
			$this->add_user_data();
		}
		$this->load->view('register_form');
	}
	
	public function add_user_data(){
		$data['user_name'] = $this->input->post('user_name');
		$data['user_email'] = $mail = $this->input->post('user_email');
		$pass = $this->input->post('user_pass');
		$data['user_pass'] = base64_encode($pass);
		//$data['user_type'] = $this->input->post('user_type');
		
		//$data['user_address'] = $this->input->post('user_address');
		$user = $this->check_user($mail);
		//$img_upload = $this->image_upload();
		//$image = $img_upload['data']['full_path'];
		//$data['user_image'] = $image;
		if($user > 0){
			$session = array('error'=>'User already exists!');
			$this->session->set_userdata($session);
			return false;
		}	
		
		$this->reg_model->add_user($data);
		$session = array('success'=>'User has been created!');
		$this->session->set_userdata($session);
	    echo "success";
	}

	public function add_random_user(){

		// Array of first names
		$firstNames = array("John", "Jane", "Michael", "Emily", "William", "Olivia", "James", "Sophia", "Robert", "Isabella", "David", "Mia", "Joseph", "Charlotte", "Christopher", "Abigail", "Matthew", "Elizabeth", "Daniel", "Avery");

		// Array of last names
		$lastNames = array("Smith", "Johnson", "Brown", "Garcia", "Miller", "Davis", "Rodriguez", "Martinez", "Jackson", "Lee", "Perez", "Harris", "Clark", "Lewis", "Robinson", "Walker", "Allen", "Young", "King", "Wright");

		// Loop through 1000 times and generate random names
		for ($i = 0; $i < 1010; $i++) {
		    $firstName = $firstNames[array_rand($firstNames)]; // Get a random first name from the array
		    $lastName = $lastNames[array_rand($lastNames)]; // Get a random last name from the array
		    $random_name = $firstName . " " . $lastName; // Output the name
		    $datau['user_name'] = $random_name;
			$datau['user_email'] = $firstName . "_" . $i ."@gmail.com";
			$passu = $firstName.$i;
			$datau['user_pass'] = base64_encode($passu);
			$data[] = $datau;
		}
		
		$this->reg_model->add_multiple_user($data);
		// $session = array('success'=>'User has been created!');
		// $this->session->set_userdata($session);
	 //    echo "success";
	}
	public function add_random_question(){

		// Array of questions
		$questions = array(
		    "What is the capital of France?",
		    "What is the highest mountain in the world?",
		    "Who discovered electricity?",
		    "What is the smallest country in the world?",
		    "What is the largest continent in the world?",
		    "What is the smallest ocean in the world?",
		    "What is the largest country in the world by land area?",
		    "Who painted the Mona Lisa?",
		    "What is the name of the first man to walk on the moon?",
		    "What is the name of the first computer programmer?"
		);

		// Array of answers
		$answers = array(
		    "Paris",
		    "Mount Everest",
		    "Benjamin Franklin",
		    "Vatican City",
		    "Asia",
		    "Arctic Ocean",
		    "Russia",
		    "Leonardo da Vinci",
		    "Neil Armstrong",
		    "Ada Lovelace"
		);

		// Loop through 100 times and generate random questions and answers
		for ($i = 0; $i < 100; $i++) {
		    $randomIndex = array_rand($questions); // Get a random index from the questions array
		    $question = $questions[$randomIndex]; // Get the question at that index
		   
			shuffle($answers);
			$randomAnswers = array_slice($answers, 0, 4);

			$start_date = "2023-02-01";
			$end_date = "2023-04-01";

			// Convert the start and end dates to timestamps
			$start_timestamp = strtotime($start_date);
			$end_timestamp = strtotime($end_date);

			// Generate a random timestamp between the start and end dates
			$random_timestamp = rand($start_timestamp, $end_timestamp);
			$voted_users = array();
			foreach ($randomAnswers as $key => $value) {
				$random_count =  rand(1, 250);
				for ($j=0; $j < $random_count; $j++) { 
					$voted_users[$value][] =  rand(1, 1000);
				}
			}

			$datau['voted_users'] = json_encode($voted_users);
			$datau['ans'] = json_encode($randomAnswers);
			$datau['question'] = $question;
			$datau['expiry_date'] = $random_timestamp;
			$datau['user_id'] = rand(1, 1000);

			$data[] = $datau;
		}
		
		$this->reg_model->add_multiple_votes($data);
		// $session = array('success'=>'User has been created!');
		// $this->session->set_userdata($session);
	 //    echo "success";
	}
	
	public function check_user($mail){
		$user = $this->reg_model->check_user($mail);
		return $user;
	}
}
