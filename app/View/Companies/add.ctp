<h2>Firmendaten bearbeiten</h2>
<div id="mainleft">
	<?php
	echo $this->Form->create('Company');
	echo $this->Form->input('salutation', array('label' => 'Anrede'));
	echo $this->Form->input('firstname', array('label' => 'Vorname'));
	echo $this->Form->input('lastname', array('label' => 'Nachname'));
	echo $this->Form->input('companyname', array('label' => 'Firmenname'));
	echo $this->Form->input('street', array('label' => 'Strasse'));
	echo $this->Form->input('postcode', array('label' => 'Postleitzahl'));
	echo $this->Form->input('city', array('label' => 'Stadt'));
	echo $this->Form->input('country', array('label' => 'Land'));
	echo $this->Form->input('fax', array('label' => 'Fax'));
	echo $this->Form->input('phone', array('label' => 'Telefon'));
	echo $this->Form->input('email', array('label' => 'Email'));
	echo $this->Form->input('www', array('label' => 'Internet'));
	echo $this->Form->input('ustid', array('label' => 'Umsatzsteuernummer'));
	echo $this->Form->input('description', array('rows' => '3', 'label' => 'Notiz'));
	echo $this->Form->input('emailsignature', array('label' => 'Email Signatur'));
	echo $this->Form->input('email_sie', array('label' => 'Email Grussformel Sie'));
	echo $this->Form->input('email_du', array('label' => 'Email Grussformel Du'));
?>
</div>	

<div id="mainright">
	<?php
	echo $this->Form->input('taxnumber', array('label' => 'Steuernummer'));
	echo $this->Form->input('bankaccountholder', array('label' => 'Kontoinhaber'));
	echo $this->Form->input('bankaccountnumber', array('label' => 'Kontonummer'));
	echo $this->Form->input('bankaccountcode', array('label' => 'Bankleitzahl'));
	echo $this->Form->input('bankaccountiban', array('label' => 'IBAN'));
	echo $this->Form->input('bankaccountswift', array('label' => 'Swift / BIC'));
	echo $this->Form->input('bankname', array('label' => 'Name der Bank'));
	?>
</div>

<div class="formfooter">
	<?php
	echo $this->Html->link('abbrechen', array('controller' => 'companies', 'action' => 'view',''), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => 'speichern','div' => false));
	?>
</div>
