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
		$this->active = "payment";
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function expenseMaster()
	{
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 

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
		$this->load->view('expenseMaster',$data);
		$this->footer->index();
	}

	
	public function expenseMasterSubmit()
	{
		//$this->header->index($this->active);
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;

 	$this->db->trans_begin();
 	 //From transaction
 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
 

 	//to leadger trans data insertion start
 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
		 

			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
		 	 	} else {
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

 	 
	 
	echo json_encode($response);
 	}

 	
 	public function journalEntry()
	{
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		//$filter_param_from = array('bank','cash');
		
		//$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $ret_arr[0], array(
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


		//$filter_param_to = array('driver','vendor');

		//$filter_ledgers_to = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_to);
		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $ret_arr[0], array(
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
		$this->load->view('journalVoucher',$data);
		$this->footer->index();
	}

	
	public function journalentrySubmit()
	{
		//$this->header->index($this->active);
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;

 	$this->db->trans_begin();
 	 //From transaction
 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
 

 	//to leadger trans data insertion start
 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
		 

			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
		 	 	} else {
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

 	 
	 
	echo json_encode($response);
 	}


public function advancesalaryMaster()
	{
		
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 

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


		$filter_param_to = array('driver');

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


		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		$this->load->view('advanceSalary',$data);
		$this->footer->index();
	}

	
	public function advancesalaryMasterSubmit()
	{
		//$this->header->index($this->active);
		//echo "<pre>";
		//print_r($_POST);
		//echo "test";
		error_reporting(E_ALL);
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $to_ledger = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $payment_mode = isset($_POST['payment_mode']) ? $_POST['payment_mode'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $salary_year = isset($_POST['adv_salary_year']) ? $_POST['adv_salary_year'] : date('Y');
		 $salary_month = isset($_POST['adv_salary_month']) ? $_POST['adv_salary_month'] : date('m');
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);

		 // advance salary data data prepare
		 $advance_sal_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'salary_year' => $salary_year,
				'salary_month' => $salary_month,
				'transaction_amount' => $payment_amount,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;
 	$advance_salary =  ADVANCE_SALARY;

 	$this->db->trans_begin();
 	 //From transaction
 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
 	$advance_salary_id = $this->payment_model->saveData($advance_salary,$advance_sal_data);
 

 	//to leadger trans data insertion start
 	if(isset($from_transaction_id) && !empty($from_transaction_id) && !empty($advance_salary_id)) {
		 

			 	$select = " * ";
				$ledgertable = LEDGER_TABLE ;

			 	$where =  "ledger_account_id = '$to_ledger'";
				$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
				
			 	$to_ledger_name = $ledger_details->ledger_account_name;
			 	 
				  
			 	// transaction data data insertion start
				 $to_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'ledger_account_name' => $to_ledger_name,
						'transaction_type' => $cr,
						'payment_reference' => $referance_no,
						'transaction_amount' => $payment_amount,
						'txn_from_id' => $from_transaction_id,
						'memo_desc' => $narration,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				$transaction_table =  TRANSACTION_TABLE;

				 //From transaction
				$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


		 	 	if(isset($to_transaction) && !empty($to_transaction)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Advance salary transaction made SuccsessFully !!!";
					//$response['redirect'] = base_url()."driver/driverList";
		 	 	} else {
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

 	 
	 
	echo json_encode($response);
 	}

 	public function driverSal(){
 		$this->header->index();
		$grp_table = LEDGER_TABLE;
		 

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


		

		
		$data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');


		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);

		if($this->uri->segment(3) != "" && $this->uri->segment(4) != ""){
			$salary_month = $this->uri->segment(3);
 			$salary_year = $this->uri->segment(4);

 			$data['salary_month'] = $salary_month;
 			$data['salary_year'] = $salary_year;

 			$driver_table =  DRIVER_TABLE;
	 		$filds = "driver_id,driver_fname,driver_mname,driver_lname,driver_add,driver_photo,driver_bdate,driver_mobno,driver_mobno1,driver_licno,driver_licexpdate,driver_panno,is_da,is_night_allowance,ledger_id,driver_fix_pay,driver_da,driver_na";
	 		$driverlist = $this->payment_model->getDriverLit($filds,$driver_table);

			//echo json_encode($driverlist);exit();

	 		$tableName = "company_holidays";
	 		$select = "count(*) as cnt";
	 		$where = "month = '$salary_month' and year = '$salary_year'";
	 		$holidays = $this->payment_model->getwheredata($select,$tableName,$where);

	 		//echo json_encode($driverlist);exit();
			
			$driverAttnData = array();
			for ($i=0; $i < count($driverlist); $i++) { 
				$driverAttnData[$i]['name'] = $driverlist[$i]->driver_fname." ".$driverlist[$i]->driver_lname;
				$driverId = $driverlist[$i]->driver_id;
				$ledgerId = $driverlist[$i]->ledger_id;
				//echo json_encode($driverAttnData);exit();
				if(!empty($holidays)){
					$driverAttnData[$i]['holidays'] = $holidays[0]->cnt;
				}else{
					$driverAttnData[$i]['holidays'] = 0;
				}
				$$driverPerDayDA = 0;

				$driverPerDayNA = 0;
				$driver_fix_pay = $driverlist[$i]->driver_fix_pay;
				$tableName =  'driver_salary_paid';
		 		$select = '*';
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$ledgerId'";
				$driverSalPaid = $this->payment_model->getwheredata($select,$tableName,$where);

				$tableName =  "driver_attendance";
		 		$select = 'count(*) as cnt';
		 		$where = "month = '$salary_month' and year = '$salary_year' and driver_id = '$driverId'";
				$driverAttn = $this->payment_model->getwheredata($select,$tableName,$where);
				$driverAttnData[$i]['Attn'] = $driverAttn[0]->cnt;

				$tableName =  ADVANCE_SALARY;
		 		$select = 'transaction_amount';
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$ledgerId'";
				$driverAdvPaid = $this->payment_model->getwheredata($select,$tableName,$where);
				//echo json_encode($ledger_id);exit();
				if(!empty($driverAdvPaid)){
					$advSal = $driverAdvPaid[0]->transaction_amount;
				}else{
					$advSal = 0;
				}

				if($driverlist[$i]->is_da == 1)
				{
					$driverPerDayDA = $driver_da/30;
				}

				if($driverlist[$i]->is_night_allowance == 1)
				{
					$driverPerDayNA = $driver_na/30;
				}
				
				$driverPerDaySal = $driver_fix_pay/30;

				$workingDay = $driverAttn[0]->cnt + $holidays[0]->cnt;

				$workingDaysSal = $workingDay * $driverPerDaySal;
				$workingDaysSal += $workingDay * $driverPerDayDA;
				$workingDaysSal += $workingDay * $driverPerDayNA;

				if($driverAttn[0]->cnt > 0){
					$driverAttnData[$i]['totalSal'] = $workingDaysSal - $advSal;
				}else{
					$driverAttnData[$i]['totalSal'] = 0;
				}

				$driverAttnData[$i]['ledgerId'] = $ledgerId;

				$driverAttnData[$i]['advSal'] = $advSal;
				if(empty($driverSalPaid)){	
					$driverAttnData[$i]['paidStatus'] = "unpaid";
				}else{
					$driverAttnData[$i]['paidStatus'] = "paid";
				}
			}
			$data['driverAttnData'] = $driverAttnData;
		}

		/*echo "<pre>";
		print_r($data);
		exit();*/
		$this->load->view('driverSalary',$data);
		$this->footer->index();
 	}

 	

 	public function salPaid()
 	{
 		$driverList = $_POST['data'];
 		$salary_month = $_POST['salary_month'];
 		$salary_year = $_POST['salary_year'];
 		$from_ledger = $_POST['from_ledger'];

 		for ($i= 0; $i < count($driverList); $i++) { 
 			//echo json_encode($val[0]['sal']);exit();
 			if($driverList[0]['sal'] > 0)
	 		{	
	 			$to_ledger = $driverList[0]['ledgerId'];
	 			$sal = $driverList[0]['sal'];
	 			$tableName = "driver_salary_paid";
		 		$select = "count(*) as cnt";
		 		$where = "salary_month = '$salary_month' and salary_year = '$salary_year' and ledger_account_id = '$to_ledger'";
		 		$alreadyPaid = $this->payment_model->getwheredata($select,$tableName,$where);
		 		//echo json_encode($alreadyPaid);exit();
		 		if($alreadyPaid[0]->cnt == 0){
		 			$from_data = array(
						'transaction_date' => date('Y-m-d h:i:s'),
						'ledger_account_id' => $to_ledger,
						'transaction_amount' => $sal,
						'memo_desc' => 'Salary Paid',
						'salary_month' => $salary_month,
						'salary_year' => $salary_year,
						'added_by' => 1,
						'added_on' => date('Y-m-d h:i:s')
					);
				 	$tableName =  "driver_salary_paid";

				 	$this->db->trans_begin();

				 	$driverPaid = $this->payment_model->saveData($tableName,$from_data);

				 	if($driverPaid != false){
				 		$cr = CR;
				 		$dr = DR;
				 		$select = "*";
						$ledgertable = LEDGER_TABLE ;
						//echo "aa";
				 	 	$where =  "ledger_account_id = '$from_ledger'";
				 		$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);

				 		$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
				 		// transaction data data insertion start
					 	$from_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $from_ledger,
							'ledger_account_name' => $from_ledger_name,
							'transaction_type' => $cr,
							'payment_reference' => "",
							'transaction_amount' => $sal,
							'txn_from_id' => 0,
							'memo_desc' => SALARY_PAID_NARRATION,
							'added_by' => 1,
							'added_on' => date('Y-m-d h:i:s')
						);
						$transaction_table =  TRANSACTION_TABLE;

						//From transaction
					 	$from_transaction_id = $this->payment_model->saveData($transaction_table,$from_data);
					 

					 	//to leadger trans data insertion start
					 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
							$select = " * ";
							$ledgertable = LEDGER_TABLE ;

						 	$where =  "ledger_account_id = '$to_ledger'";
							$ledger_details = $this->payment_model->getwheresingle($select,$ledgertable,$where);
							
						 	$to_ledger_name = $ledger_details->ledger_account_name;
						 	 
							  
						 	// transaction data data insertion start
							 $to_data = array(
									'transaction_date' => date('Y-m-d h:i:s'),
									'ledger_account_id' => $to_ledger,
									'ledger_account_name' => $to_ledger_name,
									'transaction_type' => $dr,
									'payment_reference' => "",
									'transaction_amount' => $sal,
									'txn_from_id' => $from_transaction_id,
									'memo_desc' => SALARY_PAID_NARRATION,
									'added_by' => 1,
									'added_on' => date('Y-m-d h:i:s')
								);
							$transaction_table =  TRANSACTION_TABLE;

							 //From transaction
							$to_transaction = $this->payment_model->saveData($transaction_table,$to_data);


					 	 	if(isset($to_transaction) && !empty($to_transaction)){
					 	 		$this->db->trans_commit();
					 	 		$response['error'] = false;
						 		$response['success'] = true;
								$response['successMsg'] = "Paid SuccsessFully";
								$response['redirect'] = base_url()."payment/driverSal";
					 	 	} else {
						 		$this->db->trans_rollback();
					 		}

					 	} else {
					 		$this->db->trans_rollback();
					 		$response['error'] = true;
					 		$response['success'] = false;
							$response['errorMsg'] = "Error!!! Please contact IT Dept";
					 	}
				 	}
		 		} else {

		 				//$this->db->trans_commit();
			 	 		$response['error'] = false;
				 		$response['success'] = true;
						$response['successMsg'] = "salary allready paid";
						$response['redirect'] = base_url()."payment/driverSal";
		 		}
		 	}
 		}



 		echo json_encode($response);
 	}

}
