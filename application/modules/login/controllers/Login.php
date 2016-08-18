<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

	function __construct() {
	    parent::__construct();

	    session_start();
		$this->load->model('Login_model');
		$this->load->model('helper/helper_model');
	}

	public function index()
	{
		if(isset($_SESSION['userFirstName'])){
	    	redirect(base_url().'dashboard', 'refresh');
	    }else{
			$this->load->view('login');	
	    }
	}

	public function loginAction()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$select = "*";
		$tableName = "users_master";
		$where = array(
			'user_name' => $username, 
			'password' => $password
		);
		$result = $this->Login_model->getwheredata($select, $tableName, $where);
		if(!empty($result)){
			if($result[0]->status == 1){
				$_SESSION['userFirstName'] = $result[0]->user_first_name; 
				$_SESSION['userLastName'] = $result[0]->user_last_name; 
				$_SESSION['userId'] = $result[0]->user_id; 
				$_SESSION['ledgerId'] = $result[0]->ledger_id; 
				$_SESSION['userType'] = $result[0]->user_type;				

				$response['success'] = true;
				$response['successMsg'] = "Login Successfully";
				$response['redirect'] = base_url()."dashboard";
			}else{
				$response['success'] = false;
				$response['errorMsg'] = "Your account not active";
			}
		}else{
			$response['success'] = false;
			$response['errorMsg'] = "Username Password Wrong";
		}

		echo json_encode($response);
	}	

	public function logout()
	{
		session_destroy();
		redirect(base_url().'login', 'refresh');
	}
}
