<?php $this->set("title_for_layout","Textbausteine"); ?>
<h2>Textbausteine</h2>
<div id="mainlisting">
<table class="customertable" width="625px">
	<tr>
		<th width="50px">Titel</th>
		<th width="515px">Text</th>
		<th width="25px">DB-Feld</th>
		<th width="25px">Typ</th>
		<th width="10px">Default</th>
		
	</tr>
	<tr>
<?php 
$rowcount = 1;
foreach($textdrafts as $textdraft){
	($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd';
	
	echo '<tr class="'.$rowclass.'">';
	echo '<td>'.$textdraft['Textdraft']['title'].'</td>';
	echo '<td>'.nl2br($textdraft['Textdraft']['textdraft']).'<br/>';
	echo $this->Html->link('edit', array('controller' => 'textdrafts', 'action' => 'edit', $textdraft['Textdraft']['id']), array('class' => 'newbuttonsmall')).' ';
	echo $this->Html->link('delete', array('controller' => 'textdrafts', 'action' => 'delete', $textdraft['Textdraft']['id']), array('class' => 'deletebuttonsmall'), 'Textbaustein endgültig löschen?');
	echo '</td>'; 
	echo '<td>'.$textdraft['Textdraft']['field'].'</td>';
	echo '<td>'.$textdraft['Textdraft']['type'].'</td>';
	echo '<td>'.$textdraft['Textdraft']['defaultvalue'].'</td>';
	echo '</tr>';
	$rowcount++;
}
?>

</table>
</div>
<div id="mainlistingright">
<?php echo $this->Html->link('Neuer Textbaustein', array('controller' => 'textdrafts', 'action' => 'add'), array('class' => 'newbutton')); ?>
</div>
<br style="clear:both;"/>
