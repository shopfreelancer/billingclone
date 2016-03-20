<?php
echo '<span class="sendemailreviewtext">An:</span> '.$invoice["Customer"]["email"].'<br/><br/>';
echo '<span class="sendemailreviewtext">Subject:</span> '.$subject.'<br/><br/>';
echo '<span class="sendemailreviewtext">Text:</span><br/>'.$body.'<br/><br/>';

echo '<span class="sendemailreviewtext">Anhang:</span>'.$filename;
echo '<br/><br/>';
echo $this->Html->link('Email senden', array('action' => 'sendEmail', $invoice['Invoice']['id']), array('class' => 'newbutton'));
echo '<br/><br/>';
?>
