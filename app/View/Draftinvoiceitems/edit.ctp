<?php $this->set("title_for_layout","Artikelvorlage bearbeiten"); ?>

<h2>Artikelvorlage bearbeiten</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Draftinvoiceitem');
	echo $this->Form->hidden('id');
	
	echo $this->Form->input('Draftinvoiceitem.title', array('label' => 'Titel'));
	echo $this->Form->input('Draftinvoiceitem.taxrate', array('label' => 'Steuersatz (%)'));
	echo $this->Form->input('Draftinvoiceitem.description', array('type' => 'textarea','label' => 'Beschreibung'));
	echo $this->Form->input('Draftinvoiceitem.quantity', array('label' => 'Menge'));
	echo $this->Form->input('Draftinvoiceitem.amountnet', array('label' => 'Preis (netto)'));
	echo $this->Form->input('Draftinvoiceitem.sortorder', array('label' => 'Position Nummer'));

	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'draftinvoiceitems', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>