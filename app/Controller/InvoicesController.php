<?php
App::uses('CakeEmail', 'Network/Email');

class InvoicesController extends AppController
{
    public $helpers = array('Html', 'Form', 'Price', 'Time');
    public $name = 'Invoices';
    public $components = array('Session', 'RequestHandler', 'Emailhelper','InvoiceIdHelper');

    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'id' => 'desc'
        )
    );

    public function index()
    {
        $this->paginate = array(
            'conditions' => array('Invoice.type =' => 'invoice'),
            'order' => array('Invoice.id' => 'desc'),
        );

        $invoices = $this->paginate('Invoice');

        $this->set('invoices', $invoices);
        $this->set('type_name', 'Rechnung');
        $this->set('type', 'invoice');
    }

    public function indexoffers()
    {
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

    public function view($id = null)
    {

        $invoice = $this->Invoice->read(null, $id);
        $this->set('invoice', $invoice);
        $this->set('invoicepath', $this->Emailhelper->getfullPdfPath($invoice));
    }

    public function edit($id)
    {
        $this->loadModel('Customer');

        if(empty($this->Invoice->findById($id)))
            $this->redirect(array('action' => 'index'));


        if (empty($this->request->data)) {

            $data = $this->Invoice->findById($id);
            
            $this->set('type', $data['Invoice']['type']);
            $this->set("customerDropdown", $this->getCustomerDropDown());
            $this->set("statusDropdown", $this->getStatusDropDown());

            $this->request->data = $data;


        } else {
            if ($this->Invoice->saveAll($this->request->data)) {
                $this->Session->setFlash('Rechnung wurde gespeichert.');
                $this->redirect(array('action' => 'view', $this->Invoice->id));
            }
        }
    }

    /**
     * add a new invoice. Fetch default data values for input fields.
     * @param string $type
     */
    public function add($type = 'invoice')
    {
        $this->set('type', $type);
        $this->loadModel('InvoiceType');

        $invoice_type_id = $this->InvoiceType->field(
            'id',
            array('invoicetype' => $type)
        );

        if($invoice_type_id === false){
            $this->redirect(array('action' => 'index'));
        }

        /**
         * find with conditions on related model throws errors.
         * so solving it the ugly way with joins
         */
        $this->loadModel('InvoiceTextType');
        $invoiceTextTypes = $this->InvoiceTextType->find('all',
        array(
            'conditions' => array(
                'InvoiceTextType.invoice_type_id' => $invoice_type_id,
                'AND' => array(
                    'InvoiceTextType.invoice_type_id' => "Textdraft.invoice_type_id"
                )
            )
        )

        );
        $this->set('invoiceTextTypes',$invoiceTextTypes);

        $this->loadModel('Customer');

        $this->set("freeinvoiceid", $this->InvoiceIdHelper->getNextInvoiceId($type));
        $this->set("customerDropdown", $this->getCustomerDropDown());
        $this->set("statusDropdown", $this->getStatusDropDown());
        

        if (!empty($this->request->data)) {
            var_dump($this->request->data);
            exit();

            if ($this->Invoice->saveAll($this->request->data)) {

                if ($type === 'invoice') {
                    $message = 'Neue Rechnung angelegt.';
                }
                if ($type === 'offer') {
                    $message = 'Neues Angebot angelegt.';
                }
                $this->Session->setFlash($message);
                $this->redirect(array('action' => 'view', $this->Invoice->id));
            }
        }
    }

    /**
     * Fetches Customer address for input form.
     * @param $customerId
     */
    public function getCustomerBillingAddressAjax($customerId)
    {
        if (!$this->request->is('ajax')) {
            die();
        }
        $this->loadModel('Customer');
        $customer = $this->Customer->find('first',
            array(
                'conditions' => array('id' => $customerId)
            )
        );
        $this->set('customer',$customer);
    }

    public function clonen($id, $typeswitch = null)
    {
        $this->autoRender = false;

        $invoice = $this->Invoice->findById($id);

        $invoice['Invoice']['id'] = '';

        if ($typeswitch == 'invoice') {
            $invoice['Invoice']['type'] = 'invoice';
        }

        if (!empty($invoice['Invoiceitems'])) {
            foreach ($invoice['Invoiceitems'] as &$invoiceitem) {
                $invoiceitem['id'] = '';
            }
            unset($invoiceitem);
        }

        if (!empty($invoice['Invoice_texts']['id'])) {
            $invoice['Invoice_texts']['id'] = '';
        }


        $invoice['Invoice']['date'] = date('d.m.Y');
        $invoice['Invoice']['emailsent'] = '0000-00-00 00:00:00';
        $invoice['Invoice']["freeinvoiceid"] = $this->InvoiceIdHelper->getNextInvoiceId($invoice['Invoice']['type']);

        if ($this->Invoice->saveAll($invoice)) {
            $query = $this->Invoice->query("SELECT id,type FROM invoices ORDER BY id DESC LIMIT 1 ;");

            $id = $query['0']['invoices']["id"];
            $type = $query['0']['invoices']["type"];

            if ($type == 'invoice' && !isset($typeswitch)) {
                $message = 'Die Rechnung wurde dupliziert.';
            }
            if ($type == 'offer' && !isset($typeswitch)) {
                $message = 'Das Angebot wurde dupliziert.';
            }
            if (isset($typeswitch)) {
                $message = 'Das Angebot wurde dupliziert und als Rechnung umgewandelt. Bitte überprüfen Sie alle Posten und Textinhalte.';
            }

            $this->Session->setFlash($message);
            $this->redirect(array('action' => 'view', $id));
        }


    }

    public function offertoinvoice($id)
    {
        $this->autoRender = false;
        self::clonen($id, 'invoice');
    }

    public function save($id)
    {
        $this->autoRender = false;

        $invoice = $this->Invoice->read('', $id);

        $invoice = $this->calculateInvoicePrice($invoice);

        if ($this->Invoice->saveAll($invoice)) {
            if ($invoice['Invoice']['type'] == 'invoice') {
                $message = 'Die Rechnung wurde gespeichert.';
            }
            if ($invoice['Invoice']['type'] == 'offer') {
                $message = 'Das Angebot wurde gespeichert.';
            }

            $this->Session->setFlash($message);

            $this->redirect(array('action' => 'view', $this->Invoice->id));
        }
    }

    /**
     * Sums up all invoice items and calculates total prices of invoice
     * 
     * @param $invoice
     * @return mixed
     */
    public function calculateInvoicePrice($invoice)
    {
        $this->autoRender = false;

        $amountnet = 0;
        $amounttotal = 0;

        foreach ($invoice['Invoiceitems'] as $invoiceitem) {

            $amountnetitem = floatval($invoiceitem['amountnet']);
            $taxfactoritem = floatval(($invoiceitem['taxrate'] / 100) + 1);
            $bruttoitem = round(($amountnetitem * $taxfactoritem), 2);

            $amountnet = $amountnet + $amountnetitem;
            $amounttotal = $amounttotal + $bruttoitem;

        }

        $invoice['Invoice']['amounttotal'] = $amounttotal;
        $invoice['Invoice']['amountnet'] = $amountnet;
        $invoice['Invoice']['amounttax'] = $amounttotal - $amountnet;

        return $invoice;

    }

    public function delete($id)
    {
        $invoice = $this->Invoice->read('', $id);

        if ($invoice['Invoice']['type'] == 'invoice') {
            $this->Invoice->delete($id);
            $this->Session->setFlash('Die Rechnung wurde gelöscht.');
            $this->redirect(array('action' => 'index'));
        }
        if ($invoice['Invoice']['type'] == 'offer') {
            $this->Invoice->delete($id);
            $this->Session->setFlash('Das Angebot wurde gelöscht.');
            $this->redirect(array('action' => 'indexoffers'));
        }
    }

    public function invoicePdf($id = null)
    {

        $this->autoRender = false;
        //$this->RequestHandler->respondAs("pdf");

        if (!$id) {
            $this->Session->setFlash('Sorry, there was no property ID submitted.');
            $this->redirect(array('action' => 'index'), null, true);
        }
        //Configure::write('debug',0); // Otherwise we cannot use this method while developing

        $id = intval($id);

        $invoice = $this->Invoice->read(null, $id);
        $this->set('invoice', $invoice);

        $this->set('filename', $this->Emailhelper->getfullPdfPath($invoice));

        if (empty($invoice)) {
            $this->Session->setFlash('Sorry, there is no property with the submitted ID.');
            $this->redirect(array('action' => 'index'), null, true);
        }

        $this->render();
        $this->redirect(array('action' => 'view', $id));
    }


    public function validateEmailBeforeSend($id = '')
    {

        $invoice = $this->Invoice->read(null, $id);

        if (empty($invoice["Customer"]["firstname"]) && empty($invoice["Customer"]["email_firstname"])) {
            $this->Session->setFlash('Bitte den Vornamen des Kunden in Firmendaten eintragen.');
            $this->redirect(array('action' => 'view', $id));
        }

        if (empty($invoice["Customer"]["lastname"]) && empty($invoice["Customer"]["email_lastname"])) {
            $this->Session->setFlash('Bitte den Nachnamen des Kunden in Firmendaten eintragen.');
            $this->redirect(array('action' => 'view', $id));
        }

        if (empty($invoice["Customer"]["email"])) {
            $this->Session->setFlash('Bitte Email des Kunden in Firmendaten eintragen.');
            $this->redirect(array('action' => 'view', $id));
        }

        $filename = $this->Emailhelper->getfullPdfPath($invoice);

        if ($filename === false) {
            $this->Session->setFlash('Bitte erst das PDF erzeugen.');
            $this->redirect(array('action' => 'view', $id));
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
    public function sendEmail($id = '')
    {
        $this->autoRender = false;

        $invoice = $this->Invoice->read(null, $id);

        $filename = $this->Emailhelper->getfullPdfPath($invoice);

        if (!file_exists($filename)) {
            $this->Session->setFlash('Bitte erst das PDF erzeugen.');
            $this->redirect(array('action' => 'view', $id));
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
        $this->Invoice->saveField('invoice_status_id', 3);

        $this->Session->setFlash('Email wurde versandt.');
        $this->redirect(array('action' => 'view', $id));
    }

    public function download($id = null)
    {

        $this->viewClass = 'Media';

        $invoice = $this->Invoice->read(null, $id);

        $document_name = $this->Emailhelper->getPdfName($invoice);


        $filename = $this->Emailhelper->getfullPdfPath($invoice);
        if (!file_exists($filename)) {
            $this->Session->setFlash('Bitte erst das PDF erzeugen.');
            $this->redirect(array('action' => 'view', $id));
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
     * Returns simple id - name array to populate drop down in view
     * 
     * @return mixed
     */
    public function getCustomerDropDown()
    {
        $customerDropDown = $this->Customer->find('list',[
            'conditions'=>['billable'=>1],
            'order'=>['id DESC'],
            'fields'=> ['id', 'customerDropDrownName']
        ]);

        return $customerDropDown;
    }

    /**
     * Get list of all status an invoice can have
     *
     * @return mixed
     */
    public function getStatusDropDown()
    {
        $statusDropdown = $this->Invoice->Invoice_status->find('list', array('fields' => array('id', 'invoicestatus')));
        return $statusDropdown;
    }

}

?>