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
		//$this->header->index();
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
		$this->header->index();
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
		//$this->header->index();
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


}
