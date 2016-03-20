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
	echo '<div class="input text"><label>Kunde</label><select name="data[Invoice][customer_id]">';
	foreach($customers_dropdown as $customer){
		echo '<option value="'.$customer['customers']['id'].'">'.$customer['customers']['companyname'].' '.$customer['customers']['firstname'].' '.$customer['customers']['lastname'].'</option>';
	}
	echo '</select></div>';
	
	echo '<div class="input text"><label>'.$type_name.'status</label><select name="data[Invoice][invoice_status_id]">';
	foreach($status_dropdown as $key => $value){
		if($key == 1){
			echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
		} else {
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	echo '</select></div>';
	echo $this->Form->hidden('Invoice.type', array('value' => $type));
	echo $this->Form->hidden('Invoice.freeinvoiceid', array('value' => $lastfreeinvoiceid));

	echo $this->Form->input('Invoice.invoicedate', array('label' => $type_name.'sdatum', 'value' => date("d.m.Y")));
	echo $this->Form->input('Invoice.taxrate', array('label' => 'Steuersatz (%)','value' => '19'));
	echo '<p>Dient nicht zur Berechnung, wird im Summenblock als Text unter "Umsatzsteuer" aufgef&uuml;hrt.</p>';

	echo $this->Form->input('Invoice_texts.betreff', array('label' => 'Betreff'));
	echo 'Rechnungsnummer: '.$lastfreeinvoiceid;	
	echo '<p>Wenn "Betreff" leer bleibt, wird die '.$type_name.'snummer verwendet.</p>';
	echo $this->Form->input('Invoice_texts.top', array('type' => 'textarea','label' => 'Anrede', 'value' => $default_top, 'escape' => true));
	echo $this->Form->input('Invoice_texts.bottom', array('type' => 'textarea', 'label' => 'Grussformel', 'value' => $default_bottom, 'escape' => true));
	echo $this->Form->input('Invoice_texts.notebottom', array('type' => 'textarea', 'label' => 'Zusatzfeld unten', 'value' => $default_notebottom, 'escape' => true));
	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>