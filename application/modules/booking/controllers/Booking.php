<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('booking/Booking_model');
		$this->load->model('helper/helper_model');
	}

	public function bookingMaster()
	{

		$select = 'cust_id,cust_firstname,cust_lastname';
		$tableName = 'customer_master';
		$column = "isactive";
		$value = "1";
		$data['customerList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$data['vechileTList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		//echo "<pre>"; print_r($data); exit();
		$this->header->index();
		$this->load->view('BookingAdd',$data);
		$this->footer->index();
	}

	public function addSlip()
	{
		$select = 'vehicle_id,vehicle_no';
		$tableName = 'vehicle_master';
		$data['vehicleList'] = $this->Booking_model->getVehicleList($select,$tableName);
		$select = 'driver_id,driver_fname,driver_lname';
		$tableName = 'driver_master';
		$data['driverList'] = $this->Booking_model->getVehicleList($select,$tableName);
		//echo "<pre>"; print_r($data); exit();
		$this->header->index();
		$this->load->view('DutySlip', $data);
		$this->footer->index();
	}

	public function addDutySlip() {
		echo json_encode($_POST);
	}


	public function addbooking() {	

		//booking data
		 $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : "";
		 $cust_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : "";
		 $vehicle_type = isset($_POST['vehicale_type']) ? $_POST['vehicale_type'] : "";
		 $travel_type = isset($_POST['travel_type']) ? $_POST['travel_type'] : "";
		 $pickup_location = isset($_POST['pickup_address']) ? $_POST['pickup_address'] : "";
		 $drop_location = isset($_POST['drop_address']) ? $_POST['drop_address'] : "";

		 //bdate conversion
		 if(isset($booking_date) && !empty($booking_date)){
		 	$booking_date = $this->helper_model->dbDatetime($booking_date);
		 }

		 //passenger data
		 $passenger_name = isset($_POST['passenger_name']) ? $_POST['passenger_name'] : "";
		 $passenger_number = isset($_POST['passenger_number']) ? $_POST['passenger_number'] : "";
		 $pickup_address = isset($_POST['pass_pickup_address']) ? $_POST['pass_pickup_address'] : "";
		 $drop_address = isset($_POST['pass_drop_address']) ? $_POST['pass_drop_address'] : "";
		 //$no_of_persons =;

		 $data = array(
			'booking_date' => $booking_date,
			'cust_id' => $cust_id,
			'vehicle_type' => $vehicle_type,
			'travel_type' => $travel_type,
			'pickup_location' => $pickup_location,
			'drop_location' => $drop_location,
			'booking_status' => '1',
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);
	 	$booking_table =  BOOKING_TABLE;

	 	$this->db->trans_begin();
	 	 //booking record insertion
	 	$booking_id = $this->Booking_model->saveData($booking_table,$data);
	 	//echo $booking_id;
 	//booking data insertion end

 	//passenger data insertion start
 	if(isset($booking_id) && !empty($booking_id)) {
		 $i=0;
		 foreach($passenger_number as $val) {
	 		
	 		$passenger_name[$i] = isset($passenger_name[$i]) ? $passenger_name[$i] : "";
	 		$pickup_address[$i] = isset($pickup_address[$i]) ? $pickup_address[$i] : "";;
	 		$drop_address[$i] = isset($drop_address[$i]) ? $drop_address[$i] : "";;
	 		$val = isset($val) ? $val : $val;

		 	$passdata = array(
			'passenger_name' => $passenger_name[$i],
			'passenger_number' => $val,	
			'pickup_address' =>  $pickup_address[$i],
			'drop_address' => $drop_address[$i],
			'booking_id' => $booking_id,
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s'));
		 	//Insert Ledger data with Deriver Id
		 	$passtable =  PASSENGER_TABLE;
		 	$pass_id = $this->Booking_model->saveData($passtable,$passdata);
		 	if(!isset($pass_id) || empty($pass_id)){
 	 		$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
			echo json_encode($response);exit;	
 	 		} else {

 	 			$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Vendor Added Successfully";
 	 		}
		 	$i++;
 		 }

 	 	

 	} else {
 		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
 	}

 	 
	echo json_encode($response);
 	}


 	public function vendorList(){
 		$vendor_table =  VENDOR_TABLE;
 		$filds = "vendor_id,vendor_name,vendor_contact_number,vendor_address,vendor_email,vendor_pan_num,vendor_payee_name";
 		$data['list'] = $this->Vendor_model->getVendorLit($filds,$vendor_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index();
		$this->load->view('vendorList', $data);
		$this->footer->index();
 	}

 	public function vendorDelete(){
        $vendor_id = $_POST['id'];
        $vendor_table =  VENDOR_TABLE;
        $resultMaster = $this->helper_model->delete($vendor_table,'vendor_id',$vendor_id);
        if($resultMaster != false){
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}


 	public function update($id){        
        $select = '*';
		$tableName = VENDOR_TABLE;
		$column = 'vendor_id';
		$value = $id;
		$data['vendor'] = $this->Vendor_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
		$this->header->index();
		$this->load->view('VendorAdd', $data);
		$this->footer->index();
 	}

 	public function vendorUpdate(){        

 		$vendor_name = isset($_POST['vendor_name']) ? $_POST['vendor_name'] : "";
		 $vendor_mobile_number = isset($_POST['vendor_contact_number']) ? $_POST['vendor_contact_number'] : "";
		 $vendor_phone_number = isset($_POST['vendor_phone_number']) ? $_POST['vendor_phone_number'] : "";
		 $vendor_email = isset($_POST['vendor_email']) ? $_POST['vendor_email'] : "";
		 $vendor_notes = isset($_POST['vendor_notes']) ? $_POST['vendor_notes'] : "";
		 $vendor_service_regn = isset($_POST['vendor_service_regn']) ? $_POST['vendor_service_regn'] : "";
		 $vendor_pan_num = isset($_POST['vendor_pan_num']) ? $_POST['vendor_pan_num'] : "";
		 $vendor_section_code = isset($_POST['vendor_section_code']) ? $_POST['vendor_section_code'] : "";
		 $vendor_payee_name = isset($_POST['vendor_payee_name']) ? $_POST['vendor_payee_name'] : "";
		 $vendor_address = isset($_POST['vendor_address']) ? $_POST['vendor_address'] : "";

		 $vendor_vat = isset($_POST['vendor_vat']) ? $_POST['vendor_vat'] : "";
		 $vendor_cst = isset($_POST['vendor_cst']) ? $_POST['vendor_cst'] : "";
		 $vendor_gst = isset($_POST['vendor_gst']) ? $_POST['vendor_gst'] : "";

		 $vendor_ledger_id = isset($_POST['vendor_ledger_id']) ? $_POST['vendor_ledger_id'] : "";

		 $vendor_update = array(
			'vendor_name' => $vendor_name,
			'vendor_contact_number' => $vendor_mobile_number,
			'vendor_phone_number' => $vendor_phone_number,
			'vendor_email' => $vendor_email,
			'vendor_notes' => $vendor_notes,
			'vendor_service_regn' => $vendor_service_regn,
			'vendor_pan_num' => $vendor_pan_num,
			'vendor_section_code' => $vendor_section_code,
			'vendor_payee_name' => $vendor_payee_name,
			'vendor_address' => $vendor_address,
			'vendor_vat' => $vendor_vat,
			'vendor_cst' => $vendor_cst,
			'vendor_gst' => $vendor_gst,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);
     
		$this->db->trans_begin();
		$vendor_table = VENDOR_TABLE;
		$vendor_column = 'vendor_id';
		$vendor_id = $_POST['id'];

		$result = $this->Vendor_model->updateData($vendor_table, $vendor_update, $vendor_column, $vendor_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $vendor_name."_".$vendor_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->Vendor_model->updateData($ledgertable, $ledger_update, $ledger_column, $vendor_ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Vendor Updated Successfully";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}
}
