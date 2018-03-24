<?php

App::uses('CakeEmail', 'Network/Email');

class CustomerTicketsController extends AppController {

    public $helpers = array('Html', 'Form', 'Price', 'Hours');
    public $name = 'CustomerTickets';
    public $components = array('Session', 'RequestHandler', 'Emailhelper');
    public $paginate;

    public function index() {

        $conditions['conditions'] = array(
            'active = 1');

        $CustomerTickets = $this->CustomerTicket->find('all', $conditions);

        $this->set('CustomerTickets', $CustomerTickets);
    }

    public function statistic($time = null) {

        if ($time = null) {
            $time = 'now()';
        }

        $CustomerTickets = $this->CustomerTicket->query("
			SELECT customers.companyname,customers.firstname,customers.lastname, ct.id, ct.title, ct.description, ct.hours, ct.minutes, ct.comment 
			FROM customer_tickets AS ct 
			left JOIN customers AS customers ON (ct.customer_id = customers.id) 
			WHERE ct.active = 1 ORDER BY ct.id desc;
			");

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
     * Helper Method to send ticket notification via Email
     *
     */
    public function sendEmail($id = '') {
        $this->autoRender = false;

        $this->CustomerTicket->id = $id;
        $CustomerTicket = $this->CustomerTicket->read();

        $customer = $this->CustomerTicket->query('SELECT email,firstname,lastname,salutation,customer_rate,email_salutation,email_firstname,email_lastname
		 FROM customers WHERE id = "' . $CustomerTicket["CustomerTicket"]["customer_id"] . '"');
        $customer = $customer[0];
        $company = $this->CustomerTicket->query('SELECT email, emailsignature, email_sie,email_du FROM companies WHERE id = 1');
        $company = $company[0];



        if (empty($customer["customers"]["email"])) {
            $this->Session->setFlash('Bitte Email des Kunden in Firmendaten eintragen.');
            $this->redirect(array('controller' => 'customers', 'action' => 'view', $CustomerTicket["CustomerTicket"]["customer_id"]));
        }


        $subject = $this->Emailhelper->generateTicketEmailSubject($CustomerTicket);
        $body = $this->Emailhelper->generateTicketEmailBody($customer, $company, $CustomerTicket);


        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email
                ->to($customer['customers']["email"]) // Hier noch Kundenmail eintragen
                ->replyTo($company['companies']["email"])
                ->bcc($company['companies']["email"])
                ->emailFormat('html')
                ->subject($subject)
                ->send($body);

        $this->Session->setFlash('Email wurde versandt.');
        $this->redirect(array('controller' => 'customers', 'action' => 'view', $CustomerTicket["CustomerTicket"]["customer_id"]));
    }

}
