<?php
App::import('Vendor','xtcpdf');
$pdf = new XTCPDF();
$textfont = 'helvetica';

$pdf->SetAuthor($invoice['Company']['companyname']);
$pdf->SetTitle($invoice['Invoice']['freeinvoiceid']);
$pdf->SetSubject($invoice['Invoice']['freeinvoiceid']);
$pdf->SetKeywords($invoice['Company']['companyname'], 'Rechnung', $invoice['Invoice']['freeinvoiceid']);

$pdf->SetMargins(PDF_MARGIN_LEFT, 10, 17);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(25);

$pdf->setHeaderFont(array($textfont,'',10));
$pdf->xheadercolor = array(255,255,255);
$pdf->xheadertext = '';


$foot = '<table>
<tr>
<td>Kontoinhaber '.$invoice['Company']['bankaccountholder'].'</td>
<td>Kreditinstitut '.$invoice['Company']['bankname'].'</td>
<td>Umsatzsteuernummer '.$invoice['Company']['ustid'].'</td>
</tr>
<tr>
<td>Verwendungszweck '.$invoice['Invoice']['freeinvoiceid'].'</td>
<td>IBAN '.$invoice['Company']['bankaccountiban'].'</td>
<td></td>
</tr>
<tr>
<td>Kontonummer '.$invoice['Company']['bankaccountnumber'].'</td>
<td>BIC / Swift '.$invoice['Company']['bankaccountswift'].'</td>
<td></td>
</tr>
<tr>
<td>Bankleitzahl '.$invoice['Company']['bankaccountcode'].'</td>
<td></td>
<td></td>
</tr>
</table>';

$pdf->xfootertext = $foot ;


// Tel. '.$invoice['Company']['phone'].' / '.$invoice['Company']['email'].' /  '.$invoice['Company']['www'];

$pdf->SetAutoPageBreak(TRUE,25.00); 

$pdf->AddPage();


if($invoice['Invoice']['type'] == 'invoice') {
	$type_name = 'Rechnung';
	$addlinkname = 'Neue Rechnung';
} 
if($invoice['Invoice']['type'] == 'offer') {
	$type_name = 'Angebot';
	$addlinkname = 'Neues Angebot';
} 


// Header Firmenlogo und Anschrift
$company_logo = '<img src="'.$this->webroot.'app/webroot/img/company_logo.jpg" alt="'.$invoice['Company']['companyname'].'" width="200"/>';
$company_address = $invoice['Company']['companyname'].'<br/>'.$invoice['Company']['firstname'].' '.$invoice['Company']['lastname'].'<br/>'.
$invoice['Company']['street'].'<br/>'.
$invoice['Company']['postcode'].' '.$invoice['Company']['city'].'<br/>
<br/>Tel. '.
$invoice['Company']['phone'].'<br/>'.$invoice['Company']['email'].'<br/>'.$invoice['Company']['www'];

$pdf->SetFont($textfont,'',10);
$pdf->writeHTMLCell(100, 0, '', '', $company_logo, 0, 0,false, true, 'L', true);
$pdf->SetFont($textfont,'',8);
$pdf->writeHTMLCell(80, 0, 115, '', $company_address, 0, 0, false, true, 'R', true);

$pdf->Ln();




$pdf->SetFont($textfont,'',5);
$company_address2 = $invoice['Company']['firstname'].' '.$invoice['Company']['lastname'].' | '.
$invoice['Company']['street'].' | '.$invoice['Company']['postcode'].' '.$invoice['Company']['city'];
$pdf->writeHTMLCell(0, 0, '', '45', $company_address2, 0, 0,false, true, 'L', true);


// Rechnungsanschrift
$pdf->SetFont($textfont,'',10);
$billingaddress = nl2br($invoice['Invoice_texts']['billingaddress']);

// 	public function writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true) {
$pdf->writeHTMLCell(90, 0, '', '50', $billingaddress, 0, 1, false, true,'L', true);
$pdf->Ln(12);

$date = $type_name.' '.$invoice['Invoice']['freeinvoiceid'].'<br/>'.
$type_name.'sdatum '.$invoice['Invoice']['invoicedate'].'<br/>';
$pdf->SetFont($textfont,'',8);
$pdf->writeHTMLCell(40, 0, 155, '', $date, '', 1, 0, true, 'R', true);

