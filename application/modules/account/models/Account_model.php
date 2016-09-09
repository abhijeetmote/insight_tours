<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('helper/helper_model');
	}

	public function saveData($tableName,$data){
		$result = $this->helper_model->insertid($tableName,$data);
		return $result;
	}


	public function updateData($tableName,$data,$columnName,$value){
		$result = $this->helper_model->update($tableName,$data,$columnName,$value);
		//echo $this->db->last_query();
		return $result;
	}

	public function getAccountLit($data,$table){

		$result = $this->helper_model->selectAll($data,$table);
		return $result;
	}

	public function getGroupId($select,$tableName,$context,$entity_type,$where){

		$result = $this->helper_model->selectGroupId($select,$tableName,$where);
		return $result;
	}
	
	public function getData($select, $tableName, $column, $value) {
		$result = $this->helper_model->select($select, $tableName, $column, $value);
		return $result;
	}

	 
	
	public function getall($select,$tableName,$where) {
		$result = $this->helper_model->selectAllwhere($select,$tableName,$where);
		return $result;
	}


	public function getDataOrder($select, $tableName,$order_id,$order) {
		$result = $this->helper_model->selectallOrder($select, $tableName,$order_id,$order);
		return $result;
	}

	public function getDataWhereOrder($select, $tableName,$where,$order_id,$order) {
		$result = $this->helper_model->selectallWhereOrder($select, $tableName,$where,$order_id,$order);
		return $result;
	}

	public function getwheredata($select,$tableName,$where){

		$result = $this->helper_model->selectwhere($select,$tableName,$where);
		//echo $this->db->last_query();
		return $result;
	}


	public function getwheresingle($select,$tableName,$where){

		$result = $this->helper_model->selectrow($select,$tableName,$where);
		//echo $this->db->last_query();
		return $result;
	}

	 public function getTransaction($txn_id,$txn_from_id) {

	 	if(isset($txn_id) && !empty($txn_id)) {
	 		$where  = "txn_id = $txn_id";
	 	} else if(isset($txn_from_id) && !empty($txn_from_id)) {
	 		$where  = "txn_from_id = $txn_from_id";
	 	} else {
	 		return 0;
	 	}

    	$sql = "SELECT * FROM ledger_transactions WHERE $where";
       //echo $sql;exit;
        //$result = $this->soc_db_w->query($sql);exit;
        
        $ledger_array = $this->helper_model->selectQuery($sql);
        return $ledger_array;
    }

    public function getLedger($ledger_id) {
    	$sql = "SELECT * FROM ledger_master WHERE ledger_account_id = $ledger_id";
       // echo $sql;exit;
        //$result = $this->soc_db_w->query($sql);exit;
        
        $ledger_array = $this->helper_model->selectQuery($sql);
        return $ledger_array;
    }
}
