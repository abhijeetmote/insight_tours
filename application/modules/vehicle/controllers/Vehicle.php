<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('helper/helper_model');
	}

	public function category()
	{
		$this->header->index();
		$this->load->view('vehicleCategory');
		$this->footer->index();
	}

	public function addCategory()
	{
		
		if(empty($_POST['category_name'])){
			$response['success'] = false;
			$response['successMsg'] = "Please Fill Mandatory Fields";
		}else{
			$data = array(
				'cat_name' => $_POST['category_name'],
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);

			$select = 'cat_name';
			$tableName = 'vehicle_category';
			$column = 'cat_name';
			$value = $_POST['category_name'];

			$check = $this->helper_model->select($select, $tableName, $column, $value);
			if(empty($check)){
				$result = $this->helper_model->insert($tableName,$data);
				if($result == true){
					$response['error'] = false;
					$response['success'] = true;
					$response['successMsg'] = "Successfully Submit";
				}else{
					$response['success'] = false;
					$response['error'] = true;
					$response['errorMsg'] = "Please contact IT Dept";
				}
			}else{
				$response['error'] = true;
				$response['success'] = false;
				$response['errorMsg'] = "Category already exist";
			}
		}

		echo json_encode($response);
 	}

 	public function newVehicle()
	{
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$column = '1';
		$value = '1';
		$data['category'] = $this->helper_model->selectAll($select, $tableName);
		$this->header->index();
		$this->load->view('vehicle', $data);
		$this->footer->index();
	}

	public function addVehicle()
	{
		$vehicle = array(
			'vehicle_no' => $_POST['vehicle_no'],
			'vehicle_type' => $_POST['vehicle_type'],
			'vehicle_model' => $_POST['vehicle_model'],
			'fuel_type' => $_POST['fuel_type'],
			'passanger_capacity' => $_POST['passenger_capacity'],
			'vehicle_category' => $_POST['vehicle_category'],
			'vehicle_features' => $_POST['vehicle_features'],
			'vehicle_status' => 1,
			'added_by' => '1',
			'added_on' => date('Y-m-d h:i:s')
		);

		$select = 'vehicle_id';
		$tableName = 'vehicle_master';
		$column = 'vehicle_no';
		$value = $_POST['vehicle_no'];

		$check = $this->helper_model->select($select, $tableName, $column, $value);
		if(empty($check)){
			$result = $this->helper_model->insert($tableName,$vehicle);
			if($result == true){
				$vehicleDetails = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_insuexpdate' => $_POST['insurance_exp'],
					'vehicle_pucexpdate' => $_POST['puc_exp'],
					'vehicle_Tpermitexpdate' => $_POST['tpermit_exp'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);

				$tableName = 'vehicle_details';
				$this->helper_model->insert($tableName,$vehicleDetails);

				$tableName = 'vehicle_images';
				for ($i=1; $i < count($_FILES); $i++) { 
					if($_FILES['vehichleImage'.$i]['error'] == 0){
						$imagename = $_FILES['vehichleImage'.$i]["name"]; 

						$imagetmp = addslashes(file_get_contents($_FILES['vehichleImage'.$i]['tmp_name']));
						$vehicleImages = array(
							'vehicle_id' => $result,
							'image_data' => $imagetmp,
							'image_name' => $imagename,
							'added_by' => '1',
							'added_on' => date('Y-m-d h:i:s')
						);
						$this->helper_model->insert($tableName,$vehicleImages);
					}
				}

				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Successfully Submit";
			}else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		}else{
			$response['success'] = false;
			$response['error'] = true;
			$response['errorMsg'] = "Vehicale already exist";
		}

		echo json_encode($response);
 	}

 	public function vehicleList(){
 		$data['list'] = $this->helper_model->selectAll('vehicle_id,vehicle_no,vehicle_type,vehicle_model,fuel_type,passanger_capacity,vehicle_category,vehicle_features', 'vehicle_master');

 		/*echo "<pre>";
 		print_r($data);
 		exit();*/

        $this->header->index();
		$this->load->view('vehicleList', $data);
		$this->footer->index();
 	}

 	public function vehicleDelete(){
        $vehicle_id = $_POST['id'];
        $resultMaster = $this->helper_model->delete('vehicle_master','vehicle_id',$vehicle_id);
        if($resultMaster != false){
        	$resultDetails = $this->helper_model->delete('vehicle_details','vehicle_id',$vehicle_id);
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
		$tableName = 'vehicle_master';
		$column = 'vehicle_id';
		$value = $id;
		$data['vehicle'] = $this->helper_model->select($select, $tableName, $column, $value);
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$column = '1';
		$value = '1';
		$data['category'] = $this->helper_model->selectAll($select, $tableName);
		$data['update'] = true;
		$this->header->index();
		$this->load->view('vehicle', $data);
		$this->footer->index();
 	}

 	public function vehicleUpdate(){        
        $vehicle = array(
			'vehicle_no' => $_POST['vehicle_no'],
			'vehicle_type' => $_POST['vehicle_type'],
			'vehicle_model' => $_POST['vehicle_model'],
			'fuel_type' => $_POST['fuel_type'],
			'passanger_capacity' => $_POST['passenger_capacity'],
			'vehicle_category' => $_POST['vehicle_category'],
			'vehicle_features' => $_POST['vehicle_features'],
			'vehicle_status' => 1,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
		);

		$tableName = 'vehicle_master';
		$column = 'vehicle_id';
		$value = $_POST['id'];

		$result = $this->helper_model->update($tableName, $vehicle, $column, $value);
		if($result == true){
			$response['success'] = true;
			$response['successMsg'] = "Record Updated";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }

        echo json_encode($response);
 	}
}