// Betreff
if(!empty($invoice['Invoice_texts']['betreff'])){
	$betreff = '<b>'.$invoice['Invoice_texts']['betreff'].'</b>';
} else {
	$betreff = '<b>'.$type_name.' '.$invoice['Invoice']['freeinvoiceid'].'</b>';
}
$pdf->SetLineWidth(0.208);
$pdf->SetDrawColor(220,220,220);
$pdf->SetFont($textfont,'',10);
$pdf->writeHTMLCell(0, 0, '', '', $betreff, 'B', 0 ,false, true,'L', true);
$pdf->Ln(8);

// Anrede 
$pdf->SetFont($textfont,'',10);
$itop = nl2br($invoice['Invoice_texts']['top']).'<br/><br/>';
$pdf->writeHTMLCell(0, 0, '', '', $itop, 0, 'TB',false, true,'L', true);
$pdf->Ln();


// Postenblock
$rowwidth1 = 20;
$rowwidth2 = 127;
$rowwidth3 = 30;
$rowwidth4 = 12;
$pdf->SetFont($textfont,'',8);

$pdf->writeHTMLCell($rowwidth1, 0, '', '', 'Pos', 0, 0,0, true,'L', true);
$pdf->writeHTMLCell($rowwidth2, 0, '', '', 'Beschreibung', 0, 0,0, true,'L', true);
$pdf->writeHTMLCell($rowwidth4, 0, '', '', '', 0, 0,0, true,'L', true);
$pdf->writeHTMLCell($rowwidth3, 0, '', '', 'Summe', 0, 0,0, true,'L', true);
$pdf->Ln(3);
$pdf->SetLineWidth(0.208);
$pdf->SetDrawColor(220,220,220);
$pdf->writeHTMLCell(0, 0, '', '', '', 'B', 0 ,false, true,'L', true);
$pdf->Ln(6);

foreach($invoice['Invoiceitems'] as $invoiceitem){ 
	$pdf->Ln(1);
	
	$pdf->writeHTMLCell($rowwidth1, 0,'','', $invoiceitem['sortorder'], 0, 0,false, true,'L', true);
	$pdf->writeHTMLCell($rowwidth2, 0, '', '', '<b>'.$invoiceitem['title'].'</b>', 0, 0,false, true,'L', true);
	$pdf->writeHTMLCell($rowwidth4, 0, '', '', '', 0, 0,false, true,'L', true);
	$pdf->writeHTMLCell($rowwidth3, 0, '', '', $this->Price->formatPrice($invoiceitem['amountnet']).'<br/>', 0, 0,false, true,'L', true);
	$pdf->writeHTMLCell(0, 0, '', '', '<br/>', 0, true,0, false,'L', true);
	$pdf->Ln(1);
	$y = $pdf->GetY();
	$x = $pdf->GetX();
	$pdf->writeHTMLCell($rowwidth2, '',35,$y, nl2br($invoiceitem['description']).'<br/>', 0, true ,0, true,'L', false);

}

// $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->Ln();

// Summe
$sumtable = '<table cellpadding="0" cellspacing="0" width="220px">
                <tr>
                	<td>Summe (Netto)</td><td class="sum_amount">'.$this->Price->formatPrice($invoice['Invoice']['amountnet']).'<br/></td>
                </tr>
                <tr>
                    <td>Umsatzsteuer ('.$invoice['Invoice']['taxrate'].' %)</td><td class="sum_amount">'.$this->Price->formatPrice($invoice['Invoice']['amounttax']).'<br/></td>
                </tr>
                <tr>
                	<td class="total sum_descr"><b>Gesamtbetrag</b></td><td class="total sum_amount"><b>'.$this->Price->formatPrice($invoice['Invoice']['amounttotal']).'</b><br/></td></tr>
</table><br/><br/>';
$pdf->Ln(2);
$y = $pdf->GetY();
$pdf->writeHTMLCell(35, '', 135, '', $sumtable, 0, 1,false, true,'L', false);
$pdf->Ln(0);


$pdf->SetFont($textfont,'',10);

