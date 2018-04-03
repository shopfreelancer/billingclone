<?php
class InvoiceitemsController extends AppController {
	public $helpers = array ('Html','Form', 'Hours');
	public $name = 'Invoiceitems';
	public $components = array('Session');


	
	public function index() {
	}
	

	
	public function edit($id) {

	$this->set('id', $id);
	$this->Invoiceitem->id = $id;
  
		if (empty($this->request->data)) {	  
            $this->request->data = $this->Invoiceitem->read();
			$this->set('parentid', $this->request->data['Invoiceitem']['invoiceid']);
        } else {
			$this->Invoiceitem->save($this->request->data); 
			$this->Session->setFlash('Daten gespeichert.');
			if( $this->request->data['Invoiceitem']['invoiceid'] == ''){
			$vari = $this->Invoiceitem->read();
			$parentid = $vari['Invoiceitem']['invoiceid'];
			} else {
			$parentid = $this->request->data['Invoiceitem']['invoiceid'];
			}
			$this->redirect(array('controller' => 'invoices','action' => 'save', $parentid ));
		}
		
	}
	
	public function add($parentid = null) {

		$this->set('parentid', $parentid);
		if(!empty($this->request->data)){
			if($this->Invoiceitem->save($this->request->data)){
			 $this->Session->setFlash('Der Posten wurde angelegt.');
			 $this->redirect(array('controller' => 'invoices','action' => 'save', $this->request->data['Invoiceitem']['invoiceid'] ));
			}
		}
	}
	
	public function importdraft($parentid = null) {
		
		/*
		if($parentid == null || empty($this->request->data['Draftitems']['parentid'])){
			$this->Session->setFlash('Bitte zuerst Rechnung oder Angebot auswählen.');
			$this->redirect(array('controller' => 'invoices','action' => 'index'));
		}
		*/
		
		if(empty($this->request->data)){
			$this->set('parentid', $parentid);
			$this->loadModel('Draftinvoiceitems');
			$this->set('Draftinvoiceitems', $this->Draftinvoiceitems->find('all'));	
		}
		
		if(!empty($this->request->data)){
			if(empty($this->request->data['Invoiceitem']['parentid'])){
				$this->Session->setFlash('Bitte zuerst Rechnung oder Angebot auswählen.');
				$this->redirect(array('controller' => 'invoices','action' => 'index'));
			} else {
			$this->loadModel('Draftinvoiceitems');
			
			foreach($this->request->data['Invoiceitem']['id'] as $id){
				if($id != 0){
					$draftinvoiceitem = $this->Draftinvoiceitems->findById($id);
					$invoiceitem = array(
						'id' => '',
						'sortorder' => '1',
						'invoiceid' => $this->request->data['Invoiceitem']['parentid'],
						'amountnet' => $draftinvoiceitem['Draftinvoiceitems']['amountnet'],
						'title' => $draftinvoiceitem['Draftinvoiceitems']['title'],
						'description' => $draftinvoiceitem['Draftinvoiceitems']['description'],
						'quantity' => $draftinvoiceitem['Draftinvoiceitems']['quantity'],
						'taxrate' => $draftinvoiceitem['Draftinvoiceitems']['taxrate']
					);
					$this->Invoiceitem->save($invoiceitem);
				}	
			}
			$this->Session->setFlash('Vorlage wurde eingefügt.');
			$this->redirect(array('controller' => 'invoices','action' => 'view', $this->request->data['Invoiceitem']['parentid']));	
			}
		}
	}

