<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
	}

	public function insert($tableName,$data)
	{
		return $this->db->insert($tableName, $data);
	}

	public function insertid($tableName,$data)
	{
		 $this->db->insert($tableName, $data);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	}

	public function update($tableName,$data,$columnName,$value)
	{
		$this->db->where($columnName, $value);
		return $this->db->update($tableName, $data);
	}

	public function select($select,$tableName,$columnName,$value)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($columnName, $value);
		$query = $this->db->get();
		return $query->result();
	}

	public function selectrow($select,$tableName,$where)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		//echo $this->db->_compile_select();
		$query = $this->db->get();
		return $query->row();
	}

	public function selectGroupId($select,$tableName,$where)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	public function selectAll($select,$tableName)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
	}

	public function selectQuery($query)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
	}

	public function delete($tableName,$columnName,$value)
	{
		$this->db->where($columnName, $value);
   		return $this->db->delete($tableName); 
	}



	public function showDate($originalDate){
		$newDate = date("d-m-Y", strtotime($originalDate));
		return $newDate;
	}

	public function dbDate($originalDate){
		$newDate = date("Y-m-d", strtotime($originalDate));
		return $newDate;
	}

	public function do_upload($file,$tmpfile,$allowsize,$newname,$username){

     $filename=basename($file);

                $ext = pathinfo($filename, PATHINFO_EXTENSION);

				$newname=$username."_".$newname;
				
              // $target = "";

               //echo FILE_UPLOAD; 
               
                $target = FILE_UPLOAD; 

                $target = $target .basename($newname) ; 
                //echo $target;
                //$allowedExtensions = array("jpg","jpeg","gif","png","pdf","xls","xlsx","doc","docx");
                $allowedExtensions = array("jpg","JPG","jpeg","JPEG","png","PNG","gif","GIF");
				$fsize = $allowsize;	
				$allowsize=$allowsize*1024*1024;
				
                $err='';

                if(!in_array($ext, $allowedExtensions))  {
                	$err='File Type '.$ext.' Not Allowed! <br /> Please upload only jpg,gif or jpeg,png  file';
                }

                //else if($_FILES['changeimg1']['size']>$allowsize) $err='File being uploaded have bigger size than '.$fsize.' MB';

                else if(move_uploaded_file($tmpfile, $target)){ 
                	$err=''; 
				
				 	$err="uploaded";
				//return $err;
 
					 			
				}
                else{ $err="Sorry, there was a problem uploading the document ".$filename; }

               //return $err;
}
}
