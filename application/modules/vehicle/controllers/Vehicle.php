<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('helper/helper_model');
		$this->active = "vehicle";
		//$this->load->helper(array('form', 'url'));
	}

	public function category()
	{
		@$catId = $this->uri->segment(3);
		$data = "";
		if($catId != ""){
			$select = 'cat_name,cat_id';
			$tableName = 'vehicle_category';
			$column = 'cat_id';
			$value = $catId;

			$check = $this->helper_model->select($select, $tableName, $column, $value);
			if(!empty($check)){
				$data['category'] = $check;
				$data['update'] = true;
			}else{
				redirect(base_url() .'vehicle/categoryList');
			}
		}

		

		$this->header->index($this->active);
		$this->load->view('vehicleCategory', $data);
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
				'isactive' => '1',
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
					$response['redirect'] = base_url()."vehicle/categoryList";
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
		$this->header->index($this->active);
		$this->load->view('vehicle', $data);
		$this->footer->index();
	}

	public function addVehicle()
	{
		/*echo json_encode($_POST);
		exit();*/
		$vehicle = array(
			'vehicle_name' => $_POST['vehicle_name'],
			'vehicle_no' => $_POST['vehicle_no'],
			'vehicle_type' => $_POST['vehicle_type'],
			'vehicle_model' => $_POST['vehicle_model'],
			'vehicle_desc' => $_POST['vehicle_desc'],
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
				$vehicleDetails = array();
				
				$vehicleDetail = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_exp_name' => 'insurance',
					'vehicle_exp_value' => $_POST['insurance_exp'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);
				array_push($vehicleDetails, $vehicleDetail);
			
				$vehicleDetail = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_exp_name' => 'puc',
					'vehicle_exp_value' => $_POST['puc_exp'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);
				array_push($vehicleDetails, $vehicleDetail);
			
				$vehicleDetail = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_exp_name' => 'tpermit',
					'vehicle_exp_value' => $_POST['tpermit_exp'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);
				array_push($vehicleDetails, $vehicleDetail);

				$vehicleDetail = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_exp_name' => 'oilchange',
					'vehicle_exp_value' => $_POST['oil_change'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);
				array_push($vehicleDetails, $vehicleDetail);
				
				$vehicleDetail = array(
					'vehicle_id' => $result,
					'cat_id' => $_POST['vehicle_category'],
					'vehicle_name' => $_POST['vehicle_type'],
					'vehicle_exp_name' => 'oilchangekm',
					'vehicle_exp_value' => $_POST['oil_changekm'],
					'added_by' => '1',
					'added_on' => date('Y-m-d h:i:s')
				);
				array_push($vehicleDetails, $vehicleDetail);
				
				$tableName = 'vehicle_details';
				$this->helper_model->insertBatch($tableName,$vehicleDetails);

				$tableName = 'vehicle_images';
				$imageArray = array();
				$j = 0;
				for ($i=1; $i <= count($_FILES); $i++) { 
					if($_FILES['vehichleImage'.$i]['error'] == 0){
						$imageName = rand(0,555555555).$_FILES['vehichleImage'.$i]["name"]; 
						$imageSize = $_FILES['vehichleImage'.$i]["size"]; 
						$imagetmp = $_FILES['vehichleImage'.$i]['tmp_name'];
						$path = "./assets/vehicles/".$imageName;
						$imageResult = move_uploaded_file($imagetmp, $path);
						if($imageResult == true){
							$vehicleImages = array(
								'vehicle_id' => $result,
								'image_size' => $imageSize,
								'image_name' => $imageName,
								'added_by' => '1',
								'added_on' => date('Y-m-d h:i:s')
							);
							array_push($imageArray, $vehicleImages);
						}
						$j++;
					}
					
				}
				if($j>0){
					$this->helper_model->insertBatch($tableName,$imageArray);
				}
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Successfully Submit";
				$response['redirect'] = base_url()."vehicle/vehicleList";
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
 		$tableName =  'vehicle_master v, vehicle_category c ';
 		$select = 'vehicle_id,vehicle_no,vehicle_name,vehicle_type,vehicle_model,vehicle_desc,fuel_type,passanger_capacity,vehicle_category,vehicle_features,c.cat_name';
 		$where =  'v.vehicle_category = c.cat_id';
 		$data['list'] = $this->helper_model->selectwhere($select,$tableName,$where);


        $this->header->index($this->active);
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
 		$date = date('Y-m-d');     
        $select = '*';
		$tableName = 'vehicle_master';
		$column = 'vehicle_id';
		$value = $id;
		$data['vehicle'] = $this->helper_model->select($select, $tableName, $column, $value);
		$data['vehicleDetails'] = $this->helper_model->selectQuery("SELECT v1.* FROM vehicle_details v1 where v1.vehicle_exp_value = (select MAX(v2.vehicle_exp_value) from vehicle_details v2 where v2.vehicle_exp_name = v1.vehicle_exp_name)");

		$data['puc'] = array_search('puc', array_column($data['vehicleDetails'], 'vehicle_exp_name'));
		$data['insurance'] = array_search('insurance', array_column($data['vehicleDetails'], 'vehicle_exp_name'));
		$data['tpermit'] = array_search('tpermit', array_column($data['vehicleDetails'], 'vehicle_exp_name'));
		$data['oilchange'] = array_search('oilchange', array_column($data['vehicleDetails'], 'vehicle_exp_name'));
		$data['oilchangekm'] = array_search('oilchangekm', array_column($data['vehicleDetails'], 'vehicle_exp_name'));
		$select = 'cat_id,cat_name';
		$tableName = 'vehicle_category';
		$column = '1';
		$value = '1';
		$data['category'] = $this->helper_model->selectAll($select, $tableName);

		$select = "image_name,image_id";
		$tableName = 'vehicle_images';
		$column = 'vehicle_id';
		$value = $id;
		$data['vehicleImages'] = $this->helper_model->select($select, $tableName, $column, $value);

		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('vehicle', $data);
		$this->footer->index();
 	}

 	public function vehicleUpdate(){        
        $vehicle = array(
			'vehicle_name' => $_POST['vehicle_name'],
			'vehicle_no' => $_POST['vehicle_no'],
			'vehicle_type' => $_POST['vehicle_type'],
			'vehicle_model' => $_POST['vehicle_model'],
			'vehicle_desc' => $_POST['vehicle_desc'],
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
			$vehicleDetail = array(
				'vehicle_exp_value' => $_POST['insurance_exp'],
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$tableName = 'vehicle_details';
			$column = 'vldetail_id';
			$value = $_POST['insuranceid'];
			$this->helper_model->update($tableName, $vehicleDetail, $column, $value);

			$vehicleDetail = array(
				'vehicle_exp_value' => $_POST['puc_exp'],
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$tableName = 'vehicle_details';
			$column = 'vldetail_id';
			$value = $_POST['pucid'];
			$this->helper_model->update($tableName, $vehicleDetail, $column, $value);

			$vehicleDetail = array(
				'vehicle_exp_value' => $_POST['tpermit_exp'],
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$tableName = 'vehicle_details';
			$column = 'vldetail_id';
			$value = $_POST['tpermitid'];
			$this->helper_model->update($tableName, $vehicleDetail, $column, $value);

			$vehicleDetail = array(
				'vehicle_exp_value' => $_POST['oil_change'],
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$tableName = 'vehicle_details';
			$column = 'vldetail_id';
			$value = $_POST['oil_changeid'];
			$this->helper_model->update($tableName, $vehicleDetail, $column, $value);

			$vehicleDetail = array(
				'vehicle_exp_value' => $_POST['oil_changekm'],
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$tableName = 'vehicle_details';
			$column = 'vldetail_id';
			$value = $_POST['oil_changekmid'];
			$this->helper_model->update($tableName, $vehicleDetail, $column, $value);


			$tableName = 'vehicle_images';
			$imageArray = array();
			$j = 0;
			for ($i=1; $i <= count($_FILES); $i++) { 
				if($_FILES['vehichleImage'.$i]['error'] == 0){
					$imageName = rand(0,555555555).$_FILES['vehichleImage'.$i]["name"]; 
					$imageSize = $_FILES['vehichleImage'.$i]["size"]; 
					$imagetmp = $_FILES['vehichleImage'.$i]['tmp_name'];
					$path = "./assets/vehicles/".$imageName;
					$imageResult = move_uploaded_file($imagetmp, $path);
					if($imageResult == true){
						$vehicleImages = array(
							'vehicle_id' => $_POST['id'],
							'image_size' => $imageSize,
							'image_name' => $imageName,
							'added_by' => '1',
							'added_on' => date('Y-m-d h:i:s')
						);
						array_push($imageArray, $vehicleImages);
					}
					$j++;
				}
			}
			if($j>0){
				$this->helper_model->insertBatch($tableName,$imageArray);
			}
			$response['success'] = true;
			$response['successMsg'] = "Record Updated";
			$response['redirect'] = base_url()."vehicle/vehicleList";
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

 	public function categoryList(){
 		$tableName =  'vehicle_category';
 		$select = "*";
 		$data['list'] = $this->helper_model->selectAll($select,$tableName);

        $this->header->index($this->active);
		$this->load->view('categoryList', $data);
		$this->footer->index();
 	}

 	public function categoryUpdate(){        
 		@$cat_id = $_POST['cat_id'];
 		@$cat_name = $_POST['category_name'];

 		$select = 'cat_name,cat_id';
		$tableName = 'vehicle_category';
		$column = 'cat_id';
		$value = $cat_id;

		$checkCategory = $this->helper_model->select($select, $tableName, $column, $value);
		if(!empty($checkCategory)){
			$category = array(
				'cat_name' => $cat_name,
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);

			$tableName = 'vehicle_category';
			$column = 'cat_id';
			$value = $cat_id;

			$result = $this->helper_model->update($tableName, $category, $column, $value);
			if($result == true)
			{				
				$response['success'] = true;
				$response['successMsg'] = "Record Updated";
				$response['redirect'] = base_url()."vehicle/categoryList";
	        }
	        else
	        {
	        	$response['success'] = false;
				$response['successMsg'] = "Something wrong please try again";
	        }
		}else{
			$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
		}
        echo json_encode($response);
 	}

 	public function categoryDelete(){
        @$cat_id = $_POST['id'];
        $select = 'vehicle_id';
		$tableName = 'vehicle_master';
		$column = 'vehicle_category';
		$value = $cat_id;

		$checkCategory = $this->helper_model->select($select, $tableName, $column, $value);
		if(empty($checkCategory)){
			$resultMaster = $this->helper_model->delete('vehicle_category', 'cat_id', $cat_id);
	        if($resultMaster != false){
	        	$response['success'] = true;
				$response['successMsg'] = "Record Deleted";
	        }else{
	        	$response['success'] = false;
				$response['successMsg'] = "Something wrong please try again";
	        }
		}else{
			$response['success'] = false;
			$response['successMsg'] = "This category already assigned to vehicle";
		}

        
        echo json_encode($response);
 	}

 	public function vehicleImgDelete(){
        @$img_id = $_POST['id'];
        
		$resultMaster = $this->helper_model->delete('vehicle_images', 'image_id', $img_id);
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
