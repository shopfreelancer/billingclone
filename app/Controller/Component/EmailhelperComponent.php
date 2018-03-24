<?php

/**
 * Instead of Template Files for Emails this Components formats all the data
 */
App::uses('Component', 'Controller');

class EmailhelperComponent extends Component {

    /**
     * Helper Method to get HTML formated Body of Invoice PDF
     * @return string
     */
    public function generateInvoiceEmailBody($invoice) {

        // Mittelteil zwischen Anrede und Grußformel, eigentlicher Text
        if ($invoice['Invoice']['type'] == 'invoice') {
            $middlepiece = "Im Anhang befindet sich die Rechnung " . $invoice["Invoice"]["freeinvoiceid"] . " als PDF Dokument. Und nochmals allerbesten Dank f&uuml;r die Beauftragung!<br/><br/>";
        }
        if ($invoice['Invoice']['type'] == 'offer') {
            $middlepiece = "Im Anhang befindet sich das Angebot " . $invoice["Invoice"]["freeinvoiceid"] . " als PDF Dokument. Über Rückfragen freue ich mich!<br/><br/>";
        }

        // es gibt einen separaten Email-Ansprechpartner	
        if (!empty($invoice["Customer"]["email_firstname"])) {
            if ($invoice["Customer"]["email_salutation"] == 2) {
                $salutation = "Frau";
            } else if ($invoice["Customer"]["email_salutation"] == 1) {
                $salutation = "Herr";
            } else {
                $salutation = "";
            }
            $firstname = $invoice["Customer"]["email_firstname"];
            $lastname = $invoice["Customer"]["email_lastname"];
        } else {
            $salutation = $invoice["Customer"]["salutation"];
            $firstname = $invoice["Customer"]["firstname"];
            $lastname = $invoice["Customer"]["lastname"];
        }

        // wenn Herr oder Frau dann SIE als Anrede, ansonsten DU
        if ($salutation == "Frau" || $salutation == "Herr") {
            // SIE Anrede
            if ($salutation == "Frau") {
                $string = "Sehr geehrte Frau ";
            } else {
                $string = "Sehr geehrter Herr ";
            }

            $string .= $lastname . ",<br/>";
            $string .= $middlepiece;
            $string .= nl2br($invoice['Company']['email_sie']);
        } else {
            // DU Anrede
            $string = 'Hallo ' . $firstname . ",<br/>";
            $string .= $middlepiece;
            $string .= nl2br($invoice['Company']['email_du']);
        }

        $string .= "<br/><br/>" . nl2br($invoice["Company"]["emailsignature"]);

        return $string;
    }

    /**
     * Same Same for Email Subject
     * @param array
     * @return string
     */
    public function generateInvoiceEmailSubject($invoice) {

        if ($invoice['Invoice']['type'] == 'invoice') {
            $type_name = "[" . $invoice["Invoice"]["freeinvoiceid"] . "] Rechnung für die letzte Änderungsrunde - vielen Dank!";
        }
        if ($invoice['Invoice']['type'] == 'offer') {
            $type_name = "[" . $invoice["Invoice"]["freeinvoiceid"] . "] Angebot";
        }
        return $type_name;
    }

    /**
     * Helper Method to get full name + path of PDF for invoice
     * @param array
     * @return string
     */
    public function getfullPdfPath($invoice = null) {

        $this->autoRender = false;

        if ($invoice['Invoice']['type'] == 'invoice') {
            $type_name = 'Rechnung';
        }
        if ($invoice['Invoice']['type'] == 'offer') {
            $type_name = 'Angebot';
        }

        $delim = '_';
        $company_name = str_replace(' ', $delim, $invoice['Company']['companyname']);
        $filename = Configure::read('Invoice.Path') . $company_name . $delim . $type_name . $delim . $invoice['Invoice']['freeinvoiceid'] . '.pdf';


        return $filename;
    }

    /**
     * Helper Method to get full name + path of PDF for invoice
     * @param array
     * @return string
     */
    public function getPdfName($invoice = null) {

        $this->autoRender = false;

        if ($invoice['Invoice']['type'] == 'invoice') {
            $type_name = 'Rechnung';
        }
        if ($invoice['Invoice']['type'] == 'offer') {
            $type_name = 'Angebot';
        }

        $delim = '_';
        $company_name = str_replace(' ', $delim, $invoice['Company']['companyname']);
        $filename = $company_name . $delim . $type_name . $delim . $invoice['Invoice']['freeinvoiceid'] . '.pdf';


        return $filename;
    }

    public function generateTicketEmailSubject($CustomerTicket) {
        return "[Ticket #". $CustomerTicket['CustomerTicket']["id"] . "] Change Request " . $CustomerTicket['CustomerTicket']["title"];
    }

}