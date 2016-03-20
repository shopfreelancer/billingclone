<?php $this->set("title_for_layout","Artikelvorlage anlegen"); ?>

<h2>Artikelvorlage anlegen</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Draftinvoiceitem');
	
	echo $this->Form->input('Draftinvoiceitem.title', array('label' => 'Titel'));
	echo $this->Form->input('Draftinvoiceitem.taxrate', array('label' => 'Steuersatz (%)', 'value' => '19'));
	echo $this->Form->input('Draftinvoiceitem.description', array('type' => 'textarea','label' => 'Beschreibung'));
	echo $this->Form->input('Draftinvoiceitem.quantity', array('label' => 'Menge','value'=>'1'));
	echo $this->Form->input('Draftinvoiceitem.amountnet', array('label' => 'Preis (netto)','value'=>'100.00'));
	echo $this->Form->input('Draftinvoiceitem.sortorder', array('label' => 'Position Nummer','value'=>'1'));

	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'draftinvoiceitems', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>