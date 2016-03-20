<?php
App::uses('CakeEmail', 'Network/Email');
class InvoicesController extends AppController {
	public $helpers = array ('Html','Form','Price','Time');
	public $name = 'Invoices';
	public $components = array('Session','RequestHandler','Emailhelper');
	
	public $paginate = array(
	 'limit' => 20,
	 'order' => array(
	 'id' => 'desc'
	 )
 	);
	
	public function index(){
		
		$this->paginate = array(
			'conditions' => array('Invoice.type =' => 'invoice'),
			'order' => array('Invoice.id' => 'desc')
		);
		
		$invoices = $this->paginate('Invoice');	
		$this->set('invoices', $invoices);
		$this->set('type_name', 'Rechnung'); 
		$this->set('type', 'invoice');
	}
		
	public function indexoffers() {
		 $this->paginate = array(
		 'conditions' => array('Invoice.type =' => 'offer'),
		 'order' => array('Invoice.id' => 'desc')
		);
		
		$invoices = $this->paginate('Invoice');	
		
		$this->set('invoices', $invoices);
		$this->set('type_name', 'Angebot');
		$this->set('type', 'offer');
		
		$this->render('index');
	
	}
	
	public function view($id = null) {
	
		$invoice = $this->Invoice->read(null, $id);
		$this->set('invoice', $invoice);
		$this->set('invoicepath',$this->Emailhelper->getfullPdfPath($invoice));
	}
		
	public function edit($id) {
	$this->Invoice->id = $id;
		
		if (empty($this->request->data)) {
			$data = $this->Invoice->read();
			$this->request->data = $this->Invoice->read();
			$this->set('id', $id);
			
			$this->set('type', $this->request->data['Invoice']['type']);
			
			// Selected Customer and Drop Down
			$customers_dropdown =  $this->Invoice->query("SELECT id, companyname, firstname, lastname FROM customers ORDER BY id DESC;");
			foreach($customers_dropdown as $customer){
				if($data["Customer"]['id'] == $customer['customers']['id']){
					$this->set("selected_customer", $data['Customer']['id']);
				}
			}	
		
			$this->set("customers_dropdown", $customers_dropdown);
			
			// Selected Status and Drop Down
			$status_dropdown = $this->Invoice->Invoice_status->find('list', array('fields' => array('id','invoicestatus')));

			foreach($status_dropdown as $key => $value){
				if($key == $data['Invoice']['invoice_status_id']){
					$this->set("selected_status", $key);
				}
			}
			
			$this->set("status_dropdown",$status_dropdown); 

				
	   } else {
			if ($this->Invoice->saveAll($this->request->data)) {
					$this->Session->setFlash('Rechnung wurde gespeichert.');
					$this->redirect(array('action' => 'view', $this->Invoice->id ));
			}
		}
	}

	public function add($type = 'invoice') {
	
		if (empty($this->request->data)) {
			
			$this->set('type', $type);
			
			// Default values for Form Fields
			// Last used invoice ID
			$lastfreeinvoiceid = $this->getNextInvoiceId($type);
			
			$this->set("lastfreeinvoiceid", $lastfreeinvoiceid);
		} else {
			$this->set("lastfreeinvoiceid", 1);
		}

		// Drop Down Menu for customer
		$customers_dropdown =  $this->Invoice->query("SELECT id, companyname, firstname, lastname FROM customers WHERE billable = 1 ORDER BY id DESC;");
		$this->set("customers_dropdown", $customers_dropdown);	   
		
		// Drop Down for Invoice Status
		$status_dropdown = $this->Invoice->Invoice_status->find('list', array('fields' => array('id','invoicestatus')));
		$this->set("status_dropdown",$status_dropdown); 
		
		// Default Values 
		$default_top = $this->Invoice->query('SELECT id, textdraft, field FROM textdrafts WHERE type = \''.$type.'\' AND field = \'top\' AND defaultvalue = true ORDER BY id');
		$default_bottom = $this->Invoice->query('SELECT id, textdraft, field FROM textdrafts WHERE type = \''.$type.'\' AND field = \'bottom\' AND defaultvalue = true ORDER BY id');
		$default_notebottom = $this->Invoice->query('SELECT id, textdraft, field FROM textdrafts WHERE type = \''.$type.'\' AND field = \'notebottom\' AND defaultvalue = true ORDER BY id');
		
		if(!empty($default_top)){
			$this->set("default_top", $default_top['0']['textdrafts']['textdraft']);
		} else {
			$this->set("default_top", '');
		}
		
		if(!empty($default_bottom)){
			$this->set("default_bottom", $default_bottom['0']['textdrafts']['textdraft']);
		} else {
			$this->set("default_bottom", '');
		}
		
		if(!empty($default_notebottom)){
			$this->set("default_notebottom", $default_notebottom['0']['textdrafts']['textdraft']);
		} else {
			$this->set("default_notebottom", '');
		}
	}
	
