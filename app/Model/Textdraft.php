<?php
class Textdraft extends AppModel{

	public $belongsTo = array(
		'InvoiceTextType' => array(
			'foreignKey'	=> 'invoice_text_type_id'
		),
		'invoice_type' => array(
			'foreignKey'	=> 'invoice_type_id'
		),
	);
}
?>