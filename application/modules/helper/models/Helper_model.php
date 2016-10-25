<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
	}

	public function insert($tableName,$data)
	{
		$this->db->insert($tableName, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insertid($tableName,$data)
	{
		 $this->db->insert($tableName, $data);
		 $insert_id = $this->db->insert_id();
		 return $insert_id;
	}

	public function insertBatch($tableName,$data)
	{
		$this->db->insert_batch($tableName, $data);
		return $this->db->insert_id();
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
		//echo $this->db->_compile_select();
		$query = $this->db->get();
		return $query->result();
	}

	public function selectwhere($select,$tableName,$where)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		//echo $this->db->_compile_select();
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

	public function selectAllwhere($select,$tableName,$where)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	public function selectallOrder($select,$tableName,$order_id,$order)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->order_by($order_id, $order);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function selectallWhereOrder($select,$tableName,$where,$order_id,$order)
	{
		$this->db->select($select);
		$this->db->from($tableName);
		$this->db->where($where);
		$this->db->order_by($order_id, $order);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function selectQuery($query)
	{
		$result = $this->db->query($query);
        return $result->result_array();
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

	public function dbDatetime($originalDate){
		/*$newDate = date('Y-m-d H:i:s', strtotime($originalDate));
		return $newDate;*/
		$date1 = strtr($originalDate, '/', '-');
 		return date('Y-m-d H:i:s', strtotime($date1));
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



public function _getLedGrpListRecur($led_grp_objects, $master_array = array(), $parent_id = 0, $array_id = array(), $entity_type = '')
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
    public function _getGrpChildren($group, $entity_type = '')
    {
        $children = "";
        //$soc_id = $this->session->get("auth")["soc_id"];
        
        $conditions = "parent_id = $group";
       // $bind       = $group;
        
        if ($entity_type == ENTITY_TYPE_LEDGER) {
            
        } else if ($entity_type == ENTITY_TYPE_GROUP) {
            
            $conditions .= " AND entity_type != 'ledger' ";
            //$bind[3] = trim(strtolower(ENTITY_TYPE_LEDGER));
        }
        $grp_table = LEDGER_TABLE;
        //print_r($conditions);
       // print_r($bind);
        //$where =  array($conditions => $bind);
        $where =  $conditions;
        //$children = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind, "order" => "ledger_account_name ASC"))->toArray();
         $children = $this->selectallWhereOrder('*',$grp_table,$where,'ledger_account_name','asc');
        if (count($children) > 0) {
            return $children;
        } else {
            $children = "";
            return $children;
        }
    }

     /**
     * The Component action `sorted_array` is to sort ladger tree for vouchers
     * @method sorted_array.
     * @access public
     * @param array $elements tree array
     * @param int $parentId DEFAULT 0
     * @param array $filter_param filter parameters
     * @return array
     */
  	public function sorted_array($elements, $parentId = 0,$filter_param) {
            //echo "<pre>";
            //print_r($elements);exit;
	foreach ($elements as $elementKey=>$elementValue) {
		if(in_array($elementValue['context'],$filter_param)!==false){
			if ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {
				$elements[$elementKey]['children'] = $this->sorted_array($elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
			}else {
				continue;
			}
		}
		elseif ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {

				$elements[$elementKey]['children'] = $this->sorted_array ( $elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
				if( empty($elements[$elementKey]['children']) ) { unset($elements[$elementKey]); }
		} else{
				unset($elements[$elementKey]);
			}
		}
                //print_r($elements);exit;
		return $elements;
    }



  	public function send_sms($telephone_no, $msg="") {

  			//echo "<br> tel".$telephone_no;
  			//echo "<br>".$msg;
  			$url = "http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?";
  			$post_string = "feedid=361682&username=9850275160&password=tdwtm&To=$telephone_no&Text=$msg";
						
			//initialize curl handle
			$curl_connection = curl_init($url);
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string); //set the POST variables
			$result = curl_exec($curl_connection); //run the whole process and return the response
			curl_close($curl_connection);  //close the curl handle 
			
			ob_clean();
			
          	 

    }
}
