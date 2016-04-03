<?php $this->Html->css('printinvoice.css', NULL,array('media' => 'print', 'inline' => FALSE)); 
if($invoice['Invoice']['type'] == 'invoice') {
	$pagetitle = 'Rechnungsansicht';
	$type_name = 'Rechnung';
	$addlinkname = 'Neue Rechnung';
	$indexlink = $this->Html->link('Übersicht', array('controller' => 'invoices', 'action' => 'index'), array('class' =>'newbutton'));
} 
if($invoice['Invoice']['type'] == 'offer') {
	$pagetitle = 'Angebotsansicht';
	$type_name = 'Angebot';
	$addlinkname = 'Neues Angebot';
	$indexlink = $this->Html->link('Übersicht', array('controller' => 'invoices', 'action' => 'indexoffer'), array('class' =>'newbutton'));
} 

$this->set("title_for_layout",$pagetitle);
?>

<h2><?php echo $type_name.'snummer '.$invoice['Invoice']['freeinvoiceid']; ?></h2>
<div id="mainlisting">
<div id="invoicestatus"><?php echo $type_name.'sstatus: '.$invoice['Invoice_status']['invoicestatus']; ?></div>
	<div id="invoiceview">
	<?php echo '<img id="printlogo" src="'.$this->webroot.'img/company_logo.jpg" alt="'.$invoice['Company']['companyname'].'" />'; ?>
	<div class="ivcompany">
		<?php 
		if(!empty($invoice['Company']['companyname'])){echo $invoice['Company']['companyname'].'<br/>';}
		if(!empty($invoice['Company']['lastname'])){echo $invoice['Company']['firstname'].' '.$invoice['Company']['lastname'].'<br/>';}
		echo $invoice['Company']['street'].'<br/>';
		echo $invoice['Company']['postcode'].' '.$invoice['Company']['city'].'<br/>';
		?>
	</div>
	<div class="ivcustomeraddress">
		<?php echo nl2br($invoice['Invoice_texts']['billingaddress']); ?>
	</div>
	<div class="ivdate">
	<?php
	echo $type_name.'snummer '.$invoice['Invoice']['freeinvoiceid'].'<br/>';
	echo 'Datum '.$invoice['Invoice']['invoicedate'].'<br/>';
	?>
	</div>
	<div class="betreffwrap">
	<?php 
	if(empty($invoice['Invoice_texts']['betreff'])){
		echo '<b>'.$type_name.' '.$invoice['Invoice']['freeinvoiceid'].'</b><br/>';
	} else{
		echo '<b>'.$invoice['Invoice_texts']['betreff'].'</b><br/>'; 
	}
	?>
	
	</div>
	<div class="ivanrede">
	<?php echo nl2br($invoice['Invoice_texts']['top']).'<br/>';?>
	</div>
	<div><?php echo $this->Html->link('Neuer Posten', array('controller' => 'invoiceitems', 'action' => 'add', $invoice['Invoice']['id'] ), array('class' => 'newbuttonsmall'));
	echo $this->Html->link('Artikelvorlage einfügen', array('controller' => 'invoiceitems', 'action' => 'importdraft', $invoice['Invoice']['id'] ), array('class' => 'newbuttonsmall'));
		echo $this->Html->link('Tickets einfügen', array('controller' => 'invoiceitems', 'action' => 'importtickets', $invoice['Invoice']['id'] ), array('class' => 'newbuttonsmall'));
	?>
	<div id="ivbreakdown">
		     <table cellpadding="0" cellspacing="0">
            	<tr class="heading">
                	<td width="10px">Pos</td><td>Beschreibung</td><td width="175px" style="text-align:right;">Netto</td>
                </tr>
	<?php
	foreach($invoice['Invoiceitems'] as $invoiceitem){ ?>

	<tr class="title">
		<td width="10px"><?php echo '['.$invoiceitem['sortorder'].']';?></td>
		<td><?php echo $invoiceitem['title']; ?></td>
		<td class="sum_amount"><?php echo $this->Price->formatPrice($invoiceitem['amountnet']); ?></td>
    </tr>
    <tr class="description">
		<td width="10px"></td>
		<td><div class="tably"><?php echo nl2br($invoiceitem['description']); ?></div><br/>
		<?php echo $this->Html->link('edit', array('controller' => 'invoiceitems', 'action' => 'edit', $invoiceitem['id']), array('class' => 'newbuttonsmall'));?>
		<?php echo $this->Html->link('delete', array('controller' => 'invoiceitems', 'action' => 'delete', $invoiceitem['id']), array('class' => 'deletebuttonsmall'), 'Posten endgültig löschen?');?>
		</td>
		<td></td>
    </tr>
	
<?php
	}
	?>
	</table>
	<table cellpadding="0" cellspacing="0" id="sumtable">   
				
                <tr class="heading">
                	<td class="sum_descr">Summe (Netto)</td><td class="sum_amount"><?php echo $this->Price->formatPrice($invoice['Invoice']['amountnet']); ?></td>
                </tr>
                <tr class="heading">
                    <td class="sum_descr">Umsatzsteuer (<?php echo $invoice['Invoice']['taxrate'];?> %)</td><td class="sum_amount"><?php echo $this->Price->formatPrice($invoice['Invoice']['amounttax']); ?></td>
                </tr>
                <tr class="heading">
                	<td class="total sum_descr">Gesamtbetrag</td><td class="total sum_amount"><?php echo $this->Price->formatPrice($invoice['Invoice']['amounttotal']); ?></td>
                </tr>
    </table>
	</div>
	<br style="clear:both;" />

	<div class="ivgreetings">
		<?php 
		echo '<div id="notebottom">'.nl2br($invoice['Invoice_texts']['notebottom']).'</div>';
		echo '<div id="bottom">'.nl2br($invoice['Invoice_texts']['bottom']).'</div>';
		?>
	</div>
	
	<div class="ivfooter clearfix">
		<div class="ivfootercol">
		<?php
			echo 'Kontoinhaber '.$invoice['Company']['bankaccountholder'].'<br/>';
			echo 'Kontonummer '.$invoice['Company']['bankaccountnumber'].'<br/>';
			echo 'Bankleitzahl '.$invoice['Company']['bankaccountcode'].'<br/>';
			echo 'Kreditinstitut '.$invoice['Company']['bankname'].'<br/>';
			
	
			
			?>
		</div>
		<div class="ivfootercol">
			<?php echo 'Verwendungszweck '.$invoice['Invoice']['freeinvoiceid'].'<br/>';?>
		</div>
		<div class="ivfootercol">
			<?php echo 'Steuernummer '.$invoice['Company']['taxnumber'].'<br/>';
			if(!empty($invoice['Company']['ustid'])) echo 'UST ID '.$invoice['Company']['ustid'].'<br/>';
			echo 'Internet '.$invoice['Company']['www'].'<br/>';
			echo 'Email '.$invoice['Company']['email'].'<br/>';
			echo 'Tel '.$invoice['Company']['phone'].'<br/>';
			?>
		</div>
	</div>
