<?php
/**
 * Instead of Template Files for Emails this Components formats all the data
 */
App::uses('Component','Controller');
class InvoiceIdhelperComponent extends Component {

    /**
     * Fortlaufende Nummerierung fuer Angebote und Rechnungen
     * hole letzte Nummer aus DB plus 1
     * @param string $type (entweder invoice oder offer)
     * @return string
     */
    public function getNextInvoiceId($type = 'invoice')
    {

        $this->Invoice = ClassRegistry::init('Invoice');
        $query = $this->Invoice->query('SELECT freeinvoiceid FROM invoices WHERE type = \'' . $type . '\' ORDER BY id DESC LIMIT 1 ;');

        $lastfreeinvoiceid = '';

        if (!empty($query['0']['invoices']["freeinvoiceid"])) {
            $firstpart = substr($query['0']['invoices']["freeinvoiceid"], 0, 6);
            $secondpart = ((int)substr($query['0']['invoices']["freeinvoiceid"], 6, strlen($query['0']['invoices']["freeinvoiceid"]))) + 1;
            $lastfreeinvoiceid = $firstpart . $secondpart;
        } else {
            $lastfreeinvoiceid = "RE2016001";
        }

        return $lastfreeinvoiceid;
    }
}