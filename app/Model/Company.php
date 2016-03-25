<?php
class Company extends AppModel{
public $name = 'Company';

public $validate = array(
		'lastname' => array(
			'rule' => 'notBlank',
			'message' => 'Bitte ausfüllen'
		),
		'street' => array(
			'rule' => 'notBlank',
			'message' => 'Bitte ausfüllen'
		),
		'postcode' => array(
			'rule' => 'notBlank',
			'message' => 'Bitte ausfüllen'
		),
		'city' => array(
			'rule' => 'notBlank',
			'message' => 'Bitte ausfüllen'
		),
	);

}
?>