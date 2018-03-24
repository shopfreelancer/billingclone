<?php

class CustomerTicket extends AppModel {

    public $belongsTo = array(
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
        )
    );

}

?>