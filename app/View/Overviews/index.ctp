<?php 
$this->set("title_for_layout","&Uuml;bersicht"); 
?>
<h2>&Uuml;bersicht</h2>

<h2>Offene Rechnungen</h2>
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
	foreach ($open_invoices as $invoice){
	($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd'
	?>
	<tr class="<?php echo $rowclass;?>">
		<td><?php echo '<span class="grey">'.$invoice['Invoice']['id'].'</span>'; ?></td>
		<td><?php echo $invoice['Invoice']['freeinvoiceid']; ?></td>
		<td>
		<?php echo $invoice['Customer']['companyname'].'<br/>'.$invoice['Customer']['firstname'].' '.$invoice['Customer']['lastname'].'<br/>'; ?>
<?php echo $this->Html->link('Link zur Rechnung', array('controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id']));?>
</td>
		<td><?php echo $invoice['Invoice']['invoicedate']; ?></td>
		<td><?php echo $invoice['Invoice_status']['invoicestatus']; ?></td>
		<td><?php echo $this->Price->formatPrice($invoice['Invoice']['amounttotal']); ?></td>
	</tr>
	
	<?php
	$rowcount++;
	}?>
   

</table>
<br style="clear:both;"/>