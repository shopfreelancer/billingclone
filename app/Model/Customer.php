<?php
App::uses('AuthComponent', 'Controller/Component');
class Customer extends AppModel{
	public $name = 'Customer';


	public $actsAs = array( 
        'Cryptable' => array( 
            'fields' => array( 
                'zdata' 
            ) 
        ) 
    ); 
	
	public $hasMany = array(
        'Customer_blog' => array(
            'className'     => 'Customer_blogs',
            'foreignKey'    => 'customer_id',
            'conditions'    => '',
            'order'    => 'id DESC',
            'limit'        => '',
            'dependent'=> false
        ),
		 'Customer_tickets' => array(
            'className'     => 'Customer_tickets',
            'foreignKey'    => 'customer_id',
            'conditions'    => '',
            'order'    => 'id DESC',
            'limit'        => '',
            'dependent'=> false
        )
    );


}