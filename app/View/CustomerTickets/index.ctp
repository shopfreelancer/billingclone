<?php $this->set("title_for_layout",'Tickets &Uuml;bersicht');
?>
<h2>Offene Tickets</h2>
<table class="customertable" width="100%">
	<tr>
		<th width="10px">id</th>
		<th width="180px">Kunde</th>
		<th width="55px">Title</th>
		<th width="120px">Beschreibung</th>
		<th width="120px">Zeit</th>

	</tr>

	<?php 
	if(empty($CustomerTickets[0])){
		echo 'Keine offenen Tickets vorhanden';
	} else {
		$rowcount = 1;
		foreach ($CustomerTickets as $CustomerTicket){
     
		($rowcount&1 == 1) ?  $rowclass = 'roweven' : $rowclass = 'rowodd'
		?>
		<tr class="<?php echo $rowclass;?>">
			<td><?php echo '<span class="grey">'.$CustomerTicket['CustomerTicket']['id'].'</span>'; ?></td>
			<td><?php echo $CustomerTicket['Customer']['companyname'];
			echo '<br/><span class="grey">'.$CustomerTicket['Customer']['firstname'].' '.$CustomerTicket['Customer']['lastname'].'</span>';
			?></td>
			<td><?php echo $CustomerTicket['CustomerTicket']['title']; ?></td>
			<td><?php echo $CustomerTicket['CustomerTicket']['description']; 
			/*
			if(!empty($CustomerTicket['ct']['comment'])){
			echo '<br/><br/>Kommentar:<br/>'.$CustomerTicket['ct']['comment'];
			}
			*/
			?></td>
			<td><?php echo $this->Hours->formatHours($CustomerTicket['CustomerTicket']['hours'],$CustomerTicket['CustomerTicket']['minutes']); ?></td>
		</tr>
		
		<?php
		$rowcount++;
		}
	}
	?>
   

</table>
<br style="clear:both;"/>