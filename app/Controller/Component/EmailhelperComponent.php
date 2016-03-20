<?php
/**
* Instead of Template Files for Emails this Components formats all the data
*/
App::uses('Component','Controller');
class EmailhelperComponent extends Component {
    
	/**
	* Helper Method to get HTML formated Body of Invoice PDF
	* @return string
	*/
	public function generateInvoiceEmailBody($invoice){

	// Mittelteil zwischen Anrede und Grußformel, eigentlicher Text
		if($invoice['Invoice']['type'] == 'invoice') {
			 $middlepiece = "Im Anhang befindet sich die Rechnung ".$invoice["Invoice"]["freeinvoiceid"]." als PDF Dokument. Und nochmals allerbesten Dank f&uuml;r die Beauftragung!<br/><br/>";
		} 
		if($invoice['Invoice']['type'] == 'offer') {
			$middlepiece = "Im Anhang befindet sich das Angebot ".$invoice["Invoice"]["freeinvoiceid"]." als PDF Dokument. Über Rückfragen freue ich mich!<br/><br/>";
		}
	
	// es gibt einen separaten Email-Ansprechpartner	
	if(!empty($invoice["Customer"]["email_firstname"])){
	if($invoice["Customer"]["email_salutation"] == 2){
		$salutation = "Frau";
	} else if($invoice["Customer"]["email_salutation"] == 1){
		$salutation = "Herr";
	} else {
		$salutation = "";
	}
		$firstname = $invoice["Customer"]["email_firstname"];
		$lastname =  $invoice["Customer"]["email_lastname"];
	} else {
		$salutation = $invoice["Customer"]["salutation"];
		$firstname = $invoice["Customer"]["firstname"];
		$lastname =  $invoice["Customer"]["lastname"];
	}	
	
	// wenn Herr oder Frau dann SIE als Anrede, ansonsten DU
	 if($salutation =="Frau" || $salutation =="Herr" ){
	  // SIE Anrede
		 if($salutation == "Frau"){
			 $string = "Sehr geehrte Frau ";
		 } else {
		 	$string = "Sehr geehrter Herr ";
		 }
		 
		 $string .= $lastname.",<br/>";
		 $string .= $middlepiece;
	 	$string .= nl2br($invoice['Company']['email_sie']);
	 } else {
	 // DU Anrede
	 	$string = 'Hallo '.$firstname.",<br/>";
		$string .= $middlepiece;		
		$string .= nl2br($invoice['Company']['email_du']);	 
	 }
	  
	 $string .= "<br/><br/>".nl2br($invoice["Company"]["emailsignature"]);
	 
	return $string;
	}
	
	/**
	* Same Same for Email Subject
	* @param array
	* @return string
	*/
	public function generateInvoiceEmailSubject($invoice){
	
		if($invoice['Invoice']['type'] == 'invoice') {
			$type_name =  "[".$invoice["Invoice"]["freeinvoiceid"]."] Rechnung für die letzte Änderungsrunde - vielen Dank!";
		} 
		if($invoice['Invoice']['type'] == 'offer') {
			$type_name = "[".$invoice["Invoice"]["freeinvoiceid"]."] Angebot";
		} 	
		return $type_name;
	}
	
	
	/**
	* Helper Method to get full name + path of PDF for invoice
	* @param array
	* @return string
	*/ 	
	public function getfullPdfPath($invoice = null){
				
		$this->autoRender = false;
		
		if($invoice['Invoice']['type'] == 'invoice') {
			$type_name = 'Rechnung';
		} 
		if($invoice['Invoice']['type'] == 'offer') {
			$type_name = 'Angebot';
		} 
		
		$delim = '_';
		$company_name = str_replace(' ',$delim ,$invoice['Company']['companyname']);
		$filename = Configure::read('Invoice.Path').$company_name.$delim.$type_name.$delim.$invoice['Invoice']['freeinvoiceid'].'.pdf';
		

		return $filename;
	}

