<?php 

if($type == 'invoice') {
	$pagetitle = 'Neue Rechnung';
	$type_name = 'Rechnung';
} 
if($type == 'offer') {
	$pagetitle = 'Neues Angebot';
	$type_name = 'Angebot';
} 

$this->set("title_for_layout",$pagetitle);
echo '<h2>'.$pagetitle .'</h2>';
?>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Invoice');

	echo $this->Form->input('Invoice.customer_id', array(
		'empty' => 'Kunde auswählen',
        'options' => $customerDropdown,
        'label' => "Kunde"
        )
     );

	echo '<div id="js-customer-billing-address-ajax" data-url="'.
		$this->Html->url(array(
			"controller" => "Invoices",
			"action" => "getCustomerBillingAddressAjax",
		),true)
		.'"></div>';


    echo $this->Form->input('Invoice.invoice_status_id', array(
            'default' => 1,
            'options' => $statusDropdown,
            'label' => "Status"
        )
    );

	echo $this->Form->hidden('Invoice.type', array('value' => $type));
	echo $this->Form->input('Invoice.freeinvoiceid', array('default' => $freeinvoiceid,'label'=>"Rechnungsnummer"));

	echo $this->Form->input('Invoice.invoicedate', array('label' => $type_name.'sdatum', 'value' => date("d.m.Y")));
	echo $this->Form->input('Invoice.taxrate', array('label' => 'Steuersatz (%)','value' => '19'));
	echo '<p>Dient nicht zur Berechnung, wird im Summenblock als Text unter "Umsatzsteuer" aufgef&uuml;hrt.</p>';

	echo $this->Form->input('Invoice_texts.betreff', array('label' => 'Betreff'));
	echo 'Rechnungsnummer: '.$freeinvoiceid;	
	echo '<p>Wenn "Betreff" leer bleibt, wird die '.$type_name.'snummer verwendet.</p>';

	foreach ($invoiceTextTypes as $invoiceTextType){
		$default = '';
		if(count($invoiceTextType['Textdraft']) > 0) $default = $invoiceTextType['Textdraft'][0]['textdraft'];

		echo $this->Form->input("Invoice_texts.".$invoiceTextType['InvoiceTextType']['id'], array('type' => 'textarea','label' => $invoiceTextType['InvoiceTextType']['description'], 'default' => $default, 'escape' => true));
	}
	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>