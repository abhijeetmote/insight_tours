<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('helper/helper_model');
		$this->active = "package";
		//$this->load->helper(array('form', 'url'));
	}

	public function packageMaster()
	{
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$data['vehicle'] = $this->helper_model->selectAll($select, $tableName);

		$this->header->index($this->active);
		$this->load->view('packageMaster', $data);
		$this->footer->index();
	}

	public function addPackage()
	{
		$package_name = $_POST['package_name'];
		$vehicle_cat_id = $_POST['vehicle'];
		$travel_type = $_POST['travel_type'];
		$default = isset($_POST['default']) ? $_POST['default'] : "0";
		
		$data = array(
			'vehicle_cat_id' => $vehicle_cat_id,
			'package_name' => $package_name,
			'hours' => $_POST['hours'],
			'distance' => $_POST['distance'],
			'package_amt' => $_POST['min_cost'],
			'charge_distance' => $_POST['charge_distance'],
			'charge_hour' => $_POST['charge_hour'],
			'travel_type' => $travel_type,
			'default' => $default,
			'isactive' => $_POST['status'],
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$select = 'package_id';
		$tableName = 'package_master';
		$where = "package_name = '$package_name' && vehicle_cat_id = '$vehicle_cat_id'";

		$check = $this->helper_model->selectwhere($select, $tableName, $where);
		if(empty($check)){
			if($default == 1)
			{
				$update = array(
					'default' => 0
				);

				$tableName = 'package_master';
				$column = 'travel_type';
				$value = $travel_type;

				$this->helper_model->update($tableName, $update, $column, $value);
			}

			$result = $this->helper_model->insert($tableName,$data);
			if($result == true){
				$response['error'] = false;
				$response['success'] = true;
				$response['successMsg'] = "Successfully Submit";
				$response['redirect'] = base_url()."Package/packageList";
			}else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		}else{
			$response['error'] = true;
			$response['success'] = false;
			$response['errorMsg'] = "Package Name already exist";
		}

		echo json_encode($response);
 	}

 	public function packageList(){
 		$tableName =  'package_master p,vehicle_category c';
 		$select = 'p.*,c.cat_name';
 		$where =  'p.vehicle_cat_id = c.cat_id';
 		$data['packageList'] = $this->helper_model->selectwhere($select,$tableName,$where);

 		/*$select = '*';
		$tableName = 'package_master';
		$data['packageList'] = $this->helper_model->selectAll($select, $tableName);*/

        $this->header->index($this->active);
		$this->load->view('packageList', $data);
		$this->footer->index();
 	}

 	public function update(){
 		$id = $this->uri->segment(3);
 		$select = "*";
 		$tableName = "package_master";
 		$columnName = "package_id";
 		$value = $id;
 		$data['package'] = $this->helper_model->select($select,$tableName,$columnName,$value);
 		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$data['vehicle'] = $this->helper_model->selectAll($select, $tableName);
 		$data['update'] = true;
 		$this->header->index($this->active);
		$this->load->view('packageMaster', $data);
		$this->footer->index();
 	}

 	public function updatePackage(){        
       	$package_name = $_POST['package_name'];
		$vehicle_cat_id = $_POST['vehicle'];
		$travel_type = $_POST['travel_type'];
		$default = isset($_POST['default']) ? $_POST['default'] : "0";
		if($default == 1)
		{
			$update = array(
				'default' => 0
			);

			$tableName = 'package_master';
			$column = 'travel_type';
			$value = $travel_type;

			$this->helper_model->update($tableName, $update, $column, $value);
		}
		$data = array(
			'vehicle_cat_id' => $vehicle_cat_id,
			'package_name' => $package_name,
			'hours' => $_POST['hours'],
			'distance' => $_POST['distance'],
			'package_amt' => $_POST['min_cost'],
			'charge_distance' => $_POST['charge_distance'],
			'charge_hour' => $_POST['charge_hour'],
			'travel_type' => $_POST['travel_type'],
			'default' => $default,
			'isactive' => $_POST['status'],
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'package_master';
		$column = 'package_id';
		$value = $_POST['id'];

		$result = $this->helper_model->update($tableName, $data, $column, $value);
		if($result == true){			
			$response['error'] = false;
			$response['success'] = true;
			$response['successMsg'] = "Successfully Update";
			$response['redirect'] = base_url()."Package/packageList";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }

        echo json_encode($response);
 	}

 	public function vehicleDetails(){
 		$id = $_POST['id'];
 		$vehicleDetails = $this->helper_model->selectQuery("SELECT v1.vehicle_exp_name,v1.vehicle_exp_value FROM vehicle_details v1 where v1.vehicle_exp_value = (select MAX(v2.vehicle_exp_value) from vehicle_details v2 where v2.vehicle_exp_name = v1.vehicle_exp_name and v2.vehicle_id = '$id')");
 		if($vehicleDetails == true){
 			$detail = "";
 			foreach ($vehicleDetails as $val) {
 				$detail .='<tr>
 							<td>'.ucfirst($val['vehicle_exp_name']).'</td>	
 							<td>'.ucfirst($val['vehicle_exp_value']).'</td>
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

 	public function packageListBooking()
	{
		$v_type = $this->input->post('v_type');
		$t_type = $this->input->post('t_type');
		$select = 'package_id,package_name';
		$tableName = 'package_master';
		$where = "vehicle_cat_id = '$v_type' && travel_type = '$t_type'";

		$packageList = $this->helper_model->selectwhere($select, $tableName, $where);
		if(!empty($packageList)){
			$response['success'] = true;
			$list = "";
			foreach ($packageList as $key => $val) {
				$list .= '<option value="'.$val->package_id.'">'.$val->package_name.'</option>';
			}
			$response['successMsg'] = $list;
		}else{
			$response['success'] = false;
		}
		echo json_encode($response);
	}
}
