<?php
class InvoiceType extends AppModel{

	public $useTable = "invoice_types";


	public $belongsTo = array(
		'Invoice' => array(
			'foreignKey'	=> 'invoice_type_id'
		),
		'Textdraft' => array(
			'foreignKey'	=> 'invoice_type_id'
		)
	);


	public $hasOne = array(
		'Invoice_text_type' => array(
			'foreignKey'	=> 'invoice_text_type_id'
		),
	);

}
?>