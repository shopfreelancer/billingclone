<?php $this->set("title_for_layout","Textbaustein bearbeiten"); ?>

<h2>Textbaustein bearbeiten</h2>
<div id="mainleft">	
	
	<?php
	echo $this->Form->create('Textdraft');
	echo $this->Form->hidden('Textdraft.id');
	echo $this->Form->input('Textdraft.title', array('label' => 'Titel'));
	echo $this->Form->input('Textdraft.textdraft', array('label' => 'Text', 'type' => 'textarea'));
	echo $this->Form->input('Textdraft.field', array('label' => 'Datenbank Feld (top, bottom, bottomnote)'));
	echo $this->Form->input('Textdraft.type', array('label' => 'Typ'));
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