<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('vendor/Vendor_model');
		$this->load->model('helper/helper_model');
		$this->load->model('payment/payment_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		$this->active = "vendor";
	}

	

	public function vendorMaster()
	{
		$this->header->index($this->active);
		$this->load->view('VendorAdd');
		$this->footer->index();
	}
	public function addvendor()
	{	
		
		
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

		 $vendor_status = isset($_POST['vendor_status']) ? $_POST['vendor_status'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}

		 $data = array(
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
			'status' => $vendor_status,
			'added_by' => $user_id,
			'added_on' => date('Y-m-d h:i:s')
		);
 	$vendor_table =  VENDOR_TABLE;

 	$this->db->trans_begin();
 	 //driver record insertion
 	$vendor_id = $this->Vendor_model->saveData($vendor_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($vendor_id) && !empty($vendor_id)) {
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context = VENDOR_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context, 'entity_type' => $entity_type);
 	 	$groupid = $this->Vendor_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$parent_data = $groupid->ledger_account_id;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$direct = DIRECT;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $vendor_name."_".$vendor_id,
		'parent_id' => $parent_data,	
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $vendor_id,
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
 	 	$ledger_id = $this->Vendor_model->saveData($legertable,$leddata);

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

 	//Vndor update with ledger id start
 	$update_data =  array('vendor_ledger_id' => $ledger_id);
 	$updat_column_Name = "vendor_id";
 	$update_value = $vendor_id;
 	$update_id = $this->Vendor_model->updateData($vendor_table,$update_data,$updat_column_Name,$update_value);
 	//end


	if(isset($update_id) && !empty($update_id)){
		
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Vendor Added Successfully";
		$response['redirect'] = base_url()."vendor/vendorList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}


 	public function vendorList(){
 		$vendor_table =  VENDOR_TABLE;
 		$filds = "vendor_id,vendor_name,vendor_contact_number,vendor_phone_number,vendor_address,vendor_email,vendor_pan_num,vendor_payee_name";
 		$data['list'] = $this->Vendor_model->getVendorLit($filds,$vendor_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index($this->active);
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
		$this->header->index($this->active);
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

		 $vendor_status = isset($_POST['vendor_status']) ? $_POST['vendor_status'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
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
			'status' => $vendor_status,
			'updated_by' => $user_id,
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
				$response['redirect'] = base_url()."vendor/vendorList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}


 	public function vendorbillList(){
 		//SELECT b.*,cat_name,c.cust_type_id,c.cust_firstname,c.cust_lastname FROM booking_master b,customer_master c,vehicle_category v WHERE b.`cust_id` = c.cust_id and b.vehicle_type = v.cat_id
 		
	 	 $from_date = $this->uri->segment(3);
		 $to_date = $this->uri->segment(4);
		 $status = $this->uri->segment(5);
		 $vendor_id = $this->uri->segment(6);
		 
		 $where_extra = "";

		if(($from_date!="" && $to_date!="") && ($from_date!="0" && $to_date!="0"))   {
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$from_date = date("Y-m-d", strtotime($from_date));
			$to_date = date("Y-m-d", strtotime($to_date));
			$where_extra .= " and vb.booking_date between '$from_date' and '$to_date'";

		}
		if($vendor_id!="" && $vendor_id!="0") {
			$data['vendor_id'] = $vendor_id;
			$where_extra .= " and v.vendor_id = $vendor_id";
		}
		if($status!="" && $status!="0") {
			$data['status'] = $status;
			$where_extra .= " and vb.status = $status";
		}
		 
 		$tableName =  'vendor_bill_payment_details vb , vendors_master v ';
 		$select = 'vb.*,v.*,vb.status as pstatus';
 		$where =  'v.vendor_id = vb.vendor_id ';
 		$where .= $where_extra;
 		$data['vbill_list'] = $this->Vendor_model->getwheredata($select,$tableName,$where);
 		 //echo "<pre>";
 		// print_r($data['vbill_list']);
 		$vendor_table =  VENDOR_TABLE;
 		$filds = "vendor_id,vendor_name,vendor_contact_number,vendor_phone_number,vendor_address,vendor_email,vendor_pan_num,vendor_payee_name";
 		$data['list'] = $this->Vendor_model->getVendorLit($filds,$vendor_table); 
 
        $this->header->index($this->active);
		$this->load->view('vendorbillList', $data);
		$this->footer->index();
 	}


 	public function paybill($bill_id)
	{
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 
		
 		$vendor_table =  'vendor_bill_payment_details vb , vendors_master v ';
 		$select = 'vb.*,v.*';
 		$where =  'vb.vendor_id = v.vendor_id AND vb.vendor_bill_payment_id = '. $bill_id ;
 		$data['vendorbill'] = $this->Vendor_model->getwheredata($select,$vendor_table,$where);
 		$data['vendor_ledger_id'] = isset($data['vendorbill'][0]->vendor_ledger_id) ? $data['vendorbill'][0]->vendor_ledger_id : "";
 		$data['vendor_amount'] = isset($data['vendorbill'][0]->vendor_bill_payment_amount) ? $data['vendorbill'][0]->vendor_bill_payment_amount : "";
 		$data['bill_payment_id'] = isset($bill_id) ? $bill_id : "";

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


		$filter_param_to = array('vendor');

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
		$this->load->view('billPayment',$data);
		$this->footer->index();
	}

	
	public function billPayment()
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
		 $bill_payment_id = isset($_POST['bill_payment_id']) ? $_POST['bill_payment_id'] : "";
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


		 	 		 $vendor_bill_update = array(
						'status' => 2,
						'updated_on' => date('Y-m-d h:i:s')
					);
			     
					$vendor_bill_table = 'vendor_bill_payment_details';
					$vendor_bill_payment_id = 'vendor_bill_payment_id';
					$bill_payment_id = $bill_payment_id;

					$result = $this->Vendor_model->updateData($vendor_bill_table, $vendor_bill_update, $vendor_bill_payment_id, $bill_payment_id);
					if(isset($result) && !empty($result)) {
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					$response['redirect'] = base_url()."vendor/vendorbillList";
					} else {
					$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";	
					}
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