	if (!empty($this->request->data)) {

$billingadress =  $this->Invoice->query('SELECT id, companyname, firstname, lastname, street, postcode, city, country FROM customers WHERE id = '.$this->request->data['Invoice']['customer_id'].' ORDER BY id DESC;');

 	$this->request->data['Invoice_texts']['billingaddress'] = $billingadress['0']['customers']['companyname'].chr(13).chr(10).$billingadress['0']['customers']['firstname'].' '.$billingadress['0']['customers']['lastname'].chr(13).chr(10).$billingadress['0']['customers']['street'].chr(13).chr(10).$billingadress['0']['customers']['postcode'].' '.$billingadress['0']['customers']['city'].chr(13).chr(10).$billingadress['0']['customers']['country'];

			if ($this->Invoice->saveAll($this->request->data)) {
			
			if($this->request->data['Invoice']['type'] == 'invoice'){
				$message = 'Neue Rechnung angelegt.';
			}
			if($this->request->data['Invoice']['type'] == 'offer'){
				$message = 'Neues Angebot angelegt.';
			}
					$this->Session->setFlash($message);
					$this->redirect(array('action' => 'view', $this->Invoice->id ));
			}
		} 
	}

	public function clonen($id,$typeswitch = null) {
		$this->autoRender = false;
		
		$invoice = $this->Invoice->findById($id);
		
		$invoice['Invoice']['id'] = '';
	
		if($typeswitch == 'invoice'){
			$invoice['Invoice']['type'] = 'invoice';
		}
		
		if(!empty($invoice['Invoiceitems'])){
			foreach($invoice['Invoiceitems'] as &$invoiceitem){
				$invoiceitem['id'] = '';
			}
			unset($invoiceitem);
		}
		
		if(!empty($invoice['Invoice_texts']['id'])){
			$invoice['Invoice_texts']['id'] = '';
		}
		
		
		$invoice['Invoice']['date'] = date('d.m.Y');
		$invoice['Invoice']['emailsent'] = '0000-00-00 00:00:00';
		$invoice['Invoice']["freeinvoiceid"] = $this->getNextInvoiceId($invoice['Invoice']['type']);
		
		if ($this->Invoice->saveAll($invoice)) {
			$query = $this->Invoice->query("SELECT id,type FROM invoices ORDER BY id DESC LIMIT 1 ;");
			
			$id = $query['0']['invoices']["id"];
			$type = $query['0']['invoices']["type"];
				
			if($type == 'invoice' && !isset($typeswitch)){
				$message = 'Die Rechnung wurde dupliziert.';
			}
			if($type  == 'offer' && !isset($typeswitch)){
				$message = 'Das Angebot wurde dupliziert.';
			}
			if(isset($typeswitch)){
				$message = 'Das Angebot wurde dupliziert und als Rechnung umgewandelt. Bitte überprüfen Sie alle Posten und Textinhalte.';
			}		
					
			$this->Session->setFlash($message);
			$this->redirect(array('action' => 'view', $id));
		}
	

	}
	
	public function offertoinvoice($id) {
		$this->autoRender = false;
		self::clonen($id,'invoice');
	}
	
	public function save($id){
		$this->autoRender = false;
		
		$invoice = $this->Invoice->read('',$id);
		

		
		$invoice = $this->calculatePrice($invoice);
		
		if ($this->Invoice->saveAll($invoice)) {			
			if($invoice['Invoice']['type'] == 'invoice'){
				$message = 'Die Rechnung wurde gespeichert.';
			}
			if($invoice['Invoice']['type'] == 'offer'){
				$message = 'Das Angebot wurde gespeichert.';
			}
		
			$this->Session->setFlash($message);
		
			$this->redirect(array('action' => 'view', $this->Invoice->id ));
		}
	}
	
	public function calculatePrice($invoice){
		$this->autoRender = false;
	
		$amountnet = 0;
		$amounttotal = 0;
		
		foreach($invoice['Invoiceitems'] as $invoiceitem){
			
			$amountnetitem =  floatval ($invoiceitem['amountnet']);
			$taxfactoritem =  floatval (($invoiceitem['taxrate'] / 100) + 1);
			$bruttoitem = round(($amountnetitem * $taxfactoritem),2);
			//var_dump($bruttoitem );
			
			$amountnet = $amountnet + $amountnetitem;
			$amounttotal = $amounttotal + $bruttoitem;

		}
		

		$invoice['Invoice']['amounttotal']	= $amounttotal;
		$invoice['Invoice']['amountnet']	= $amountnet;
		$invoice['Invoice']['amounttax'] = $amounttotal - $amountnet;
		
		return $invoice;
	
	}
	
    public function delete($id) {
	
		$invoice = $this->Invoice->read('',$id);
	
		
		if($invoice['Invoice']['type'] == 'invoice'){
			$this->Invoice->delete($id);
			$this->Session->setFlash('Die Rechnung wurde gelöscht.');
			$this->redirect(array('action'=>'index'));
		}
		if($invoice['Invoice']['type'] == 'offer'){
			$this->Invoice->delete($id);
			$this->Session->setFlash('Das Angebot wurde gelöscht.');
			$this->redirect(array('action'=>'indexoffers'));
		}
	}
	
	public function invoicePdf($id = null){
	
	$this->autoRender = false;
	//$this->RequestHandler->respondAs("pdf");
	
		if (!$id)
		{
			$this->Session->setFlash('Sorry, there was no property ID submitted.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		//Configure::write('debug',0); // Otherwise we cannot use this method while developing

		$id = intval($id);
	
		$invoice = $this->Invoice->read(null, $id);
		$this->set('invoice', $invoice);
		
		$this->set('filename',$this->Emailhelper->getfullPdfPath($invoice));
			
		if (empty($invoice))
		{
			$this->Session->setFlash('Sorry, there is no property with the submitted ID.');
			$this->redirect(array('action'=>'index'), null, true);
		}

		$this->render();
		$this->redirect(array('action' => 'view', $id ));
	}
	

	
	public function sendEmailReview($id = ''){

		$invoice = $this->Invoice->read(null, $id);

		if(empty($invoice["Customer"]["firstname"]) && empty($invoice["Customer"]["email_firstname"])){
			$this->Session->setFlash('Bitte den Vornamen des Kunden in Firmendaten eintragen.');
			$this->redirect(array('action' => 'view', $id ));		
		}
			
		if(empty($invoice["Customer"]["lastname"]) && empty($invoice["Customer"]["email_lastname"])){
			$this->Session->setFlash('Bitte den Nachnamen des Kunden in Firmendaten eintragen.');
			$this->redirect(array('action' => 'view', $id ));		
		}
		
		if(empty($invoice["Customer"]["email"])){
			$this->Session->setFlash('Bitte Email des Kunden in Firmendaten eintragen.');
			$this->redirect(array('action' => 'view', $id ));		
		}
		
		$filename = $this->Emailhelper->getfullPdfPath($invoice);
		
		if($filename === false){
			$this->Session->setFlash('Bitte erst das PDF erzeugen.');
			$this->redirect(array('action' => 'view', $id ));	
		}
	
		$subject = $this->Emailhelper->generateInvoiceEmailSubject($invoice);
		$body = $this->Emailhelper->generateInvoiceEmailBody($invoice);
		
		$this->set('invoice', $invoice);
		$this->set('subject', $subject);
		$this->set('body', $body);
		$this->set('filename', $filename);
	}
	
	
	/**
	* Helper Method to send invoice PDF via Email
	*
	*/
	public function sendEmail($id = ''){
		$this->autoRender = false;
		
		$invoice = $this->Invoice->read(null, $id);
		
		$filename = $this->Emailhelper->getfullPdfPath($invoice);
		
		if(!file_exists($filename)){
			$this->Session->setFlash('Bitte erst das PDF erzeugen.');
			$this->redirect(array('action' => 'view', $id ));	
		}
		
		$subject = $this->Emailhelper->generateInvoiceEmailSubject($invoice);
		$body = $this->Emailhelper->generateInvoiceEmailBody($invoice);
	
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email
		->to($invoice["Customer"]["email"])
		->bcc($invoice["Company"]["email"])
		->emailFormat('html')
		->subject($subject)
		->attachments($filename)
		->send($body);
	
		$this->Invoice->id = $id;
		$this->Invoice->saveField('emailsent', date('Y-m-d H:i:s'));
		$this->Invoice->saveField('invoice_status_id',3);
	
		$this->Session->setFlash('Email wurde versandt.');
		$this->redirect(array('action' => 'view', $id ));
	}
	
	public function download($id = null){

		$this->viewClass = 'Media';
	
		$invoice = $this->Invoice->read(null, $id);
 
		$document_name = $this->Emailhelper->getPdfName($invoice);
	
	
		$filename = $this->Emailhelper->getfullPdfPath($invoice);
		if(!file_exists($filename)){
			$this->Session->setFlash('Bitte erst das PDF erzeugen.');
			$this->redirect(array('action' => 'view', $id ));	
		}
		
		
		
 
		// Sende die Datei an den Browser
		
		$params = array(
		       'id' => $document_name,
		       'name' => $document_name,
		       'download' => true,
		       'extension' => "",
		       'path' => Configure::read('Invoice.Path')
		);
		$this->set($params);		
	}	
	
	/**
	* Fortlaufende Nummerierung fuer Angebote und Rechnungen
	* hole letzte Nummer aus DB plus 1
	* @param string (entweder invoice oder offer)
	*/
	public function getNextInvoiceId($type = 'invoice'){
		$query = $this->Invoice->query('SELECT freeinvoiceid FROM invoices WHERE type = \''.$type.'\' ORDER BY id DESC LIMIT 1 ;');
		
		$lastfreeinvoiceid = '';
		
		if(!empty($query['0']['invoices']["freeinvoiceid"])){
			$firstpart = substr($query['0']['invoices']["freeinvoiceid"],0,6);
			$secondpart = ((int) substr($query['0']['invoices']["freeinvoiceid"],6,strlen($query['0']['invoices']["freeinvoiceid"]))) + 1;
			$lastfreeinvoiceid = $firstpart.$secondpart;
		}
		
		return $lastfreeinvoiceid;
	}

}
?>