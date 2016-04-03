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
		'freeinvoiceid' => array('allowEmpty' => false,'rule' => array('notBlank'),),
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
			'className'     => 'InvoiceStatus',
			'foreignKey'    => 'invoice_status_id',
		),
		'Invoice_type' => array(
			'className'     => 'Invoice_texts',
			'foreignKey'    => 'invoice_type_id',
		),


    );

	public function __construct($id = false, $table = null, $ds = null)
	{
		parent::__construct($id, $table, $ds);
		$this->setInvoiceTypeNames();
	}

	public function afterFind($results, $primary = false)
	{
		foreach($results as $key => $value){
			$results[$key]['Invoice']["InvoiceTypeName"] = $this->getInvoiceTypeName($results[$key]['Invoice']['invoice_type_id']);
		}
		return $results;
	}


	public function getInvoiceTypeName($invoice_type_id)
	{
		return $this->invoiceTypeNames[$invoice_type_id];
	}

	public function setInvoiceTypeNames()
	{
		if(count($this->invoiceTypeNames) === 0){
			$this->invoiceTypeNames = [1=>'invoice',2=>'offer'];
		}
	}
	

}
?>