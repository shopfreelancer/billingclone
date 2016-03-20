<?php 
$this->set("title_for_layout","Akquise &uuml;bersicht"); 
?>
<h2>Akquise &Uuml;bersicht <?php if(!empty($zeitraum)) echo $zeitraum; ?></h2>

<div id="mainlisting">
<div class="akquise_row">
<?php echo $this->Akquise->buildStataHTML('Kontaktmedium',$kontaktmediums); ?>
<?php echo $this->Akquise->buildStataHTML('Kundentypologie',$kundentypologies); ?>
<?php echo $this->Akquise->buildStataHTML('Shopsystem',$shopsystems); ?>
</div>

<div class="akquise_row">
<?php echo $this->Akquise->buildStataHTML('Arbeitsinhalt',$arbeitsinhalts); ?>
<?php echo $this->Akquise->buildStataHTML('Absagegrund',$absagegrunds); ?>
<?php echo $this->Akquise->buildStataHTML('Resultat',$resultats); ?>
</div>

<div class="akquise_row">
<?php echo $this->Akquise->buildStataHTML('Gender',$genders); ?>
</div>


<div class="akquise_stata_block_last">
<div class="akquise_stata_headline">Akquisekontakte gesamt: <?php echo $totalcount[0][0]['summe']; ?></div>
</div>

</div>
<div id="mainlistingright">
<div id="akquise_zeitraum_list">
<div class="akquise_stata_headline">Zeitr&auml;ume</div>
<?php
$zeitraums = $this->Akquise->getZeitraumValues();
foreach($zeitraums as $zeitraum){
	echo $this->Html->link($zeitraum, array('controller' => 'akquises', 'action' => 'index',$zeitraum), array('class' => 'newbutton'));
}
echo $this->Html->link('Alle', array('controller' => 'akquises', 'action' => 'index'), array('class' => 'newbutton'));
?>
</div>
<?php echo $this->Html->link('Neue Akquise', array('controller' => 'akquises', 'action' => 'add'), array('class' => 'newbutton')); ?>
</div>
<br style="clear:both;"/>