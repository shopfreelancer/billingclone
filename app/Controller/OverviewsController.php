<?php
class OverviewsController extends AppController {
	public $helpers = array ('Html','Form', 'Price');
	public $uses = null;
	public $components = array('Session');

	public $paginate = array(
	 'limit' => 20,
	 'order' => array(
	 'Invoice.id' => 'desc'
	 )
 	);
	
	public function index() {
		
		$this->loadModel('Invoice');
		$this->paginate = array(
		 'limit' => 20,
		 'conditions' => array('type' => 'invoice', 'invoice_status_id=3'),
		 'order' => array(
		 'Invoice.id' => 'desc'
		 )
		);
		$open_invoices = $this->paginate('Invoice');
		$this->set('open_invoices',$open_invoices);
		 
	}
	

}