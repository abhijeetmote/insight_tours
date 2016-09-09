<?php error_reporting(1); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('account/account_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		//SelectEnhanced
		//$this->load->library('session');
		
	}

	public function addAccount()
	{
		$this->header->index();
		
		
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
 	 	$reporting_head = REPORT_HEAD_EXPENSE;
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
        $this->header->index();
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

		$this->header->index();
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
		
		$this->header->index();
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
					$response['redirect'] = base_url()."account/ledgerList";
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
		$this->header->index();
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
    	$this->header->index();
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
		$this->header->index();
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
 
}
