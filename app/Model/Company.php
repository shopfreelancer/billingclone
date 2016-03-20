<?php
class Company extends AppModel{
public $name = 'Company';

public $validate = array(
		'lastname' => array(
			'rule' => 'notEmpty',
			'message' => 'Bitte ausfüllen'
		),
		'street' => array(
			'rule' => 'notEmpty',
			'message' => 'Bitte ausfüllen'
		),
		'postcode' => array(
			'rule' => 'notEmpty',
			'message' => 'Bitte ausfüllen'
		),
		'city' => array(
			'rule' => 'notEmpty',
			'message' => 'Bitte ausfüllen'
		),
	);

}
?>