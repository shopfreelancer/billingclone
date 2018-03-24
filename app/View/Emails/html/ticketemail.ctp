<?php

/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

Hallo <?php echo $customerTicket['Customer']['firstname'] ?> <?php echo $customerTicket['Customer']['lastname'] ?>,<br/>
folgende Aufgabe wurde soeben von mir umgesetzt:<br/><br/>
<?php echo nl2br($customerTicket['CustomerTicket']['description']);?> <br/><br/>
Aufgewendete Zeit: <?php echo $this->Hours->formatHours($customerTicket['CustomerTicket']['hours'], $customerTicket['CustomerTicket']['minutes']); ?><br/>
<br/><br/>

    <?php
        if (empty($customerTicket['CustomerTicket']['price_rate'])) {
            $ticket_pricerate = $customerTicket["Customer"]["customer_rate"];
        } else {
            $ticket_pricerate = $customerTicket['CustomerTicket']['price_rate'];
        }

    ?>
Ticket erstellt am: <?php echo $this->Time->format('d.m.Y H:i', $customerTicket['CustomerTicket']['created']);?> <br/>
Ticket geschlossen am: <?php echo $this->Time->format('d.m.Y H:i', $customerTicket['CustomerTicket']['modified']); ?>
<br/><br/>
zum vereinbarten Stundensatz von <?php echo $ticket_pricerate; ?> EUR zzgl. USt
<br/><br/>

Ich bitte darum, die hier aufgeführten Änderungen zu überprüfen.
<br/>Besten Dank!<br/><br/>
<?php echo nl2br($company["Company"]['email_sie']); ?>

<br/><br/> <?php echo nl2br($company["Company"]["emailsignature"]);?>
<br/><br/>