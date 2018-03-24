<?php

class CustomerBlogsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'CustomerBlogs';
    public $components = array('Session', 'RequestHandler');

    public function index() {
        
    }

    public function edit($id) {

        if (empty($this->data)) {
            $this->CustomerBlog->id = $id;
            $this->data = $this->CustomerBlog->read();
            $this->set('customer_id', $this->data['CustomerBlog']['customer_id']);
        } else {
            if ($this->CustomerBlog->save($this->data)) {
                $this->Session->setFlash('Daten gespeichert.');
                $this->redirect(array('controller' => 'customers', 'action' => 'view', $this->data['CustomerBlog']['customer_id']));
            }
        }
    }

    public function add($customer_id = null) {

        if (empty($this->data)) {
            $this->set('customer_id', $customer_id);
        } else {
            if ($this->CustomerBlog->save($this->data)) {
                $this->Session->setFlash('Daten gespeichert.');
                $this->redirect(array('controller' => 'customers', 'action' => 'view', $this->data['CustomerBlog']['customer_id']));
            }
        }
    }

    public function delete($id) {

        $this->CustomerBlog->id = $id;
        $redirect = $this->CustomerBlog->read();

        $this->CustomerBlog->delete($id);
        $this->Session->setFlash('Der Posten wurde gelöscht.');

        $this->redirect(array('controller' => 'customers', 'action' => 'view', $redirect['CustomerBlog']['customer_id']));
    }

}
