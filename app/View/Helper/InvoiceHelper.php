<?php
class InvoiceHelper extends AppHelper {


	/**
	*
	* @return string
	*/
    function formatInvoiceName($invoice) {

	if($invoice['Invoice']['type'] == 'invoice'){
		$type_name = 'Rechnung';
	}
	if($invoice['Invoice']['type'] == 'offer'){
		$type_name = 'Angebot';
	}
	return $type_name;

    }
}
?>