</div>
</div>	
</div>
<div id="mainlistingright">
<?php echo $this->Html->link($type_name.' speichern', array('controller' => 'invoices', 'action' => 'save',$invoice['Invoice']['id']), array('class' =>'newbutton'));?><br style="clear:both"/>
<?php echo $this->Html->link($type_name.' löschen', array('action' => 'delete', $invoice['Invoice']['id']),array('class' =>'cancelbutton'), $type_name.' wirklich löschen?' )?>
<?php echo $this->Html->link($type_name.' bearbeiten', array('action' => 'edit', $invoice['Invoice']['id']), array('class' => 'newbutton')); ?><br style="clear:both"/>
<?php echo $this->Html->link($type_name.' klonen', array('action' => 'clonen', $invoice['Invoice']['id']), array('class' => 'newbutton')); ?><br style="clear:both"/>
<?php if($invoice['Invoice']['type'] == 'offer') {
echo $this->Html->link('Angebot zu Rechnung', array('action' => 'offertoinvoice', $invoice['Invoice']['id']), array('class' => 'newbutton')).'<br style="clear:both"/>'; 
}
echo $this->Html->link('PDF erzeugen', array('action' => 'invoicePdf', $invoice['Invoice']['id']), array('class' => 'newbutton')); ?><br style="clear:both"/>
<?php
echo $this->Html->link('Download', array('action' => 'download', $invoice['Invoice']['id']), array('class' => 'newbutton')); ?><br style="clear:both"/>
<?php
if($this->Time->format('Y',$invoice['Invoice']['emailsent']) < 2000){
echo $this->Html->link('PDF als Email senden', array('action' => 'validateEmailBeforeSend', $invoice['Invoice']['id']), array('class' => 'newbutton'));
} else {
echo "Email bereits versandt am ".$this->Time->format('d.m.Y H:i',$invoice['Invoice']['emailsent'])."<br/>";
echo $this->Html->link('nochmal senden', array('action' => 'sendEmailReview', $invoice['Invoice']['id']));
}
?><br style="clear:both"/>
<hr>
<?php echo $indexlink; ?><br style="clear:both"/>
<?php echo $this->Html->link($addlinkname, array('controller' => 'invoices', 'action' => 'add', $invoice['Invoice']['type']), array('class' => 'newbutton'));
?><br style="clear:both"/>
</div>
<br style="clear:left;"/>