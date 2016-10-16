<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('booking/Booking_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		$this->load->model('helper/helper_model');
		$this->load->model('account/account_model');
		$this->active = "booking";
	}

	public function bookingMaster()
	{

		$select = '*';
		$tableName = 'customer_master';
		$column = "isactive";
		$value = "1";
		$data['customerList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$select = '*';
		$data['vechileTList'] = $this->Booking_model->getData($select, $tableName, $column, $value);
		//echo "<pre>"; print_r($data); exit();
		$this->header->index($this->active);
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
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
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
			'booked_by' => $user_id,
			'added_by' => $user_id,
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
			'added_by' => $user_id,
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
 		
	 	 $from_date = $this->uri->segment(3);
		 $to_date = $this->uri->segment(4);
		 $status = $this->uri->segment(5);
		 $c_type = $this->uri->segment(6);
		 $b_type = $this->uri->segment(7);
		 $where_extra = "";

		if(($from_date!="" && $to_date!="") && ($from_date!="0" && $to_date!="0"))   {
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$from_date = date("Y-m-d", strtotime($from_date));
			$to_date = date("Y-m-d", strtotime($to_date));
			$where_extra .= " and booking_date between '$from_date' and '$to_date'";

		}
		if($c_type!="" && $c_type!="0") {
			$data['c_type'] = $c_type;
			$where_extra .= " and c.cust_type_id = $c_type";
		}
		if($status!="" && $status!="0") {
			$data['status'] = $status;
			$where_extra .= " and booking_status = $status";
		}
		if($b_type!="" && $b_type!="0") {
			$data['b_type'] = $b_type;
			if($b_type == 1) {
			$where_extra .= " and (duty_slip_id = null OR duty_slip_id = '')";
			}else {
			$where_extra .= " and (duty_slip_id != null OR duty_slip_id != '')";	
			}
		}

 		$tableName =  'customer_master c, booking_master b , vehicle_category v ';
 		$select = 'b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname';
 		$where =  'c.cust_id = b.cust_id and b.vehicle_type = v.cat_id';
 		$where .= $where_extra;
 		$data['booking_list'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		$pass_table =  PASSENGER_TABLE;
 		$filds = "*";
 		$data['pass_list'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";print_r($data['booking_list']);exit;
        $this->header->index($this->active);
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

 		$select = '*';
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


 		if(isset($data['booking'][0]->duty_slip_id) && !empty($data['booking'][0]->duty_slip_id)){
 			
			$this->bookingList();return false;

 		} 

 		//echo "<pre>";print_r($data['booking']);exit;
		$booking_id = $id;
 		$tableName =  PASSENGER_TABLE;
 		$select = '*';
 		$where =  "booking_id = '$booking_id'";
 		$data['passenger'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";
 		//print_r($data['passenger']);
		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('BookingAdd', $data);
		$this->footer->index();
 	}

 	public function view($id){

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

 		//echo "<pre>";print_r($data['booking']);exit;
		$booking_id = $id;
 		$tableName =  PASSENGER_TABLE;
 		$select = '*';
 		$where =  "booking_id = '$booking_id'";
 		$data['passenger'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		//echo "<pre>";
 		//print_r($data['passenger']);
		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('view', $data);
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

 	public function bookingDelete(){

 		$booking_id = $_POST['id'];
 		$select = '*';
		$tableName = BOOKING_TABLE;
		$column = 'booking_id';
		$value = $booking_id;
		$booking_result = $this->Booking_model->getData($select, $tableName, $column, $value);
		if(($booking_result[0]->booking_status != 1 ||  $booking_result[0]->booking_status != 4) &&
			(isset($booking_result[0]->duty_slip_id) || !empty($booking_result[0]->duty_slip_id)) ) {

	 		$response['error'] = true;
	 	    $response['success'] = false;
			$response['errorMsg'] = "Duty Sleep exists against Booking!!!";
			$response['successMsg'] = "Duty Sleep exists against Booking!!!";
		} else {
        
	        $booking_table =  BOOKING_TABLE;
	        $resultMaster = $this->helper_model->delete($booking_table,'booking_id',$booking_id);
	        if($resultMaster != false){
	        	$response['success'] = true;
				$response['successMsg'] = "Record Deleted";
	        }else{
	        	$response['error'] = true;
		 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";
	        }
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
		  $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		 
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
			'updated_by' => $user_id,
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
			'added_by' => $user_id,
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
			'updated_by' => $user_id,
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
	 		$select = 'b.duty_slip_id,b.booked_by,b.added_on,b.pickup_location,b.drop_location,v.cat_name,b.package_id,b.package_id,b.travel_type,b.cust_id';
	 		$where =  'b.vehicle_type = v.cat_id and b.booking_id = '.$booking_id.'';
	 		$data['bookingDetails'] = $this->Booking_model->getwheredata($select,$tableName,$where);

	 		$cust_id = $data['bookingDetails'][0]->cust_id;
	 		if(isset($cust_id) && !empty($cust_id)) {

	 			$select = '*';
				$tableName = 'customer_master';
				$where = "cust_id = '$cust_id'";
				$custDetails = $this->helper_model->selectwhere($select, $tableName, $where);
				$data['cust_id'] = $custDetails[0]->cust_id;
				$data['cust_type_id'] = $custDetails[0]->cust_type_id;
				if($data['cust_type_id'] == 2){
					$data['cust_name'] = $custDetails[0]->cust_compname;
					$data['cust_type'] = "Corporate";
				}elseif($data['cust_type_id'] == 1){
					$data['cust_name'] = $custDetails[0]->cust_firstname. " " .$custDetails[0]->cust_lastname;
					$data['cust_type'] = "Indivisual";
				} else {
					$data['cust_name'] = $custDetails[0]->cust_firstname. " " .$custDetails[0]->cust_lastname;
					$data['cust_type'] = "Other";
				}

	 		}

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
	 		$select = 'passenger_name,passenger_number,pickup_address,pickup_time,added_on,drop_address';
			$column = 'booking_id';
			$value = $booking_id;
			$data['passengerDetails'] = $this->Booking_model->getData($select, $tableName, $column, $value);
	 		//echo "<pre>"; print_r($data); exit();

			$select = '*';
			$tableName = 'vehicle_master ';
			$where = "vehicle_status = 1 ";
			$data['vehicleList'] = $this->Booking_model->getwheredata($select, $tableName, $where);


			$select = 'driver_id,driver_fname,driver_lname';
			$tableName = 'driver_master';
			$where = "isactive = '1'";
			$data['driverList'] = $this->Booking_model->getwheredata($select,$tableName,$where);
			$data['booking_id'] = $booking_id;

			$select = '*';
			$tableName = 'vendors_master';
			$where = "status = '1'";
			$data['vendorlist'] = $this->Booking_model->getwheredata($select,$tableName,$where);
			//echo "<pre>"; print_r($data); exit();


			$grp_table = LEDGER_TABLE;
		 

			$ledger_data = $this->account_model->getDataOrder('*',$grp_table,'parent_id','asc');
			
			$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
			$filter_param_from = array('bank','cash');
			
			$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
			
			$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
	                                'useEmpty' => true,
	                                'emptyText' => '--Select--',
	                                'options' => array(
	                                                'children' =>  array(
	                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
	                                                                'options' => array (
	                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
	                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
	                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
	                                                                  )
	                                    
	                                                 )                    
	                                                         
	                                 )), "optgroup");


			 
			$data['from_select'] = $this->selectEnhanced->render("",'from_ledger','from_ledger','');


			$ledger_data = $this->selectEnhanced_to->__construct("driver_payment", $filter_ledgers_from, array(
	                                'useEmpty' => true,
	                                'emptyText' => '--Select--',
	                                'options' => array(
	                                                'children' =>  array(
	                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
	                                                                'options' => array (
	                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
	                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
	                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;}
	                                                                  )
	                                    
	                                                 )                    
	                                                         
	                                 )), "optgroup");

			$data['driver_payment'] = $this->selectEnhanced->render("",'driver_payment','driver_payment','');		

			if(isset($dutySleepExist) && !empty(isset($dutySleepExist))) {
			$data['from_selectd_ledger_id'] = $dutySleepExist[0]->advance_ledger_id;
			}

			$select = " ledger_account_id ";
			$ledgertable = LEDGER_TABLE ;
			$context_cash = PATTY_CASH_CONTEXT;
			$entity_type = LEDGER_ENTITY;
			$where =  array('ledger_account_name' =>  $context_cash, 'entity_type' => $entity_type);
	 	 	$patycash_ledger = $this->Booking_model->getGroupId($select,$ledgertable,$context_cash,$entity_type,$where);

	 	 	if(isset($patycash_ledger) && !empty(isset($patycash_ledger))) {
			$data['driver_selectd_ledger_id'] = $patycash_ledger->ledger_account_id;
			}


			if(isset($data['bookingDetails']) && !empty($data['bookingDetails'])) {

				$cust_id = $data['bookingDetails'][0]->cust_id;
				$select = 'l.ledger_account_id,l.ledger_account_name';
				$tableName = 'ledger_master l , customer_master c';
				$where = "c.ledger_id = l.ledger_account_id AND c.cust_id = $cust_id";
				$data['custlist'] = $this->Booking_model->getwheredata($select,$tableName,$where);

				if(!isset($data['custlist']) || empty($data['custlist'])){
					echo "Customer not map with booking";die;
				}
			}

			$this->header->index($this->active);
			$this->load->view('DutySlip', $data);
			$this->footer->index();
		}
	}

	public function addDutySlip() {

		$start_date = NULL;
		$end_date = NULL;

		/*if(isset($_POST['start_date']) && !empty($_POST['start_date']) &&
		   isset($_POST['end_date']) && !empty($_POST['end_date']) ) {
			$status = 3;
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
		} else if(isset($_POST['start_date']) && !empty($_POST['start_date'])) {
			$status = 2;
			$start_date = $_POST['start_date'];
		} else {
			$status = 1;
		}*/
		$status = $_POST['tour_status'];
		$user_id = 0;
		if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		

		//For vendor entry
		$vendor_id = NULL;
		$is_outsource = 0;
		$vendor_fees = NULL;
		if(isset($_POST['vendor']) && !empty($_POST['vendor'])) {

			$vendor_id = $_POST['vendor'];
			$is_outsource = 1;
			$vendor_fees = $_POST['vendor_fess'];
		}

		//For advance entry
		$advance_paid = NULL;
		$advance_ledger_id = NULL;
		$advance_paid_flag = 0;
		
		if(isset($_POST['from_ledger']) && !empty($_POST['from_ledger'])) {

			$advance_ledger_id = $_POST['from_ledger'];
			$advance_paid = $_POST['payment_amount'];
			$advance_paid_flag = 0;
		}
		 $this->db->trans_begin();


		if(isset($_POST['from_ledger']) && !empty($_POST['from_ledger']) && $advance_paid_flag == 0) {

			$advance_ledger_id = $_POST['from_ledger'];
			$advance_paid = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : 0.00;



			$customerLedgerId = $_POST['cust_ledger_id'];
			$from_ledger_name = $_POST['cust_ledger_name'];
			$dr = DR;


			// transaction data data insertion start (advance payment)
			 	$from_data = array(
					'transaction_date' => date('Y-m-d h:i:s'),
					'ledger_account_id' => $customerLedgerId,
					'ledger_account_name' => $from_ledger_name,
					'transaction_type' => $dr,
					'payment_reference' => $_POST['booking_id'],
					'transaction_amount' => $advance_paid,
					'txn_from_id' => 0,
					'memo_desc' => ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
					'added_by' => $user_id,
					'added_on' => date('Y-m-d h:i:s')
				);
				$transaction_table =  TRANSACTION_TABLE;

				//From transaction
			 	$from_transaction_id = $this->Booking_model->saveData($transaction_table,$from_data);
			 

			 	//to leadger trans data insertion start
			 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
					$select = " * ";
					$ledgertable = LEDGER_TABLE ;

				 	$where =  "ledger_account_id = '$advance_ledger_id'";
					$ledger_details = $this->Booking_model->getwheresingle($select,$ledgertable,$where);
					
				 	$to_ledger_name = $ledger_details->ledger_account_name;
				 	 
					  
				 	// transaction data data insertion start
					 $to_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $advance_ledger_id,
							'ledger_account_name' => $to_ledger_name,
							'transaction_type' => $dr,
							'payment_reference' => $_POST['booking_id'],
							'transaction_amount' => $advance_paid,
							'txn_from_id' => $from_transaction_id,
							'memo_desc' => ADVANCE_RECIVE_NARRATION." : ".$_POST['booking_id'],
							'added_by' => $user_id,
							'added_on' => date('Y-m-d h:i:s')
						);
					$transaction_table =  TRANSACTION_TABLE;

					 //From transaction
					$to_transaction = $this->Booking_model->saveData($transaction_table,$to_data);


			 	 	if(!isset($to_transaction) && empty($to_transaction)){
			 	 		$this->db->trans_rollback();
				 		$response['error'] = true;
				 		$response['success'] = false;
						$response['errorMsg'] = "Error!!! Please contact IT Dept";
			 	 	}  

			 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
			 	}
 			$advance_paid_flag = 1;
		}



		//driver adavance 
		$driver_advance_paid = isset($_POST['driver_advance_paid']) ? $_POST['driver_advance_paid'] : NULL;
		$driver_advance_return = isset($_POST['driver_advance_return']) ? $_POST['driver_advance_return'] : NULL;
		$total_expense = isset($_POST['total_expense']) ? $_POST['total_expense'] : NULL;
		$start_km = isset($_POST['start_km']) ? $_POST['start_km'] : NULL;
		$end_km = isset($_POST['end_km']) ? $_POST['end_km'] : NULL;
		$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : NULL;
		$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : NULL;
		 //bdate conversion
		 if(isset($start_time) && !empty($start_time)){
		 	$start_time = $this->helper_model->dbDatetime($start_time);
		 }
		  //bdate conversion
		 if(isset($end_time) && !empty($end_time)){
		 	$end_time = $this->helper_model->dbDatetime($end_time);
		 }

		$dutySlip = array(
			'vehicle_id' => $_POST['vehicle'],
			'driver_id' => $_POST['driver'],
			'total_kms' => $_POST['total_km'],
			'extra_kms' => $_POST['extra_kms'],
			'start_date' => $start_date,
			'end_date' => $end_date,
			'extra_hrs' => $_POST['extra_hrs'],
			'total_hrs' => $_POST['total_hrs'],
			'toll_fess' => $_POST['toll_fess'],
			'parking_fees' => $_POST['parking_fees'],
			'total_amt' => $_POST['total_amt'],
			'booking_id' => $_POST['booking_id'],
			'comments' => $_POST['comments'],
			'vendor_id' => $vendor_id,
			'commision_amount' => $vendor_fees,
			'is_outsource' => $is_outsource,
			'advance_paid' => $advance_paid,
			'advance_paid_flag' => $advance_paid_flag,
			'advance_ledger_id' => $advance_ledger_id,
			'driver_advance_paid' => $driver_advance_paid,
			'driver_advance_return' => $driver_advance_return,
			'total_advance_expense' => $total_expense,
			'cust_id' => $_POST['cust_id'],
			'cust_type' => $_POST['cust_type_id'],
			'start_km' => $start_km,
			'end_km' => $end_km,
			'start_time' => $start_time,
			'end_time' => $end_time,
			'status' => $status,
			'added_by' => $user_id,
			'added_on' => date('Y-m-d h:i:s')
		);
		
		


		$tableName = 'duty_sleep_master';
		$result = $this->Booking_model->saveData($tableName,$dutySlip);
		if($result != false){

			//vendor Bill entry if booking outsorec

			if(isset($_POST['vendor']) && !empty($_POST['vendor'])) {

					$vendor_fees = $_POST['vendor_fess'];
					$vendor_bill = array(
					'vendor_id' => $vendor_id,
					'duty_sleep_id' => $result,
					'booking_id' => $_POST['booking_id'],
					'booking_status' => $status,
					'vendor_bill_payment_amount' => $vendor_fees,
					'status' => '1',
					'added_by' => $user_id,
					'added_on' => date('Y-m-d h:i:s')
					);

				$vendor_bill_table = VENDOR_BILL_TABLE;
				$bill_result = $this->Booking_model->saveData($vendor_bill_table,$vendor_bill);	
				if($bill_result != true) {
					$this->db->trans_rollback();
					$response['success'] = false;
					$response['successMsg'] = "Vendor Bill Not Saved";
				}
			}


			if($status >= 3) {

				 $driver_payment = $_POST['driver_payment'];
				$dri_id = $_POST['driver'];
				$select = 'l.ledger_account_id,l.ledger_account_name';
				$tableName = 'ledger_master l , driver_master c';
				$where = "c.ledger_id = l.ledger_account_id AND c.driver_id = $dri_id";
				$driver_data = $this->Booking_model->getwheredata($select,$tableName,$where);

				if(!isset($driver_data) || empty($driver_data)){

					$this->db->trans_rollback();
					$response['success'] = false;
					$response['successMsg'] = "Error!!! Please contact IT Dept";
				}else{

					$driver_ledger_id = $driver_data[0]->ledger_account_id;
					$driver_ledger_name = $driver_data[0]->ledger_account_name;
					$tottalexp = $total_expense;


					$dr = DR;
					$cr = CR;
					$select = " * ";
					$ledgertable = LEDGER_TABLE ;

				 	$where =  "ledger_account_id = '$driver_payment'";
					$ledger_details = $this->Booking_model->getwheresingle($select,$ledgertable,$where);
					
				 	$from_ledger_name = $ledger_details->ledger_account_name;

						// transaction data insertion start (expense payment)
						 	$from_data = array(
								'transaction_date' => date('Y-m-d h:i:s'),
								'ledger_account_id' => $driver_payment,
								'ledger_account_name' => $from_ledger_name,
								'transaction_type' => $cr,
								'payment_reference' => $_POST['booking_id'],
								'transaction_amount' => $tottalexp,
								'txn_from_id' => 0,
								'memo_desc' => EXPENSE_ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
								'added_by' => $user_id,
								'added_on' => date('Y-m-d h:i:s')
							);
							$transaction_table =  TRANSACTION_TABLE;

							//From transaction
						 	$from_transaction_id = $this->Booking_model->saveData($transaction_table,$from_data);
						 

						 	//to leadger trans data insertion start
						 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
								 
							 	 
								  
							 	// transaction data data insertion start
								 $to_data = array(
										'transaction_date' => date('Y-m-d h:i:s'),
										'ledger_account_id' => $driver_ledger_id,
										'ledger_account_name' => $driver_ledger_name,
										'transaction_type' => $dr,
										'payment_reference' => $_POST['booking_id'],
										'transaction_amount' => $tottalexp,
										'txn_from_id' => $from_transaction_id,
										'memo_desc' => EXPENSE_ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
										'added_by' => $user_id,
										'added_on' => date('Y-m-d h:i:s')
									);
								$transaction_table =  TRANSACTION_TABLE;

								 //From transaction
								$to_transaction = $this->Booking_model->saveData($transaction_table,$to_data);


						 	 	if(!isset($to_transaction) && empty($to_transaction)){
						 	 		$this->db->trans_rollback();
							 		$response['error'] = true;
							 		$response['success'] = false;
									$response['errorMsg'] = "Error!!! Please contact IT Dept";
						 	 	}  

						 	} else {
						 		$this->db->trans_rollback();
						 		$response['error'] = true;
						 		$response['success'] = false;
								$response['errorMsg'] = "Error!!! Please contact IT Dept";
						 	}

				} 
			}


			$data = array(
				'duty_slip_id' => $result,
				'booking_status' => $status
			);
			$tableName = 'booking_master';
			$columnName = 'booking_id';
			$value = $_POST['booking_id'];
			$this->Booking_model->updateData($tableName,$data,$columnName,$value);
			if($_POST['end_date'] != ""){
				$this->addInvoice($result,$_POST['start_date'],$_POST['total_amt'],$_POST['booking_id']);
			}
			$this->db->trans_commit();
			$response['success'] = true;
			$response['successMsg'] = "Successfully Submit";
			$response['redirect'] = base_url()."booking/bookingList";
		}else{
			$this->db->trans_rollback();
			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
		}

		echo json_encode($response);
	}



	public function updateDuty() {

		error_reporting(E_ALL);
		/*if(isset($_POST['start_date']) && !empty($_POST['start_date']) &&
		   isset($_POST['end_date']) && !empty($_POST['end_date'])) {
			$status = 3;
		} else if(isset($_POST['start_date']) && !empty($_POST['start_date'])) {
			$status = 2;
		} else {
			$status = 1;
		}*/
		$status = $_POST['tour_status'];
		//echo $status;exit;
		$user_id = 0;
		if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}

		$advance_ledger_id = $_POST['from_ledger'];
		$advance_paid = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : 0.00;
		$advance_paid_flag = isset($_POST['pre_advance_leg_id']) ? $_POST['pre_advance_leg_id'] : 0;
		 


		if(isset($_POST['from_ledger']) && !empty($_POST['from_ledger']) && $advance_paid_flag == 0) {
			 
			$customerLedgerId = $_POST['cust_ledger_id'];
			$from_ledger_name = $_POST['cust_ledger_name'];
			$dr = DR;

			$this->db->trans_begin();
			// transaction data data insertion start (advance payment)
			 	$from_data = array(
					'transaction_date' => date('Y-m-d h:i:s'),
					'ledger_account_id' => $customerLedgerId,
					'ledger_account_name' => $from_ledger_name,
					'transaction_type' => $dr,
					'payment_reference' => $_POST['booking_id'],
					'transaction_amount' => $advance_paid,
					'txn_from_id' => 0,
					'memo_desc' => ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')
				);
				$transaction_table =  TRANSACTION_TABLE;

				//From transaction
			 	$from_transaction_id = $this->Booking_model->saveData($transaction_table,$from_data);
			 

			 	//to leadger trans data insertion start
			 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
					$select = " * ";
					$ledgertable = LEDGER_TABLE ;

				 	$where =  "ledger_account_id = '$advance_ledger_id'";
					$ledger_details = $this->Booking_model->getwheresingle($select,$ledgertable,$where);
					
				 	$to_ledger_name = $ledger_details->ledger_account_name;
				 	 
					  
				 	// transaction data data insertion start
					 $to_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $advance_ledger_id,
							'ledger_account_name' => $to_ledger_name,
							'transaction_type' => $dr,
							'payment_reference' => $_POST['booking_id'],
							'transaction_amount' => $advance_paid,
							'txn_from_id' => $from_transaction_id,
							'memo_desc' => ADVANCE_RECIVE_NARRATION." : ".$_POST['booking_id'],
							'added_by' => 1,
							'added_on' => date('Y-m-d h:i:s')
						);
					$transaction_table =  TRANSACTION_TABLE;

					 //From transaction
					$to_transaction = $this->Booking_model->saveData($transaction_table,$to_data);


			 	 	if(!isset($to_transaction) && empty($to_transaction)){
			 	 		$this->db->trans_rollback();
				 		$response['error'] = true;
				 		$response['success'] = false;
						$response['errorMsg'] = "Error!!! Please contact IT Dept";
			 	 	}  

			 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
			 	}
 			$advance_paid_flag = 1;
		}

		//For vendor entry update
		$vendor_id = NULL;
		$is_outsource = 0;
		$vendor_fees = NULL;
		if(isset($_POST['vendor']) && !empty($_POST['vendor'])) {

			$vendor_id = $_POST['vendor'];
			$is_outsource = 1;
			$vendor_fees = isset($_POST['vendor_fess']) ? $_POST['vendor_fess'] : 0.00;
		}

		//driver adavance 
		$driver_advance_paid = isset($_POST['driver_advance_paid']) ? $_POST['driver_advance_paid'] : NULL;
		$driver_advance_return = isset($_POST['driver_advance_return']) ? $_POST['driver_advance_return'] : NULL;
		$total_expense = isset($_POST['total_expense']) ? $_POST['total_expense'] : NULL;
		$start_km = isset($_POST['start_km']) ? $_POST['start_km'] : NULL;
		$end_km = isset($_POST['end_km']) ? $_POST['end_km'] : NULL;
		$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : NULL;
		$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : NULL;

		//echo $start_time;
		//echo $end_time;
		 //bdate conversion
		 if(isset($start_time) && !empty($start_time)){
		 	$start_time = $this->helper_model->dbDatetime($start_time);
		 }
		  //bdate conversion
		 if(isset($end_time) && !empty($end_time)){
		 	$end_time = $this->helper_model->dbDatetime($end_time);
		 }

		// echo $start_time;
		// echo $end_time;
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
			'vendor_id' => $vendor_id,
			'commision_amount' => $vendor_fees,
			'is_outsource' => $is_outsource,
			'advance_paid' => $advance_paid,
			'advance_paid_flag' => $advance_paid_flag,
			'advance_ledger_id' => $advance_ledger_id,
			'driver_advance_paid' => $driver_advance_paid,
			'driver_advance_return' => $driver_advance_return,
			'total_advance_expense' => $total_expense,
			'cust_id' => $_POST['cust_id'],
			'cust_type' => $_POST['cust_type_id'],
			'start_km' => $start_km,
			'end_km' => $end_km,
			'start_time' => $start_time,
			'end_time' => $end_time,
			'status' => $status,
			'updated_by' => $user_id,
			'updated_on' => date('Y-m-d h:i:s')
		);

		if(isset($_POST['pre_vendor_id']) && !empty($_POST['pre_vendor_id'])) {
			 
			$vendor_bill = array(
				'vendor_id' => $vendor_id,
				'duty_sleep_id' => $_POST['duty_sleep_id'],
				'booking_status' => $status,
				'vendor_bill_payment_amount' => $vendor_fees,
				'status' => '1',
				'updated_by' => $user_id,
				'updated_on' => date('Y-m-d h:i:s')
			 );

			$vendor_bill_table = VENDOR_BILL_TABLE;
			$vendor_bill_cloumn = 'duty_sleep_id';
			$duty_sleep_id = $_POST['duty_sleep_id'];
			$bill_result = $this->Booking_model->updateData($vendor_bill_table, $vendor_bill, $vendor_bill_cloumn, $duty_sleep_id);
			if($bill_result != true) {
					$this->db->trans_rollback();
					$response['success'] = false;
					$response['successMsg'] = "Vendor Bill Not updated";
			}

		} 

		 if(empty($_POST['pre_vendor_id']) && isset($_POST['vendor']) && !empty($_POST['vendor'])) {
		 	 
				$vendor_fees = isset($_POST['vendor_fess']) ?  $_POST['vendor_fess'] : 0.00;
				$vendor_bill = array(
				'vendor_id' => $vendor_id,
				'duty_sleep_id' => $_POST['duty_sleep_id'],
				'booking_id' => $_POST['booking_id'],
				'booking_status' => $status,
				'vendor_bill_payment_amount' => $vendor_fees,
				'status' => '1',
				'added_by' => $user_id,
				'added_on' => date('Y-m-d h:i:s')
				);

				$vendor_bill_table = VENDOR_BILL_TABLE;
				$bill_result = $this->Booking_model->saveData($vendor_bill_table,$vendor_bill);	
				if($bill_result != true) {
					$this->db->trans_rollback();
					$response['success'] = false;
					$response['successMsg'] = "Vendor Bill Not Saved";
				}
		}



 

		if($status >= 3) {

				 $driver_payment = $_POST['driver_payment'];
				$dri_id = $_POST['driver'];
				$select = 'l.ledger_account_id,l.ledger_account_name';
				$tableName = 'ledger_master l , driver_master c';
				$where = "c.ledger_id = l.ledger_account_id AND c.driver_id = $dri_id";
				$driver_data = $this->Booking_model->getwheredata($select,$tableName,$where);

				if(!isset($driver_data) || empty($driver_data)){

					$this->db->trans_rollback();
					$response['success'] = false;
					$response['successMsg'] = "Error!!! Please contact IT Dept";
				}else{

					$driver_ledger_id = $driver_data[0]->ledger_account_id;
					$driver_ledger_name = $driver_data[0]->ledger_account_name;
					$tottalexp = $total_expense;


					$dr = DR;
					$cr = CR;
					$select = " * ";
					$ledgertable = LEDGER_TABLE ;

				 	$where =  "ledger_account_id = '$driver_payment'";
					$ledger_details = $this->Booking_model->getwheresingle($select,$ledgertable,$where);
					
				 	$from_ledger_name = $ledger_details->ledger_account_name;

						// transaction data insertion start (expense payment)
						 	$from_data = array(
								'transaction_date' => date('Y-m-d h:i:s'),
								'ledger_account_id' => $driver_payment,
								'ledger_account_name' => $from_ledger_name,
								'transaction_type' => $cr,
								'payment_reference' => $_POST['booking_id'],
								'transaction_amount' => $tottalexp,
								'txn_from_id' => 0,
								'memo_desc' => EXPENSE_ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
								'added_by' => $user_id,
								'added_on' => date('Y-m-d h:i:s')
							);
							$transaction_table =  TRANSACTION_TABLE;

							//From transaction
						 	$from_transaction_id = $this->Booking_model->saveData($transaction_table,$from_data);
						 

						 	//to leadger trans data insertion start
						 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
								 
							 	 
								  
							 	// transaction data data insertion start
								 $to_data = array(
										'transaction_date' => date('Y-m-d h:i:s'),
										'ledger_account_id' => $driver_ledger_id,
										'ledger_account_name' => $driver_ledger_name,
										'transaction_type' => $dr,
										'payment_reference' => $_POST['booking_id'],
										'transaction_amount' => $tottalexp,
										'txn_from_id' => $from_transaction_id,
										'memo_desc' => EXPENSE_ADVANCE_PAID_NARRATION." : ".$_POST['booking_id'],
										'added_by' => $user_id,
										'added_on' => date('Y-m-d h:i:s')
									);
								$transaction_table =  TRANSACTION_TABLE;

								 //From transaction
								$to_transaction = $this->Booking_model->saveData($transaction_table,$to_data);


						 	 	if(!isset($to_transaction) && empty($to_transaction)){
						 	 		$this->db->trans_rollback();
							 		$response['error'] = true;
							 		$response['success'] = false;
									$response['errorMsg'] = "Error!!! Please contact IT Dept";
						 	 	}  

						 	} else {
						 		$this->db->trans_rollback();
						 		$response['error'] = true;
						 		$response['success'] = false;
								$response['errorMsg'] = "Error!!! Please contact IT Dept";
						 	}

				} 
			}


		$duty_table = 'duty_sleep_master';
		$duty_column = 'duty_sleep_id';
		$duty_sleep_id = $_POST['duty_sleep_id'];

		$result = $this->Booking_model->updateData($duty_table, $updatdDutySlip, $duty_column, $duty_sleep_id);


		$updatdbooking = array(
			'booking_status' => $status
		);
		$booking_table = 'booking_master';
		$booking_column = 'duty_slip_id';
		$duty_sleep_id = $_POST['duty_sleep_id'];
		$booking_update = $this->Booking_model->updateData($booking_table, $updatdbooking, $booking_column, $duty_sleep_id);

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
			$this->db->trans_commit();
			$response['success'] = true;
			$response['successMsg'] = "Successfully Updated";
			$response['redirect'] = base_url()."booking/bookingList";
		}else{
			$this->db->trans_rollback();
			$response['success'] = false;
			$response['error'] = error;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}
		 
		echo json_encode($response);
	}



	public function addInvoice($duty_sleep_id,$start_date,$total_amt,$booking_id){
		$invoice_no = strtoupper($this->generateRandomString(4));
		$user_id = 0;
		if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}

		$invoiceData = array(
			'invoice_no' => $invoice_no,
			'duty_sleep_id' => $duty_sleep_id,
			'booking_id' => $booking_id,
			'invoice_start_date' => $start_date,
			'invoice_date' => date('Y-m-d h:i:s'),
			'payment_mode' => 'cash',
			'total_amount' => $total_amt,
			'transaction_id' => 0,
			'bank_name' => '',
			'status' => 1,
			'added_by' => $user_id,
			'added_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'invoice_master';
		return $this->Booking_model->saveData($tableName,$invoiceData);
	}

	public function updateInvoice($total_amt,$start_date,$duty_sleep_id){

		$user_id = 0;
		if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		$invoiceData = array(
			'invoice_start_date' => $start_date,
			'payment_mode' => 'cash',
			'total_amount' => $total_amt,
			'transaction_id' => 0,
			'bank_name' => '',
			'status' => 1,
			'updated_by' => $user_id,
			'updated_on' => date('Y-m-d h:i:s')
		);

		$duty_table = 'invoice_master';
		$duty_column = 'duty_sleep_id';
		$duty_sleep_id = $duty_sleep_id;

		return $this->Booking_model->updateData($duty_table, $invoiceData, $duty_column, $duty_sleep_id);
	}
	

	public function generateRandomString($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}


 	public function generateDutyslip($booking_id){

 		error_reporting(E_ALL);
 		$this->load->helper('dompdf');
	    $tableName =  'booking_master bok , duty_sleep_master dut, customer_master cus ,vehicle_master ve, users_master us,driver_master dr';
 		$select = 'bok.booking_date,bok.duty_slip_id,bok.booked_by,bok.added_on,bok.pickup_location,bok.vehicle_type,bok.booking_id,
 		bok.drop_location,bok.travel_type,cus.cust_id,cus.cust_type_id,cus.cust_firstname,cus.cust_lastname,dr.driver_fname,dr.driver_lname,
 		cus.contact_per_name,cus.cust_mob1,ve.vehicle_no,ve.vehicle_type,ve.vehicle_model,dut.vehicle_id,dut.comments,us.user_first_name,us.user_last_name,
 		dut.total_hrs,dut.extra_hrs,dut.total_kms,dut.extra_kms,dut.start_time,dut.end_time,dut.start_km,dut.end_km,dut.parking_fees,dut.toll_fess';
 		$where =  'bok.booking_id = '.$booking_id.' and bok.booking_id = dut.booking_id and dr.driver_id = dut.driver_id and 
 					bok.cust_id = cus.cust_id and dut.vehicle_id = ve.vehicle_id and bok.booked_by = us.user_id';

 		$data['dutyslipdetails'] = $this->Booking_model->getwheredata($select,$tableName,$where);
 		$duty_slip_id = $data['dutyslipdetails'][0]->duty_slip_id;
 		$filename = "DS-".$duty_slip_id;
 		//echo "<pre>";
 		//print_r($data['dutyslipdetails']);exit;
		$html = $this->load->view('dutySlipPdf', $data, true);
		
		$output = pdf_create($html, 'filename', array('Attachment' => 0));
		 file_put_contents('./assets/dutyslip/'.$filename.'.pdf', $output);
		//$path = "./assets/dutyslip/".$filename;
 	}
}
