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
		$c_type = $this->uri->segment(3);
		$from_date = $this->uri->segment(4);
		$to_date = $this->uri->segment(5);
		
		$where_extra = "";

		if($c_type == ""){
			$c_type = 1;
		}

		if(($from_date!="" && $to_date!="") && ($from_date!="0" && $to_date!="0"))   {
			if($c_type == 2){
				$data['month'] = $from_date;
				$data['year'] = $to_date;
				$where_extra .= " and im.completed_month = '$from_date' and im.completed_year = '$to_date'";
			}else{
				$data['from_date'] = $from_date;
				$data['to_date'] = $to_date;
				$from_date = date("Y-m-d", strtotime($from_date));
				$to_date = date("Y-m-d", strtotime($to_date));
				$where_extra .= " and invoice_start_date between '$from_date' and '$to_date'";
			}
		}

		if($c_type!="" && $c_type!="0") {
			$data['c_type'] = $c_type;
			$where_extra .= " and cm.cust_type_id = $c_type";
		}

		$tableName =  'invoice_master im, booking_master bm , customer_master cm ';
 		$select = 'im.*,cm.cust_firstname,cm.cust_lastname,cm.cust_compname,cm.cust_type_id';
 		$where =  'cm.cust_id = bm.cust_id and bm.booking_id = im.booking_id';
 		$where .= $where_extra;
		$data['invoiceList'] = $this->Invoice_model->getwheredata($select,$tableName,$where);

		$data['months'] = array('01' => 'JAN','02' => 'FEB','03' => 'MAR','04' => 'APR','05' => 'MAY',
						'06' => 'JUN','07' => 'JUL','08' => 'AUG','09' => 'SEP','10' => 'OCT',
						'11' => 'NOV','12' => 'DEC' );
		$current_year = date('Y');
		$next_year = $current_year + 1;
		$data['years'] =  array($current_year => $current_year, $next_year => $next_year);


		
		if($c_type == 2){
			$invoice = array();
			foreach ($data['invoiceList'] as $key => $value) {
				$invoice[$key] = get_object_vars($data['invoiceList'][$key]);
			}

			$invoice_data = array();
			$name = '';
			foreach ($invoice as $i => $value) {
				$key = array_search($name, array_column($invoice_data, 'cust_compname'));
				if($key !== false){
					$invoice_data[$key]['gross_amt'] += $invoice[$i]['gross_amt'];
					$invoice_data[$key]['service_tax_amt'] += $invoice[$i]['service_tax_amt'];
					$invoice_data[$key]['education_cess_amt'] += $invoice[$i]['education_cess_amt'];
					$invoice_data[$key]['sec_education_cess_amt'] += $invoice[$i]['sec_education_cess_amt'];
					$invoice_data[$key]['total_amount'] += $invoice[$i]['total_amount'];
					$invoice_data[$key]['adv_amount'] += $invoice[$i]['adv_amount'];
					$invoice_data[$key]['final_amount'] += $invoice[$i]['final_amount'];
					$invoice_data[$key]['tours'] += 1;
				}else{
					$name = $invoice[$i]['cust_compname'];
					array_push($invoice_data, $invoice[$i]);
					$invoice_data[$i]['tours'] = 1;
				}
			}

			$corporate = array();
			foreach ($invoice_data as $i => $value) {
				$corporate[$i] = (object) $value;
			}

			$data['invoiceList'] = $corporate;
		}



		$this->header->index($this->active);
		$this->load->view('InvoiceList',$data);
		$this->footer->index();
	}

	public function invoicePaid()
	{
		$final_invoiceId = $this->uri->segment(3);
		$cust_id = $this->uri->segment(4);
		
		$tableName =  'invoice_master im, booking_master bm , customer_master cm ';
 		$select = 'cm.ledger_id';
 		$where =  "cm.cust_id = bm.cust_id and bm.booking_id = im.booking_id and cm.cust_id = '$cust_id'";
		$customerDetails = $this->Invoice_model->getwheredata($select,$tableName,$where);


		$data['final_invoiceId'] = $final_invoiceId;
		$data['ledgerId'] = $customerDetails[0]->ledger_id;
		$data['cust_id'] = $cust_id;

		//echo "<pre>";print_r($data);exit();
		
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
		

		$this->load->view('invoicePaid',$data);
		$this->footer->index();
	}

	public function invoicePaidSubmit(){
		//error_reporting(E_ALL);
		$from_ledger = $_POST['from_ledger'];

		$payment_mode = $_POST['payment_mode'];
		//echo json_encode($payment_mode);exit();
		@$final_invoiceId = $_POST['final_invoiceId'];
		$customerLedgerId = $_POST['customerLedger'];
		$discount = $_POST['discount'];
		$tds = $_POST['tds'];
		/*$cust_type_id = $_POST['cust_type_id'];
		$completed_month = $_POST['completed_month'];
		$completed_year = $_POST['completed_year'];*/
		$cust_id = $_POST['cust_id'];


		
		$select = "final_amount";
		$tableName = "final_invoice_master";
		$column = 'final_invoice_id';
		$value = $final_invoiceId;
		$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);
		
		
		$final_amount = $invoiceData[0]->final_amount;

		if($discount != "" && is_numeric($discount)){
			$disc_data = array(
				'final_invoice_id' => $final_invoiceId,
				'discount' => $discount,
				'added_on' => date('Y-m-d h:i:s')
			);
			$disc_table =  "discount_transaction_master";

		 	$from_transaction_id = $this->Invoice_model->saveData($disc_table,$disc_data);
		 	$final_amount = $final_amount - $discount;
		}

		if($tds != "" && is_numeric($tds)){
			$tds_data = array(
				'final_invoice_id' => $final_invoiceId,
				'tds' => $tds,
				'added_on' => date('Y-m-d h:i:s')
			);
			$tds_table =  "tds_transaction_master";

		 	$from_transaction_id = $this->Invoice_model->saveData($tds_table,$tds_data);
		 	$final_amount = $final_amount - $tds;
		}
	 	
 		$data = array(
			'payment_status' => 'paid'
		);
		$columnName = "final_invoice_id";
		$value = $final_invoiceId;
		$tableName =  'invoice_master';

		$result = $this->Invoice_model->updateData($tableName,$data,$columnName,$value);

		$data = array(
			'payment_status' => 'paid'
		);
		$columnName = "final_invoice_id";
		$value = $final_invoiceId;
		$tableName =  'final_invoice_master';

		$result = $this->Invoice_model->updateData($tableName,$data,$columnName,$value);

		$this->db->trans_begin();

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
			'payment_reference' => $final_invoice_id,
			'transaction_amount' => $final_amount,
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
					'payment_reference' => $final_invoice_id,
					'transaction_amount' => $final_amount,
					'txn_from_id' => $from_transaction_id,
					'memo_desc' => INVOICE_PAID_NARRATION,
					'added_by' => 1,
					'added_on' => date('Y-m-d h:i:s')
				);
			$transaction_table =  TRANSACTION_TABLE;

			 //From transaction
			$to_transaction = $this->Invoice_model->saveData($transaction_table,$to_data);

	 	 	if(isset($to_transaction) && !empty($to_transaction)){
	 	 		$this->db->trans_commit();
	 	 		$response['success'] = true;
				$response['successMsg'] = "Successfully Updated";
				$response['redirect'] = base_url()."invoice/invoiceList";
	 	 	} else {
		 		$this->db->trans_rollback();
	 		}

	 	} else {
	 		$this->db->trans_rollback();
	 		$response['error'] = true;
	 		$response['success'] = false;
			$response['errorMsg'] = "Error!!! Please contact IT Dept";
	 	}
		

		echo json_encode($response);
	}

	public function invoiceGenerate()
	{
		$invoiceId = $this->uri->segment(3);
		$cust_id = $this->uri->segment(4);
		$cust_type_id = $this->uri->segment(5);
		$completed_month = $this->uri->segment(6);
		$completed_year = $this->uri->segment(7);

		if($cust_type_id == 1){
			$select = "*";
			$tableName = "invoice_master";
			$column = 'invoice_id';
			$value = $invoiceId;
			$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);
			if($invoiceData[0]->final_invoice_id != 0){
				$invoiceData = "";
			}
		}else{
			$tableName =  'invoice_master';
	 		$select = '*';
	 		$where =  "cust_id = '$cust_id' and completed_month = '$completed_month' and completed_year = '$completed_year' ";
			$invoiceData = $this->Invoice_model->getwheredata($select, $tableName, $where);
			if($invoiceData[0]->final_invoice_id != 0){
				$invoiceData = "";
			}
		}

		if(!empty($invoiceData)){
			$final_amount = 0;
			$gross_amt = 0;
			$service_tax_amt = 0;
			$education_cess_amt = 0;
			$sec_education_cess_amt = 0;
			$total_amount = 0;
			$adv_amount = 0;
			for ($i=0; $i < count($invoiceData); $i++) { 
				$gross_amt += $invoiceData[$i]->gross_amt;
				$service_tax_amt += $invoiceData[$i]->service_tax_amt;
				$education_cess_amt += $invoiceData[$i]->education_cess_amt;
				$sec_education_cess_amt += $invoiceData[$i]->sec_education_cess_amt;
				$total_amount += $invoiceData[$i]->total_amount;
				$adv_amount += $invoiceData[$i]->adv_amount;
				$final_amount += $invoiceData[$i]->final_amount;
			}

			
			$final_invoice_no = $this->generateRandomString(4);
			$final_invoice_data = array(
				'invoice_no' => $final_invoice_no,
				'cust_id' => $invoiceData[0]->cust_id,
				'payment_status' => "unpaid",
				'gross_amt' => $gross_amt,
				'service_tax_amt' => $service_tax_amt,
				'education_cess_amt' => $education_cess_amt,
				'sec_education_cess_amt' => $sec_education_cess_amt,
				'total_amount' => $total_amount,
				'adv_amount' => $adv_amount,
				'final_amount' => $final_amount,
				'completed_month' => $completed_month,
				'completed_year' => $completed_year,
				'added_by' => 1,
				'added_on' => date('Y-m-d h:i:s')
			);
			$final_invoice_table =  "final_invoice_master";
			//echo "<pre>";print_r($final_invoice_data);exit;
		 	$final_invoice_id = $this->Invoice_model->saveData($final_invoice_table,$final_invoice_data);

		 	$invoice_no = $invoiceData[$i]->invoice_no;

		 	for ($i=0; $i < count($invoiceData); $i++) { 
		 		$data = array(
					'final_invoice_id' => $final_invoice_id,
					'final_invoice_no' => $final_invoice_no
				);
				$columnName = "invoice_id";
				$value = $invoiceData[$i]->invoice_id;
				$tableName =  'invoice_master';

				$result = $this->Invoice_model->updateData($tableName,$data,$columnName,$value);
		 	}

		 	if($cust_type_id == 1){
				$this->individualInvoicePdf($invoiceId, $final_invoice_id, $final_invoice_no);
			}else{
				$this->corporateInvoicePdf($final_invoice_id);
			}
		}else{
			redirect(base_url()."invoice/invoiceList");
		}
	}

	public function individualInvoicePdf($invoiceId, $final_invoice_id, $final_invoice_no){
		$select = "booking_id,duty_sleep_id,total_amount,invoice_no,invoice_date,gross_amt,service_tax_amt,education_cess_amt,sec_education_cess_amt,final_amount,adv_amount";
		$tableName = "invoice_master";
		$column = 'invoice_id';
		$value = $invoiceId;
		$invoiceData = $this->Invoice_model->getData($select, $tableName, $column, $value);

		if(!empty($invoiceData)){

			$duty_sleep_id = $invoiceData[0]->duty_sleep_id;
			$booking_id = $invoiceData[0]->booking_id;
			$data['invoice_no'] = $final_invoice_no;
			$data['invoice_date'] = $invoiceData[0]->invoice_date;
			$data['total_amount'] = $invoiceData[0]->total_amount;
			$data['gross_amt'] = $invoiceData[0]->gross_amt;
			$data['service_tax_amt'] = $invoiceData[0]->service_tax_amt;
			$data['education_cess_amt'] = $invoiceData[0]->education_cess_amt;
			$data['sec_education_cess_amt'] = $invoiceData[0]->sec_education_cess_amt;
			$data['final_amount'] = $invoiceData[0]->final_amount;
			$data['adv_amount'] = $invoiceData[0]->adv_amount;
			
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
			$data['final_invoice_id'] = $final_invoice_id;

			$this->load->helper('dompdf');

			$html = $this->load->view('individualPdf', $data, true);
			pdf_create($html, $final_invoice_no, false);

			$this->header->index($this->active);
			$this->load->view('individualhtml', $data);
			$this->footer->index();

		}else{
			redirect("");
		}
	}

	public function invoicePdfMail()
	{
		$final_invoice_id = $_POST['final_invoice_id'];
		$tableName =  'customer_master cm, final_invoice_master fm ';
 		$select = 'cm.cust_email1,fm.invoice_no';
 		$where =  "cm.cust_id = fm.cust_id and fm.final_invoice_id = '$final_invoice_id'";
 		$data = $this->Invoice_model->getwheredata($select,$tableName,$where);

 		//echo $data[0]->cust_email1; exit();

		$this->load->helper('mail');
		mailer($data[0]->cust_email1, 'Invoice', 'Dear Customer,<br/><br/>Please find attachment', 'pdf/'.$data[0]->invoice_no.".pdf");
		echo json_encode('success');
	}

    public function corporateInvoicePdf($final_invoice_id)
    {
		/*$tableName =  'booking_master b, invoice_master im, final_invoice_master fm, customer_master c, package_master p, duty_sleep_master ds';
 		//$select = 'c.*,b.*,p.*';
 		$select = 'c.cust_compname,c.cust_address,c.cust_telno,fm.invoice_no,im.invoice_date,c.contact_per_name,fm.gross_amt,fm.service_tax_amt,fm.education_cess_amt,fm.sec_education_cess_amt,fm.total_amount,fm.adv_amount,fm.final_amount,ds.toll_fess,ds.parking_fees';
 		$where =  "c.cust_id = b.cust_id and p.package_id = b.package_id and b.booking_id = im.booking_id and b.duty_slip_id = im.duty_sleep_id and im.final_invoice_id = fm.final_invoice_id and im.final_invoice_id = '$final_invoice_id' ";
 		$invoice = $this->Invoice_model->getwheredata($select,$tableName,$where);

		

 		$tableName_toll =  'booking_master b, invoice_master im,duty_sleep_master ds,final_invoice_master fm';
 		//$select = 'c.*,b.*,p.*';
 		$select_toll = 'ds.toll_fess, ds.parking_fees';
 		$where_toll =  "b.booking_id = im.booking_id and im.final_invoice_id = fm.final_invoice_id and b.duty_slip_id = ds.duty_sleep_id and  im.final_invoice_id = '$final_invoice_id'";
 		$invoice_toll = $this->Invoice_model->getwheredata($select_toll,$tableName_toll,$where_toll);

 		//SELECT ds.toll_fess, ds.parking_fees FROM booking_master b, invoice_master im,duty_sleep_master ds,final_invoice_master fm WHERE  b.booking_id = im.booking_id and im.final_invoice_id = fm.final_invoice_id and b.duty_slip_id = ds.duty_sleep_id and  im.final_invoice_id = '1'

 		$tollfees = 0;
 		$parkingfees = 0;
 		for ($i=0; $i < count($invoice_toll); $i++) { 
 			 $tollfees += $invoice_toll[$i]->toll_fess;
 			 $parkingfees += $invoice_toll[$i]->parking_fees;
 			//echo "<br>";
 		}*/
 		//echo $tollfees;
 		//echo $parkingfees;

 		$tableName =  'booking_master b, invoice_master im, final_invoice_master fm, customer_master c, package_master p, duty_sleep_master ds';
 		//$select = 'c.*,b.*,p.*';
 		 $select = 'c.cust_compname,c.cust_address,c.cust_telno,fm.invoice_no,im.invoice_date,c.contact_per_name,fm.gross_amt,fm.service_tax_amt,fm.education_cess_amt,fm.sec_education_cess_amt,fm.total_amount,fm.adv_amount,fm.final_amount,ds.toll_fess,ds.parking_fees';
 		$where =  "c.cust_id = b.cust_id and p.package_id = b.package_id and b.booking_id = im.booking_id and im.final_invoice_id = fm.final_invoice_id and ds.duty_sleep_id = im.duty_sleep_id and im.final_invoice_id = '$final_invoice_id'";
 		$invoice = $this->Invoice_model->getwheredata($select,$tableName,$where);

 		 
 		$tollfees = 0;
 		$parkingfees = 0;
 		for ($i=0; $i < count($invoice); $i++) { 
 			$tollfees += $invoice[$i]->toll_fess;
 			$parkingfees += $invoice[$i]->parking_fees;
 		}

		if(!empty($invoice)){

	 		$data['cust_compname'] = $invoice[0]->cust_compname;
	 		$data['cust_address'] = $invoice[0]->cust_address;
	 		$data['cust_telno'] = $invoice[0]->cust_telno;
	 		$data['invoice_no'] = $invoice[0]->invoice_no;
	 		$data['invoice_date'] = $invoice[0]->invoice_date;
	 		$data['contact_per_name'] = $invoice[0]->contact_per_name;
	 		$data['gross_amt'] = $invoice[0]->gross_amt;
	 		$data['service_tax_amt'] = $invoice[0]->service_tax_amt;
	 		$data['education_cess_amt'] = $invoice[0]->education_cess_amt;
	 		$data['sec_education_cess_amt'] = $invoice[0]->sec_education_cess_amt;
	 		$data['total_amount'] = $invoice[0]->total_amount;
	 		$data['adv_amount'] = $invoice[0]->adv_amount;
	 		$data['final_amount'] = $invoice[0]->final_amount;
	 		$data['toll_parking'] = $tollfees + $parkingfees;
	 		$data['final_invoice_id'] = $final_invoice_id;

	    	$this->load->helper('dompdf');
	     
			$html = $this->load->view('corporatePdf', $data, true);
			pdf_create($html, $invoice[0]->invoice_no, false);

			$this->header->index($this->active);
			$this->load->view('corporateHtml', $data);
			$this->footer->index();

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

    public function generateRandomString($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
