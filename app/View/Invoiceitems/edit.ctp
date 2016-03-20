<?php $this->set("title_for_layout","Rechnungsposten bearbeiten"); ?>

<h2>Rechnungsposten bearbeiten</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Invoiceitem');
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('invoiceid');
	
	echo $this->Form->input('Invoiceitem.title', array('label' => 'Titel', 'size' => '150','maxlength'=>'150'));
	echo $this->Form->input('Invoiceitem.taxrate', array('label' => 'Steuersatz (%)'));
	echo $this->Form->input('Invoiceitem.description', array('type' => 'textarea','label' => 'Beschreibung'));
	echo $this->Form->input('Invoiceitem.quantity', array('label' => 'Menge'));
	echo $this->Form->input('Invoiceitem.amountnet', array('label' => 'Preis (netto)'));
	echo $this->Form->input('Invoiceitem.sortorder', array('label' => 'Position Nummer'));

	?>
	<div class="formfooter">
	<?php
	if($parentid != null){
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'view', $parentid), array('class' =>'cancelbutton'));
	} else {
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	}
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>