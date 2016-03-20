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
	<h1>Login</h1>
		
	</div>
	<div id="main">
	<div id="error_container"><?php echo $this->Session->flash(); ?></div>
	<?php echo $content_for_layout ?>
	</div>
	
	<div id="version">BillingClone v1.0</div>
	</div>
	
	</div>
  <?php // <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script> ?>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $this->webroot; ?>js/jquery-1.4.2.min.js"%3E%3C/script%3E'))</script>

  
  <?php echo $this->fetch('scriptBottom'); ?>
</body>
</html>
