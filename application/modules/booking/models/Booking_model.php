<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('helper/helper_model');
	}

	public function getVehicleList($data,$table){

		$result = $this->helper_model->selectAll($data,$table);
		return $result;
	}

	public function saveData($tableName,$data){
		$result = $this->helper_model->insertid($tableName,$data);
		return $result;
	}


	public function updateData($tableName,$data,$columnName,$value){
		$result = $this->helper_model->update($tableName,$data,$columnName,$value);
		return $result;
	}

	public function listDriver(){

	}

	public function listData($data,$table){
		$result = $this->helper_model->selectAll($data,$table);
		return $result;

	}

	public function getGroupId($select,$tableName,$context,$entity_type,$where){

		$result = $this->helper_model->selectGroupId($select,$tableName,$where);
		return $result;
	}

	public function getwheredata($select,$tableName,$where){

		$result = $this->helper_model->selectwhere($select,$tableName,$where);
		return $result;
	}

	public function getData($select, $tableName, $column, $value) {
		$result = $this->helper_model->select($select, $tableName, $column, $value);
		return $result;
	}

	public function getBookingLit($data,$table){

		$result = $this->helper_model->selectAll($data,$table);
		return $result;
	}

	public function getDutySlip($data,$table){

		$result = $this->helper_model->selectAll($data,$table);
		return $result;
	}

	
}
