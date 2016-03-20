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

	echo '<div class="input text"><label>Kunde</label><select name="data[Invoice][customerid]">';
	foreach($customers_dropdown as $customer){
	
	if($customer['customers']['id'] == $selected_customer){
		echo '<option selected="selected" value="'.$customer['customers']['id'].'">'.$customer['customers']['companyname'].' '.$customer['customers']['firstname'].' '.$customer['customers']['lastname'].'</option>';
	} else {
		echo '<option value="'.$customer['customers']['id'].'">'.$customer['customers']['companyname'].' '.$customer['customers']['firstname'].' '.$customer['customers']['lastname'].'</option>';
	}
	}

	echo '</select></div>';
	
	echo '<div class="input text"><label>'.$type_name.'sstatus</label><select name="data[Invoice][invoice_status_id]">';
	foreach($status_dropdown as $key => $value){
		if($key == $selected_status){
			echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
		} else {
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	echo '</select></div>';
	
	
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
	if($id != null){
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'view', $id), array('class' =>'cancelbutton'));
	} else {
	echo $indexlink;
	}
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>