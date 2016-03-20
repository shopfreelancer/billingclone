<h2>Kunden hinzuf&uuml;gen</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Customer');
	echo $this->Form->input('salutation', array('label' => 'Anrede'));
	echo $this->Form->input('firstname', array('label' => 'Vorname'));
	echo $this->Form->input('lastname', array('label' => 'Nachname'));
	echo $this->Form->input('companyname', array('label' => 'Firmenname'));
	echo $this->Form->input('street', array('label' => 'Strasse'));
	echo $this->Form->input('postcode', array('label' => 'Postleitzahl'));
	echo $this->Form->input('city', array('label' => 'Stadt'));
	echo $this->Form->input('country', array('label' => 'Land'));
	echo $this->Form->input('taxtrate', array('label' => 'Steuersatz (%)','value' => 19));
	echo $this->Form->input('fax', array('label' => 'Fax'));
	echo $this->Form->input('phone', array('label' => 'Telefon'));
	echo $this->Form->input('handy', array('label' => 'Handy'));
	echo $this->Form->input('email', array('label' => 'Email'));
	echo $this->Form->input('email_salutation',array('type'=>'select', 'options'=>$this->Input->getGenderValues(), 'label'=>'Email Anrede'));	
	echo $this->Form->input('email_firstname', array('label' => 'Email Vorname'));
	echo $this->Form->input('email_lastname', array('label' => 'Email Nachname'));	
	echo $this->Form->input('www', array('label' => 'Internet'));
	echo $this->Form->input('ustid', array('label' => 'Umsatzsteuernummer'));
	echo $this->Form->input('customer_rate', array('label' => 'Stundensatz'));
	echo $this->Form->input('billable', array('type' => 'checkbox', 'label' => 'Rechnungsf&auml;hig?'));
	echo $this->Form->input('description', array('rows' => '12', 'label' => 'Notiz'));
	echo $this->Form->input('zdata', array('rows' => '12', 'label' => 'Zugangsdaten Sec'));
	?>
	<div class="formfooter">
	<?php
	if(!isset($id)){
	echo $this->Html->link('Abbrechen', array('controller' => 'customers', 'action' => 'index'), array('class' =>'cancelbutton'));
	} else {
	echo $this->Html->link('Abbrechen', array('controller' => 'customers', 'action' => 'view',$id), array('class' =>'cancelbutton'));
	}
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>