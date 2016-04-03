<?php
if($type == 'invoice') {
	$pagetitle = 'Rechnung bearbeiten';
	$type_name = 'Rechnung';
	$indexlink = $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'newbutton'));
} 
if($type == 'offer') {
	$pagetitle = 'Angebot bearbeiten';
	$type_name = 'Angebot';
	$indexlink = $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'indexoffer'), array('class' =>'newbutton'));
} 

$this->set("title_for_layout",$pagetitle);
echo '<h2>'.$pagetitle .'</h2>';
?>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Invoice');
	echo $this->Form->hidden('id');
	echo $this->Form->input('Invoice.customer_id', array(
        'options' => $customerDropdown,
        'label' => "Kunde"
        )
     );
	echo $this->Form->input('Invoice.invoice_status_id', array(
			'options' => $statusDropdown,
			'label' => "Status"
		)
	);
	
	echo $this->Form->input('Invoice.freeinvoiceid', array('label' => $type_name.'snummer'));
	echo $this->Form->input('Invoice.invoicedate', array('label' => $type_name.'sdatum'));
	echo $this->Form->input('Invoice_texts.betreff', array('label' => 'Betreff'));
	echo $this->Form->hidden('Invoice_texts.id');
	echo $this->Form->input('Invoice.taxrate', array('label' => 'Steuersatz (%)','value' => '19'));
	echo $this->Form->input('Invoice_texts.top', array('type' => 'textarea', 'escape' => true));
	echo $this->Form->input('Invoice_texts.bottom', array('type' => 'textarea', 'escape' => true));
	echo $this->Form->input('Invoice_texts.notebottom', array('type' => 'textarea', 'label' => 'Zusatzfeld unten', 'escape' => true));
	echo $this->Form->input('Invoice_texts.billingaddress', array('type' => 'textarea', 'label' => 'Rechnungsadresse'));
	
	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>