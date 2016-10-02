<?php error_reporting(1); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	function __construct() {
	    parent::__construct();
	     ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('account/account_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		$this->load->model('helper/MonthlyPeriodListener');
		$this->load->model('helper/YearlyPeriodListener');
		$this->load->model('helper/ReporttransactiontotalListener');
		$this->active = "account";
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function addAccount()
	{
		$this->header->index($this->active);
		
		
		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context_cash = CASH_CONTEXT;
		$context_bank = BANK_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context_cash, 'entity_type' => $entity_type);
 	 	$groupid_cash = $this->account_model->getGroupId($select,$ledgertable,$context_cash,$entity_type,$where);

 	 	$cash_group = $groupid_cash->ledger_account_id;	
 	 	$where =  array('context' =>  $context_bank, 'entity_type' => $entity_type);
 	 	$groupid_bank = $this->account_model->getGroupId($select,$ledgertable,$context_bank,$entity_type,$where);
 	 	
 	 	$bank_group = $groupid_bank->ledger_account_id;	

 	 	$data['cash_group'] = $cash_group;
 	 	$data['bank_group'] = $bank_group;

		$this->load->view('addAccount',$data);

		$this->footer->index();
	}

	public function accountSubmit()
	{
		 $account_type = isset($_POST['account_type']) ? $_POST['account_type'] : "";
		 $account_name = isset($_POST['account_name']) ? $_POST['account_name'] : "";
		 $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : "";
		 $amount = isset($_POST['amount']) ? $_POST['amount'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $account_status = isset($_POST['account_status']) ? $_POST['account_status'] : "";
		 // ledger data preparation
	 	$select = " ledger_account_id,context";
		$ledgertable = LEDGER_TABLE ;
		$entity_type = GROUP_ENTITY;
		$where =  array('ledger_account_id' =>  $account_type, 'entity_type' => $entity_type);
 	 	$groupid = $this->account_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$context = $groupid->context;
 	 	$reporting_head = BALANCE_SHEET;
 	 	$nature_of_account = DR;
 	 	$entity_type = ENTITY_TYPE_LEDGER;	
	 // account data insertion start
		 $data = array(
				'group_id' => $account_type,
				'account_name' => $account_name,
				'account_type' => $context,
				'account_no' => $account_no,
				'amount' => $amount,
				'comment' => $comment,
				'status' => $account_status,
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);
 	$account_table =  ACCOUNT_TABLE;

 	$this->db->trans_begin();
 	 //driver record insertion
 	$account_id = $this->account_model->saveData($account_table,$data);

 	//diver data insertion end

 	//Ledger data insertion start
 	if(isset($account_id) && !empty($account_id)) {
		
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $account_name,
		'parent_id' => $account_type,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => $account_id,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $reporting_head,
		'entity_type' => 3,
		'defined_by' => 2,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$ledger_id = $this->account_model->saveData($legertable,$leddata);

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
 	$updat_column_Name = "account_id";
 	$update_value = $account_id;
 	$update_id = $this->account_model->updateData($account_table,$update_data,$updat_column_Name,$update_value);
 	//end




 	// transaction data data insertion start
	 $trans_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $ledger_id,
				'ledger_account_name' => $account_name,
				'transaction_type' => $nature_of_account,
				'payment_reference' => $account_no,
				'transaction_amount' => $amount,
				'txn_from_id' => 0,
				'memo_desc' => 'Initial entry for account creation',
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;

 	 
 	 // transaction
 	$transaction_id = $this->account_model->saveData($transaction_table,$trans_data);
 	

	if(isset($update_id) && !empty($update_id) && isset($transaction_id) && !empty($transaction_id)){
		//$this->session->set_msg(array('status' => 'success','msg'=>'Driver '));
		$this->db->trans_commit();
		$response['success'] = true;
		$response['error'] = false;
		$response['successMsg'] = "Account Added Successfully";
		$response['redirect'] = base_url()."account/accountList";

	}else{
		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
	}
	echo json_encode($response);
 	}




 	public function accountList(){

 		$driver_table =  ACCOUNT_TABLE;
 		$filds = "*";
 		$data['list'] = $this->account_model->getAccountLit($filds,$driver_table);

 		//echo "<pre>";print_r($data['list']);
        $this->header->index($this->active);
		$this->load->view('accountList', $data);
		$this->footer->index();
 	}

 	public function accountDelete(){

        $account_id = $_POST['id'];
        $account_table =  ACCOUNT_TABLE;



        $select = " ledger_id";
		
		$where =  array('account_id' =>  $account_id);
 	 	$groupid = $this->account_model->getGroupId($select,$account_table,'','',$where);
 	 	$ledger_id = $groupid->ledger_id;

 	 	$select = " * ";
		$transaction_table = TRANSACTION_TABLE ;
		 
		$where =  array('ledger_account_id' =>  $ledger_id );
 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);

 	 	foreach ($led_data as $led_data) {
	 		$trans_data = array(
		'ledger_account_name' => $account_name,
		'transaction_type' => $nature_of_account,
		'payment_reference' => $account_no,
		'updated_by' => 1,
		'updated_on' => date('Y-m-d h:i:s')
		);
	 		//$trans_data = 'ledger_account_id';
		$trans_column = "txn_id";
		$transaction_table =  TRANSACTION_TABLE;
		$trans_id = $led_data->txn_id;	

		$trans_result = $this->helper_model->delete($transaction_table,$trans_column,$trans_id);	
			


		}

		 
 	   	$ledgertable =  LEDGER_TABLE;
    	$resultMaster = $this->helper_model->delete($ledgertable,'ledger_account_id',$ledger_id);	
 	 
 	 	
 	 	$resultMaster = $this->helper_model->delete($account_table,'account_id',$account_id);	

    
		if(empty($resultMaster) || $resultMaster == false) {

			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
		
		} else {
			$response['success'] = true;
			$response['successMsg'] = "Deleted Successfully";	
		}
		
	 	echo json_encode($response);
 	}


 	public function update($id){        
        $select = '*';
		$tableName = ACCOUNT_TABLE;
		$column = 'account_id';
		$value = $id;
		$data['account'] = $this->account_model->getData($select, $tableName, $column, $value);

		$data['update'] = true;


		$select = " ledger_account_id ";
		$ledgertable = LEDGER_TABLE ;
		$context_cash = CASH_CONTEXT;
		$context_bank = BANK_CONTEXT;
		$entity_type = GROUP_ENTITY;
		$where =  array('context' =>  $context_cash, 'entity_type' => $entity_type);
 	 	$groupid_cash = $this->account_model->getGroupId($select,$ledgertable,$context_cash,$entity_type,$where);

 	 	$cash_group = $groupid_cash->ledger_account_id;	
 	 	$where =  array('context' =>  $context_bank, 'entity_type' => $entity_type);
 	 	$groupid_bank = $this->account_model->getGroupId($select,$ledgertable,$context_bank,$entity_type,$where);
 	 	
 	 	$bank_group = $groupid_bank->ledger_account_id;	

 	 	$data['cash_group'] = $cash_group;
 	 	$data['bank_group'] = $bank_group;

		$this->header->index($this->active);
		$this->load->view('addAccount', $data);
		$this->footer->index();
 	}

 	public function accountUpdate(){        

 		$account_type = isset($_POST['account_type']) ? $_POST['account_type'] : "";
		 $account_name = isset($_POST['account_name']) ? $_POST['account_name'] : "";
		 $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : "";
		 $amount = isset($_POST['amount']) ? $_POST['amount'] : "";
		 $comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
		 $account_status = isset($_POST['account_status']) ? $_POST['account_status'] : "";
		 $ledger_id = isset($_POST['ledger_id']) ? $_POST['ledger_id'] : "";
		  // ledger data preparation
	 	$select = " ledger_account_id,context";
		$ledgertable = LEDGER_TABLE ;
		$entity_type = GROUP_ENTITY;
		$where =  array('ledger_account_id' =>  $account_type, 'entity_type' => $entity_type);
 	 	$groupid = $this->account_model->getGroupId($select,$ledgertable,$context,$entity_type,$where);
 	 	
 	 	$context = $groupid->context;
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
 	 	$nature_of_account = DR;
 	 	$entity_type = ENTITY_TYPE_LEDGER;	
	 // account data insertion start
		 $account_update = array(
				'group_id' => $account_type,
				'account_name' => $account_name,
				'account_type' => $context,
				'account_no' => $account_no,
				'amount' => $amount,
				'comment' => $comment,
				'status' => $account_status,
				'added_by' => '1',
				'added_on' => date('Y-m-d h:i:s')
			);
 		$account_table =  ACCOUNT_TABLE;
    
		$this->db->trans_begin();
	 
		$account_column = 'account_id';
		$account_id = $_POST['id'];

		$result = $this->account_model->updateData($account_table, $account_update, $account_column, $account_id);

		if(isset($result) && $result == true) {
			$ledgertable = LEDGER_TABLE;
			$ledger_column = 'ledger_account_id';
			$ledger_update = array(
			'ledger_account_name' => $account_name,
			'parent_id' => $account_type,
			'report_head' => $reporting_head,
			'context' => $context,
			'status' => $account_status,
			'updated_by' => '1',
			'updated_on' => date('Y-m-d h:i:s')
			);

			$ledger_result = $this->account_model->updateData($ledgertable, $ledger_update, $ledger_column, $ledger_id);

			if(empty($ledger_result) || $ledger_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

			} else{

				if(isset($ledger_id)) {
				$select = " * ";
				$transaction_table = TRANSACTION_TABLE ;
				 
				$where =  array('ledger_account_id' =>  $ledger_id );
		 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);

		 	 	foreach ($led_data as $led_data) {
	 	 		$trans_data = array(
				'ledger_account_name' => $account_name,
				'transaction_type' => $nature_of_account,
				'payment_reference' => $account_no,
				'updated_by' => 1,
				'updated_on' => date('Y-m-d h:i:s')
				);
	 	 		//$trans_data = 'ledger_account_id';
	 	 		$trans_column = "txn_id";
 				$transaction_table =  TRANSACTION_TABLE;
 				$trans_id = $led_data->txn_id;	
 				$trans_result = $this->account_model->updateData($transaction_table, $trans_data, $trans_column, $trans_id);
 				if(empty($trans_result) || $trans_result == false) {

				$this->db->trans_rollback();
	 	 		$response['error'] = true;
	 	 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";

				}
		 	 	}


		 	 	}

				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Vendor Updated Successfully";
				$response['redirect'] = base_url()."account/accountList";
			}
		} else {

			$this->db->trans_rollback();
 	 		$response['error'] = true;
 	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}

        echo json_encode($response);
 	}



 	public function addAmount()
	{
		
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->account_model->getDataOrder('*',$grp_table,'parent_id','asc');
		
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		
		$ledger_data = $this->selectEnhanced->__construct("from_ledger", $filter_ledgers_from, array(
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


		 
		$data['from_select'] = $this->selectEnhanced->render("",'from_ledger','from_ledger','');		
		$this->load->view('addAmount',$data);
		$this->footer->index();
	}



	public function addAmountSubmit()
	{
		 
		 $from_ledger = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
		 $payment_amount = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : "";
		 $narration = isset($_POST['narration']) ? $_POST['narration'] : "";
		 $referance_no = isset($_POST['referance_no']) ? $_POST['referance_no'] : "";
		 $cr = CR;
		 $dr = DR;

	 	$select = "*";
		$ledgertable = LEDGER_TABLE ;
		//echo "aa";
 	 	$where =  "ledger_account_id = '$from_ledger'";
 		$ledger_details = $this->account_model->getwheresingle($select,$ledgertable,$where);
 		//print_r($ledger_details);
 	 	//echo "ee";
 	 	$from_ledger_name = $ledger_details->ledger_account_name;
 	 	 
	 	// transaction data data insertion start
		 $from_data = array(
				'transaction_date' => date('Y-m-d h:i:s'),
				'ledger_account_id' => $from_ledger,
				'ledger_account_name' => $from_ledger_name,
				'transaction_type' => $dr,
				'payment_reference' => $referance_no,
				'transaction_amount' => $payment_amount,
				'txn_from_id' => 0,
				'memo_desc' => $narration,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
 	$transaction_table =  TRANSACTION_TABLE;

 	 
 	 //From transaction
 	$from_transaction_id = $this->account_model->saveData($transaction_table,$from_data);
 	if(isset($from_transaction_id) && !empty($from_transaction_id)){
		 	 		$this->db->trans_commit();
		 	 		$response['error'] = false;
		 	 		$response['success'] = true;
					$response['successMsg'] = "Payment Made SuccsessFully !!!";
					//$response['redirect'] = base_url()."account/ledgerList";
					//$response['redirect'] = base_url()."driver/driverList";
	 }else {
 		$this->db->trans_rollback();
 		$response['error'] = true;
 		$response['success'] = false;
		$response['errorMsg'] = "Error!!! Please contact IT Dept";
 	}
 	 
	echo json_encode($response);
 	}



	public function ledgerList()
	{
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		//error_reporting(1);

		$ledger_data = $this->account_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ledger_data = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		//echo "<pre>";
		$data['ledgers'] = $ledger_data[0];
		$this->load->view('ledgerList',$data);
		$this->footer->index();
	}

	
	/**
    * The controller action `listTransactionAction` is called to lists transactions for a perticular ledger id.
    * @method listTransactionAction.
    * @access public.
    * @param type $ledger_id ledger account id
    * @uses ChsOne\Components\Accounts\Transaction::listLedgerTransactions() get transaction details.
    */

    public function listTransaction($ledger_id, $offset=0, $length=10)
    {
    	$this->header->index($this->active);
    	//error_reporting(5);
        //echo $ledger_id;exit;
       // $number_page = $this->request->getQuery("page", "int");
       // $number_page = ($number_page > 0) ? $number_page : 1;
        $filter_criteria = array();
    //    $soc_id = $this->session->get("auth")["soc_id"];
        $translist  = $this->getLedgerTransactions($ledger_id, $filter_criteria, 'ledger', $offset, $length);
      /*echo "<pre>";
        print_r($translist);/*exit;*/
        //$translist  = $this->transaction->listLedgerTransactions($ledger_id);
        //echo "<pre>";print_r($translist);exit();
        
        $ledger_dts = $this->account_model->getLedger($ledger_id);
        /*echo "<pre>";
        print_r($ledger_dts);	 */
        $translistcount = count($translist['transaction_array']);
        //get counter entry ledger names
        $ledger_names = array();
        if($translistcount > 0) {
        	$ledger_names = $this->getCounterEntryLedgerName($translist['transaction_array']);
        }
        
       /* echo "<pre>";
        print_r($ledger_names);*/

        $total_records = $translist['total_records'];  //count number of records
        $no_of_records = 10;
        $total_pages = ceil($total_records / $no_of_records); 

         
       /* echo "<pre>";
        print_r($translist);*/
        $data['ledger_id'] = $ledger_id;
        $data["page"] = $translist['transaction_array'];
        $data['export_url'] =  base_url() . "transaction/downloadTxns/" . $ledger_id . "/";
        $data['translist'] = $translist;
        $data['ledger_names'] = $ledger_names;
        $data['length'] = $length;
        $data['offset'] = $offset;
        $data['total_records'] = $total_records;
        $data['ledger'] = $ledger_dts[0];
         
        $data['total_pages'] = $total_pages;
        $data['no_of_records'] = $no_of_records;
       
      	 $data['ledgers'] = $ledger_data[0];
		$this->load->view('transactionList',$data);
		$this->footer->index();           	
    }
	 

 

	/**
     * The function `getLedgerTransactions` is used to fetch ledger transaction w.r.t the offset and limit.
     *
     * @method getLedgerTransactions
     * @access public
     * @param integer $soc_id
     * @param integer $ledger_id
     * @param array $criteria
     * @param string $entity
     * @param integer $offset
     * @param integer $length
     * @return array
     */
    public function getLedgerTransactions($ledger_id, $criteria, $entity = 'ledger', $offset = 0, $length = PAGE_NUMBER) {
    	
    	
    	$result_array = array();
    	$filter_array = $column_array = $sort_array = array();
    	$criteria_clause = '';
    	foreach( $criteria as $control => $condition ) {
    		if( !empty($condition) ) {
    			$criteria_clause.= empty($criteria_clause) ? $condition : ' AND '. $condition;
    		}
    	}
    	if( !empty($criteria_clause) ) {
    		array_push($filter_array, $criteria_clause);
    	}
    	array_push($column_array, 'SQL_CALC_FOUND_ROWS a.*, b.*');//SQL_CALC_FOUND_ROWS 
		
    	
    	switch($entity) {
        case 'ledger':
            //LedgerTxn::query()->limit($length, $offset);
            array_push($sort_array, 'a.transaction_date DESC' );
            array_push($sort_array, 'a.added_on DESC' );
            array_push($filter_array, 'a.ledger_account_id='.$ledger_id );
            //array_push($filter_array, 'a.soc_id='. $soc_id );
            array_push($filter_array, 'transaction_amount !=0.00');
            #$this->db->join('chsone_grp_ledger_tree as b', 'a.ledger_account_id = b.pk_ledger_account_id' );
            #$result_set = $this->db->get('chsone_ledger_transactions as a');

            //echo '<br/>'.$this->db->last_query();
            break;
        case 'main':
        case 'group':
                //LedgerTxn::query()->limit($length, $offset);
                array_push($sort_array, 'a.ledger_account_id ASC' );
                array_push($sort_array, 'a.transaction_date DESC' );
                array_push($sort_array, 'a.added_on DESC' );

                array_push($filter_array, 'a.ledger_account_id IN('.$ledger_id.')' );
                //array_push($filter_array, 'a.soc_id='. $soc_id );
                array_push($filter_array, 'transaction_amount !=0.00');
                #$this->db->join('chsone_grp_ledger_tree as b', 'a.ledger_account_id = b.pk_ledger_account_id' );
                #$result_set = $this->db->get('chsone_ledger_transactions as a');
                break;
    	}//end of switch
    	/*echo "<pre>";
    	print_r($sort_array);
    	print_r($filter_array);
    	print_r($column_array);*/
    	//$ledger_transaction = new LedgerTxn();
        //$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($this->soc_db_w);
        
        $sql = "SELECT SQL_CALC_FOUND_ROWS ".(implode(', ', $column_array))." FROM "." ledger_transactions "." as a LEFT JOIN ledger_master as b ON a.ledger_account_id = b.ledger_account_id WHERE ".(implode(' AND ', $filter_array) )." ORDER BY ".(implode(', ', $sort_array))." LIMIT ".$offset.','.$length;
       // echo $sql;exit;
        //$result = $this->soc_db_w->query($sql);exit;
        
        $transaction_array = $this->helper_model->selectQuery($sql);
        
    	$column_array = $filter_array = $sort_array = array();
    	// find total rows without limit
    	$found_rows_array = $this->helper_model->selectQuery('SELECT FOUND_ROWS() as "total_records"');
    	//$transaction_array = $result_set->result_array();
        //echo 'found_rows='.count($transaction_array);
    	//print_r($found_rows_array);//exit;
    	// find the minimum txn_id i.e. the last transaction record when order by desc
    	$least_ledger_ac_id = array();
    	foreach($transaction_array as $tar => $transaction) {
    		if( !isset($least_ledger_ac_id[$transaction['ledger_account_id']]) || ( $least_ledger_ac_id[$transaction['ledger_account_id']] > $transaction['txn_id'] ) ) {
    			$least_ledger_ac_id[$transaction['ledger_account_id']] = $transaction['txn_id'];
    		}
    	}// end of least ledger_ac_id
    	// find the total balance for the ledger(s)
            //print_r($least_ledger_ac_id);
        array_push($sort_array,'a.transaction_date DESC' );
    	array_push($sort_array,'a.added_on DESC' );
    	array_push($sort_array,'a.ledger_account_id' );    
        array_push($column_array, 'a.txn_id, a.ledger_account_id, SUM(IF(a.transaction_type = "cr", a.transaction_amount, 0)) as "credit_amount", SUM(IF(a.transaction_type = "dr", a.transaction_amount, 0)) as "debit_amount"');    
    	/*$this->db->order_by('a.transaction_date', 'DESC' );
    	$this->db->order_by('a.added_on', 'DESC' );
    	$this->db->group_by('a.ledger_account_id' );*/
    	//$this->db->select('a.txn_id, a.ledger_account_id, SUM(IF(a.transaction_type = "cr", a.transaction_amount, 0)) as "credit_amount", SUM(IF(a.transaction_type = "dr", a.transaction_amount, 0)) as "debit_amount"', false);
    	if( !empty($criteria_clause) ) {
    		array_push($filter_array, $criteria_clause);
    	}
    	array_push($filter_array, 'a.ledger_account_id IN('.$ledger_id.')' );
    	//array_push($filter_array, 'a.soc_id='. $soc_id );
    	array_push($filter_array, 'transaction_amount !=0.00');
        $sql = "SELECT ".(implode(', ', $column_array))." FROM "." ledger_transactions "." as a LEFT JOIN ledger_master as b ON a.ledger_account_id = b.ledger_account_id WHERE ".(implode(' AND ', $filter_array) )." ORDER BY ".(implode(', ', $sort_array));//." LIMIT ".$offset.','.$length;
        //echo $sql;exit();
        $transaction_total = $this->helper_model->selectQuery($sql);
        //print_r($transaction_total);exit();  
    	//$transaction_total = $this->db->get('chsone_ledger_transactions as a')->result_array();
    	$filter_array = array();
    	//echo '<br/>'.$this->db->last_query();
    	// find the total balance for the records before the above selected.
    	$prev_transaction_total = array();//echo $offset.'+'.$length.'='.($offset+$length) .'<'. $found_rows_array[0]['total_records']; exit();
    	if( !empty($transaction_array) && ($offset+$length < $found_rows_array[0]['total_records']) ) {
    		foreach( $transaction_total as $ttr => $total ) {//print_r($total);exit();
    			$x_where_clause = '';
    			if( !empty($criteria_clause) ) {
    				$x_where_clause.= empty($x_where_clause) ? str_replace('a.','x.', $criteria_clause) : ' AND '.str_replace('x.','a.', $criteria_clause);
    			}
    
    			array_push($sort_array, 'a.transaction_date DESC' );
    			array_push($sort_array, 'a.added_on DESC' );
    			array_push($sort_array, 'a.ledger_account_id' );
    			array_push($column_array,'a.ledger_account_id, SUM(IF(a.transaction_type = "cr", a.transaction_amount, 0)) as "credit_amount", SUM(IF(a.transaction_type = "dr", a.transaction_amount, 0)) as "debit_amount"');
    			if( !empty($criteria_clause) ) {
    				array_push($filter_array, $criteria_clause);
    			}
    			array_push($filter_array, 'a.ledger_account_id IN('.$total['ledger_account_id'].')' );
    			//array_push($filter_array, 'a.soc_id='. $soc_id );
    			//$this->db->where('a.txn_id NOT IN ('.trim($earlier_entry_ids[0]['transaction_ids'],',').')');
    			array_push($filter_array, 'a.txn_id NOT IN (
                            SELECT `tmp`.`txn_id` FROM (
                            SELECT `x`.`ledger_account_id`, `x`.`txn_id`
                            FROM (`ledger_transactions` as x)
                            WHERE '.( !empty($x_where_clause) ? $x_where_clause.' AND ' : '' ).' `x`.`ledger_account_id` IN('.$total['ledger_account_id'].') 
                            AND `x`.`transaction_amount` != 0
                            ORDER BY `x`.`transaction_date` DESC, `x`.`added_on` DESC limit 0,'.($offset+$length).'
                            ) as `tmp`
                                                    )');
    			//$this->db->where('a.txn_id < "'.$least_ledger_ac_id[$total['ledger_account_id']].'"' );
    			array_push($filter_array, 'transaction_amount !=0.00');
                        $sql = "SELECT ".(implode(', ', $column_array))." FROM "." ledger_transactions "." as a LEFT JOIN ledger_master as b ON a.ledger_account_id = b.ledger_account_id WHERE ".(implode(' AND ', $filter_array) )." ORDER BY ".(implode(', ', $sort_array));
//." LIMIT ".($found_rows_array[0]['total_records'] - $offset)." OFFSET ".$offset;
                        //echo $sql;exit();
                        $previous_ledger_transaction_total = $this->helper_model->selectQuery($sql);
                        //print_r($previous_ledger_transaction_total);
    			//$previous_ledger_transaction_total = $this->db->get('chsone_ledger_transactions as a')->result_array();
    			if( is_array($previous_ledger_transaction_total) && !empty($previous_ledger_transaction_total) ) {
    				$prev_transaction_total = array_merge($prev_transaction_total, $previous_ledger_transaction_total );
    			}//echo '<br>'.$this->db->last_query();
    		}
    	}
    	//echo "<pre>";print_r($prev_transaction_total);echo "<br>";print_r($transaction_total);echo "<br>";echo $found_rows_array[0]['total_records'];exit();
    	$result_array = array('transaction_array' => $transaction_array, 'total_records' => $found_rows_array[0]['total_records'], 'transaction_total' => $transaction_total, 'prev_transaction_total' => $prev_transaction_total, 'total_records' => $found_rows_array[0]['total_records'] );
    	/*echo "<pre>";
    	print_r($result_array);exit;*/
    	return $result_array;
    } 



    public  function getCounterEntryLedgerName($all_ledger = array() ) {
        	$ledger_array = array();
        	//print_r($all_ledger);exit();
        	foreach($all_ledger as $alr => $t) {
        		$ledger_account_name = '';
        		if($t['txn_from_id'] == null || $t['txn_from_id'] == '' || $t['txn_from_id'] == 0 ) {
        			// find the counter entry ledger name.
        			//$conditions = " txn_from_id = ?1";
        			//$bind = array( 1 => $t['txn_id']);
        			$tax_id = $t['txn_id'];
    				$sql = "SELECT * FROM ledger_transactions WHERE txn_from_id = $tax_id";
     	
       				 $translist_new = $this->helper_model->selectQuery($sql);
        			//$translist_new = LedgerTxn::find(array("conditions" => $conditions,"bind" => $bind));
        			$counter_entry = $translist_new;
        			if( count($counter_entry) > 0 ) {
        				$ledger_account_name = $counter_entry[0]['ledger_account_name'];
        				if( empty($counter_entry[0]['ledger_account_name']) ) {
        					$counter_ledger_details = $this->account_model->getLedger($counter_entry[0]['ledger_account_id']);
        					$counter_entry_ledger_details= $counter_ledger_details;
        					$ledger_account_name = $counter_entry_ledger_details['ledger_account_name'];
        					unset($counter_ledger_details, $counter_entry_ledger_details);
        				}
        				array_push($ledger_array, 'To '.$ledger_account_name);
        			}
        			else {
        				array_push($ledger_array, 'For '.$t['ledger_account_name']);
        			}
        		}else {
        			//echo "hi".$t['txn_from_id'];exit();
        			// find the entry ledger name for this counter entry.
        			$conditions = "txn_id = ?1";
        			$bind = array(1 => $t['txn_from_id']);
        			//$translist_new = LedgerTxn::find(array("conditions" => $conditions,"bind" => $bind));

        			 $tax_from_id = $t['txn_from_id'];
    				$sql = "SELECT * FROM ledger_transactions WHERE txn_id = $tax_from_id";
     				
       				 $translist_new = $this->helper_model->selectQuery($sql);

        			$counter_entry = $translist_new;
        			if( count($counter_entry) > 0 ) {
        				$ledger_account_name = $counter_entry[0]['ledger_account_name'];
        				if( empty($counter_entry[0]['ledger_account_name']) ) {
        					$counter_ledger_details = $this->account_model->getLedger($counter_entry[0]['ledger_account_id']);
        					$counter_entry_ledger_details= $counter_ledger_details;
        					$ledger_account_name = $counter_entry_ledger_details['ledger_account_name'];
        					unset($counter_ledger_details, $counter_entry_ledger_details);
        				}
        				array_push($ledger_array, 'By '.$ledger_account_name);
        			}
        			else {
        				array_push($ledger_array, 'For '.$t['ledger_account_name']);
        			}
        		}
        	}// end of foreach all_ledger
        	return $ledger_array;
        }

 
    /*
     * Delete transaction
     * @method deleteAction
     * @access public
     * @param int $id
     * @uses ChsOne\Components\Accounts\Transaction::listLedgerTransactions() get transaction details.
     * @return url to redict
     */
    public function transactionDelete($id)
    {
    	
    	$id = $_POST['id'];

        $conditions = "txn_id = ?0";
        $params     = array("0" => $id);
        $trans_to =  $this->account_model->getTransaction($id,'');
       /* echo "<pre>";
        print_r($trans_to);exit;*/
        //echo $trans_to[0]['txn_from_id'];exit;


        if($trans_to[0]['txn_from_id']!=0 && $trans_to[0]['txn_from_id']!='') {
        $trans_from = $counter_ledger_details = $this->account_model->getTransaction($trans_to[0]['txn_from_id'],'');
        } else {
        $trans_from = $this->account_model->getTransaction('',$id);
        }
       // echo $trans_to[0]['txn_id'];exit;
         //Deleting transaction
        $flag = 0;
        if(isset($trans_to) && $trans_to!=''){

		$trans_column = "txn_id";
		$transaction_table =  TRANSACTION_TABLE;
		$trans_id = $trans_to[0]['txn_id'];	

		$trans_result = $this->helper_model->delete($transaction_table,$trans_column,$trans_id);	
 		if(!$trans_result) {
			$flag == 1;
		}
        }
        if(isset($trans_from) && $trans_from!=''){

        $trans_column = "txn_id";
		$transaction_table =  TRANSACTION_TABLE;
		$trans_id = $trans_from[0]['txn_id'];	

		$trans_result = $this->helper_model->delete($transaction_table,$trans_column,$trans_id);	
		if(!$trans_result) {
			$flag == 1;
		}
        }


        if ($flag == 1) {
            $response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
        } else {
            $response['success'] = true;
			$response['successMsg'] = "Deleted Successfully";	
        }
        
      
		
	 	echo json_encode($response);

    }



    public function transactionupdate($id){        

    	error_reporting(5);
        $select = '*';
		$tableName = LEDGER_TRANSACTIONS;
		$column = 'txn_id';
		$value = $id;
		$trans_from = $this->account_model->getData($select, $tableName, $column, $value);
		
		 
		$data['update'] = true;

        if($trans_from[0]->txn_from_id!=0 && $trans_from[0]->txn_from_id!='') {
        $column_cond = 'txn_id';
		$value_con = $trans_from[0]->txn_from_id;
        } else {
        $column_cond = 'txn_from_id';
		$value_con = $id;
        }
        
        $trans_to = $this->account_model->getData($select, $tableName, $column_cond, $value_con);
        $count_to = count($trans_to);


        $grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->account_model->getDataOrder('*',$grp_table,'parent_id','asc');

		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		  
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
		

		$ledger_data_to = $this->selectEnhanced_to->__construct("to_ledger", $ret_arr[0], array(
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

		

		 $data['to_select'] = $this->selectEnhanced->render("to_ledger",'to_ledger','to_ledger','');
		 $data['from_select'] = $this->selectEnhanced_to->render("",'from_ledger','from_ledger','');	

		$data['from_selectd_ledger_id'] = $trans_from[0]->ledger_account_id;
		$data['to_selected_ledger_id'] =  $trans_to[0]->ledger_account_id;
		$data['to_data'] = $trans_to;
		
		
        $data['from_data'] = $trans_from;
        $data['id'] = $id;
		$this->header->index($this->active);
		$this->load->view('editTransaction', $data);
		$this->footer->index();
 	}
    

    public function transactionEdit() {


    			error_reporting(5);
	    	 $from_ledg_id = isset($_POST['from_ledger']) ? $_POST['from_ledger'] : "";
			 $transaction_date = isset($_POST['transaction_date']) ? $_POST['transaction_date'] : "";
			 $txn_amt_from = isset($_POST['transaction_amount_from']) ? $_POST['transaction_amount_from'] : "";
			 $narration_from = isset($_POST['memo_desc_from']) ? $_POST['memo_desc_from'] : "";
			 $txn_type_from = isset($_POST['selection_from_type']) ? trim($_POST['selection_from_type']) : "";
			 $from_txn_id = isset($_POST['from_txn_id']) ? $_POST['from_txn_id'] : "";



			 $to_ledg_id = isset($_POST['to_ledger']) ? $_POST['to_ledger'] : "";
			 $transaction_date = isset($_POST['transaction_date']) ? $_POST['transaction_date'] : "";
			 $txn_amt_to = isset($_POST['transaction_amount_to']) ? $_POST['transaction_amount_to'] : "";
			 $narration_to = isset($_POST['memo_desc_to']) ? $_POST['memo_desc_to'] : "";
			 $txn_type_to = isset($_POST['selection_to_type']) ? trim($_POST['selection_to_type']) : "";
			 $to_txn_id = isset($_POST['to_txn_id']) ? $_POST['to_txn_id'] : "";
			 // transaction from data preparation
		 	 //bdate conversion
			 if(isset($transaction_date) && !empty($transaction_date)){
			 	$transaction_date = $this->helper_model->dbDatetime($transaction_date);
			 }
		 	$from_data = array(
				'ledger_account_id' => $from_ledg_id,
				'transaction_date' => $transaction_date,
				'transaction_amount' => $txn_amt_from,
				'memo_desc' => $narration_from,
				'transaction_type' => $txn_type_from,
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);


			$to_data = array(
				'ledger_account_id' => $to_ledg_id,
				'transaction_date' => $transaction_date,
				'transaction_amount' => $txn_amt_to,
				'memo_desc' => $narration_to,
				'transaction_type' => $txn_type_to,
				'updated_by' => '1',
				'updated_on' => date('Y-m-d h:i:s')
			);
			$transaction_table =  TRANSACTION_TABLE;

		 	$this->db->trans_begin();
		 	//driver update with ledger id start
		 	$updat_column_Name = "txn_id";
		 	$update_value = $from_txn_id;
		 	$update_from_id = $this->account_model->updateData($transaction_table,$from_data,$updat_column_Name,$update_value);

		 	if(isset($update_from_id) && !empty($update_from_id)){

	 			if(isset($to_txn_id) || !empty($to_txn_id)) {

			 			$updat_column_Name = "txn_id";
					 	$update_value = $to_txn_id;
					 	$update_to_id = $this->account_model->updateData($transaction_table,$to_data,$updat_column_Name,$update_value);

					 	if(isset($update_to_id) && !empty($update_to_id)) {
			 	 		$this->db->trans_commit();
			 	 		$response['error'] = false;
			 	 		$response['success'] = true;
						$response['successMsg'] = "Transaction Update SuccsessFully1 !!!";
						$response['redirect'] = base_url()."account/ledgerList";
						} else {
							$this->db->trans_rollback();
					 		$response['error'] = true;
					 		$response['success'] = false;
							$response['errorMsg'] = "Error!!! Please contact IT Dept";
						}
			 	} else {

			 			$this->db->trans_commit();
			 	 		$response['error'] = false;
			 	 		$response['success'] = true;
						$response['successMsg'] = "Transaction Update SuccsessFully2 !!!";
						$response['redirect'] = base_url()."account/ledgerList";
			 	}
		 			
					//$response['redirect'] = base_url()."driver/driverList";
			 }else {
		 		$this->db->trans_rollback();
		 		$response['error'] = true;
		 		$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";
		 	}
		 	
 		echo json_encode($response);
    }

    /**
     * This action used for profit and loss
     * @method profit_and_lossAction
     * @access public
     * @param string $type DEFAULT monthly
     * @param string $format 
     * 
     */
    public function profit_and_loss()
    {
       //error_reporting(E_ALL);
       // echo "<pre>";
        //$request = $this->request;
        //$arrPostData = $request->getPost();
       $this->header->index($this->active);
        $type = isset($_POST['type']) ? $_POST['type'] : "monthly";
        $lstMonth = isset($_POST['lstMonth']) ? $_POST['lstMonth'] : "";
            //echo "<pre>";print_r($arrPostData);exit();
        $arrbehaviour = array(  'directincome'=>array('operating_type'=>'direct','behaviour'=>'income'),
                                'directexpense'=>array('operating_type'=>'direct','behaviour'=>'expense'),
                                'indirectincome'=>array('operating_type'=>'indirect','behaviour'=>'income'),
                                'indirectexpense'=>array('operating_type'=>'indirect','behaviour'=>'expense'));
        
        //$soc_id = $this->session->get("auth")["soc_id"];
        #fetch/prepare initial dates such as accounting start and end, FY etc.
       // $arrdetails = array('soc_id'=> $this->session->get("auth")["soc_id"]);

        $arrfy_details = $this->ReporttransactiontotalListener->get_unit_start_date();
        //$arrfy_details = $this->accountreporting->accountreporting('reporttransactiontotal:get_unit_start_date', $arrdetails);
        /*echo "<pre>";
        print_r($arrfy_details);*/
        #form default value setting set 
        $unit_start_date_year = array();
        $fy_start_from = $arrfy_details['arraccountStartMaster']['fy_start_from'];
        if($fy_start_from == '01-01'){
            $intfystart = 1;
            $data["fymonthstart"]= $intfystart;
            
            for($i = 0 ; $i<count($arrfy_details['arrAccountFinancialMaster']);$i++){
                $curfystart = array();
                $curfystart = explode("-",$arrfy_details['arrAccountFinancialMaster'][$i]['fy_start_date']);
                $unit_start_date_year[] = $curfystart[0];
            }
        }else{
            
            for($i = 0 ; $i<count($arrfy_details['arrAccountFinancialMaster']);$i++){
                $curfystart = array();
                $curfyend = array();
                $curfystart = explode("-",$arrfy_details['arrAccountFinancialMaster'][$i]['fy_start_date']);
                if( $arrfy_details['arrAccountFinancialMaster'][$i]['fy_start_date'] <= date("Y-m-d") ) {
                	$curfyend = explode("-",$arrfy_details['arrAccountFinancialMaster'][$i]['fy_end_date']);
                
	                if($curfystart[0] == $curfyend[0] ){
	                   $curfystart[0] = $curfystart[0] - 1; 
	                }
	                $unit_start_date_year[] = $curfystart[0]."-".$curfyend[0];
                }
            }
            $data["unit_start_date_year"]= $unit_start_date_year;
            $arrfystart = explode("-",$arrfy_details['arraccountStartMaster'][0]['fy_start_from']);
            $intfystart = intval($arrfystart[0]);
           $data["fymonthstart"]= $intfystart;
        }
        
        $arrPreparePeriodDetails = array();
        $lstYear = $_POST["lstYear"]? $_POST["lstYear"] : end($unit_start_date_year);
        $lastyearstart = end($unit_start_date_year);
        $firstyearstart = $unit_start_date_year[0];
        $lstMonth = $_POST["lstMonth"] ? $_POST["lstMonth"] : '';
        $uptoMonth = $_POST["uptoMonth"] ? $_POST["uptoMonth"] : '';//exit();
        switch ($type) {
            case 'yearly':
                #prepare monthly/yearly periods as an array
            	//echo $_POST["lstYear"];
                $lstYear = ($_POST["lstYear"] != 0) ? $_POST["lstYear"] : end($unit_start_date_year);
                $uptoYear = ($_POST["uptoMonth"] != 0)? $_POST["uptoMonth"] : '0';
                //echo $lstYear;
                $arrAccntyearlyData = array( 'lstYear'=>$lstYear,'uptoYear'=>$uptoYear,'fyyears'=>$arrfy_details);
                //echo "<pre>";print_r($arrAccntyearlyData);
                //$arrPreparePeriodDetails = $this->accountreporting->accountreporting('YearlyPeriod:calYearlyPeriod', $arrAccntyearlyData);
               $arrPreparePeriodDetails = $this->YearlyPeriodListener->calYearlyPeriod($arrAccntyearlyData);
                break;
            case 'monthly':
            default :
                #prepare monthly/yearly periods as an array
                $arrAccntMonthlyData = array( 'fystart'=>$intfystart,'lstYear'=>$lstYear,'lstMonth'=>$lstMonth,'uptoMonth'=>$uptoMonth,'arrfy_details'=>$arrfy_details,'lastyearstart'=>$lastyearstart,'firstyearstart'=>$firstyearstart);
                //echo "<pre>";print_r($arrAccntMonthlyData);exit();
                //$arrPreparePeriodDetails = $this->accountreporting->accountreporting('MonthlyPeriod:calMonthlyPeriod', $arrAccntMonthlyData);
                 $arrPreparePeriodDetails = $this->MonthlyPeriodListener->calMonthlyPeriod($arrAccntMonthlyData);

                break;

        }
        //print_r($arrPreparePeriodDetails);
      //  exit;
        #fetch direct income ledger ids
        $arrGetLegersDetails = array( "operatingtype"=>'directincome',"flaghierarchy"=>'1');
        $arrLedgerDetails['directincome'] = $this->ReporttransactiontotalListener->getLedgers($arrGetLegersDetails);
        //$arrLedgerDetails['directincome'] = $this->accountreporting->accountreporting('reporttransactiontotal:getLedgers', $arrGetLegersDetails);
        #fetch indirect income ledger ids
        $arrGetLegersDetails = array( "operatingtype"=>'indirectincome',"flaghierarchy"=>'1');
        $arrLedgerDetails['indirectincome'] = $this->ReporttransactiontotalListener->getLedgers($arrGetLegersDetails);
        //$arrLedgerDetails['indirectincome'] = $this->accountreporting->accountreporting('reporttransactiontotal:getLedgers', $arrGetLegersDetails);
        
        #fetch direct expense ledger ids
        $arrGetLegersDetails = array( "operatingtype"=>'directexpense',"flaghierarchy"=>'1');
         $arrLedgerDetails['directexpense'] = $this->ReporttransactiontotalListener->getLedgers($arrGetLegersDetails);
       // $arrLedgerDetails['directexpense'] = $this->accountreporting->accountreporting('reporttransactiontotal:getLedgers', $arrGetLegersDetails);
        
        #fetch indirect expense ledger ids
        $arrGetLegersDetails = array( "operatingtype"=>'indirectexpense',"flaghierarchy"=>'1');
          $arrLedgerDetails['indirectexpense'] = $this->ReporttransactiontotalListener->getLedgers($arrGetLegersDetails);
        //$arrLedgerDetails['indirectexpense'] = $this->accountreporting->accountreporting('reporttransactiontotal:getLedgers', $arrGetLegersDetails);
        //  print_r($arrPreparePeriodDetails);
      // echo "<pre>"; print_r($arrLedgerDetails['directincome']);exit;
        
        switch ($type) {
            case 'yearly':
                #fetch direct income ledger transaction w.r.t. the array of periods
                $arrAccntyearlyData = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['directincome']['ledgerIds'],'behaviour'=>"income",'operating_type'=>"direct");
                //$arrTransactionDetails['directincome'] = $this->accountreporting->accountreporting('YearlyPeriod:getTransactionDetails', $arrAccntyearlyData);
                $arrTransactionDetails['directincome'] = $this->YearlyPeriodListener->getTransactionDetails($arrAccntyearlyData);
                
                #fetch indirect income ledger transaction w.r.t. the array of periods
                $arrAccntyearlyindirectIncomeData = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['indirectincome']['ledgerIds'],'behaviour'=>"income",'operating_type'=>"indirect");
                $arrTransactionDetails['indirectincome'] = $this->YearlyPeriodListener->getTransactionDetails($arrAccntyearlyindirectIncomeData);
                //$arrTransactionDetails['indirectincome'] = $this->accountreporting->accountreporting('YearlyPeriod:getTransactionDetails', $arrAccntyearlyindirectIncomeData);
                
                #fetch direct expense ledger transaction w.r.t. the array of periods
                $arrAccntyearlyDirectExpenseData = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['directexpense']['ledgerIds'],'behaviour'=>"expense",'operating_type'=>"direct");
               /* echo "<pre>";
                print_r($arrAccntyearlyDirectExpenseData);exit;*/
                $arrTransactionDetails['directexpense'] = $this->YearlyPeriodListener->getTransactionDetails($arrAccntyearlyDirectExpenseData);
                //$arrTransactionDetails['directexpense'] = $this->accountreporting->accountreporting('YearlyPeriod:getTransactionDetails', $arrAccntyearlyDirectExpenseData);
                
                #fetch indirect expense ledger transaction w.r.t. the array of periods
                $arrAccntyearlyIndirectExpenseData = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['indirectexpense']['ledgerIds'],'behaviour'=>"expense",'operating_type'=>"indirect");
                $arrTransactionDetails['indirectexpense'] = $this->YearlyPeriodListener->getTransactionDetails($arrAccntyearlyIndirectExpenseData);
                //$arrTransactionDetails['indirectexpense'] = $this->accountreporting->accountreporting('YearlyPeriod:getTransactionDetails', $arrAccntyearlyIndirectExpenseData);
                break;
            case 'monthly':
            default :
                #fetch direct income ledger transaction w.r.t. the array of periods
                $arrledgerTrans = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['directincome']['ledgerIds'],'behaviour'=>"income",'operating_type'=>"direct");
                $arrTransactionDetails['directincome'] = $this->MonthlyPeriodListener->getTransactionDetails($arrledgerTrans);
                //$arrTransactionDetails['directincome'] = $this->accountreporting->accountreporting('MonthlyPeriod:getTransactionDetails', $arrledgerTrans);
                
                #fetch indirect income ledger transaction w.r.t. the array of periods
                $arrledgerTrans = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['indirectincome']['ledgerIds'],'behaviour'=>"income",'operating_type'=>"indirect");
                $arrTransactionDetails['indirectincome'] = $this->MonthlyPeriodListener->getTransactionDetails($arrledgerTrans);
                //$arrTransactionDetails['indirectincome'] = $this->accountreporting->accountreporting('MonthlyPeriod:getTransactionDetails', $arrledgerTrans);
                
                #fetch direct expense ledger transaction w.r.t. the array of periods
                $arrledgerTrans = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['directexpense']['ledgerIds'],'behaviour'=>"expense",'operating_type'=>"direct");
                $arrTransactionDetails['directexpense'] = $this->MonthlyPeriodListener->getTransactionDetails($arrledgerTrans);
                //$arrTransactionDetails['directexpense'] = $this->accountreporting->accountreporting('MonthlyPeriod:getTransactionDetails', $arrledgerTrans);
                
                #fetch indirect expense ledger transaction w.r.t. the array of periods
                $arrledgerTrans = array( 'transdate'=>$arrPreparePeriodDetails,"ledgerID"=>$arrLedgerDetails['indirectexpense']['ledgerIds'],'behaviour'=>"expense",'operating_type'=>"indirect");
                $arrTransactionDetails['indirectexpense'] = $this->MonthlyPeriodListener->getTransactionDetails($arrledgerTrans);	
                //$arrTransactionDetails['indirectexpense'] = $this->accountreporting->accountreporting('MonthlyPeriod:getTransactionDetails', $arrledgerTrans);
                break;
        }
        /*echo "<pre>";
        print_r($arrTransactionDetails);*/
        
        if(!empty($arrTransactionDetails)){
            foreach ($arrTransactionDetails as $ledgerType => $TransactionDetails){
                if(!empty($TransactionDetails)){
                    $buildHierachy = array();
                    $arrLedgerDetails1 = array();
                    
                    $arrLedgerDetails1 = $arrLedgerDetails[$ledgerType]['ledgerhierarchy'];
                    //echo $ledgerType;
                    $buildHierachy = array('rs_group_hierarchy' => $arrLedgerDetails1, 'rs_report_data' => $TransactionDetails);
                    //$arrLedgerDetailsnew[$ledgerType] = $this->accountreporting->accountreporting('reporttransactiontotal:getTransactionTotals',$buildHierachy );
                    $arrLedgerDetailsnew[$ledgerType] = $this->ReporttransactiontotalListener->getTransactionTotals($buildHierachy);
                    //echo "<pre>";print_r($arrLedgerDetailsnew[$ledgerType]);exit();
                    $total_pnl_element = count($arrLedgerDetails[$ledgerType]['ledgerhierarchy']) -1;
                    if( !isset($net_total_array[$pnl_element]) ) { $net_total_array[$pnl_element] = array(); }
                    
                    $arrLedgerHierachyDetails = array('arrLedgerHierachyDetails'=>$arrLedgerDetailsnew[$ledgerType],);
                    $net_total_array[$ledgerType] = $this->ReporttransactiontotalListener->getNetTotalLedgers($arrLedgerHierachyDetails);
                   // $net_total_array[$ledgerType] = $this->accountreporting->accountreporting('reporttransactiontotal:getNetTotalLedgers',$arrLedgerHierachyDetails );            
                }
            }
        }
        
        #render output appropriately
        if(!empty($arrPostData) ){
            
        }else{
            $arrtableheader = array();
            $totalcolumn = 1;
            for($i = $intfystart ; $i < ($intfystart + 12);$i++){
                $j = ($i > 12) ? $i-12 : $i;
                if(strtotime(date("Y-m-d")) < strtotime(date("Y").'-'.$j.'-01')){ break; }
                $strheader = date("M Y",strtotime(date("Y").'-'.$j.'-01'));
                $arrtableheader[] = $strheader;
                $totalcolumn++;
            }
        }
        
        $arrCalGrossExportData = array("arrPreparePeriodDetails"=>$arrPreparePeriodDetails, 'net_total_array'=> $net_total_array,'type'=>$type);
        $arrgrossProfitTotal = $this->ReporttransactiontotalListener->grossProfitTotal($arrCalGrossExportData);
        //$arrgrossProfitTotal = $this->accountreporting->accountreporting('reporttransactiontotal:grossProfitTotal',$arrCalGrossExportData );
        
        $arrCalNetExportData = array("arrPreparePeriodDetails"=>$arrPreparePeriodDetails, 'net_total_array'=> $net_total_array,'type'=>$type,'income_from_operation'=>$arrgrossProfitTotal);
        $arrNetProfit = $this->ReporttransactiontotalListener->netProfitTotal($arrCalNetExportData);
        //$arrNetProfit = $this->accountreporting->accountreporting('reporttransactiontotal:netProfitTotal',$arrCalNetExportData );
        
        $arrdownloadformat = array('pdf','excel');
        if(!empty($downloadformat) && in_array($downloadformat, $arrdownloadformat)){
            $net_total_array = $data['net_total_array'];
            $arrexportData = array("arrPreparePeriodDetails" => $arrPreparePeriodDetails,"arrgrossProfitTotal"=>$arrgrossProfitTotal,"arrNetProfit"=>$arrNetProfit,"format"=>$downloadformat,"For"=> "profit_and_loss","hierarchyLedgerDetails"=>$arrLedgerDetailsnew, 'net_total_array'=> $net_total_array,'type'=>$type);
            //$this->exportEvent->exportDocument('accountsreportexport:'.$downloadformat.'Docs',$arrexportData );
            exit();
            $this->view->disable();  
            
        }elseif( !empty($downloadformat) && ($downloadformat== 'array') ) {
            return $arrNetProfit;
        }
       //echo "<pre>"; print_r($unit_start_date_year);
        $data["hierarchyLedgerDetails"] = $arrLedgerDetailsnew; 
        $data["lstYear"] = $lstYear; 
        $data["intfystart"] = $intfystart; 
        $data["lstMonth"] = $lstMonth; 
        $data["arrgrossProfitTotal"] = $arrgrossProfitTotal; 
        $data["arrNetProfit"] = $arrNetProfit; 
        $data["uptoMonth"] = $uptoMonth; 
        $data["arrbehaviour"] = $arrbehaviour; 
        $data["arrLedgerDetails"] = $arrLedgerDetails; 
        $data["arrPreparePeriodDetails"] = $arrPreparePeriodDetails; 
        $data["arrTransactionDetails"] = $arrTransactionDetails; 
        $data["net_total_array"] = $net_total_array; 
        $data["arrtableheader"] = $arrtableheader;
        $data["type"] = $type;
        $data["unit_start_date_year"] = $unit_start_date_year;
       
        $this->load->view('viewPL',$data);

		$this->footer->index();

    }

     public function calulateMonthsAction()
    {
        
        
       $lstYear  = $_POST['lstYear'];
        $arrYear = explode("-", $lstYear);
        $arrYear[1] = isset($arrYear[1]) ? $arrYear[1]  : $arrYear[0];
        
        //$arrdetails = array('soc_id'=> $this->session->get("auth")["soc_id"]);
       // $arrfy_details = $this->accountreporting->accountreporting('reporttransactiontotal:get_unit_start_date', $arrdetails);
       $arrfy_details = $this->ReporttransactiontotalListener->get_unit_start_date();
       //echo "<pre>";
       //print_r($arrfy_details);
       //echo "aaa".$arrfy_details['arraccountStartMaster'][0]['fy_start_from'];
        $startMonth = explode("-",$arrfy_details['arraccountStartMaster'][0]['fy_start_from']);
        //echo "start month:";
        //print_r($startMonth);
        $lastMonth = 12;
        $currntYearFlag = 0;
        if($arrYear[0] == $arrYear[1]){
            $currntYearFlag  = (date("Y") == $arrYear[0] ) ? 1: 0;
        }else{
            if((($arrYear[1])  == (date("Y")+1) && date("Y") == $arrYear[0]) || date("Y") == $arrYear[0]){
                $currntYearFlag  = 1;
            }
        }
        if($currntYearFlag == 1 ){
                $lastMonth = 12 - date("m") + 1 + intval($startMonth[0]);
        }
        $fystartdate= $arrYear[0]."-".$arrfy_details['arraccountStartMaster'][0]['fy_start_from'];
        
        $arrMonth = array();
        for($i = 0; $i< $lastMonth;$i++){
            $j = intval($startMonth[0]) + $i;
            $j = ($j > 12) ? $j - 12 : $j;
            $arrMonth[$i]['Monthkey'] = $j;
            $arrMonth[$i]['Monthvalue'] = date("M Y", strtotime($fystartdate ." +".$i." months"));
        }
        $finalMonths['Months'] = $arrMonth;
        
        echo json_encode($finalMonths);
        exit;
    }

    public function addGroup() {
    	//error_reporting(E_ALL);
    	$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		$where =  'entity_type != 3';
 	 	$led_data = $this->account_model->getDataWhereOrder('*',$grp_table,$where,'parent_id','asc');

		$ret_arr = $this->helper_model->_getLedGrpListRecur($led_data, array(), 0, array(), $entity_type="group");
		
		$ledger_data = $this->selectEnhanced->__construct("lstParentAccount", $ret_arr[0], array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;},
                                                'operating_type' => function($arr){return isset($arr['operating_type'])? $arr['operating_type']:false;},        
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;},
                                                                             'operating_type' => function($arr){return isset($arr['operating_type'])? $arr['operating_type']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )));


		 
		$data['lstParentAccount'] = $this->selectEnhanced->render("",'lstParentAccount','lstParentAccount','');		
		$account_nature = array("Income" => "cr", "Expense" => "dr", "Asset" => "dr");
		$this->load->view('addGroup',$data);
		$this->footer->index();

    	

    	/*$select = " * ";
		$transaction_table = LEDGER_TABLE ;
		 
		$where =  array('entity_type' =>  "main" );
 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);
 	 	echo "<pre>";
 	 	print_r($led_data);exit;
 	 	$this->load->view('viewPL',$data);

		$this->footer->index();*/

    }

    public function editEntity($id) {
    	//error_reporting(E_ALL);
    	$this->header->index($this->active);
    	$ledger_id = $id;
    	
    	$grp_table = LEDGER_TABLE;
    	$led_details = $this->account_model->getLedger($ledger_id);
    	
    	$data['parent_id'] = isset($led_details[0]['parent_id']) ? $led_details[0]['parent_id'] : "";
    	$data['entity_type'] = isset($led_details[0]['entity_type']) ? $led_details[0]['entity_type'] : "";
    	$data['entity_name'] = isset($led_details[0]['ledger_account_name']) ? $led_details[0]['ledger_account_name'] : "";
    	$data['ledger_type'] = isset($led_details[0]['nature_of_account']) ? $led_details[0]['nature_of_account'] : "";
    	$data['op_type'] = isset($led_details[0]['operating_type']) ? $led_details[0]['operating_type'] : "";
    	$data['led_id'] = $id;
		$where =  'entity_type != 3';
 	 	

 	 	$led_data = $this->account_model->getDataWhereOrder('*',$grp_table,$where,'parent_id','asc');

		$ret_arr = $this->helper_model->_getLedGrpListRecur($led_data, array(), 0, array(), $entity_type="group");
		
		$ledger_data = $this->selectEnhanced->__construct("lstParentAccount", $ret_arr[0], array(
                                'useEmpty' => true,
                                'emptyText' => '--Select--',
                                'options' => array(
                                                'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;},
                                                'operating_type' => function($arr){return isset($arr['operating_type'])? $arr['operating_type']:false;},        
                                                'children' =>  array(
                                                                "type" => GROUP_CHILDREN_OPTION_DIS,
                                                                'options' => array (
                                                                             'nature' =>  function($arr){return isset($arr['nature'])? $arr['nature']:false;},
                                                                             'entity_type' =>  function($arr){return isset($arr['entity_type'])? $arr['entity_type']:false;},
                                                                             'behaviour' => function($arr){return isset($arr['behaviour'])? $arr['behaviour']:false;},
                                                                             'operating_type' => function($arr){return isset($arr['operating_type'])? $arr['operating_type']:false;}
                                                                  )
                                    
                                                 )                    
                                                         
                                 )));


		 
		$data['lstParentAccount'] = $this->selectEnhanced->render("",'lstParentAccount','lstParentAccount','');		
		$account_nature = array("Income" => "cr", "Expense" => "dr", "Asset" => "dr");
		$this->load->view('addGroup',$data);
		$this->footer->index();

    	

    	/*$select = " * ";
		$transaction_table = LEDGER_TABLE ;
		 
		$where =  array('entity_type' =>  "main" );
 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);
 	 	echo "<pre>";
 	 	print_r($led_data);exit;
 	 	$this->load->view('viewPL',$data);

		$this->footer->index();*/

    }

    public function addgroupSubmit() {

    	/*echo "<pre>";
    	print_r($_POST);exit();*/
    	$leg_name = isset($_POST['entity_name']) ? $_POST['entity_name'] : "";
    	$ledger_type = isset($_POST['ledger_type']) ? $_POST['ledger_type'] : "";
    	$parent_id = isset($_POST['lstParentAccount']) ? $_POST['lstParentAccount'] : "";
    	$nature = isset($_POST['nature']) ? $_POST['nature'] : "";
    	$behaviour = isset($_POST['behaviour']) ? $_POST['behaviour'] : "";
    	$op_type = isset($_POST['op_type']) ? $_POST['op_type'] : "";
    	if($behaviour == "asset") {
    		$reporting_head = BALANCE_SHEET;
    	} else {
 	 		$reporting_head = PROFIT_AND_LOSS;
 	 	}
 	 	$nature_of_account = $nature;
 	 	$op_type = $op_type;
 	 	$context = $leg_name;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $leg_name,
		'parent_id' => $parent_id,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => 0,
		'context' => $context,
		'ledger_start_date' => date('Y-m-d h:i:s'),
		'behaviour' => $behaviour,
		'operating_type' => $op_type,
		'entity_type' => $ledger_type,
		'defined_by' => 1,
		'status' => '1',
		'added_by' => '1',
		'added_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$this->db->trans_begin();
 	  
 		 
 	 		$ledger_id = $this->account_model->saveData($legertable,$leddata);

 	 		if($ledger_type=="ledger") {
	 		// transaction data data insertion start
			$trans_data = array(
			'transaction_date' => date('Y-m-d h:i:s'),
			'ledger_account_id' => $ledger_id,
			'ledger_account_name' => $leg_name,
			'transaction_type' => $nature_of_account,
			'transaction_amount' => 0.00,
			'txn_from_id' => 0,
			'memo_desc' => 'Initial entry for account creation',
			'added_by' => 1,
			'added_on' => date('Y-m-d h:i:s')
			);
			$transaction_table =  TRANSACTION_TABLE;

			 
			 // transaction
			$transaction_id = $this->account_model->saveData($transaction_table,$trans_data);
			} else {
			$transaction_id = 1;	
			}

			if(isset($ledger_id) && !empty($ledger_id) && isset($transaction_id) && !empty($transaction_id)){
				//$this->session->set_msg(array('status' => 'success','msg'=>'Driver '));
				$this->db->trans_commit();
				$response['success'] = true;
				$response['error'] = false;
				$response['successMsg'] = "Entity Added Successfully";
				$response['redirect'] = base_url()."account/ledgerList";

			}else{
				$this->db->trans_rollback();
					$response['error'] = true;
					$response['success'] = false;
				$response['errorMsg'] = "Error!!! Please contact IT Dept";
			}
			echo json_encode($response);
    }


     public function updateGroup() {
     	error_reporting(E_ALL);
    	/*echo "<pre>";
    	print_r($_POST);exit();*/
    	$leg_name = isset($_POST['entity_name']) ? $_POST['entity_name'] : "";
    	$ledger_type = isset($_POST['ledger_type']) ? $_POST['ledger_type'] : "";
    	$parent_id = isset($_POST['lstParentAccount']) ? $_POST['lstParentAccount'] : "";
    	$nature = isset($_POST['nature']) ? $_POST['nature'] : "";
    	$behaviour = isset($_POST['behaviour']) ? $_POST['behaviour'] : "";
    	$op_type = isset($_POST['op_type']) ? $_POST['op_type'] : "";
    	$led_id = isset($_POST['led_id']) ? $_POST['led_id'] : "";
    	if($behaviour == "asset") {
    		$reporting_head = BALANCE_SHEET;
    	} else {
 	 		$reporting_head = PROFIT_AND_LOSS;
 	 	}
 	 	$nature_of_account = $nature;
 	 	$op_type = $op_type;
 	 	$context = $leg_name;
 	 	// ledger data preparation

 	 	$leddata = array(
		'ledger_account_name' => $leg_name,
		'parent_id' => $parent_id,
		'report_head' => $reporting_head,
		'nature_of_account' => $nature_of_account,
		'context_ref_id' => 0,
		'context' => $context,
		'behaviour' => $behaviour,
		'operating_type' => $op_type,
		'entity_type' => $ledger_type,
		'updated_by' => '1',
		'updated_on' => date('Y-m-d h:i:s'));
 	 	//Insert Ledger data with Deriver Id
 	 	$legertable =  LEDGER_TABLE;
 	 	$this->db->trans_begin();
 	  
 		 
 		//$ledger_id = $this->account_model->saveData($legertable,$leddata);

	 	$update_value = $led_id;
	 	$updat_column_Name = "ledger_account_id";
	 	$update_id = $this->account_model->updateData($legertable,$leddata,$updat_column_Name,$update_value);         		

		if(isset($update_id) && !empty($update_id)){
			//$this->session->set_msg(array('status' => 'success','msg'=>'Driver '));
			$this->db->trans_commit();
			$response['success'] = true;
			$response['error'] = false;
			$response['successMsg'] = "Entity Updated Successfully";
			$response['redirect'] = base_url()."account/ledgerList";

		}else{
			$this->db->trans_rollback();
				$response['error'] = true;
				$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
		}
		echo json_encode($response);
    }



    public function groupList()
	{
		$this->header->index($this->active);
		 
		$grp_table = LEDGER_TABLE;
		$where =  'entity_type != 3';
 	 	$led_data = $this->account_model->getDataWhereOrder('*',$grp_table,$where,'parent_id','asc');

		$ret_arr = $this->helper_model->_getLedGrpListRecur($led_data, array(), 0, array(), $entity_type="group");
		$data['ledgers'] = $ret_arr[0];
		$this->load->view('groupList',$data);
		$this->footer->index();
	}

	/*public function ledgerDelete(){

        $ledger_id = $_POST['id'];
        
 	 	if(isset($ledger_id) && !empty($ledger_id)) {

 	 	$select = " * ";
		$transaction_table = TRANSACTION_TABLE ;
	 	$this->db->trans_begin();
		$where =  array('ledger_account_id' =>  $ledger_id );
 	 	$led_data = $this->account_model->getall($select,$transaction_table,$where);

 	 	foreach ($led_data as $led_data) {
	 		$trans_data = array(
		'ledger_account_name' => $account_name,
		'transaction_type' => $nature_of_account,
		'payment_reference' => $account_no,
		'updated_by' => 1,
		'updated_on' => date('Y-m-d h:i:s')
		);
	 		//$trans_data = 'ledger_account_id';
		$trans_column = "txn_id";
		$transaction_table =  TRANSACTION_TABLE;
		$trans_id = $led_data->txn_id;	

		$trans_result = $this->helper_model->delete($transaction_table,$trans_column,$trans_id);	
			


		}

		 
 	   	$ledgertable =  LEDGER_TABLE;
    	$resultMaster = $this->helper_model->delete($ledgertable,'ledger_account_id',$ledger_id);	
 	 
 	 	}
    
		if(empty($resultMaster) || $resultMaster == false) {

			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";
		
		} else {
			$this->db->trans_commit();
			$response['success'] = true;
			$response['successMsg'] = "Ledger Deleted Successfully";	
		}
		
	 	echo json_encode($response);
 	}*/

 	 /**
     * The Component action `disableLedger` is to Change status of ledger
     * @method disableLedger.
     * @access public
     * @param INT $ledger_id
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function disableLedger($ledger_id) {
        
        $ledger_id = $_POST['id'];
        if(isset($ledger_id) && !empty($ledger_id)) {
        	$select = " * ";
			$ledger_table = LEDGER_TABLE ;
			$where =  array('ledger_account_id' =>  $ledger_id );
		 	$ledger = $this->account_model->getLedger($ledger_id);
		 	$data = $ledger;
		 	$ledger_table = LEDGER_TABLE; 
		 	$updat_column_Name = "ledger_account_id";
		 	$pre_status = $data[0]['status'];
        	 

        	while(!empty($data[0]['parent_id']) && $data[0]['parent_id']!= 0 && $data[0]['parent_id']!= ''){
			
    			if(!empty($data[0]['parent_id']) && $data[0]['parent_id']!=1 && $data[0]['status']==0) {
		            $leger_parent = $this->account_model->getLedger($data[0]['parent_id']);
		            $data[0]['parent_id'] = $leger_parent[0]['parent_id'];
		        } else {
		            $data[0]['parent_id'] = 0;
		        }

		        if($leger_parent[0]['status'] == 0) {
		        	$inactive_status = 0;
		        } else {
		        	$active_status = 1;
		        }
			}

			if(isset($inactive_status) && $inactive_status == 0) {
				$status = 0;
			} else {

				if($ledger[0]['status'] == 0) {
					$status = 1; 
				} else {
					$status = 0; 
				}
			}

			$update_data =  array('status' => $status);
		 	$update_value = $ledger_id;
		 	$update_id = $this->account_model->updateData($ledger_table,$update_data,$updat_column_Name,$update_value);         		
        }

        	if(empty($update_id) || $update_id == false) {

			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";

		
			} else {
				 
				$response['success'] = true;
				if($pre_status == $status) {
				$response['successMsg'] = "Ledger Group is not Enabled";
				$response['isredirect']	= 0;
				}else if($status == 1) {
				$response['successMsg'] = "Ledger Enabled Successfully";
				$response['isredirect']	= 1;
				} else{
				$response['successMsg'] = "Ledger Disabled Successfully";
				$response['isredirect']	= 1;	
				}


				$response['redirect'] = base_url()."account/ledgerList";	
			}

			echo json_encode($response);
        
    }
    
    /**
     * The Component action `disableGroup` is to Change status of group aand its children
     * @method disableGroup.
     * @access public
     * @param INT $group_id
     * @var integer $soc_id
     * @see _getLedgerChildren()
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
   public function disableGroup($ledger_id) {
        
        $ledger_id = $_POST['id'];
        if(isset($ledger_id) && !empty($ledger_id)) {
        	$select = " * ";
			$ledger_table = LEDGER_TABLE ;
			$where =  array('ledger_account_id' =>  $ledger_id );
		 	$ledger = $this->account_model->getLedger($ledger_id);
		 	$data = $ledger;
		 	$ledger_table = LEDGER_TABLE; 
		 	$updat_column_Name = "ledger_account_id";
		 	$pre_status = $data[0]['status'];
        	 

        	while(!empty($data[0]['parent_id']) && $data[0]['parent_id']!= 0 && $data[0]['parent_id']!= ''){
			
    			if(!empty($data[0]['parent_id']) && $data[0]['parent_id']!=1 && $data[0]['status']==0) {
		            $leger_parent = $this->account_model->getLedger($data[0]['parent_id']);
		            $data[0]['parent_id'] = $leger_parent[0]['parent_id'];
		        } else {
		            $data[0]['parent_id'] = 0;
		        }

		        if($leger_parent[0]['status'] == 0) {
		        	$inactive_status = 0;
		        } else {
		        	$active_status = 1;
		        }
			}

			if(isset($inactive_status) && $inactive_status == 0) {
				$status = 0;
			} else {

				if($ledger[0]['status'] == 0) {
					$status = 1;
					$flag = 1; 
				} else {
					$status = 0; 
				}
			}
			 if($flag != 1) {
		        $this->_getLedgerChildren($ledger_id, $status );
	        }
			$update_data =  array('status' => $status);
		 	$update_value = $ledger_id;
		 	$update_id = $this->account_model->updateData($ledger_table,$update_data,$updat_column_Name,$update_value);         		
        }

        	if(empty($update_id) || $update_id == false) {

			$response['success'] = false;
			$response['successMsg'] = "Error!!! Please contact IT Dept";

		
			} else {
				 
				$response['success'] = true;
				if($pre_status == $status) {
				$response['successMsg'] = "Parent Group is not Enabled";
				$response['isredirect']	= 0;
				}else if($status == 1) {
				$response['successMsg'] = "Group Enabled Successfully";
				$response['isredirect']	= 1;
				} else{
				$response['successMsg'] = "Group Disabled Successfully";
				$response['isredirect']	= 1;	
				}


				$response['redirect'] = base_url()."account/groupList";	
			}
			
			echo json_encode($response);
        
    }



    /**
     * The Component action `_getLedgerChildren` is to get children
     * @method _getLedgerChildren.
     * @access public
     * @param integer $id
     * @param string $status
     * @see _getLedgerChildren()
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function _getLedgerChildren($id, $status)
    {
        $ledger = $this->account_model->getParent($id);
        $updat_column_Name = "ledger_account_id";
        $ledger_table = LEDGER_TABLE ;
        foreach ($ledger as $ldg) {
            
            $ldg->status = $status;
            $update_data =  array('status' => $status);
		 	$update_value = $ldg['ledger_account_id'];
		 	$update_id = $this->account_model->updateData($ledger_table,$update_data,$updat_column_Name,$update_value);         		
            if ( $update_id ) {
                
            } else {
                
            }
            $this->_getLedgerChildren($ldg['ledger_account_id'], $status);
            
        }
    }
 
}
