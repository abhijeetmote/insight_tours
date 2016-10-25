<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('User_model');
		$this->load->model('helper/helper_model');
		$this->active = "user";
	}

	public function index()
	{
		
		$this->header->index($this->active);
		$this->load->view('UserAdd');
		$this->footer->index();
	}
	public function adduser()
	{	

		 
		 
		 $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : "";
		 $user_fname = isset($_POST['first_name']) ? $_POST['first_name'] : "";
		 $user_lname = isset($_POST['last_name']) ? $_POST['last_name'] : "";
		 $user_email_id = isset($_POST['email_id']) ? $_POST['email_id'] : "";
		 $user_dob = isset($_POST['user_dob']) ? $_POST['user_dob'] : "";
		 $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : "";
		 $password = isset($_POST['password']) ? $_POST['password'] : "";
		 $mob_no = isset($_POST['mob_no']) ? $_POST['mob_no'] : "";
		 $profilephoto = isset($_FILES['profilephoto']) ? $_FILES['profilephoto'] : "";
		 $user_status = isset($_POST['status']) ? $_POST['status'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}



		 
		 //bdate conversion
		 if(isset($user_dob) && !empty($user_dob)){
		 	$user_dob = $this->helper_model->dbDate($user_dob);

		 }
		    $_FILES['profilephoto']['name']."<br>";
			$_FILES['profilephoto']['tmp_name'];
			$isfile=basename($_FILES['profilephoto']['name']);
			$newname=$isfile;
			$sizeinmb=25;
			$user_profile_photo=FILE_UPLOAD.$user_fname."_".$newname;
		
		 $user = array(
			'user_type' => isset($_POST['user_type']) ? $_POST['user_type'] : "",
			'user_first_name' => $user_fname,
			'user_last_name' => $user_lname,
			'user_email_id' => $user_email_id,
			'user_dob' => isset($_POST['user_dob']) ? $_POST['user_dob'] : "",
			'user_name' => isset($_POST['user_name']) ? $_POST['user_name'] : "",
			'password' => isset($_POST['password']) ? md5($_POST['password']) : "",
			'user_mobile_number' => isset($_POST['mob_no']) ? $_POST['mob_no'] : "",
			'user_profile_photo' => isset($_FILES['profilephoto']) ? $user_profile_photo : "",
			'status' => $user_status,
			'added_by' => $user_id,
			'added_on' => date('Y-m-d')
			);
  
			
			if($isfile!=''){

			$imgerr=$this->helper_model->do_upload($_FILES['profilephoto']['name'],$_FILES['profilephoto']['tmp_name'],$sizeinmb,$newname,$user_fname);


			}
			
			

		$select = 'user_id';
		$tableName = 'users_master';
		$column = 'user_id';
		#$value = $_POST['user_id'];

		 //$check = $this->helper_model->select($select, $tableName, $column, $value);
		
			  $result = $this->helper_model->insert($tableName,$user);
			 

			if($result == true){
				 
				
			    $response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Successfully Submit";
				$response['redirect'] = base_url()."user/viewuser";
			} else{
				$response['success'] = false;
				$response['error'] = true;
				$response['errorMsg'] = "Please contact IT Dept";
			}
		
		echo json_encode($response);
		
	}
	public function viewuser()
	{
		

		
		$data['list'] = $this->helper_model->selectAll('role,user_name,password,user_first_name,user_last_name,user_email_id,user_mobile_number,user_profile_photo,user_type,user_dob,user_source,user_referer,user_gmt_time_zone,status,user_id', 'users_master');

 		/*echo "<pre>";
 		print_r($data);
 		exit();*/

        $this->header->index($this->active);
		$this->load->view('userlist', $data);
		$this->footer->index();
	}
	public function edituser()
	{
		$siteid=$_GET['id'];
		$result = $this->User_model->viewuserdet($siteid);
		$result['sitedata']=$result;
		$this->header->index($this->active);
		$this->load->view('editsite',$result);
		$this->footer->index();
	}
	 	public function update($id){        
         $select = '*';
		$tableName = 'users_master';
		$column = 'user_id';
		$value = $id;
		$data['user'] = $this->helper_model->select($select, $tableName, $column, $value);
		$data['update'] = true;
		$this->header->index($this->active);
		$this->load->view('UserAdd', $data);
		$this->footer->index();
 	}
	public function userUpdate(){        
      
		 $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : "";
		 $user_fname = isset($_POST['first_name']) ? $_POST['first_name'] : "";
		 $user_lname = isset($_POST['last_name']) ? $_POST['last_name'] : "";
		 $user_email_id = isset($_POST['email_id']) ? $_POST['email_id'] : "";
		 $user_dob = isset($_POST['user_dob']) ? $_POST['user_dob'] : "";
		 $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : "";
		 $password = isset($_POST['password']) ? $_POST['password'] : "";
		 $mob_no = isset($_POST['mob_no']) ? $_POST['mob_no'] : "";
		 $profilephoto = isset($_FILES['profilephoto']) ? $_FILES['profilephoto'] : "";
		 $user_status = isset($_POST['user_status']) ? $_POST['user_status'] : "0";
		 $user_photo_old = isset($_POST['user_image']) ? $_POST['user_image'] : "0";
		 $curr_user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "0";
		 $user_id = 0;
		 if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		}
		 
		 
		  	
			$select = '*';
			$tableName = 'users_master';
			$column = 'user_id';
			$value = $curr_user_id;
			$user_data = $this->helper_model->select($select, $tableName, $column, $value);
			
			if($user_data[0]->password == $password) {
				$password = $password;
			} else {
				$password = md5($password);
			}



			$isfile=basename($_FILES['profilephoto']['name']);
			$newname=$isfile;
			$sizeinmb=25;
			$user_profile_photo=FILE_UPLOAD.$user_fname."_".$newname;

			 
			
			if(!isset($newname) || empty($newname)) {
			$user_profile_photo = $user_photo_old;
			} 

			  $user = array(
			'user_id' => $_POST['user_id'],
			'user_first_name' => $_POST['first_name'],
			'user_last_name' => $_POST['last_name'],
			'user_email_id' => $_POST['email_id'],
			'user_dob' => $_POST['user_dob'],
			'user_name' => $_POST['user_name'],
			'password' => $password,
			'user_mobile_number' => $_POST['mob_no'],
			'user_profile_photo' => $user_profile_photo,
			'status' => $user_status,
			'updated_by' => $user_id,
			'updated_on' => date('Y-m-d h:i:s')
			);
		
			if($isfile!=''){

			echo $imgerr=$this->helper_model->do_upload($_FILES['profilephoto']['name'],$_FILES['profilephoto']['tmp_name'],$sizeinmb,$newname,$user_fname);


			}
		
		$tableName = 'users_master';
		$column = 'user_id';
		$value = $_POST['user_id'];

		$result = $this->helper_model->update($tableName, $user, $column, $value);
		if($result == true){
			$response['success'] = true;
			$response['successMsg'] = "Record Updated";
			$response['redirect'] = base_url()."user/viewuser";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }

        echo json_encode($response);
 	}
	 	public function userDelete(){
        $user_id = $_POST['id'];
        $resultMaster = $this->helper_model->delete('users_master','user_id',$user_id);
        if($resultMaster != false){
        	//$resultDetails = $this->helper_model->delete('vehicle_details','vehicle_id',$vehicle_id);
        	$response['success'] = true;
			$response['successMsg'] = "Record Deleted";
        }else{
        	$response['success'] = false;
			$response['successMsg'] = "Something wrong please try again";
        }
        echo json_encode($response);
 	}
}
