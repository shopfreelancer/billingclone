<?php
App::uses('Sanitize', 'Utility');
class CustomersController extends AppController {
	public $helpers = array ('Html','Form','Price','Hours');
	public $name = 'Customers';
	public $components = array('Session', 'RequestHandler');

	public $paginate = array(
	 'limit' => 20,
	 'order' => array(
	 'id' => 'desc'
	 )
 	);

	public function index() {
		$customers  = $this->paginate('Customer');
		$this->set('customers', $customers);
	}
	
	public function view($id = null) {
		$this->Customer->id = $id;

		$this->loadModel('Invoice');
		$this->set('invoices', $this->Invoice->findAllByCustomer_id($this->Customer->id, array(), array('Invoice.id' => 'desc')));
		$this->set('customer', $this->Customer->read());
	}
	
	public function add($id = null) {
		if(!empty($id)){
		$this->set('id', $id);
		} else {
		$id = '';
		}
        $this->Customer->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Customer->read();
        } else {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash('Kunde gespeichert.');
				$this->redirect(array('action' => 'view', $this->Customer->id));
			}
		}
	}
    
    public function delete($id) {
		$this->Customer->id = $id;
        $this->Customer->delete($id);
        $this->Session->setFlash('Der Kunde wurde gelöscht.');
        $this->redirect(array('action'=>'index'));
	}
	
	public function livesearch() {
           //Configure::write('debug', 0);
           $this->autoRender = false;
 
           if($this->RequestHandler->isAjax()) {
		   
		   $searchterm = Sanitize::paranoid($this->data, array('ä','ö','ü','ß','Ä','Ö','Ü'));

		   $customers_search_result = $this->Customer->find('all', array(
		   'conditions' => array( 
		   
			   'OR' => array(
			   array('Customer.firstname LIKE' => '%'.$searchterm.'%'),
			   array('Customer.lastname LIKE' => '%'.$searchterm.'%'),
			   array('Customer.companyname LIKE' => '%'.$searchterm.'%'),
			   array('Customer.phone LIKE' => '%'.$searchterm.'%'),
			   array('Customer.handy LIKE' => '%'.$searchterm.'%')
			   )
		   ),
		   'fields' => array('Customer.id','Customer.firstname', 'Customer.lastname', 'Customer.companyname'),
		   'limit' => 10
		   ));
		   $data = '';
		   if(!empty($customers_search_result[0]['Customer']['firstname'])){
			   foreach($customers_search_result as $customer_search_result){
			   $data[] = array(
			   'id' => $customer_search_result['Customer']['id'],
			   'firstname' => $customer_search_result['Customer']['firstname'],
			   'lastname' => $customer_search_result['Customer']['lastname'],
			   'companyname' => $customer_search_result['Customer']['companyname'],
			   );
			   }
		   }
		   //echo $data;
		  //var_dump($customers_search);
		  $this->header('Content-Type: application/json');
		  if(!empty($data)){
		  echo json_encode($data);
		  }
			exit(); 

           }
       }
	   	   
}