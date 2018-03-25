<?php
class Invoice extends AppModel{
	
	public $name = 'Invoice';
	protected $invoiceTypeNames = [];

	public $validate = array(
            'customer_id' => array(
                'required' => 'add',
                'rule' => array('notBlank'),
                'allowEmpty' => false
            ),
            'freeinvoiceid' => array('allowEmpty' => false,'rule' => array('notBlank')),
	);
	
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
            ),
	);

	public $belongsTo =  array(
	    'Customer' => array(
                'foreignKey'    => 'customer_id',
            ),
            'Company' => array(
                'className'     => 'Companies',
                'foreignKey'    => '',
                'conditions'    => '',
                'order'    => ''
            ),
            'Invoice_status' => array(
		'className'     => 'InvoiceStatus',
		'foreignKey'    => 'invoice_status_id',
            ),
            'Invoice_type' => array(
                'className'     => 'Invoice_texts',
		'foreignKey'    => 'invoice_type_id',
            ),
        );
}
?>