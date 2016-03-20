<?php $this->set("title_for_layout","Kundenblog bearbeiten"); ?>

<h2>Ticket bearbeiten</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('CustomerTicket');
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('customer_id');
	
	echo $this->Form->input('CustomerTicket.title', array('label' => 'Titel'));
	echo $this->Form->input('CustomerTicket.description', array('type' => 'textarea','label' => 'Beschreibung'));
	echo $this->Form->input('CustomerTicket.comment', array('type' => 'textarea','label' => 'Kommentar'));
	echo $this->Form->input('CustomerTicket.active', array('type' => 'checkbox','label' => 'Aktiv (noch nicht verbucht)'));
	echo $this->Form->input('CustomerTicket.taxrate', array('type' => 'text','label' => 'Steuersatz (%)','value' => '19'));	
	echo $this->Form->input('CustomerTicket.hours', array('label' => 'Stunden'));
	echo $this->Form->input('CustomerTicket.minutes', array('label' => 'Minuten'));
	echo $this->Form->input('CustomerTicket.price_rate', array('label' => 'Stundensatz'));	

	?>
	<div class="formfooter">
	<?php
	if($customer_id != null){
	echo $this->Html->link('Abbrechen', array('controller' => 'customers', 'action' => 'view', $customer_id), array('class' =>'cancelbutton'));
	} else {
	echo $this->Html->link('Abbrechen', array('controller' => 'customers', 'action' => 'index'), array('class' =>'cancelbutton'));
	}
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>