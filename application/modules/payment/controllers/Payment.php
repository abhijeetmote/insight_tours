<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('payment/payment_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function paymentMaster()
	{
		$this->header->index();
		$grp_table = LEDGER_TABLE;
		error_reporting(0);
		$ledger_data = $this->payment_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		//print_r($ret_arr[0]);
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

		$data['select'] = $this->selectEnhanced->render("",'from_ledger','from_ledger','chosen-select form-control');
		
		$this->load->view('paymentMaster',$data);
		$this->footer->index();
	}

	private function _getLedGrpListRecur($led_grp_objects, $master_array = array(), $parent_id = 0, $array_id = array(), $entity_type = '')
    {
    	foreach ($led_grp_objects as $led_grp_items) {
            $children = "";
            $children = $this->_getGrpChildren($led_grp_items["ledger_account_id"], $entity_type);


            if (!in_array($led_grp_items["ledger_account_id"], $array_id)) {
                $master_array[$led_grp_items["ledger_account_id"]]["name"] = $led_grp_items["ledger_account_name"];
                $master_array[$led_grp_items["ledger_account_id"]]["nature"] = $led_grp_items["nature_of_account"];
                $master_array[$led_grp_items["ledger_account_id"]]["behaviour"] = $led_grp_items["behaviour"];
                $master_array[$led_grp_items["ledger_account_id"]]["entity_type"] = $led_grp_items["entity_type"];
                $master_array[$led_grp_items["ledger_account_id"]]["ledger_account_id"] = $led_grp_items["ledger_account_id"];
                $master_array[$led_grp_items["ledger_account_id"]]["parent"] = $led_grp_items["parent_id"];
                $master_array[$led_grp_items["ledger_account_id"]]["status"] = $led_grp_items["status"];
                $master_array[$led_grp_items["ledger_account_id"]]["context"] = preg_replace('/[0-9]+/', '', $led_grp_items["context"]);
                $master_array[$led_grp_items["ledger_account_id"]]["is_parent"] = "no";
                //$master_array[$led_grp_items["ledger_account_id"]]["operating_type"] = $led_grp_items["operating_type"];
                
                array_push($array_id, $led_grp_items["ledger_account_id"]);
                
            }

            if (!empty($children)) {
            	$final_array = $this->_getLedGrpListRecur($children, $master_array[$parent_id], $led_grp_items["ledger_account_id"], $array_id, $entity_type);
                if (is_array($final_array[0]) && !empty($final_array[0])) {
                    $master_array[$led_grp_items["ledger_account_id"]]["children"] = $final_array[0];
                    $master_array[$led_grp_items["ledger_account_id"]]["is_parent"] = "yes";
                }

                $array_id = $final_array[1];

            }
            
        }
        return array($master_array, $array_id);
    }

    /**
     * The Component action `_getGrpChildren` is called to get children of a group
     * @method _getGrpChildren.
     * @access public
     * @param integer $group id of group of which children to be fetched
     * @param sting $entity_type
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct() 
     * @return string
     */
    private function _getGrpChildren($group, $entity_type = '')
    {
        $children = "";
        //$soc_id = $this->session->get("auth")["soc_id"];
        
        $conditions = "parent_id";
        $bind       = $group;
        
        if ($entity_type == ENTITY_TYPE_LEDGER) {
            
        } else if ($entity_type == ACC_TYPE_BANK || $entity_type == ACC_TYPE_CASH) {
            
            $conditions .= " AND (behaviour = ?3  ";
            $bind[3] = "asset";
            
            
            $conditions .= " OR behaviour = ?4)  ";
            $bind[4] = "liability";
            
            
            $conditions .= " AND (TRIM(LOWER(entity_type)) != ?5) ";
            $bind[5] = trim(strtolower(ENTITY_TYPE_LEDGER));
            
        } else if ($entity_type == ENTITY_TYPE_GROUP) {
            
            $conditions .= " AND (TRIM(LOWER(entity_type)) != ?3) ";
            $bind[3] = trim(strtolower(ENTITY_TYPE_LEDGER));
        }
        $grp_table = LEDGER_TABLE;
        //print_r($conditions);
       // print_r($bind);
        $where =  array($conditions => $bind);
        //$children = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind, "order" => "ledger_account_name ASC"))->toArray();
         $children = $this->payment_model->getDataWhereOrder('*',$grp_table,$where,'ledger_account_name','asc');
        if (count($children) > 0) {
            return $children;
        } else {
            $children = "";
            return $children;
        }
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

 	public function driverList(){
 		$driver_table =  DRIVER_TABLE;
 		$filds = "driver_id,driver_fname,driver_mname,driver_lname,driver_add,driver_photo,driver_bdate,driver_mobno,driver_mobno1,driver_licno,driver_licexpdate,driver_panno,is_da,is_night_allowance,ledger_id";
 		$data['list'] = $this->driver_model->getDriverLit($filds,$driver_table);
 		//echo "<pre>";print_r($data['list']);
        $this->header->index();
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
		$this->header->index();
		$this->load->view('driverMaster', $data);
		$this->footer->index();
 	}

 	public function driverUpdate(){        

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
		 //bdate conversion
		 if(isset($driver_dob) && !empty($driver_dob)){
		 	$driver_dob = $this->helper_model->dbDate($driver_dob);
		 }

		 // licence exp date conversion
		 if(isset($driver_licence_exp) && !empty($driver_licence_exp)){
		 	$driver_licence_exp = $this->helper_model->dbDate($driver_licence_exp);
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
				'driver_licno' => $driver_licence,
				'driver_licexpdate' => $driver_licence_exp,
				'driver_panno' => $driver_pan,
				'driver_fix_pay' => $driver_fix_pay,
				'driver_da' => $driver_da_pay,
				'driver_na' => $driver_na_pay,
				'is_da' => $driver_da,
				'is_night_allowance' => $driver_night,
				'isactive' => '1',
				'updated_by' => '1',
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

        $this->header->index();
         
		$select = 'driver_id,driver_fname,driver_lname';
		$tableName = 'driver_master';
		$data['driverdetails'] = $this->helper_model->selectAll($select, $tableName);
		$this->load->view('driverAttend',$data);
		$this->footer->index();
 	}
}