	public function importtickets($parentid = null) {
		
		/*
		if($parentid == null || empty($this->request->data['Draftitems']['parentid'])){
			$this->Session->setFlash('Bitte zuerst Rechnung oder Angebot auswählen.');
			$this->redirect(array('controller' => 'invoices','action' => 'index'));
		}
		*/
		
		if(empty($this->request->data)){
		
			$this->loadModel('Invoices');
			$invoice = $this->Invoices->findById($parentid);
	
			$this->set('parentid', $parentid);
			$this->loadModel('CustomerTicket');
			
			$customerQuery = $this->CustomerTicket->find('all', array(
                            'conditions' => array( 
                                'customer_id' => $invoice['Invoices']['customer_id'],
                                'active' => '1' )
			   ));
                        
			   if(!empty($customerQuery[0])){
			   $this->set('CustomerTickets', $customerQuery);
			   } else {
			   $this->set('CustomerTicketsText', 'Keine buchbaren Tickets gefunden');
			   }
			   
		}
		
		if(!empty($this->request->data)){
			if(empty($this->request->data['Invoiceitem']['parentid'])){
				$this->Session->setFlash('Bitte zuerst Rechnung oder Angebot auswählen.');
				$this->redirect(array('controller' => 'invoices','action' => 'index'));
			} else {
			$this->loadModel('CustomerTicket');
			$sortorderCounter = 1;
		
			foreach($this->request->data['id'] as $id){
				if($id != 0){
					$CustomerTicket = $this->CustomerTicket->findById($id);
				
					if(empty($CustomerTicket['CustomerTicket']['price_rate'])){
						$this->loadModel('Customer');
						$Customer = $this->Customer->findById($CustomerTicket['CustomerTicket']['customer_id']);
						
						if(!empty($Customer['Customer']['customer_rate'])){
							$ticket_pricerate = $Customer['Customer']['customer_rate'];	
						} else {
							$ticket_pricerate = '';
						}
						
					} else {
						$ticket_pricerate = $CustomerTicket['CustomerTicket']['price_rate'];
					}
					
						// Zeit in Beschreibungstext einfügen
						//App::import('Helper', 'Hours'); // loadHelper('Html'); in CakePHP 1.1.x.x
						//$hours = new HoursHelper($this->view);
						
					$view = new View($this);
       					$hours  = $view->loadHelper('Hours');
						
					$appendix = 'Aufgewendete Zeit: '.$hours->formatHours($CustomerTicket['CustomerTicket']['hours'],$CustomerTicket['CustomerTicket']['minutes']);
					$appendix .= '<br/>zum vereinbarten Stundensatz von '.$ticket_pricerate.' EUR zzgl. USt'; 					
					
					$invoiceitem = array(
						'id' => '',
						'sortorder' => $sortorderCounter,
						'invoiceid' => $this->request->data['Invoiceitem']['parentid'],
						'amountnet' => $this->calculateTimeFactor($CustomerTicket['CustomerTicket']['hours'],$CustomerTicket['CustomerTicket']['minutes']) * $ticket_pricerate,
						'title' => 'Change Request '.$CustomerTicket['CustomerTicket']['title'],
						'description' => $CustomerTicket['CustomerTicket']['description'].'<br/>'.$appendix,
						'quantity' => 1,
						'taxrate' => $CustomerTicket['CustomerTicket']['taxrate']
					);
					$this->Invoiceitem->save($invoiceitem);
                                        $sortorderCounter ++;
                                        
                                        $this->CustomerTicket->id = $id;
                                        $this->CustomerTicket->save(array('active' => 0));
				}	
                                
			}
			
	
			$this->Session->setFlash('Vorlage wurde eingefügt.');
			$this->redirect(array('controller' => 'invoices','action' => 'save', $this->request->data['Invoiceitem']['parentid']));	
			}
		}
	}

	/*
	* Minutes to Int
	*/
	public function calculateTimeFactor($hours,$minutes){
		$this->autoRender = false;
		
		
		$minutesInt = 0;
		if($minutes > 0 && $minutes <= 15){
			$minutesInt  = 0.25;
		} else if($minutes > 15 && $minutes <= 30){
			$minutesInt  = 0.5;
		} else if($minutes > 30 && $minutes <= 45){
			$minutesInt  = 0.75;
		} else if($minutes > 45 && $minutes <= 60){
			$minutesInt  = 1;
		}
		$timeFactor = $hours + $minutesInt;
		
		return $timeFactor;
	}
    
    public function delete($id) {
		//$this->autoRender = false;
	
		$this->Invoiceitem->id = $id;
	    $redirect = $this->Invoiceitem->read();
	
        $this->Invoiceitem->delete($id);
       
		$this->redirect(array('controller' => 'invoices','action' => 'save', $redirect['Invoiceitem']['invoiceid'] ));
	}

}