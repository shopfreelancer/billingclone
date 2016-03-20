<?php
class TextdraftsController extends AppController {
	public $helpers = array ('Html','Form');
	public $name = 'Textdrafts';
	public $components = array('Session');
	

	
	public function index() {	
		$this->set('textdrafts', $this->Textdraft->find('all'));
	}

	public function add() {
	
	if (!empty($this->data)) {
			if ($this->Textdraft->save($this->data)) {
					$this->Session->setFlash('Neuer Textbaustein angelegt.');
					$this->redirect(array('action' => 'index'));
			}
		} 
	}


	public function edit($id) {
	
	$this->Textdraft->id = $id;
	//$this->set('id', $id);
	
	if (empty($this->data)) {	  
            $this->data = $this->Textdraft->read();
	}
	else {
			$this->Textdraft->save($this->data);
					$this->Session->setFlash('Textbaustein gespeichert.');
					$this->redirect(array('action' => 'index'));
			
		} 
	}
	
	public function delete($id) {
		$this->Textdraft->id = $id;
	    $this->Textdraft->delete($id);
        $this->Session->setFlash('Der Posten wurde gelöscht.');
		$this->redirect(array('controller' => 'textdrafts','action' => 'index'));
	}
}