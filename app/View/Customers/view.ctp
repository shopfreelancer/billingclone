<?php $this->set("title_for_layout","Kunden Detailansicht");?>
<h2>
<?php
if (!empty($customer['Customer']['companyname'])){
	echo $customer['Customer']['companyname'];
} else {
	echo $customer['Customer']['firstname'].' '.$customer['Customer']['lastname'];
}
?>
</h2>
<div id="mainlisting">
<p class="customerviewkundennummer"><?php echo 'Kundennummer '. $customer['Customer']['id'];?></p>
<div class="customerviewaddress">
<?php 
if (!empty($customer['Customer']['companyname'])){
	echo $customer['Customer']['companyname'].'<br/>';
}
echo $customer['Customer']['firstname'].' '.$customer['Customer']['lastname'].'<br/>';
echo $customer['Customer']['street'].'<br/>';
echo $customer['Customer']['postcode'].' '.$customer['Customer']['city'].'<br/>';
if (!empty($customer['Customer']['country'])){
	echo $customer['Customer']['country'].'<br/>';
} ?>
</div>
<div class="customerviewinfo">
<?php
echo 'Tel '. $customer['Customer']['phone'].'<br/>';
echo 'Handy '. $customer['Customer']['handy'].'<br/>';
echo 'Fax '. $customer['Customer']['fax'].'<br/>';
echo 'Email '. $customer['Customer']['email'].'<br/>';
echo 'www '. $this->Html->link($customer['Customer']['www'], $customer['Customer']['www']).'<br/>';
?>
</div>
<div class="customerviewnote">
<?php echo 'Aktueller Stundensatz '.$customer['Customer']['customer_rate'].' EUR<br/><br/>'; ?>
<?php echo '<b>Notiz</b><br/>'. nl2br($customer['Customer']['description']).'<br/>';?>
</div>

<?php if(!empty($customer['Customer']['zdata'])){
echo '<div class="customerviewnote"><b>Zugangsdaten Sec</b><br/>'. nl2br(htmlspecialchars($customer['Customer']['zdata'])).'<br/></div>';
}?>

<?php
if(empty($invoices)){
echo '<p class="grey">Keine Angebote oder Rechnungen für den Kunden gefunden.</p>';
} else {
echo '<p class="grey">Folgende Dokumente liegen vor:</p><br/>';
	foreach($invoices as $invoice){
	$type_name = $this->Invoice->formatInvoiceName($invoice);
	echo '<span class="cview_type">'.$type_name.'</span> '.$invoice['Invoice']['invoicedate'].' '.$invoice['Invoice']['freeinvoiceid'].' <span class="cview_price">'.$this->Price->formatPrice($invoice['Invoice']['amounttotal']).'</span> '.
	'<span class="cview_status">'.$invoice['Invoice_status']['invoicestatus'].'</span> '.
	$this->Html->link('Link zu '.$type_name  , array('controller' => 'invoices', 'action' => 'view', $invoice['Invoice']['id'])).' ';
if($this->Time->format('Y',$invoice['Invoice']['emailsent']) > 2000){	
	echo "Email: ".$this->Time->format('d.m.Y H:i',$invoice['Invoice']['emailsent']);
}
	echo '<br/>';
	}
}

if(!empty($customer['Customer_tickets'])){
	echo '<br/><p class="grey">Folgende offene Serviceeinheiten liegen vor:</p><br/>';
	
	foreach($customer['Customer_tickets'] as $customer_ticket){
		if((int)$customer_ticket['active'] === 1){
			echo '<div class="customerblogid" style="display:none;">'.$customer_ticket['id'].'</div>';
			
			echo '<div class="blog_heading">Change Request '.$customer_ticket['title'].'</div>';
			echo '<div contenteditable="true" class="blog_entry">'.nl2br($customer_ticket['description']).'</div>';
			echo '<div contenteditable="true" class="blog_entry">'.nl2br($customer_ticket['comment']).'</div>';
			echo '<div class="blog_entry">'.$this->Hours->formatHours($customer_ticket['hours'],$customer_ticket['minutes']).'</div>';
			
			echo $this->Html->link('delete', array('controller' => 'customer_tickets', 'action' => 'delete', $customer_ticket['id']), array('class' => 'deletebuttonsmall dnone'), 'Posten endgültig löschen?');
		  echo $this->Html->link('edit', array('controller' => 'customer_tickets', 'action' => 'edit', $customer_ticket['id']), array('class' => 'dnone newbuttonsmall'));
 		echo $this->Html->link('send Email', array('controller' => 'customer_tickets', 'action' => 'sendEmail', $customer_ticket['id']), array('class' => 'dnone newbuttonsmall sendemailbutton')).'<br style="clear:both;"/>';		  
		}
	}
}



if(!empty($customer['Customer_blog'])){
	echo '<br/><p class="grey">Folgende Blogeintr&auml;ge liegen vor:</p><br/>';
	
	foreach($customer['Customer_blog'] as $customer_blog){
	echo '<div class="customerblogid" style="display:none;">'.$customer_blog['id'].'</div>';
	
	echo '<div class="blog_heading">'.date('d.m.Y', strtotime($customer_blog['created'])).' '.$customer_blog['title'].'</div>';
	echo '<div contenteditable="true" class="blog_entry">'.nl2br($customer_blog['description']).'</div>';
	
	echo $this->Html->link('delete', array('controller' => 'customer_blogs', 'action' => 'delete', $customer_blog['id']), array('class' => 'deletebuttonsmall dnone'), 'Posten endgültig löschen?');
  echo $this->Html->link('edit', array('controller' => 'customer_blogs', 'action' => 'edit', $customer_blog['id']), array('class' => 'dnone newbuttonsmall')).'<br style="clear:both;"/>';

	}
}
?>
<div class="formfooter">
</div>
</div>
<div id="mainlistingright">
<?php 
echo $this->Html->link('Übersicht', array('controller' => 'customers', 'action' => 'index',''), array('class' =>'newbutton')).'<br style="clear:both"/>';
echo $this->Html->link('Neuer Kunde', array('controller' => 'customers', 'action' => 'add'), array('class' => 'newbutton')).'<br style="clear:both"/>';
echo $this->Html->link('Kunde löschen', array('action' => 'delete', $customer['Customer']['id']),array('class' =>'cancelbutton'), 'Kundendaten wirklich löschen?' );
echo $this->Html->link('Kunde bearbeiten', array('action' => 'add', $customer['Customer']['id']), array('class' => 'newbutton')); 
if(!empty($customer['Customer_blog'])){
	echo '<a href="#" id="editbuttonsnone" class="newbutton">Edit Buttons</a><br style="clear:both"/>';
} 
echo $this->Html->link('Neues Kundenblog', array('controller' => 'customer_blogs', 'action' => 'add', $customer['Customer']['id']), array('class' => 'newbutton'));
echo $this->Html->link('Neues Ticket', array('controller' => 'customer_tickets', 'action' => 'add', $customer['Customer']['id']), array('class' => 'newbutton')); 
 
?>
<br style="clear:both"/>

</div>
<br style="clear:both;"/>