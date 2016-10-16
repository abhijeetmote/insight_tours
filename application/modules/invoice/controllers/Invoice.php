<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('Invoice/Invoice_model');
		$this->load->model('helper/helper_model');
		$this->load->model('helper/selectEnhanced');
		$this->load->model('helper/selectEnhanced_to');
		$this->active = "invoice";
	}

	public function InvoiceList()
	{
		$tableName =  'invoice_master im, booking_master bm , customer_master cm ';
 		$select = 'im.*,cm.cust_firstname,cm.cust_lastname';
 		$where =  'cm.cust_id = bm.cust_id and bm.booking_id = im.booking_id';
		$data['invoiceList'] = $this->Invoice_model->getwheredata($select,$tableName,$where);
		
		//echo "<pre>"; print_r($data); exit();
		$this->header->index($this->active);
		$this->load->view('InvoiceList',$data);
		$this->footer->index();
	}

	public function invoicePaid()
	{
		$invoiceId = $this->uri->segment(3);

		$tableName =  'invoice_master im, booking_master bm , customer_master cm ';
 		$select = 'cm.ledger_id';
 		$where =  "cm.cust_id = bm.cust_id and bm.booking_id = im.booking_id and im.invoice_id = '$invoiceId'";
		$customerDetails = $this->Invoice_model->getwheredata($select,$tableName,$where);
		
		$this->header->index($this->active);
		$grp_table = LEDGER_TABLE;
		 

		$ledger_data = $this->Invoice_model->getDataOrder('*',$grp_table,'parent_id','asc');
		//echo "<pre>";
		//print_r($ledger_data);
		$ret_arr = $this->helper_model->_getLedGrpListRecur($ledger_data, array(), 0, array(), $entity_type="");
		$filter_param_from = array('bank','cash');
		
		$filter_ledgers_from = $this->helper_model->sorted_array($ret_arr[0],0,$filter_param_from);
		//echo "test";exit;
		//print_r($filter_ledgers_from);exit;
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
		$data['invoiceId'] = $invoiceId;
		$data['ledgerId'] = $customerDetails[0]->ledger_id;

		$this->load->view('invoicePaid',$data);
		$this->footer->index();
	}

	public function invoicePaidSubmit(){
		//error_reporting(E_ALL);
		$from_ledger = $_POST['from_ledger'];

		$payment_mode = $_POST['payment_mode'];
		//echo json_encode($payment_mode);exit();
		@$invoiceId = $_POST['invoiceId'];
		$customerLedgerId = $_POST['customerLedger'];


		$select = "booking_id,duty_sleep_id,total_amount,invoice_no";
		$tableName = "invoice_master";
		$column = 'invoice_id';
		$value = $invoiceId;
		$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);
		//echo json_encode($invoiceData);exit();
		if(!empty($invoiceData)){
			$invoice_no = $invoiceData[0]->invoice_no;
			$total_amount = $invoiceData[0]->total_amount;
			$data = array(
				'payment_status' => 'paid'
			);
			$columnName = "invoice_id";
			$value = $invoiceId;

			$this->db->trans_begin();

			$result = $this->Invoice_model->updateData($tableName,$data,$columnName,$value);
			if($result == true){

				$tableName = "duty_sleep_master";
				$data = array(
					'payment_status' => 1
				);
				$columnName = "duty_sleep_id";
				$value = $invoiceData[0]->duty_sleep_id;
				$this->Invoice_model->updateData($tableName,$data,$columnName,$value);

				$cr = CR;
		 		$dr = DR;
		 		$select = "*";
				$ledgertable = LEDGER_TABLE ;
				//echo "aa";
		 	 	$where =  "ledger_account_id = '$customerLedgerId'";
		 		$ledger_details = $this->Invoice_model->getwheresingle($select,$ledgertable,$where);

		 		$from_ledger_name = $ledger_details->ledger_account_name;
 	 
		 		// transaction data data insertion start
			 	$from_data = array(
					'transaction_date' => date('Y-m-d h:i:s'),
					'ledger_account_id' => $customerLedgerId,
					'ledger_account_name' => $from_ledger_name,
					'transaction_type' => $dr,
					'payment_reference' => $invoice_no,
					'transaction_amount' => $total_amount,
					'txn_from_id' => 0,
					'memo_desc' => INVOICE_PAID_NARRATION,
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')
				);
				$transaction_table =  TRANSACTION_TABLE;

				//From transaction
			 	$from_transaction_id = $this->Invoice_model->saveData($transaction_table,$from_data);
			 

			 	//to leadger trans data insertion start
			 	if(isset($from_transaction_id) && !empty($from_transaction_id)) {
					$select = " * ";
					$ledgertable = LEDGER_TABLE ;

				 	$where =  "ledger_account_id = '$from_ledger'";
					$ledger_details = $this->Invoice_model->getwheresingle($select,$ledgertable,$where);
					
				 	$to_ledger_name = $ledger_details->ledger_account_name;
				 	 
					  
				 	// transaction data data insertion start
					 $to_data = array(
							'transaction_date' => date('Y-m-d h:i:s'),
							'ledger_account_id' => $from_ledger,
							'ledger_account_name' => $to_ledger_name,
							'transaction_type' => $dr,
							'payment_reference' => $invoice_no,
							'transaction_amount' => $total_amount,
							'txn_from_id' => $from_transaction_id,
							'memo_desc' => INVOICE_PAID_NARRATION,
							'added_by' => 1,
							'added_on' => date('Y-m-d h:i:s')
						);
					$transaction_table =  TRANSACTION_TABLE;

					 //From transaction
					$to_transaction = $this->Invoice_model->saveData($transaction_table,$to_data);

					$data = array(
						'booking_status' => '3'
					);
					$tableName = "booking_master";
					$columnName = "booking_status";
					$value = $value = $invoiceData[0]->booking_id;

					$this->Invoice_model->updateData($tableName,$data,$columnName,$value);


			 	 	if(isset($to_transaction) && !empty($to_transaction)){
			 	 		$this->db->trans_commit();
			 	 		$response['success'] = true;
						$response['successMsg'] = "Successfully Updated";
						$response['redirect'] = base_url()."invoice/invoiceGenerate/".$invoiceId;
			 	 	} else {
				 		$this->db->trans_rollback();
			 		}

			 	} else {
			 		$this->db->trans_rollback();
			 		$response['error'] = true;
			 		$response['success'] = false;
					$response['errorMsg'] = "Error!!! Please contact IT Dept";
			 	}
			}
		}else{
			$response['success'] = false;
			$response['error'] = error;
			$response['errorMsg'] = "Undefined Invoice ID";
		}

		echo json_encode($response);
	}

	public function invoiceGenerate($invoiceId){
		$select = "booking_id,duty_sleep_id,total_amount,invoice_no";
		$tableName = "invoice_master";
		$column = 'invoice_id';
		$value = $invoiceId;
		$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);
		if(!empty($invoiceData)){

			$duty_sleep_id = $invoiceData[0]->duty_sleep_id;
			$booking_id = $invoiceData[0]->booking_id;
			$data['invoice_no'] = $invoiceData[0]->invoice_no;
			$data['invoiceId'] = $invoiceId;
			$select = "*";
			$tableName = "duty_sleep_master";
			$column = 'duty_sleep_id';
			$value = $duty_sleep_id;
			$data['dutySlipData'] = $this->Invoice_model->getData($select, $tableName, $column, $value);

			$tableName =  'customer_master c, booking_master b , package_master p ';
	 		$select = 'c.*,b.*,p.*';
	 		$where =  "c.cust_id = b.cust_id and p.package_id = b.package_id and b.booking_id = '$booking_id'";
	 		$data['booking'] = $this->Invoice_model->getwheredata($select,$tableName,$where);

	 		/*echo "<pre>";
	 		print_r($data);
	 		exit();*/

	 		$this->header->index($this->active);
			$this->load->view('invoicehtml', $data);
			$this->footer->index();
		}else{
			redirect("");
		}
	}

	public function invoicePdf($invoiceId)
    {
    	$select = "booking_id,duty_sleep_id,total_amount,invoice_no,invoice_date";
		$tableName = "invoice_master";
		$column = 'invoice_id';
		$value = $invoiceId;
		$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);
		if(!empty($invoiceData)){

			$duty_sleep_id = $invoiceData[0]->duty_sleep_id;
			$booking_id = $invoiceData[0]->booking_id;
			$data['invoice_no'] = $invoiceData[0]->invoice_no;
			$data['invoice_date'] = $invoiceData[0]->invoice_date;
			
			$tableName =  'duty_sleep_master d, vehicle_master v, driver_master dm';
	 		$select = 'd.*,v.vehicle_name,vehicle_no,dm.driver_fname';
	 		$where =  "v.vehicle_id = d.vehicle_id and dm.driver_id = d.driver_id and d.booking_id = '$booking_id'";
	 		$data['dutySlipData'] = $this->Invoice_model->getwheredata($select,$tableName,$where);

			$tableName =  'customer_master c, booking_master b , package_master p ';
	 		$select = 'c.*,b.*,p.*';
	 		$where =  "c.cust_id = b.cust_id and p.package_id = b.package_id and b.booking_id = '$booking_id'";
	 		$data['booking'] = $this->Invoice_model->getwheredata($select,$tableName,$where);

	 		$select = "*";
			$tableName = "passenger_details";
			$column = 'booking_id';
			$value = $booking_id;
			$data['passenger'] = $this->Invoice_model->getData($select, $tableName, $column, $value);

	 		/*echo "<pre>";
	 		print_r($data);
	 		exit();*/

	    	$this->load->helper('dompdf');

			$html = $this->load->view('individualPdf', $data, true);
			pdf_create($html, 'filename');

		}else{
			redirect("");
		}
    }

    public function dutySlipPdf()
    {
    	$this->load->helper('dompdf');
	     
		$html = $this->load->view('dutySlipPdf', $data, true);
		pdf_create($html, 'filename', array('Attachment' => 0));
    }

    public function individualPdf()
    {
    	$this->load->helper('dompdf');
	     
		$html = $this->load->view('individualPdf', $data, true);
		pdf_create($html, 'filename', array('Attachment' => 0));
    }

    public function corporatePdf()
    {
    	$this->load->helper('dompdf');
	     
		$html = $this->load->view('corporatePdf', $data, true);
		pdf_create($html, 'filename', array('Attachment' => 0));
    }
}
