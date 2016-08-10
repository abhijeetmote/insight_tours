<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('helper/helper_model');
	}
	
public function insertsite($data)
{
		
		$tableName = 'site_master';
		$result = $this->helper_model->insert($tableName,$data);
	
}
public function viewuser()
{
		
		$tableName='users_master';
		
		$result = $this->helper_model->selectall($tableName);
		return $result;
	
}
public function viewuserdet($siteid)
{
		
		$tableName='users_master';
		$colname='site_id';
		
		$result = $this->helper_model->select('',$tableName,$colname,$siteid);
		return $result;
	
}

	
}
