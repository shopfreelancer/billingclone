<?php $this->set("title_for_layout",'Artikelvorlagen &Uuml;bersicht'); 
echo '<h2>Artikelvorlagen &Uuml;bersicht</h2>';
 ?>
<div id="mainlisting">
<table class="customertable" width="620px">
	<tr>
		<th width="10px"><?php echo $this->Paginator->sort('id', 'id'); ?></th>
		<th width="210px"><?php echo $this->Paginator->sort('Titel', 'title'); ?></th>
		<th width="400px">Beschreibung</th>
	</tr>

	<?php 
	$rowcount = 1;
	foreach ($draftinvoiceitems as $draftinvoiceitem){
	($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd'
	?>
	<tr class="<?php echo $rowclass;?>">
		<td><?php echo $draftinvoiceitem['Draftinvoiceitem']['id']; ?></td>
		<td><?php echo $draftinvoiceitem['Draftinvoiceitem']['title']; ?><br/>
				<?php echo $this->Html->link('edit', array('controller' => 'draftinvoiceitems', 'action' => 'edit', $draftinvoiceitem['Draftinvoiceitem']['id']), array('class' => 'newbuttonsmall'));?>
		<?php echo $this->Html->link('delete', array('controller' => 'draftinvoiceitems', 'action' => 'delete', $draftinvoiceitem['Draftinvoiceitem']['id']), array('class' => 'deletebuttonsmall'), 'Posten endgültig löschen?');?>
		
		</td>
		<td><?php echo $draftinvoiceitem['Draftinvoiceitem']['description']; ?></td>
	</tr>
	
	<?php
	$rowcount++;
	}?>
   

</table>
</div>
<div id="mainlistingright">
<?php
echo $this->Html->link('Neue Artikelvorlage', array('controller' => 'draftinvoiceitems', 'action' => 'add'), array('class' => 'newbutton')); 
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