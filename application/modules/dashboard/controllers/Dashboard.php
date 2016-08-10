<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('dashboard_model');
	}

	public function index()
	{
		
		$this->header->index();
		$this->load->view('Dashboard');
		$this->footer->index();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */