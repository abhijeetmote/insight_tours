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
		//echo $this->db->last_query();
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

	public function getwheresingle($select,$tableName,$where){

		$result = $this->helper_model->selectrow($select,$tableName,$where);
		//echo $this->db->last_query();
		return $result;
	}

	public function sendDutyslip_notification($duty_slip_id_notifi,$booking_id_notifi){



			$select = '*';
			$booking_table = 'booking_master';
			$booking_id_field = 'booking_id';
			$id = $booking_id_notifi;
			$booking_data = $this->getData($select, $booking_table, $booking_id_field, $id);

			$booking_from = isset($booking_data[0]->pickup_location) ? $booking_data[0]->pickup_location : "NA";
			$booking_to = isset($booking_data[0]->drop_location) ? $booking_data[0]->drop_location : "NA";

			$booking_date_old = isset($booking_data[0]->booking_date) ? $booking_data[0]->booking_date : "NA";

			$select = '*';
			$duty_slip_table = 'duty_sleep_master';
			$duty_slip_id = 'duty_sleep_id';
			$duty_slip_value = $duty_slip_id_notifi;
			$duty_data = $this->getData($select, $duty_slip_table, $duty_slip_id, $duty_slip_value);
			//print_r($duty_data);

			 $driver_id = isset($duty_data[0]->driver_id) ? $duty_data[0]->driver_id : "NA";
			 $vehicle_id = isset($duty_data[0]->vehicle_id) ? $duty_data[0]->vehicle_id : "NA";
			$start_date = isset($duty_data[0]->start_date) ? $duty_data[0]->start_date : "NA";
			$booking_id_data = "BK_".$booking_id_notifi;

			$booking_date = isset($duty_data[0]->start_date) ? $duty_data[0]->start_date : "NA";
			if($booking_date == "NA") {
				$booking_date = $booking_date_old;
			}

			$driver_name = "";
			$driver_no = "";
			if(isset($driver_id) && !empty($driver_id)) {
				$select = '*';
				$driver_select = 'driver_fname,driver_lname,driver_mobno,driver_mobno1';
				$driver_table = 'driver_master';
				$driver_field = 'driver_id';
				$driver_value = $driver_id;
				$driver_data = $this->getData($driver_select, $driver_table, $driver_field, $driver_value);
				//echo "tes dr".print_r($driver_data);
				if(isset($driver_data) && !empty($driver_data)) {
					$driver_name = $driver_data[0]->driver_fname." ".$driver_data[0]->driver_lname;
					if (isset($driver_data[0]->driver_mobno)) {
						$driver_no = $driver_data[0]->driver_mobno;
					} else{
						$driver_no = $driver_data[0]->driver_mobno1;
					}
					
				}
			}

			
			$vname = "NA";
			$vno = "NA";
			if(isset($vehicle_id) && !empty($vehicle_id)) {
				$select = '*';
				$v_select = 'vehicle_no,vehicle_name';
				$v_table = 'vehicle_master';
				$v_field = 'vehicle_id';
				$v_value = $vehicle_id;
				$v_data = $this->getData($v_select, $v_table, $v_field, $v_value);
				//print_r($v_data);
				if(isset($v_data)) {
					$vname = isset($v_data[0]->vehicle_name) ? $v_data[0]->vehicle_name : "NA";
					$vno = isset($v_data[0]->vehicle_no) ? $v_data[0]->vehicle_no : "NA";
				}
			}

		 	$select = '*';
			$passenger = 'passenger_details';
			$booking_id = 'booking_id';
			$booking_value = $booking_id_notifi;
			$pass_data = $this->getData($select, $passenger, $booking_id, $booking_value);
			$pass_details = "passenger Details :- ";

			$i = 1;
			foreach ($pass_data as $pass_data) {
				//$passenger_number = isset($pass_data[0]->passenger_number) ? $pass_data[0]->passenger_number : "NA";
				 
				 $passenger_number = 9702564933;
				 $passenger_name = isset($pass_data->passenger_name) ? $pass_data->passenger_name : "NA";
				$pickup_address = isset($pass_data->pickup_address) ? $pass_data->pickup_address : "NA";
				 $drop_address = isset($pass_data->pickup_address) ? $pass_data->pickup_address : "NA";

				 $passenger_msg = "New Toure Shedule by CMP Name on ".$booking_date." From ".$booking_from." To ".$booking_to." Details as ". "Driver Name : ". 
				$driver_name ." ,No : ".$driver_no. " ,vehicle name ". $vname." vehicle no : ".$vno."& your Pickup Point is : ".$pickup_address;

				$result = $this->helper_model->send_sms($passenger_number,$passenger_msg);

				$pass_details .=  "  ".$i. ". " .$passenger_name. " , ".$passenger_number." Pickup Point ".$pickup_address;
				$i++;
			}
			$driver_no = 9702564933;
			  $driver_msg = "You Have New Booking ". $booking_id_data ."on ".$booking_date. " From ". $booking_from. " To ".$booking_to ."Details As ".$pass_details;

			$result = $this->helper_model->send_sms($driver_no,$driver_msg);
			 

	}
}
