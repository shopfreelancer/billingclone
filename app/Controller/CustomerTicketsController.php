<?php

App::uses('CakeEmail', 'Network/Email');

class CustomerTicketsController extends AppController {

    public $helpers = array('Html', 'Form', 'Price', 'Hours');
    public $name = 'CustomerTickets';
    public $components = array('Session', 'RequestHandler', 'Emailhelper');
    public $paginate;

    /**
     * Action displays all ticket that are not billed yet
     */
    public function index() {

        $conditions['conditions'] = array('active = 1');

        $CustomerTickets = $this->CustomerTicket->find('all', $conditions);

        $this->set('CustomerTickets', $CustomerTickets);
    }

    public function edit($id) {

        if (empty($this->data)) {
            $this->CustomerTicket->id = $id;
            $this->data = $this->CustomerTicket->read();
            $this->set('customer_id', $this->data['CustomerTicket']['customer_id']);
        } else {
            if ($this->CustomerTicket->save($this->data)) {
                $this->Session->setFlash('Daten gespeichert.');
                $this->redirect(array('controller' => 'customers', 'action' => 'view', $this->data['CustomerTicket']['customer_id']));
            }
        }
    }

    public function add($customer_id = null) {

        if (empty($this->data)) {
            $this->set('customer_id', $customer_id);
        } else {
            if ($this->CustomerTicket->save($this->data)) {
                $this->Session->setFlash('Daten gespeichert.');
                $this->redirect(array('controller' => 'customers', 'action' => 'view', $this->data['CustomerTicket']['customer_id']));
            }
        }
    }

    public function delete($id) {
        $this->CustomerTicket->id = $id;
        $redirect = $this->CustomerTicket->read();
        $this->CustomerTicket->delete($id);
        $this->Session->setFlash('Der Posten wurde gelöscht.');
        $this->redirect(array('controller' => 'customers', 'action' => 'view', $redirect['CustomerTicket']['customer_id']));
    }

    /**
     * Helper Method to send ticket notification via Email to customer
     * 
     * @param type $id
     */
    public function sendEmail($id = '') {
        $this->autoRender = false;

        $this->CustomerTicket->id = $id;
        $customerTicket = $this->CustomerTicket->read();


        if (empty($customerTicket["Customer"]["email"])) {
            $this->Session->setFlash('Bitte die Email-Adresse des Kunden in die Firmendaten eintragen.');
            $this->redirect(array('controller' => 'customers', 'action' => 'view', $customerTicket["CustomerTicket"]["customer_id"]));
        }

        $this->loadModel('Company');
        $company = $this->Company->find('first');


        $subject = $this->Emailhelper->generateTicketEmailSubject($customerTicket);


        $Email = new CakeEmail();
        $Email->config('smtp');

        $Email->viewVars(array(
                    'customerTicket' => $customerTicket,
                    'company' => $company
                        )
                )->template('ticketemail')
                ->to($customerTicket['Customer']["email"]) // Hier noch Kundenmail eintragen
                ->replyTo($company['Company']["email"])
                ->bcc($company['Company']["email"])
                ->emailFormat('html')
                ->subject($subject)
                ->send();

        $this->Session->setFlash('Email wurde versandt.');
        $this->redirect(array('controller' => 'customers', 'action' => 'view', $customerTicket["CustomerTicket"]["customer_id"]));
    }

}
