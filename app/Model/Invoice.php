<?php
class Invoice extends AppModel{
public $name = 'Invoice';
	
	public $hasMany = array(
        'Invoiceitems' => array(
            'className'     => 'Invoiceitems',
            'foreignKey'    => 'invoiceid',
            'conditions'    => '',
            'order'    => 'Invoiceitems.sortorder ASC',
            'limit'        => '',
            'dependent'=> true
        ),
    );
	
	public $hasOne = array(
		'Invoice_texts' => array(
            'className'     => 'Invoice_texts',
            'foreignKey'    => 'invoice_id',
            'conditions'    => '',
            'order'    => '',
            'dependent'=> true
        )

	);

	
	public $belongsTo =  array(
		'Customer' => array(
            'className'     => 'Customers',
            'foreignKey'    => 'customer_id',
            'conditions'    => '',
            'order'    => ''
        ),
		'Company' => array(
            'className'     => 'Companies',
            'foreignKey'    => '',
            'conditions'    => '',
            'order'    => ''
        ),
		'Invoice_status' => array(
            'className'     => 'Invoice_status',
            'foreignKey'    => 'invoice_status_id',
            'conditions'    => '',
            'order'    => ''
        )
    );
}
?>