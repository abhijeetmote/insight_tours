<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends MX_Controller {

	function __construct() {
	    parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('header');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */