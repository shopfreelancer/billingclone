<?php
class DraftinvoiceitemsController extends AppController {
	public $helpers = array ('Html','Form');
	public $name = 'Draftinvoiceitems';
	public $components = array('Session');
	
	public $paginate = array(
	 'limit' => 20,
	 'order' => array('Draftinvoiceitem.id' => 'desc')
 	);

	public function index(){
		$this->set('draftinvoiceitems',  $this->paginate('Draftinvoiceitem'));
	}
	
	public function edit($id){
	$this->Draftinvoiceitem->id = $id;
  
		if (empty($this->data)) {	  
            $this->data = $this->Draftinvoiceitem->read();
        } else {
			if($this->Draftinvoiceitem->save($this->data)){ 
			$this->Session->setFlash('Daten gespeichert.');
			$this->redirect(array('controller' => 'draftinvoiceitems','action' => 'index'));
			}
		}
		
	}
	
	public function add(){
	
		if (!empty($this->data)) {	  
			if($this->Draftinvoiceitem->save($this->data)){ 
			$this->Session->setFlash('Daten gespeichert.');
			$this->redirect(array('controller' => 'draftinvoiceitems','action' => 'index'));
			}
		}
		
	}	
	
	
	public function delete($id) {
	
	   	$this->Draftinvoiceitem->id = $id;
        $this->Draftinvoiceitem->delete($id);
        $this->Session->setFlash('Der Posten wurde gelöscht.');
		$this->redirect(array('controller' => 'draftinvoiceitems','action' => 'index'));
	}
}
?>