// zusätzliche Notiz unten
if(!empty($invoice['Invoice_texts']['notebottom'])){
$y = $pdf->GetY();
$x = $pdf->GetX();
$notebottom = nl2br($invoice['Invoice_texts']['notebottom']);
$pdf->writeHTMLCell(0, 1, '', $y, $notebottom, 0, 1,false, true,'L', true);
$pdf->Ln(2);
}

// Grussformel
$y = $pdf->GetY() +4;

$y = $pdf->GetY() - 2;
$ibottom = '<img src="'.$this->webroot.'app/webroot/img/unterschrift.jpg" alt=""/><br/>'.nl2br($invoice['Invoice_texts']['bottom']).'<br/><br/>';
$pdf->writeHTMLCell(0, 0, '', $y, $ibottom, 0, 2,false, true,'L', true);

$pdf->Ln(5);

// nur bei Angeboten: Feld für Datum und Unterschrift
if($invoice['Invoice']['type'] == 'offer') {
	$offer_bottom_block1 = 'Ort, Datum';
	$offer_bottom_block2 = 'Unterschrift , ggfs. Firmenstempel';
	
	$pdf->Ln(4);
	$pdf->SetLineWidth(0.208);
	$pdf->SetDrawColor(220,220,220);
	$y = $pdf->GetY();
	$pdf->writeHTMLCell(70, 0, '', $y, '', 'B', 1 ,false, true,'L', true);
	$pdf->writeHTMLCell(70, 0, 100, $y, '', 'B', 1 ,false, true,'L', true);
	$pdf->Ln(2);
	$pdf->writeHTMLCell(70, 4, '', '', $offer_bottom_block1, 0, 0, false, true, 'L', true);
	$pdf->writeHTMLCell(70, 4, 100, '', $offer_bottom_block2, 0, 0, false, true, 'L', true);
	$pdf->Ln(6);
}

// Footer Kontodaten
$pdf->SetFont($textfont,'',8);

$footer_row1 =  '<b>Kontodaten</b><br/>';
$footer_row1 .= 'Kontoinhaber '.$invoice['Company']['bankaccountholder'].'<br/>';
$footer_row1 .= 'Kontonummer '.$invoice['Company']['bankaccountnumber'].'<br/>';
$footer_row1 .= 'Bankleitzahl '.$invoice['Company']['bankaccountcode'].'<br/>';
$footer_row1 .= 'Kreditinstitut '.$invoice['Company']['bankname'].'<br/>';

$footer_row2 = '<br/><br/>Verwendungszweck '.$invoice['Invoice']['freeinvoiceid'].'<br/><br/>';
$footer_row2 .= 'IBAN '.$invoice['Company']['bankaccountiban'].'<br/>';
$footer_row2 .= 'BIC / Swift '.$invoice['Company']['bankaccountswift'].'<br/>';
$footer_row3 = '<br/><br/>Umsatzsteuernummer '.$invoice['Company']['ustid'].'<br/>';


// $footer_row3 .= 'Steuernummer '.$invoice['Company']['taxnumber'].'<br/>';
/*
$footer_row3 = 'Tel '.$invoice['Company']['phone'].'<br/>';
$footer_row3 .= $invoice['Company']['www'].'<br/>';
$footer_row3 .= $invoice['Company']['email'].'<br/>';
*/

/*
$pdf->SetLineWidth(0.208);
$pdf->SetDrawColor(220,220,220);
$pdf->writeHTMLCell(0, 0, '', '', '', 'B', 1 ,false, true,'L', true);
$pdf->Ln(2);
$pdf->writeHTMLCell(60, 4, '', '', $footer_row1, 0, 0,'0', 1, 0);
$pdf->writeHTMLCell(70, 4, '', '', $footer_row2, 0, 0,'0', 1, 0);
$pdf->writeHTMLCell(60, 4, '', '', $footer_row3, 0, 0,'0', 1, 0);
$pdf->Ln(18);
$pdf->SetLineWidth(0.208);
$pdf->SetDrawColor(220,220,220);
$pdf->writeHTMLCell(0, 0, '', '', '', 'B', 1 ,false, true,'L', true);

$pdf->Ln();
$pdf->SetFont($textfont,'',10);
*/

$pdf->lastPage();
$pdf->Output($filename, 'FD');
  
?>