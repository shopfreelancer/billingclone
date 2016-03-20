<?php $this->set("title_for_layout","Neues Ticket anlegen"); ?>

<h2>Neues Ticket anlegen</h2>
<div id="mainleft">	
	
	<?php
	
	echo $this->Form->create('CustomerTicket');
	echo $this->Form->hidden('customer_id', array('value' => $customer_id));
	
	
	echo $this->Form->input('CustomerTicket.title', array('type' => 'text','label' => 'Titel / Datum', 'value' => date("d.m.Y") ));
	echo $this->Form->input('CustomerTicket.description', array('type' => 'textarea','label' => 'Beschreibung'));
	echo $this->Form->input('CustomerTicket.comment', array('type' => 'textarea','label' => 'Interner Kommentar'));
	echo $this->Form->input('CustomerTicket.taxrate', array('type' => 'text','label' => 'Steuersatz (%)','value' => '19'));
	echo $this->Form->input('CustomerTicket.active', array('type' => 'checkbox', 'label'=>'noch nicht verbucht', 'checked'=>'true','value' => 1));
	echo $this->Form->input('CustomerTicket.hours', array('type'=>'select', 'options'=>array(0,1,2,3,4,5,6,7,8,9,10,11,12),'label' => 'Stunden'));
	echo $this->Form->input('CustomerTicket.minutes',array('type'=>'select', 'options'=>array(0=>"0",15=>"15",30=>"30",45=>"45"), 'label'=>'Minuten'));
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