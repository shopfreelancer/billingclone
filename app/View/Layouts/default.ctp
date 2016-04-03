<!DOCTYPE html>
<html lang="de" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title_for_layout?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<?php
	$this->Html->script('contentedit', array('block' => 'scriptBottom')); 
	echo $this->Html->css('style.css');
	echo $this->fetch('css');
	?>
	
	
	<?php echo '<script src="'.$this->webroot.'js/modernizr-1.6.min.js"></script>'; ?>
</head>
<body>
	<div id="container">
	<div id="header">
	<h1>Billing Clone</h1>
		<div id="menu">
			<?php echo $this->Html->link('Übersicht', array('controller' => 'overviews', 'action' => 'index')); ?>
			<?php echo $this->Html->link('Kunden', array('controller' => 'customers', 'action' => 'index')); ?>
			<?php echo $this->Html->link('Tickets', array('controller' => 'customer_tickets', 'action' => 'index')); ?>
			<?php echo $this->Html->link('Angebote', array('controller' => 'invoices', 'action' => 'indexoffers')); ?>
			<?php echo $this->Html->link('Rechnungen', array('controller' => 'invoices', 'action' => 'index')); ?>
			<?php echo $this->Html->link('Akquise', array('controller' => 'akquises', 'action' => 'index')); ?>
		</div>
	</div>
	<div id="main">
	<div id="error_container"><?php echo $this->Session->flash(); ?></div>
	<?php echo $content_for_layout ?>
	</div>
	<div id="footer"><?php echo $this->Html->link('Einstellungen', array('controller' => 'companies', 'action' => 'index'), array('class' => 'footerlink')).' '; 
	echo $this->Html->link('Textbausteine', array('controller' => 'textdrafts', 'action' => 'index'), array('class' => 'footerlink')).' ';
	echo $this->Html->link('Artikelvorlagen', array('controller' => 'draftinvoiceitems', 'action' => 'index'), array('class' => 'footerlink')); 
	echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'newbuttonsmall footerlogout')); ?>
	<div id="version">BillingClone v1.0</div>
	</div>
	
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <?php // <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script> ?>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $this->webroot; ?>js/jquery-1.4.2.min.js"%3E%3C/script%3E'))</script>

  
  <?php echo $this->fetch('scriptBottom'); ?>
</body>
</html>
