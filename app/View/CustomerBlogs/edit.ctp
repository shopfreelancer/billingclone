<?php $this->set("title_for_layout","Kundenblog bearbeiten"); ?>

<h2>Kundenblog bearbeiten</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('CustomerBlog');
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('customer_id');
	
	echo $this->Form->input('CustomerBlog.title', array('label' => 'Titel'));
	echo $this->Form->input('CustomerBlog.description', array('type' => 'textarea','label' => 'Beschreibung'));

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