<?php $this->set("title_for_layout","Neuer Rechnungsposten"); ?>

<h2>Neuer Rechnungsposten</h2>
<div id="mainleft">	
<?php echo $this->Form->create(null,array('action' => 'importdraft')); 
echo $this->Form->hidden('parentid', array('value' => $parentid));
?>


<?php
$counter = 0;
foreach($Draftinvoiceitems as $Draftinvoiceitem){
	echo $this->Form->checkbox('id.'.$counter.']', array('value' => $Draftinvoiceitem['Draftinvoiceitems']['id']));
	echo $Draftinvoiceitem['Draftinvoiceitems']['title'].'<br />';
	$counter++;
}
?>

<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end(array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
?>

</div>
<br style="clear:both;"/>