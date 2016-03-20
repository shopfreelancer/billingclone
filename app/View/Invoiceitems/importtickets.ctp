<?php $this->set("title_for_layout","Neuer Rechnungsposten"); ?>

<h2>Tickets abrechnen</h2>
<div id="mainleft">	
<?php echo $this->Form->create(null,array('action' => 'importtickets')); 
echo $this->Form->hidden('parentid', array('value' => $parentid));
?>


<?php
if(!empty($CustomerTicketsText)){
echo '<div>'.$CustomerTicketsText.'</div>';
} else {
$counter = 0;
foreach($CustomerTickets as $CustomerTicket){
	echo $this->Form->checkbox('id.'.$counter.']', array('value' => $CustomerTicket['CustomerTicket']['id'],'checked' => true));
	echo $CustomerTicket['CustomerTicket']['title'].'<br />';
	$counter++;
}
}
?>

<?php
	echo $this->Html->link('Abbrechen', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'cancelbutton'));
	echo $this->Form->end(array('name' => 'submit', 'class' => 'submitbutton clearfix', 'label' => false,'div' => false));
?>

</div>
<br style="clear:both;"/>