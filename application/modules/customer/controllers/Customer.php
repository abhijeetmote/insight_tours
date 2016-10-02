<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('customer/Customer_model');
		$this->load->model('helper/helper_model');
		$this->active = "customer";
	}

	

	public function customerMaster()
	{
		$select = 'package_id,package_name,travel_type';
		$tableName = 'package_master';
		$data['package'] = $this->helper_model->selectAll($select, $tableName);

		$this->header->index($this->active);
		$this->load->view('CustomerAdd', $data);
		$this->footer->index();
	}
	public function addcustomer(){		

		$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";
		$middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : "";
		$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : "";
		$compname = isset($_POST['company_name']) ? $_POST['company_name'] : "";
		$contact_person_name = isset($_POST['contact_person_name']) ? $_POST['contact_person_name'] : "";	
		$contact_person_desig = isset($_POST['contact_person_desig']) ? $_POST['contact_person_desig'] : "";
		$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : "";
		$alt_mobile = isset($_POST['alt_mobile']) ? $_POST['alt_mobile'] : "";
		$email = isset($_POST['email']) ? $_POST['email'] : "";
		$alt_email = isset($_POST['alt_email']) ? $_POST['alt_email'] : "";				
		$address = isset($_POST['address']) ? $_POST['address'] : "";		
		$state = isset($_POST['state']) ? $_POST['state'] : "";		
		$city = isset($_POST['city']) ? $_POST['city'] : "";		
		$pin = isset($_POST['pin']) ? $_POST['pin'] : "";		
		$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : "";		
		$password = isset($_POST['password']) ? $_POST['password'] : "";
		$localpackage = isset($_POST['localpackage']) ? $_POST['localpackage'] : "0";
		$outstationpackage = isset($_POST['outstationpackage']) ? $_POST['outstationpackage'] : "0";
		$cust_type_id=1;
		$data = array(
			'cust_type_id' => $cust_type_id,
			'cust_firstname' => $first_name,
			'cust_middlename' => $last_name,
			'cust_lastname' => $last_name,
			'cust_compname' => $compname,
			'contact_per_name' => $contact_person_name,
			'contact_per_desg' => $contact_person_desig,
			'cust_telno' => $phone,			
			'cust_mob1' => $mobile,
			'cust_mob2' => $alt_mobile,
			'cust_email1' => $email,
			'cust_email2' => $alt_email,
			'cust_address' => $address,
			'cust_state' => $state,
			'cust_city' => $city,
			'cust_pin' => $pin,			
			'cust_username' =>$user_name,
			'cust_password' => md5($password),
			'ledger_id'=>'8',
			'is_service_tax' =>'0',
			'local_package_id' =>$localpackage,
			'outstation_package_id' =>$outstationpackage,
			'isactive' =>'0',			
			'added_by' =>'1',
			'added_on' => date('Y-m-d h:i:s'),
			'updated_by' =>'1',
			'updated_on' => date('Y-m-d h:i:s')
		);
		//print_r($data);

 		$customer_table = 'customer_master';
 		$this->db->trans_begin();
 	 	//customer record insertion
 		$customer_id = $this->Customer_model->saveData($customer_table,$data);
 	
		 //diver data insertion end

	 	//Ledger data insertion start
	 	if(isset($customer_id) && !empty($customer_id)) {
			$select = "ledger_account_id ";
			$ledgertable ='ledger_master';
			$context = 'customer';
			$entity_type = 'group';
			$where =  array('context' =>  $context, 'entity_type' => $entity_type);
	 	 	$groupid = $this->Customer_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
	 	 	
	 	 	$parent_data = $groupid->ledger_account_id;
	 	 	$reporting_head ='REPORT_HEAD_INCOME';
	 	 	$nature_of_account ='DR';
	 	 	// ledger data preparation

	 	 	$leddata = array(
			'ledger_account_name' => $first_name."_".$customer_id,
			'parent_id' => $parent_data,	
			'report_head' => $reporting_head,
			'nature_of_account' => $nature_of_account,
			'context_ref_id' => $customer_id,
			'context' => $context,
			'ledger_start_date' => date('Y-m-d h:i:s'),
			'behaviour' => $reporting_head,
			'entity_type' => 3,
			'defined_by' => 1,
			'status' => '1',
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s'));
	 	 	//Insert Ledger data with Deriver Id
	 	 	$legertable = 'ledger_master';
	 	 	$ledger_id = $this->Customer_model->saveData($legertable,$leddata);

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
	 	$update_data =  array('ledger_id' => $ledger_id);
	 	$updat_column_Name = "cust_id";
	 	$update_value = $customer_id;
	 	$update_id = $this->Customer_model->updateData($customer_table,$update_data,$updat_column_Name,$update_value);
	 	//end


		if(isset($update_id) && !empty($update_id)){
			
			$this->db->trans_commit();
			$response['success'] = true;
			$response['error'] = false;
			$response['successMsg'] = "Customer Added Successfully";
			$response['redirect'] = base_url()."customer/customerList";

		}else{
			$this->db->trans_rollback();
	 		$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}
		echo json_encode($response);
	}


 	public function customerList(){
 		$customer_table = 'customer_master';
 		$filds = "cust_id,cust_firstname,cust_middlename,cust_lastname,cust_compname,cust_telno, cust_mob1,cust_email1,cust_address";
 		$data['list'] = $this->Customer_model->getCustomerList($filds,$customer_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index($this->active);
		$this->load->view('customerList', $data);
		$this->footer->index();
 	}

 public function customerDelete(){
        $customer_id = $_POST['id'];
        $customer_table ='customer_master';
        $resultMaster = $this->helper_model->delete($customer_table,'cust_id',$customer_id);
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
		$tableName = 'customer_master';
		$column = 'cust_id';
		$value = $id;
		$data['customer'] = $this->Customer_model->getData($select, $tableName, $column, $value);
		$select = 'package_id,package_name,travel_type';
		$tableName = 'package_master';
		$data['package'] = $this->helper_model->selectAll($select, $tableName);
		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('customerAdd', $data);
		$this->footer->index();
 	}

 	public function customerUpdate(){        

 		$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";
		$middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : "";
		$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : "";
		$compname = isset($_POST['company_name']) ? $_POST['company_name'] : "";
		$contact_person_name = isset($_POST['contact_person_name']) ? $_POST['contact_person_name'] : "";	
		$contact_person_desig = isset($_POST['contact_person_desig']) ? $_POST['contact_person_desig'] : "";
		$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : "";
		$alt_mobile = isset($_POST['alt_mobile']) ? $_POST['alt_mobile'] : "";
		$email = isset($_POST['email']) ? $_POST['email'] : "";
		$alt_email = isset($_POST['alt_email']) ? $_POST['alt_email'] : "";				
		$address = isset($_POST['address']) ? $_POST['address'] : "";		
		$state = isset($_POST['state']) ? $_POST['state'] : "";		
		$city = isset($_POST['city']) ? $_POST['city'] : "";		
		$pin = isset($_POST['pin']) ? $_POST['pin'] : "";		
		$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : "";		
		$password = isset($_POST['password']) ? $_POST['password'] : "";


		$customer_ledger_id = isset($_POST['ledger_id']) ? $_POST['ledger_id'] : "";
		$customer_id =isset($_POST['id']) ? $_POST['id'] : "";
		$localpackage = isset($_POST['localpackage']) ? $_POST['localpackage'] : "0";
		$outstationpackage = isset($_POST['outstationpackage']) ? $_POST['outstationpackage'] : "0";



		$select = '*';
		$tableName = 'customer_master';
		$column = 'cust_id';
		$value = $customer_id;
		$cus_data = $this->Customer_model->getData($select, $tableName, $column, $value);
		
		if($cus_data[0]->cust_password == $password) {
			$password = $password;
		} else {
			$password = md5($password);
		}

		 $customer_update = array(			
			'cust_firstname' => $first_name,
			'cust_middlename' => $last_name,
			'cust_lastname' => $last_name,
			'cust_compname' => $compname,
			'contact_per_name' => $contact_person_name,
			'contact_per_desg' => $contact_person_desig,
			'cust_telno' => $phone,			
			'cust_mob1' => $mobile,
			'cust_mob2' => $alt_mobile,
			'cust_email1' => $email,
			'cust_email2' => $alt_email,
			'cust_address' => $address,
			'cust_state' => $state,
			'cust_city' => $city,
			'cust_pin' => $pin,			
			'cust_username' =>$user_name,
			'cust_password' => $password,
			'ledger_id'=>$customer_ledger_id,
			'is_service_tax' =>'0',
			'local_package_id' =>$localpackage,
			'outstation_package_id' =>$outstationpackage,
			'isactive' =>'0',			
			'added_by' =>'1',
			'added_on' => date('Y-m-d h:i:s'),
			'updated_by' =>'1',
			'updated_on' => date('Y-m-d h:i:s')
		);
		      
		$this->db->trans_begin();
		$customer_table = 'customer_master';
		$customer_column = 'cust_id';
		$customer_id = $_POST['id'];

		$result = $this->Customer_model->updateData($customer_table, $customer_update, $customer_column, $customer_id);

		if(isset($result) && $result == true) {
			$ledgertable = 'ledger_master';
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $first_name."_".$customer_id,
			'status' => '1',
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->Customer_model->updateData($ledgertable, $ledger_update, $ledger_column, $customer_ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Customer Updated Successfully";
				$response['redirect'] = base_url()."customer/customerList";
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