	/**
	* Helper Method to get full name + path of PDF for invoice
	* @param array
	* @return string
	*/ 	
	public function getPdfName($invoice = null){
				
		$this->autoRender = false;
		
		if($invoice['Invoice']['type'] == 'invoice') {
			$type_name = 'Rechnung';
		} 
		if($invoice['Invoice']['type'] == 'offer') {
			$type_name = 'Angebot';
		} 
		
		$delim = '_';
		$company_name = str_replace(' ',$delim ,$invoice['Company']['companyname']);
		$filename = $company_name.$delim.$type_name.$delim.$invoice['Invoice']['freeinvoiceid'].'.pdf';
		

		return $filename;
	}
	
	
	/**
	* Helper Method to get HTML formated Body of Invoice PDF
	* @return string
	*/
	public function generateTicketEmailBody($customer,$company,$CustomerTicket){
	 App::uses('CakeTime', 'Utility');
	// wenn Herr oder Frau dann SIE als Anrede, ansonsten DU

	// es gibt einen separaten Email-Ansprechpartner	
	if(!empty($customer["customers"]["email_firstname"])){
		$firstname = $customer["customers"]["email_firstname"];
		$lastname =  $customer["customers"]["email_lastname"];
	} else {
		$firstname = $customer["customers"]["firstname"];
		$lastname =  $customer["customers"]["lastname"];
	}


	/*
	 if($salutation =="Frau" || $salutation =="Herr" ){
	  // SIE Anrede
		 if($salutation == "Frau"){
			 $string = "Sehr geehrte Frau ";
		 } else {
		 	$string = "Sehr geehrter Herr ";
		 }
		 
		 $string .= $lastname.",<br/>";
		 
	 } else {
	*/
	 	$string = 'Hallo '.$firstname.' '.$lastname.',<br/>';	 
	
	 
		$string .= "folgende Aufgabe wurde soeben von mir umgesetzt:<br/><br/>";
		$string .= nl2br($CustomerTicket['CustomerTicket']['description']).'<br/><br/>';
		$string .= 'Aufgewendete Zeit: '.$this->formatHours($CustomerTicket['CustomerTicket']['hours'],$CustomerTicket['CustomerTicket']['minutes']);	
		
		if(empty($CustomerTicket['CustomerTicket']['price_rate'])){
			$ticket_pricerate = $customer["customers"]["customer_rate"];	
		} else {
			$ticket_pricerate = $CustomerTicket['CustomerTicket']['price_rate'];
		}
		$string .= '<br/><br/>';
		$string .= 'Ticket erstellt am: '.CakeTime::format('d.m.Y H:i',$CustomerTicket['CustomerTicket']['created']).'<br/>';
		$string .= 'Ticket geschlossen am: '.CakeTime::format('d.m.Y H:i',$CustomerTicket['CustomerTicket']['modified']);
		$string .= '<br/><br/>';
		$string .= 'zum vereinbarten Stundensatz von '.$ticket_pricerate.' EUR zzgl. USt'; 		
		$string .= "<br/><br/>";
	 
	 
	 	$string .= "Ich bitte darum, die Änderungen zu überprüfen und mir ggfs. Rückmeldung zu geben unter ".$company["companies"]["email"]." <br/>Besten Dank!<br/><br/>";
	 	$string .= nl2br($company["companies"]['email_sie']);
	 
	 $string .= "<br/><br/>".nl2br($company["companies"]["emailsignature"]);
	 $string .= "<br><br>---------------------------------------------------------<br/>";
	 $string .= "Diese Email wurde von meinem Ticketsystem generiert.<br/>"; 
	 $string .= "---------------------------------------------------------<br/>";
	 
	 
	 
	return $string;
	}
	
	public function generateTicketEmailSubject($CustomerTicket){
		return "[Ticket #".rand(100001,99999).$CustomerTicket['CustomerTicket']["id"]."] Change Request ".$CustomerTicket['CustomerTicket']["title"];
	}
	
	/**
	* "schoen" formatierte Rückgabe für Stunden und Minuten
	* @return string
 	*/
    public function formatHours($hours, $minutes) {
        if((int)$hours === 1){
			$hours = $hours.' Stunde ';
		} else {
			$hours = $hours.' Stunden ';
		}
		
		if((int)$minutes === 1){
			$minutes = $minutes.' Minute';
		} else {
			$minutes = $minutes.' Minuten';
		}
		
		$time = $hours.$minutes;
        return $time;
    }		
		
}