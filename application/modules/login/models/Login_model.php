<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('helper/helper_model');
	}

	public function getwheredata($select,$tableName,$where){

		$result = $this->helper_model->selectwhere($select,$tableName,$where);
		return $result;
	}	
}
