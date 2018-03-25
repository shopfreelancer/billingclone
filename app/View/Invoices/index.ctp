<?php $this->set("title_for_layout",$type_name.'s&uuml;bersicht'); 
echo '<h2>'.$type_name.'s&uuml;bersicht</h2>'; ?>
<div id="mainlisting">
<table class="customertable" width="600px">
	<tr>
		<th width="10px"><?php echo $this->Paginator->sort('id', 'id'); ?></th>
		<th width="55px"><?php echo $this->Paginator->sort('freeinvoiceid','Nummer'); ?></th>
		<th width="175px"><?php echo $this->Paginator->sort('Customer.companyname','Kunde'); ?></th>
		<th width="120px"><?php echo $this->Paginator->sort('invoicedate','Datum'); ?></th>
		<th width="120px"><?php echo $this->Paginator->sort('status','Status'); ?></th>
		<th width="120px"><?php echo $this->Paginator->sort('amounttotal','Betrag'); ?></th>
	</tr>

	<?php 
	$rowcount = 1;
	foreach ($invoices as $invoice){
	($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd'
	?>
	<tr class="<?php echo $rowclass;?>">
		<td><?php echo '<span class="grey">'.$invoice['Invoice']['id'].'</span>'; ?></td>
		<td><?php echo $invoice['Invoice']['freeinvoiceid']; ?></td>
		<td>
		<?php echo $invoice['Customer']['customerDropDrownName'].'<br/>'; ?>
<?php echo $this->Html->link('Link zu '.$type_name, array('controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id']));?>
</td>
		<td><?php echo $invoice['Invoice']['invoicedate']; ?></td>
		<td><?php echo $invoice['Invoice_status']['invoicestatus']; ?></td>
		<td><?php echo $this->Price->formatPrice($invoice['Invoice']['amounttotal']); ?></td>
	</tr>
	
	<?php
	$rowcount++;
	}?>
   

</table>
</div>
<div id="mainlistingright">
<?php 
if($type == 'invoice'){
echo $this->Html->link('Neue Rechnung', array('controller' => 'invoices', 'action' => 'add', 'invoice'), array('class' => 'newbutton')); 
}
if($type == 'offer'){
echo $this->Html->link('Neues Angebot', array('controller' => 'invoices', 'action' => 'add', 'offer'), array('class' => 'newbutton')); 
}
?>
</div>
<br style="clear:both;"/>

<div id="pagination">
<?php
	echo $this->Paginator->prev('<', null, null, array('class' => 'disabled')).' ';
	echo $this->Paginator->numbers().' ';
	echo $this->Paginator->next('>', null, null, array('class' => 'disabled'));
?> 
<?php echo $this->Paginator->counter(array(
 'format' => 'Zeige %current% Eintr&auml;ge von insgesamt
 %count%'
));  ?>
</div>