<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends MX_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->module('header/header');
		$this->load->module('footer/footer');
		$this->load->model('inventory_model');
		$this->load->model('helper/helper_model');
	}

	public function index()
	{
		$this->header->index();
		$this->load->view('InventoryAdd');
		$this->footer->index();
	}

	public function addItem()
	{
		$data = array(
			'inven_items_name' => $_POST['name'],
			'inven_items_unit' => $_POST['unit'],
			'inven_items_quantity' => $_POST['qty'],
			'inven_items_netcost' => $_POST['cost'],
			'added_on' => date('Y-m-d')
		);

		$tableName = 'inventory_items';

		$result = $this->helper_model->insert($tableName,$data);

		$response['success'] = $result;

		echo json_encode($response);
 	}
}
