<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('driver/driver_model');
		$this->load->model('helper/helper_model');
		$this->active = "driver";
		//$this->load->library('session');
		
	}

	public function driverMaster()
	{
		$this->header->index($this->active);
		$this->load->view('driverMaster');
		$this->footer->index();
	}

	public function driverMasterSubmit()
	{
		
		 $driver_fname = isset($_POST['driver_fname']) ? $_POST['driver_fname'] : "";
		 $driver_mname = isset($_POST['driver_mname']) ? $_POST['driver_mname'] : "";
		 $driver_lname = isset($_POST['driver_lname']) ? $_POST['driver_lname'] : "";
		 $driver_dob = isset($_POST['driver_dob']) ? $_POST['driver_dob'] : "";
		 $driver_address = isset($_POST['driver_address']) ? trim($_POST['driver_address']) : "";
		 $driver_mobile = isset($_POST['driver_mobile']) ? $_POST['driver_mobile'] : "";
		 $driver_mobile1 = isset($_POST['driver_mobile1']) ? $_POST['driver_mobile1'] : "";
		 $driver_licence = isset($_POST['driver_licence']) ? $_POST['driver_licence'] : "";
		 $driver_licence_exp = isset($_POST['licence_exp']) ? $_POST['licence_exp'] : "";
		 $driver_pan = isset($_POST['driver_pan']) ? $_POST['driver_pan'] : "";
		 $driver_fix_pay = isset($_POST['driver_fix_pay']) ? $_POST['driver_fix_pay'] : "";
		 $driver_da_pay = isset($_POST['driver_da']) ? $_POST['driver_da'] : "";
		 $driver_na_pay = isset($_POST['driver_na']) ? $_POST['driver_na'] : "";
		 $driver_da = isset($_POST['da']) ? 2 : 1;
		 $driver_night = isset($_POST['night']) ? 2 : 1;
		 $driver_status = isset($_POST['driver_status']) ? $_POST['driver_status'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		 //bdate conversion
		 if(isset($driver_dob) && !empty($driver_dob)){
		 	$driver_dob = $this->helper_model->dbDate($driver_dob);
		 }

		 // licence exp date conversion
		 if(isset($driver_licence_exp) && !empty($driver_licence_exp)){
		 	$driver_licence_exp = $this->helper_model->dbDate($driver_licence_exp);
		 }

		$driver_photo = "";
		for ($i=1; $i <= count($_FILES); $i++) { 
			if($_FILES['driverImage']['error'] == 0){
				$imageName = rand(0,555555555).$_FILES['driverImage']["name"]; 
				$imageSize = $_FILES['driverImage']["size"]; 
				$imagetmp = $_FILES['driverImage']['tmp_name'];
				$path = "./assets/drivers/".$imageName;
				$imageResult = move_uploaded_file($imagetmp, $path);
				if($imageResult == true){
					$driver_photo = $imageName;
				}
			}
		}
		 
	 // driver data insertion start
		 $data = array(
				'driver_fname' => $driver_fname,
				'driver_mname' => $driver_mname,
				'driver_lname' => $driver_lname,
				'driver_bdate' => $driver_dob,
				'driver_mobno' => $driver_mobile,
				'driver_mobno1' => $driver_mobile1,
				'driver_add' => $driver_address,
				'driver_photo' => $driver_photo,
				'driver_licno' => $driver_licence,
				'driver_licexpdate' => $driver_licence_exp,
				'driver_fix_pay' => $driver_fix_pay,
				'driver_da' => $driver_da_pay,
				'driver_na' => $driver_na_pay,
				'driver_panno' => $driver_pan,
				'is_da' => $driver_da,
				'is_night_allowance' => $driver_night,
				'isactive' => $driver_status,
				'added_by' => $user_id,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$driver_table =  DRIVER_TABLE;

 	$this->db->trans_begin();
 	 //driver record insertion
 	$driver_id = $this->driver_model->saveData($driver_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($driver_id) && !empty($driver_id)) {
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context = DRIVER_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context, 'entity_type' => $entity_type);
 	 	$groupid = $this->driver_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$parent_data = $groupid->ledger_account_id;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$direct = DIRECT;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $driver_fname."_".$driver_id,
		'parent_id' => $parent_data,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $driver_id,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $reporting_head,
		'operating_type' => $direct,
		'entity_type' => 3,
		'defined_by' => 1,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$ledger_id = $this->driver_model->saveData($legertable,$leddata);

 	 	if(!isset($ledger_id) || empty($ledger_id)){
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

 	//driver update with ledger id start
 	$update_data =  array('ledger_id' => $ledger_id);
 	$updat_column_Name = "driver_id";
 	$update_value = $driver_id;
 	$update_id = $this->driver_model->updateData($driver_table,$update_data,$updat_column_Name,$update_value);
 	//end


	if(isset($update_id) && !empty($update_id)){
		//$this->session->set_msg(array('status' => 'success','msg'=>'Driver '));
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Driver Added Successfully";
		$response['redirect'] = base_url()."driver/driverList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}

 	public function driverList(){
 		$driver_table =  DRIVER_TABLE;
 		$filds = "driver_id,driver_fname,driver_mname,driver_lname,driver_add,driver_photo,driver_bdate,driver_mobno,driver_mobno1,driver_licno,driver_licexpdate,driver_panno,is_da,is_night_allowance,ledger_id";
 		$data['list'] = $this->driver_model->getDriverLit($filds,$driver_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index($this->active);
		$this->load->view('driverList', $data);
		$this->footer->index();
 	}

 	public function driverDelete(){
        $driver_id = $_POST['id'];
        $driver_table =  DRIVER_TABLE;
        $resultMaster = $this->helper_model->delete($driver_table,'driver_id',$driver_id);
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
		$tableName = DRIVER_TABLE;
		$column = 'driver_id';
		$value = $id;
		$data['driver'] = $this->driver_model->getData($select, $tableName, $column, $value);
		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('driverMaster', $data);
		$this->footer->index();
 	}

 	public function driverUpdate(){        

 		$driver_photo_old = "";
 		$driver_fname = isset($_POST['driver_fname']) ? $_POST['driver_fname'] : "";
		 $driver_mname = isset($_POST['driver_mname']) ? $_POST['driver_mname'] : "";
		 $driver_lname = isset($_POST['driver_lname']) ? $_POST['driver_lname'] : "";
		 $driver_dob = isset($_POST['driver_dob']) ? $_POST['driver_dob'] : "";
		 $driver_address = isset($_POST['driver_address']) ? trim($_POST['driver_address']) : "";
		 $driver_mobile = isset($_POST['driver_mobile']) ? $_POST['driver_mobile'] : "";
		 $driver_mobile1 = isset($_POST['driver_mobile1']) ? $_POST['driver_mobile1'] : "";
		 $driver_licence = isset($_POST['driver_licence']) ? $_POST['driver_licence'] : "";
		 $driver_licence_exp = isset($_POST['licence_exp']) ? $_POST['licence_exp'] : "";
		 $driver_pan = isset($_POST['driver_pan']) ? $_POST['driver_pan'] : "";
		 $driver_fix_pay = isset($_POST['driver_fix_pay']) ? $_POST['driver_fix_pay'] : "";
		 $driver_da_pay = isset($_POST['driver_da']) ? $_POST['driver_da'] : "";
		 $driver_na_pay = isset($_POST['driver_na']) ? $_POST['driver_na'] : "";
		 $driver_da = isset($_POST['da']) ? 2 : 1;
		 $driver_night = isset($_POST['night']) ? 2 : 1;
		 $ledger_id = isset($_POST['ledger_id']) ? $_POST['ledger_id'] : "";
		 $driver_status = isset($_POST['driver_status']) ? $_POST['driver_status'] : "0";
		 $driver_photo_old = isset($_POST['driver_image']) ? $_POST['driver_image'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		 //bdate conversion
		 if(isset($driver_dob) && !empty($driver_dob)){
		 	$driver_dob = $this->helper_model->dbDate($driver_dob);
		 }

		 // licence exp date conversion
		 if(isset($driver_licence_exp) && !empty($driver_licence_exp)){
		 	$driver_licence_exp = $this->helper_model->dbDate($driver_licence_exp);
		 }

		$driver_photo = "";
		for ($i=1; $i <= count($_FILES); $i++) { 
			if($_FILES['driverImage']['error'] == 0){
				$imageName = rand(0,555555555).$_FILES['driverImage']["name"]; 
				$imageSize = $_FILES['driverImage']["size"]; 
				$imagetmp = $_FILES['driverImage']['tmp_name'];
				$path = "./assets/drivers/".$imageName;
				$imageResult = move_uploaded_file($imagetmp, $path);
				if($imageResult == true){
					$driver_photo = $imageName;
				}
			}
		}
		 
		if(!isset($driver_photo) || empty($driver_photo)) {
			$driver_photo = $driver_photo_old;
		} 
	 // driver data insertion start
		 $driver_update = array(
				'driver_fname' => $driver_fname,
				'driver_mname' => $driver_mname,
				'driver_lname' => $driver_lname,
				'driver_bdate' => $driver_dob,
				'driver_mobno' => $driver_mobile,
				'driver_mobno1' => $driver_mobile1,
				'driver_add' => $driver_address,
				'driver_photo' => $driver_photo,
				'driver_licno' => $driver_licence,
				'driver_licexpdate' => $driver_licence_exp,
				'driver_panno' => $driver_pan,
				'driver_fix_pay' => $driver_fix_pay,
				'driver_da' => $driver_da_pay,
				'driver_na' => $driver_na_pay,
				'is_da' => $driver_da,
				'is_night_allowance' => $driver_night,
				'isactive' => $driver_status,
				'updated_by' => $user_id,
				'updated_on' => date('Y-m-d h:i:s')
				
			);

    
		$this->db->trans_begin();
		$driver_table = DRIVER_TABLE;
		$driver_column = 'driver_id';
		$driver_id = $_POST['id'];

		$result = $this->driver_model->updateData($driver_table, $driver_update, $driver_column, $driver_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $driver_fname."_".$driver_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->driver_model->updateData($ledgertable, $ledger_update, $ledger_column, $ledger_id);

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
				$response['redirect'] = base_url()."driver/driverList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}

 	public function driverAttend(){

 		$date = date('Y-m-d');
        $data['driverdetails'] = $this->helper_model->selectQuery("SELECT driver_id,driver_fname,driver_lname FROM driver_master where driver_id not in (select driver_id from driver_attendance where DATE_FORMAT(user_check_in, '%Y-%m-%d') = '$date')");
        //echo "<pre>"; print_r($data);exit();
        $this->header->index($this->active);
        $this->load->view('driverAttend',$data);
		$this->footer->index();
 	}

 	public function driverAttnSubmit(){
        $driver_id = $_POST['driver_name'];
        $date = $_POST['driver_in_dt'];

		$d = date_parse_from_format("Y-m-d", $date);

		if($d['month'] < 10){
	       	$month = "0".$d['month'];
	       }else{
	       	$month = $d['month'];
	       }
		$data = array(
		'driver_id' => $driver_id,
		'user_check_in' => $date,
		'month' => $month,
		'year' => $d['year'],
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s')
		);
 		$tableName =  DRIVER_ATTENDANCE_TABLE;
		$result = $this->driver_model->saveData($tableName, $data);
		if($result != false){
			$response['success'] = true;
 	 		$response['error'] = false;
 	 		$response['successMsg'] = "Submit Successfully";
		}else{
			$response['error'] = true;
 	 		$response['success'] = false;
			$response['Msg'] = "Error!!! Please contact IT Dept";
		}
		echo json_encode($response);
 	}

 	public function driverAttendReport(){
 		$driver_table =  DRIVER_TABLE;
 		$filds = "driver_id,driver_fname,driver_lname";
 		$data['driver'] = $this->driver_model->getDriverLit($filds,$driver_table);
		//echo "<pre>"; print_r($data);exit();
		$this->header->index($this->active);
		$this->load->view('driverAttnReport', $data);
		$this->footer->index();
 	}

 	public function attnReport(){
 		$from_date = date('Y-m-d', strtotime($_POST['from_date']));
 		$to_date = date('Y-m-d', strtotime($_POST['to_date']));
 		$driver_id = $_POST['driver'];
 		$driver = $this->helper_model->selectQuery("SELECT driver_id,user_check_in,DATE_FORMAT(user_check_in, '%Y-%m-%d') as date from driver_attendance where user_check_in >= '$from_date' and user_check_in <= '$to_date' and driver_id = '$driver_id'");

 		$tableName =  "company_holidays";
 		$select = "*";
 		$where = "holiday_date >= '$from_date' and holiday_date <= '$to_date'";
 		$holidays = $this->driver_model->getwheredata($select,$tableName,$where);
		$dateDiff = date_diff(date_create($to_date), date_create($from_date));

		$driverCnt = count($driver);
		$holidayCnt = count($holidays);
		$leaves = $driverCnt - $dateDiff->days;

		$holidayArray = array();
		foreach ($holidays as $key => $value) {
			$holidayArray[$key] = $value->holiday_date;
		}

		$driverArray = array();
		foreach ($driver as $key => $value) {
			$driverArray[$key] = $value['date'];
		}

		$data = "";
		for ($i=0; $i < $dateDiff->days; $i++) { 
			$j = 0;
			$key = array_search($from_date, $holidayArray);
			if($key !== false){
				
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Holiday</td>
					</tr>';
				$j++;
			}

			$key = array_search($from_date, $driverArray);
			if($key !== false){
				
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Present at '.$driver[$key]['user_check_in'].'</td>
					</tr>';
				$j++;
			}
			if($j == 0){
				$data .= '<tr>
						<td>'.$from_date.'</td>
						<td>Leave</td>
					</tr>';
			}
			$from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
		}
		$response['response'] = $data;
		$response['driver'] = $holidays;
		echo json_encode($response);
 	}

 	public function driverbillList(){
 		//SELECT b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname FROM booking_master b,customer_master c,vehicle_category v WHERE b.`cust_id` = c.cust_id and b.vehicle_type = v.cat_id
 		
	 	 $from_date = $this->uri->segment(3);
		 $to_date = $this->uri->segment(4);
		 //$status = $this->uri->segment(5);
		 $driver_id = $this->uri->segment(5);
		 
		 $where_extra = "";

		if(($from_date!="" && $to_date!="") && ($from_date!="0" && $to_date!="0"))   {
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$from_date = date("Y-m-d", strtotime($from_date));
			$to_date = date("Y-m-d", strtotime($to_date));
			$where_extra .= " and transaction_date between '$from_date' and '$to_date'";

		}
		if($driver_id!="" && $driver_id!="0") {
			$data['driver_id'] = $driver_id;
			$where_extra .= " and driver_id = $driver_id";
		}
		/*if($status!="" && $status!="0") {
			$data['status'] = $status;
			$where_extra .= " and vb.status = $status";
		}*/
		 
 		$tableName =  'advance_salary ad, driver_master d';
 		$select = 'd.*,ad.*';
 		$where =  'd.ledger_id = ad.ledger_account_id ';
 		$where .= $where_extra;
 		$data['driversal_list'] = $this->driver_model->getwheredata($select,$tableName,$where);
 		 //echo "<pre>";
 		// print_r($data['vbill_list']);

 		$driver_table =  DRIVER_TABLE;
 		$filds = "driver_id,driver_fname,driver_mname,driver_lname,driver_add,driver_photo,driver_bdate,driver_mobno,driver_mobno1,driver_licno,driver_licexpdate,driver_panno,is_da,is_night_allowance,ledger_id";
 		$data['list'] = $this->driver_model->getDriverLit($filds,$driver_table);

        $this->header->index($this->active);
		$this->load->view('driver_adv_sal_list', $data);
		$this->footer->index();
 	}
}
