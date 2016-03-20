<h2>Akquisekontakt hinzuf&uuml;gen</h2>
<div id="mainleft_fullwidth">	
	
	<?php
	echo $this->Form->create('Akquise');
	echo $this->Form->input('erstkontaktdatum', array('label' => 'Datum'));
	echo $this->Form->input('gender',array('type'=>'select', 'options'=>$this->Akquise->getGenderValues(), 'label'=>'Gender'));	
	echo $this->Form->input('kundenname', array('label' => 'Kundenname'));
	echo $this->Form->input('kundenemail', array('label' => 'Kundenemail'));
	echo $this->Form->input('telephone', array('label' => 'Telefonnummer'));
	echo $this->Form->input('postcode', array('label' => 'Postleitzahl'));
	
	echo $this->Form->input('kontaktmedium',array('type'=>'select', 'options'=>array("Email","Kontaktformular","Anruf","Sonstige","Eigenansprache"), 'label'=>'Kontakt via'));
	echo $this->Form->input('kundentypologie',array('type'=>'select', 'options'=>$this->Akquise->getKundentypologieValues(), 'label'=>'Branche'));
	echo $this->Form->input('shopsystem',array('type'=>'select', 'options'=>$this->Akquise->getShopsystemValues(), 'label'=>'Shopsystem'));
	echo $this->Form->input('arbeitsinhalt',array('type'=>'select', 'options'=>$this->Akquise->getArbeitsinhaltValues(), 'label'=>'Arbeitsinhalt'));
	echo $this->Form->input('resultat',array('type'=>'select', 'options'=>$this->Akquise->getResultatValues(), 'label'=>'Erfolg'));
	echo $this->Form->input('absagegrund',array('type'=>'select', 'options'=>$this->Akquise->getAbsagegrundValues(), 'label'=>'Absagegrund'));
	echo $this->Form->input('referenz', array('label' => 'Weitervermittelt von wem?'));
	echo $this->Form->input('comment', array('label' => 'Kommentar:'));
	
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