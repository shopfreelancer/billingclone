<?php $this->set("title_for_layout","Neuer Textbaustein"); ?>

<h2>Neuer Textbaustein</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Textdraft');
	echo $this->Form->input('Textdraft.title', array('label' => 'Titel'));
	echo $this->Form->input('Textdraft.textdraft', array('label' => 'Text', 'type' => 'textarea'));
	echo $this->Form->input('Textdraft.field', array('label' => 'Datenbank Feld', 'value' => 'top'));
	echo $this->Form->input('Textdraft.type', array('label' => 'Typ', 'value' => 'invoice'));
	echo $this->Form->input('Textdraft.defaultvalue', array('label' => 'Soll Wert vorselektiert beim Anlegen einer neuen Rechnung erscheinen?', 'value'=>'0'));

	?>
	<div class="formfooter">
	<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'textdrafts', 'action' => 'index'), array('class' =>'cancelbutton'));	
	echo $this->Form->end( array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
	?>
	</div>
	
</div>
<br style="clear:both;"/>