<?php
class InvoiceTextType extends AppModel{

	public $hasMany = array(
		'Textdraft' => array(
			'foreignKey'	=> "invoice_text_type_id",
			/*
			'conditions' => array(
				'AND' => array(
					'InvoiceTextType.invoice_type_id' => "Textdraft.invoice_type_id"
				)
			),
			*/

		)
	);


}
?>