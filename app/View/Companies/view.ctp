<h2>Ihre Firmendaten</h2>
<div id="mainlisting">
<div class="companyviewaddress">
<?php 
if (!empty($company['Company']['companyname'])){
	echo $company['Company']['companyname'].'<br/>';
}
echo $company['Company']['firstname'].' '.$company['Company']['lastname'].'<br/>';
echo $company['Company']['street'].'<br/>';
echo $company['Company']['postcode'].' '.$company['Company']['city'].'<br/>';
if (!empty($company['Company']['country'])){
	echo $company['Company']['country'].'<br/>';
} ?>
</div>
<div class="companyviewinfo">
<?php
echo 'Tel '. $company['Company']['phone'].'<br/>';
echo 'Fax '. $company['Company']['fax'].'<br/>';
echo 'Email '. $company['Company']['email'].'<br/>';
echo 'www '. $this->Html->link($company['Company']['www'], $company['Company']['www']).'<br/>';
?>
</div>

<div class="formfooter">
</div>
</div>
<div id="mainlistingright">

<?php echo $this->Html->link('bearbeiten', array('action' => 'add', '1'), array('class' => 'newbutton')); ?><br style="clear:both"/>

</div>
<br style="clear:both;"/>