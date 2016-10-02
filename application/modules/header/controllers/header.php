<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends MX_Controller {

	function __construct() {
	    parent::__construct();

	    session_start();
	    if(!isset($_SESSION['userFirstName'])){
	    	redirect(base_url().'login', 'refresh');
	    }
	}
	
	public function index($active = "")
	{
		$data['active'] = $active;
		$this->load->view('header', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
