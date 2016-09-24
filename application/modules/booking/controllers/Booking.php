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
		$select = '*';
		$data['vechileTList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		//echo "<pre>"; print_r($data); exit();
		$this->header->index();
		$this->load->view('BookingAdd',$data);
		$this->footer->index();
	}

	public function addbooking() {	
		//error_reporting(E_ALL);
		//booking data
		 $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : "";
		 $cust_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : "";
		 $vehicle_type = isset($_POST['vehicale_type']) ? $_POST['vehicale_type'] : "";
		 $travel_type = isset($_POST['travel_type']) ? $_POST['travel_type'] : "";
		 $pickup_location = isset($_POST['pickup_address']) ? $_POST['pickup_address'] : "";
		 $drop_location = isset($_POST['drop_address']) ? $_POST['drop_address'] : "";
		 $package_id = isset($_POST['package']) ? $_POST['package'] : "";
		// echo $booking_date;
		 //bdate conversion
		 if(isset($booking_date) && !empty($booking_date)){
		 	$booking_date = $this->helper_model->dbDatetime($booking_date);
		 }
		 // echo $booking_date;exit;

		 //passenger data
		 $passenger_name = isset($_POST['passenger_name']) ? $_POST['passenger_name'] : "";
		 $passenger_number = isset($_POST['passenger_number']) ? $_POST['passenger_number'] : "";
		 $pickup_address = isset($_POST['pass_pickup_address']) ? $_POST['pass_pickup_address'] : "";
		 $drop_address = isset($_POST['pass_drop_address']) ? $_POST['pass_drop_address'] : "";
		 $no_of_persons = count($passenger_name);

		 $data = array(
			'booking_date' => $booking_date,
			'booked_on' => date('Y-m-d h:i:s'),
			'cust_id' => $cust_id,
			'vehicle_type' => $vehicle_type,
			'travel_type' => $travel_type,
			'package_id' => $package_id,
			'pickup_location' => $pickup_location,
			'drop_location' => $drop_location,
			'no_of_persons' => $no_of_persons,
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
				$response['successMsg'] = "Booking Added Successfully";
				$response['redirect'] = base_url()."booking/bookingList";
 	 		}
		 	$i++;
 		 }

 	 	

 	} else {
 		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
 	}
 	//exit;
 	 
	echo json_encode($response);
 	}


 	public function bookingList(){
 		//SELECT b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname FROM booking_master b,customer_master c,vehicle_category v WHERE b.`cust_id` = c.cust_id and b.vehicle_type = v.cat_id
 		$tableName =  'customer_master c, booking_master b , vehicle_category v ';
 		$select = 'b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname';
 		$where =  'c.cust_id = b.cust_id and b.vehicle_type = v.cat_id';
 		$data['booking_list'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		$pass_table =  PASSENGER_TABLE;
 		$filds = "*";
 		$data['pass_list'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";print_r($data['booking_list']);exit;
        $this->header->index();
		$this->load->view('bookingList', $data);
		$this->footer->index();
 	}



 	public function passengerList(){
 		//SELECT b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname FROM booking_master b,customer_master c,vehicle_category v WHERE b.`cust_id` = c.cust_id and b.vehicle_type = v.cat_id
 		$booking_id = $_POST['id'];
 		$tableName =  PASSENGER_TABLE;
 		$select = '*';
 		$where =  "booking_id = '$booking_id'";
 		$passenger_details = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";print_r($passenger_details);exit;
 		if($passenger_details == true){
 			$detail = "";
 			foreach ($passenger_details as $val) {
 				$detail .='<tr>
 							<td>'.ucfirst($val->passenger_name).'</td>	
 							<td>'.ucfirst($val->passenger_number).'</td>
 							<td>'.ucfirst($val->pickup_address).'</td>
 							<td>'.ucfirst($val->drop_address).'</td>
 							</tr>';	
 			}
 			
 			$response['success'] = true;
 			$response['successMsg'] = $detail;
 		}else{
 			$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
 		}
 		echo json_encode($response);
        
 	}


 	public function update($id){

 		$select = 'cust_id,cust_firstname,cust_lastname';
		$tableName = 'customer_master';
		$column = "isactive";
		$value = "1";
		$data['customerList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$data['vechileTList'] = $this->Booking_model->getData($select, $tableName, $column, $value);

        /*$select = '*';
		$tableName = BOOKING_TABLE;
		$column = 'booking_id';
		$value = $id;
		$data['booking'] = $this->Booking_model->getData($select, $tableName, $column, $value);*/

		$tableName =  'package_master p,'. BOOKING_TABLE .' b';
 		$select = 'b.*,p.package_name';
 		$where =  'b.package_id = p.package_id and b.booking_id = '.$id.'';
 		$data['booking'] = $this->Booking_model->getwheredata($select,$tableName,$where);

		$booking_id = $id;
 		$tableName =  PASSENGER_TABLE;
 		$select = '*';
 		$where =  "booking_id = '$booking_id'";
 		$data['passenger'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";
 		//print_r($data['passenger']);
		$data['update'] = true;
		$this->header->index();
		$this->load->view('BookingAdd', $data);
		$this->footer->index();
 	}

 	public function passengerDelete(){
        $pass_id = $_POST['id'];
        $passenger_table =  PASSENGER_TABLE;
        $resultMaster = $this->helper_model->delete($passenger_table,'id',$pass_id);
        if($resultMaster != false){
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}

 	public function Bookingupdate(){

 		/*echo "<pre>";
 		print_r($_POST);exit;*/
 		 $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : "";
		 $cust_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : "";
		 $vehicle_type = isset($_POST['vehicale_type']) ? $_POST['vehicale_type'] : "";
		 $travel_type = isset($_POST['travel_type']) ? $_POST['travel_type'] : "";
		 $pickup_location = isset($_POST['pickup_address']) ? $_POST['pickup_address'] : "";
		 $drop_location = isset($_POST['drop_address']) ? $_POST['drop_address'] : "";
		 $booking_status = isset($_POST['booking_status']) ? $_POST['booking_status'] : "";
		 $cancel_comment = isset($_POST['cancel_comment']) ? $_POST['cancel_comment'] : "";
		 
		 
		 //echo $booking_date;
		 //bdate conversion
		 if(isset($booking_date) && !empty($booking_date)){
		 	$booking_date = $this->helper_model->dbDatetime($booking_date);
		 }
		// echo $booking_date;exit;

		 //passenger new data
		 $passenger_name = isset($_POST['passenger_name']) ? $_POST['passenger_name'] : "";
		 $passenger_number = isset($_POST['passenger_number']) ? $_POST['passenger_number'] : "";
		 $pickup_address = isset($_POST['pass_pickup_address']) ? $_POST['pass_pickup_address'] : "";
		 $drop_address = isset($_POST['pass_drop_address']) ? $_POST['pass_drop_address'] : "";

		 //passenger edit data
		 $passenger_name_edit = isset($_POST['passenger_name_edit']) ? $_POST['passenger_name_edit'] : "";
		 $passenger_number_edit = isset($_POST['passenger_number_edit']) ? $_POST['passenger_number_edit'] : "";
		 $pickup_address_edit = isset($_POST['pass_pickup_address_edit']) ? $_POST['pass_pickup_address_edit'] : "";
		 $drop_address_edit = isset($_POST['pass_drop_address_edit']) ? $_POST['pass_drop_address_edit'] : "";
		 $package_id = isset($_POST['package']) ? $_POST['package'] : "";
		 //$no_of_persons = count($passenger_name);

		 $booking_data = array(
			'new_booking_date' => $booking_date,
			'booked_on' => date('Y-m-d h:i:s'),
			'cust_id' => $cust_id,
			'vehicle_type' => $vehicle_type,
			'travel_type' => $travel_type,
			'package_id' => $package_id,
			'pickup_location' => $pickup_location,
			'drop_location' => $drop_location,
			'booking_status' => $booking_status,
			'cancel_comment' => $cancel_comment,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);
	 	$booking_table =  BOOKING_TABLE;
		$this->db->trans_begin();
		$booking_column = 'booking_id';
		$booking_id = $_POST['id'];

		$result = $this->Booking_model->updateData($booking_table, $booking_data, $booking_column, $booking_id);

		$this->db->trans_begin();
	  

 	//passenger data insertion start
 	if(isset($booking_id) && !empty($booking_id)) {
 		if(isset($passenger_number) && !empty($passenger_number)) {
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
				$response['successMsg'] = "Booking Updated Successfully";
				$response['redirect'] = base_url()."booking/bookingList";
 	 		}
		 	$i++;
 		 }
 		}

 		if(isset($passenger_number_edit) && !empty($passenger_number_edit)) {
 		 foreach($passenger_number_edit as $key=>$val) {
	 		
	 		 $passenger_name_edit[$key] = isset($passenger_name_edit[$key]) ? $passenger_name_edit[$key] : "";
	 		 $pickup_address_edit[$key] = isset($pickup_address_edit[$key]) ? $pickup_address_edit[$key] : "";
	 		 $drop_address_edit[$key] = isset($drop_address_edit[$key]) ? $drop_address_edit[$key] : "";

	 		$val = isset($val) ? $val : $val;

		 	$passdata = array(
			'passenger_name' => $passenger_name_edit[$key],
			'passenger_number' => $val,	
			'pickup_address' =>  $pickup_address_edit[$key],
			'drop_address' => $drop_address_edit[$key],
			'booking_id' => $booking_id,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s'));
		 	//Insert Ledger data with Deriver Id
		 	$passtable =  PASSENGER_TABLE;
		 	$pass_column = "id";
		 	 $pass_id = $key;
		 	 $result = $this->Booking_model->updateData($passtable, $passdata, $pass_column, $pass_id);
		 	
		 	if(!isset($result) || empty($result)){
 	 		$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
			echo json_encode($response);exit;	
 	 		} else {

 	 			$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Booking updated Successfully";
				$response['redirect'] = base_url()."booking/bookingList";
 	 		}
		 	 
 		 }
 	 	}

 	} else {
 		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Booking updated Successfully";
		$response['redirect'] = base_url()."booking/bookingList";
 	}

 	 
	echo json_encode($response);
 	}

	public function addSlip()
	{
		$booking_id = $this->uri->segment(3);
		if($booking_id == ""){
			redirect('dashboard');
		}else{
			$select = '*';
			$tableName = 'duty_sleep_master';
			$column = 'booking_id';
			$value = $booking_id;
			$dutySleepExist = $this->Booking_model->getData($select, $tableName, $column, $value);
			if(empty($dutySleepExist)){
				$data['update'] = false;
			}else{
				$data['update'] = true;
				$data['DutySlip'] = $dutySleepExist;
				$select = 'vehicle_id,vehicle_no';
				$tableName = 'vehicle_master';
				$column = 'vehicle_id';
				$value = $dutySleepExist[0]->vehicle_id;
				$data['selectVehicle'] = $this->Booking_model->getData($select, $tableName, $column, $value);
				$select = 'driver_id,driver_fname,driver_lname';
				$tableName = 'driver_master';
				$column = 'driver_id';
				$value = $dutySleepExist[0]->driver_id;
				$data['selectDriver'] = $this->Booking_model->getData($select, $tableName, $column, $value);
				/*echo "<pre>";
				print_r($data);
				exit();*/
			}

			$tableName =  'booking_master b , vehicle_category v ';
	 		$select = 'b.duty_slip_id,b.booked_by,b.added_on,b.pickup_location,v.cat_name,b.package_id,b.package_id';
	 		$where =  'b.vehicle_type = v.cat_id and b.booking_id = '.$booking_id.'';
	 		$data['bookingDetails'] = $this->Booking_model->getwheredata($select,$tableName,$where);

	 		$package_id = $data['bookingDetails'][0]->package_id;
	 		$select = '*';
			$tableName = 'package_master';
			$where = "package_id = '$package_id'";
			$packageDetails = $this->helper_model->selectwhere($select, $tableName, $where);
			
			$data['hours'] = $packageDetails[0]->hours;
			$data['charge_hour'] = $packageDetails[0]->charge_hour;
			$data['distance'] = $packageDetails[0]->distance;
			$data['charge_distance'] = $packageDetails[0]->charge_distance;
			$data['package_amt'] = $packageDetails[0]->package_amt;


	 		$tableName =  'passenger_details';
	 		$select = 'passenger_name,passenger_number,pickup_address,pickup_time,added_on';
			$column = 'booking_id';
			$value = $booking_id;
			$data['passengerDetails'] = $this->Booking_model->getData($select, $tableName, $column, $value);
	 		//echo "<pre>"; print_r($data); exit();

			$select = 'vehicle_id,vehicle_no';
			$tableName = 'vehicle_master';
			$data['vehicleList'] = $this->Booking_model->getVehicleList($select,$tableName);
			$select = 'driver_id,driver_fname,driver_lname';
			$tableName = 'driver_master';
			$data['driverList'] = $this->Booking_model->getVehicleList($select,$tableName);
			$data['booking_id'] = $booking_id;
			//echo "<pre>"; print_r($data); exit();
			$this->header->index();
			$this->load->view('DutySlip', $data);
			$this->footer->index();
		}
	}

	public function addDutySlip() {
		$dutySlip = array(
			'vehicle_id' => $_POST['vehicle'],
			'driver_id' => $_POST['driver'],
			'total_kms' => $_POST['total_km'],
			'extra_kms' => $_POST['extra_kms'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'extra_hrs' => $_POST['extra_hrs'],
			'total_hrs' => $_POST['total_hrs'],
			'toll_fess' => $_POST['toll_fess'],
			'parking_fees' => $_POST['parking_fees'],
			'total_amt' => $_POST['total_amt'],
			'booking_id' => $_POST['booking_id'],
			'comments' => $_POST['comments'],
			'status' => 1,
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'duty_sleep_master';
		$result = $this->Booking_model->saveData($tableName,$dutySlip);
		if($result != false){
			$data = array(
				'duty_slip_id' => $result
			);
			$tableName = 'booking_master';
			$columnName = 'booking_id';
			$value = $_POST['booking_id'];
			$this->Booking_model->updateData($tableName,$data,$columnName,$value);
			if($_POST['end_date'] != ""){
				$this->addInvoice($result,$_POST['start_date'],$_POST['total_amt'],$_POST['booking_id']);
			}

			$response['success'] = true;
			$response['successMsg'] = "Successfully Submit";
			$response['redirect'] = base_url()."booking/bookingList";
		}else{
			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
		}

		echo json_encode($response);
	}

	public function updateDuty() {
		$updatdDutySlip = array(
			'vehicle_id' => $_POST['vehicle'],
			'driver_id' => $_POST['driver'],
			'total_kms' => $_POST['total_km'],
			'extra_kms' => $_POST['extra_kms'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'extra_hrs' => $_POST['extra_hrs'],
			'total_hrs' => $_POST['total_hrs'],
			'toll_fess' => $_POST['toll_fess'],
			'parking_fees' => $_POST['parking_fees'],
			'total_amt' => $_POST['total_amt'],
			'comments' => $_POST['comments'],
			'status' => 1,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);

		$duty_table = 'duty_sleep_master';
		$duty_column = 'duty_sleep_id';
		$duty_sleep_id = $_POST['duty_sleep_id'];

		$result = $this->Booking_model->updateData($duty_table, $updatdDutySlip, $duty_column, $duty_sleep_id);
		if($result != false){
			if(strtolower($_POST['payment_status']) != "paid" && $_POST['end_date'] != ""){
				$tableName =  'invoice_master';
		 		$select = 'invoice_id';
				$column = 'duty_sleep_id';
				$value = $_POST['duty_sleep_id'];
				$dutySlipDetails = $this->Booking_model->getData($select, $tableName, $column, $value);
				if(empty($dutySlipDetails)){
					$this->addInvoice($_POST['duty_sleep_id'],$_POST['start_date'],$_POST['total_amt'],$_POST['booking_id']);
				}else{
					$this->updateInvoice($_POST['total_amt'],$_POST['start_date'],$_POST['duty_sleep_id']);
				}
			}
			$response['success'] = true;
			$response['successMsg'] = "Successfully Updated";
			$response['redirect'] = base_url()."booking/bookingList";
		}else{
			$response['success'] = false;
			$response['error'] = error;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

		echo json_encode($response);
	}

	public function addInvoice($duty_sleep_id,$start_date,$total_amt,$booking_id){
		$invoiceData = array(
			'duty_sleep_id' => $duty_sleep_id,
			'booking_id' => $booking_id,
			'invoice_start_date' => $start_date,
			'invoice_date' => date('Y-m-d h:i:s'),
			'payment_mode' => 'cash',
			'total_amount' => $total_amt,
			'transaction_id' => 0,
			'bank_name' => '',
			'status' => 1,
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'invoice_master';
		return $this->Booking_model->saveData($tableName,$invoiceData);
	}

	public function updateInvoice($total_amt,$start_date,$duty_sleep_id){
		$invoiceData = array(
			'invoice_start_date' => $start_date,
			'payment_mode' => 'cash',
			'total_amount' => $total_amt,
			'transaction_id' => 0,
			'bank_name' => '',
			'status' => 1,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);

		$duty_table = 'invoice_master';
		$duty_column = 'duty_sleep_id';
		$duty_sleep_id = $duty_sleep_id;

		return $this->Booking_model->updateData($duty_table, $invoiceData, $duty_column, $duty_sleep_id);
	}
	

 	


 	
}
