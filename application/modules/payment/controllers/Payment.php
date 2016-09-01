<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('payment/payment_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function expenseMaster()
	{
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		error_reporting(1);

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
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


		$filter_param_to = array('driver','vendor');

		$filter_ledgers_to = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_to);
		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $filter_ledgers_to, array(
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

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');
		$data['from_select'] = $this->selectEnhanced_to->render("",'from_ledger','from_ledger','');		
		$this->load->view('paymentMaster',$data);
		$this->footer->index();
	}

	
	public function paymentMasterSubmit()
	{
		echo "test";exit;	
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
		 
		 //bdate conversion
		 if(isset($driver_dob) && !empty($driver_dob)){
		 	$driver_dob = $this->helper_model->dbDate($driver_dob);
		 }

		 // licence exp date conversion
		 if(isset($driver_licence_exp) && !empty($driver_licence_exp)){
		 	$driver_licence_exp = $this->helper_model->dbDate($driver_licence_exp);
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
				'driver_licno' => $driver_licence,
				'driver_licexpdate' => $driver_licence_exp,
				'driver_fix_pay' => $driver_fix_pay,
				'driver_da' => $driver_da_pay,
				'driver_na' => $driver_na_pay,
				'driver_panno' => $driver_pan,
				'is_da' => $driver_da,
				'is_night_allowance' => $driver_night,
				'isactive' => '1',
				'added_by' => '1',
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
		'entity_type' => 2,
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

 
}
