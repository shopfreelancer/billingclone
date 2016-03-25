<?php

/**
 * Class CompaniesController
 */
class CompaniesController extends AppController {
	public $helpers = array ('Html','Form');
	public $name = 'Companies';
	public $components = array('Session');

	/**
	 * main index, no own view
	 */
	public function index() {
		$company = $this->Company->find('first');
		if(count($company) == 0){
			$this->redirect(array('action' => 'add'));
		} else {
			$this->redirect(array('action' => 'view',$this->Company->id));
		}
	}

	/**
	 * @param null $id
	 */
	public function view($id = null) {
		$this->set('company', $this->Company->find('first'));
	}

	/**
	 * @param null $id
	 */
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