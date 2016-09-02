<?php error_reporting(1); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('account/account_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function addAccount()
	{
		$this->header->index();
		
		
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context_cash = CASH_CONTEXT;
		$context_bank = BANK_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context_cash, 'entity_type' => $entity_type);
 	 	$groupid_cash = $this->account_model->getGroupId($select,$ledgertable,$context_cash,$entity_type,$where);

 	 	$cash_group = $groupid_cash->ledger_account_id;	
 	 	$where =  array('context' =>  $context_bank, 'entity_type' => $entity_type);
 	 	$groupid_bank = $this->account_model->getGroupId($select,$ledgertable,$context_bank,$entity_type,$where);
 	 	
 	 	$bank_group = $groupid_bank->ledger_account_id;	

 	 	$data['cash_group'] = $cash_group;
 	 	$data['bank_group'] = $bank_group;

		$this->load->view('addAccount',$data);

		$this->footer->index();
	}

	public function accountSubmit()
	{
		 $account_type = isset($_POST['account_type']) ? $_POST['account_type'] : "";
		 $account_name = isset($_POST['account_name']) ? $_POST['account_name'] : "";
		 $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : "";
		 $amount = isset($_POST['amount']) ? $_POST['amount'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $account_status = isset($_POST['account_status']) ? $_POST['account_status'] : "";
		 // ledger data preparation
	 	$select = " ledger_account_id,context";
		$ledgertable = LEDGER_TABLE ;
		$entity_type = GROUP_ENTITY;
		$where =  array('ledger_account_id' =>  $account_type, 'entity_type' => $entity_type);
 	 	$groupid = $this->account_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$context = $groupid->context;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$entity_type = ENTITY_TYPE_LEDGER;	
	 // account data insertion start
		 $data = array(
				'group_id' => $account_type,
				'account_name' => $account_name,
				'account_type' => $context,
				'account_no' => $account_no,
				'amount' => $amount,
				'comment' => $comment,
				'status' => $account_status,
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);
 	$account_table =  ACCOUNT_TABLE;

 	$this->db->trans_begin();
 	 //driver record insertion
 	$account_id = $this->account_model->saveData($account_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($account_id) && !empty($account_id)) {
		
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $account_name,
		'parent_id' => $account_type,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $account_id,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $reporting_head,
		'entity_type' => 3,
		'defined_by' => 2,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$ledger_id = $this->account_model->saveData($legertable,$leddata);

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
 	$updat_column_Name = "account_id";
 	$update_value = $account_id;
 	$update_id = $this->account_model->updateData($account_table,$update_data,$updat_column_Name,$update_value);
 	//end




 	// transaction data data insertion start
	 $trans_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $ledger_id,
				'ledger_account_name' => $account_name,
				'transaction_type' => $nature_of_account,
				'payment_reference' => $account_no,
				'transaction_amount' => $amount,
				'txn_from_id' => 0,
				'memo_desc' => 'Initial entry for account creation',
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;

 	 
 	 // transaction
 	$transaction_id = $this->account_model->saveData($transaction_table,$trans_data);
 	

	if(isset($update_id) && !empty($update_id) && isset($transaction_id) && !empty($transaction_id)){
		//$this->session->set_msg(array('status' => 'success','msg'=>'Driver '));
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Account Added Successfully";
		$response['redirect'] = base_url()."account/accountList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}




 	public function accountList(){

 		$driver_table =  ACCOUNT_TABLE;
 		$filds = "*";
 		$data['list'] = $this->account_model->getAccountLit($filds,$driver_table);

 		//echo "<pre>";print_r($data['list']);
        $this->header->index();
		$this->load->view('accountList', $data);
		$this->footer->index();
 	}

 	public function accountDelete(){

        $account_id = $_POST['id'];
        $account_table =  ACCOUNT_TABLE;



        $select = " ledger_id";
		
		$where =  array('account_id' =>  $account_id);
 	 	$groupid = $this->account_model->getGroupId($select,$account_table,'','',$where);
 	 	$ledger_id = $groupid->ledger_id;

 	 	$select = " * ";
		$transaction_table = TRANSACTION_TABLE ;
		 
		$where =  array('ledger_account_id' =>  $ledger_id );
 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);

 	 	foreach ($led_data as $led_data) {
	 		$trans_data = array(
		'ledger_account_name' => $account_name,
		'transaction_type' => $nature_of_account,
		'payment_reference' => $account_no,
		'updated_by' => 1,
		'updated_on' => date('Y-m-d h:i:s')
		);
	 		//$trans_data = 'ledger_account_id';
		$trans_column = "txn_id";
		$transaction_table =  TRANSACTION_TABLE;
		$trans_id = $led_data->txn_id;	

		$trans_result = $this->helper_model->delete($transaction_table,$trans_column,$trans_id);	
			


		}

		 
 	   	$ledgertable =  LEDGER_TABLE;
    	$resultMaster = $this->helper_model->delete($ledgertable,'ledger_account_id',$ledger_id);	
 	 
 	 	
 	 	$resultMaster = $this->helper_model->delete($account_table,'account_id',$account_id);	

    
		if(empty($resultMaster) || $resultMaster == false) {

			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
		
		} else {
			$response['success'] = true;
			$response['successMsg'] = "Deleted Successfully";	
		}
		
	 	echo json_encode($response);
 	}


 	public function update($id){        
        $select = '*';
		$tableName = ACCOUNT_TABLE;
		$column = 'account_id';
		$value = $id;
		$data['account'] = $this->account_model->getData($select, $tableName, $column, $value);

		$data['update'] = true;


		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context_cash = CASH_CONTEXT;
		$context_bank = BANK_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context_cash, 'entity_type' => $entity_type);
 	 	$groupid_cash = $this->account_model->getGroupId($select,$ledgertable,$context_cash,$entity_type,$where);

 	 	$cash_group = $groupid_cash->ledger_account_id;	
 	 	$where =  array('context' =>  $context_bank, 'entity_type' => $entity_type);
 	 	$groupid_bank = $this->account_model->getGroupId($select,$ledgertable,$context_bank,$entity_type,$where);
 	 	
 	 	$bank_group = $groupid_bank->ledger_account_id;	

 	 	$data['cash_group'] = $cash_group;
 	 	$data['bank_group'] = $bank_group;

		$this->header->index();
		$this->load->view('addAccount', $data);
		$this->footer->index();
 	}

 	public function accountUpdate(){        

 		$account_type = isset($_POST['account_type']) ? $_POST['account_type'] : "";
		 $account_name = isset($_POST['account_name']) ? $_POST['account_name'] : "";
		 $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : "";
		 $amount = isset($_POST['amount']) ? $_POST['amount'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $account_status = isset($_POST['account_status']) ? $_POST['account_status'] : "";
		 $ledger_id = isset($_POST['ledger_id']) ? $_POST['ledger_id'] : "";
		  // ledger data preparation
	 	$select = " ledger_account_id,context";
		$ledgertable = LEDGER_TABLE ;
		$entity_type = GROUP_ENTITY;
		$where =  array('ledger_account_id' =>  $account_type, 'entity_type' => $entity_type);
 	 	$groupid = $this->account_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$context = $groupid->context;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$entity_type = ENTITY_TYPE_LEDGER;	
	 // account data insertion start
		 $account_update = array(
				'group_id' => $account_type,
				'account_name' => $account_name,
				'account_type' => $context,
				'account_no' => $account_no,
				'amount' => $amount,
				'comment' => $comment,
				'status' => $account_status,
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);
 		$account_table =  ACCOUNT_TABLE;
    
		$this->db->trans_begin();
	 
		$account_column = 'account_id';
		$account_id = $_POST['id'];

		$result = $this->account_model->updateData($account_table, $account_update, $account_column, $account_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $account_name,
			'parent_id' => $account_type,
			'report_head' => $reporting_head,
			'context' => $context,
			'status' => $account_status,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->account_model->updateData($ledgertable, $ledger_update, $ledger_column, $ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{

				if(isset($ledger_id)) {
				$select = " * ";
				$transaction_table = TRANSACTION_TABLE ;
				 
				$where =  array('ledger_account_id' =>  $ledger_id );
		 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);

		 	 	foreach ($led_data as $led_data) {
	 	 		$trans_data = array(
				'ledger_account_name' => $account_name,
				'transaction_type' => $nature_of_account,
				'payment_reference' => $account_no,
				'updated_by' => 1,
				'updated_on' => date('Y-m-d h:i:s')
				);
	 	 		//$trans_data = 'ledger_account_id';
	 	 		$trans_column = "txn_id";
 				$transaction_table =  TRANSACTION_TABLE;
 				$trans_id = $led_data->txn_id;	
 				$trans_result = $this->account_model->updateData($transaction_table, $trans_data, $trans_column, $trans_id);
 				if(empty($trans_result) || $trans_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

				}
		 	 	}


		 	 	}

				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Vendor Updated Successfully";
				$response['redirect'] = base_url()."account/accountList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}



 	public function addAmount()
	{
		
		$this->header->index();
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
		$this->load->view('addAmount',$data);
		$this->footer->index();
	}



	public function addAmountSubmit()
	{
		 
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->account_model->getwheresingle($select,$ledgertable,$where);
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

 	 
 	 //From transaction
 	$from_transaction_id = $this->account_model->saveData($transaction_table,$from_data);
 	if(isset($from_transaction_id) && !empty($from_transaction_id)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					$response['redirect'] = base_url()."account/ledgerList";
					//$response['redirect'] = base_url()."driver/driverList";
	 }else {
 		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
 	}
 	 
	echo json_encode($response);
 	}



	public function ledgerList()
	{
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		//error_reporting(1);

		$ledger_data = $this->account_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ledger_data = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		//echo "<pre>";
		$data['ledgers'] = $ledger_data[0];
		$this->load->view('ledgerList',$data);
		$this->footer->index();
	}

	
	 
 
}
