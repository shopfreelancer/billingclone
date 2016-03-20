<?php $this->set("title_for_layout","Firmendaten&uuml;bersicht"); ?>
<h2>Einstellungen &Uuml;bersicht</h2>
<div id="mainlisting">
<?php // var_dump($company); ?>
</div>
<div id="mainlistingright">
<?php echo $this->Html->link('Firmendaten', array('controller' => 'companies', 'action' => 'view'), array('class' => 'newbutton')); ?>
</div>
<br style="clear:both;"/>