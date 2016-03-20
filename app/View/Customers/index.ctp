<?php 
$this->set("title_for_layout","Kunden &uuml;bersicht"); 
?>
<h2>Kunden &Uuml;bersicht</h2>
<div id="mainlisting">
<table class="customertable" width="600px">
	<tr>
		<th width="40px"><?php echo $this->Paginator->sort('id', 'id'); ?></th>
		<th width="220px"><?php echo $this->Paginator->sort('companyname','Kunde'); ?></th>
		<th width="220px">Adresse</th>
		<th width="120px">Sonstiges</th>
	</tr>

	<?php 
	$rowcount = 1;
	foreach ($customers as $customer){
	
	($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd'
	
	?>
	
	<tr class="<?php echo $rowclass;?>">
		<td><?php echo $customer['Customer']['id']; ?></td>
		<td><?php 
if (!empty($customer['Customer']['companyname'])){
	echo $customer['Customer']['companyname'].'<br/>';
} 
	echo $customer['Customer']['firstname'].' '.$customer['Customer']['lastname']; ?>

</td>
		<td><?php echo $customer['Customer']['street'].'<br/>';
echo $customer['Customer']['postcode'].' '.$customer['Customer']['city'].'<br/>';
if (!empty($customer['Customer']['country'])){
	echo $customer['Customer']['country'].'<br/>';
} ?>
		
		</td>
		<td>
		<?php echo $this->Html->link('Zum Kunden', array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id'])); ?>
		</td>
	</tr>
	
	<?php
	$rowcount++;
	}?>
   

</table>
</div>
<div id="mainlistingright">

<div id="livesearch"><b>Kundensuche</b><br/>
<div id="searchable" contenteditable="true" style="border-bottom: 1px #ccc dotted; width:160px; height:25px; line-height: 33px;"></div>
</div><br style="clear:both;"/>

<?php echo $this->Html->link('Neuer Kunde', array('controller' => 'customers', 'action' => 'add'), array('class' => 'newbutton')); ?>
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
<?php
$this->Html->script('livesearch',  array('block' => 'scriptBottom')); 
?>
