<?php
class CompaniesController extends AppController {
	public $helpers = array ('Html','Form');
	public $name = 'Companies';
	public $components = array('Session');

	
	public function index() {
		$this->set('company', $this->Company->find('first'));
		 
	}
	
	public function view($id = null) {
		$this->set('company', $this->Company->find('first'));
	}
	
	public function add($id = null) {
        $this->Company->id = $id;
		
        if (empty($this->data)) {
            $this->data = $this->Company->find('first');
        } else {
			if ($this->Company->save($this->data)) {
				$this->Session->setFlash('Firmendaten gespeichert.');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

}