<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('company/Company_model');
		$this->load->model('helper/helper_model');
		$this->active = "company";
	}

	public function holiday(){

        $this->header->index($this->active);         
		$this->load->view('addHoliday');
		$this->footer->index();
 	}

 	public function addHoliday(){
        $date = $_POST['date'];
        $date = date('Y-m-d', strtotime($date));
        $desc = $_POST['desc'];
        $d = date_parse_from_format("Y-m-d", $date);
		if($d['month'] < 10){
       		$month = "0".$d['month'];
	       }else{
	       	$month = $d['month'];
	       }
		$data = array(
		'holiday_date' => $date,
		'holiday_desc' => $desc,
		'month' => $month,
		'year' => $d['year'],
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s')
		);


 		$tableName =  HOLIDAY_TABLE;
 		$select = "holiday_id";
 		$where = array(
 				'holiday_date' => $date
 			);
		$exist = $this->Company_model->getwheredata($select,$tableName,$where);
		if(empty($exist)){
			$result = $this->Company_model->saveData($tableName, $data);
			if($result != false){
				$response['success'] = true;
	 	 		$response['error'] = false;
	 	 		$response['successMsg'] = "Submit Successfully";
	 	 		$response['redirect'] = base_url()."company/holidayList";
			}else{
				$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";
			}
		}else{
			$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Holiday already exist on same date";
		}
		echo json_encode($response);
 	}

 	public function holidayList(){

 		$tableName = "company_holidays";
 		$select = "*";
 		$data['holidayList'] = $this->Company_model->selectAll($select,$tableName);
 		//echo "<pre>";print_r($data);exit;
        $this->header->index($this->active);
		$this->load->view('holidayList', $data);
		$this->footer->index();
 	}

 	public function holidayDelete(){

 		$holiday_id = $_POST['id'];
        $resultMaster = $this->helper_model->delete('company_holidays','holiday_id',$holiday_id);
        if($resultMaster != false){
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}
}
