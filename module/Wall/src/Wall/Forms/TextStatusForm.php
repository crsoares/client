<?php

namespace Wall\Forms;

use Zend\Form\Form;
use Zend\Form\Element;

class TextStatusForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('text-content');

		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'well input-append');

		$this->add(array(
			'name' => 'status',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => array(
				'class' => 'span11',
				'placeholder' => 'Como você está?'
			)
		));

		$this->add(new Element\Csrf('csrf'));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Submit',
				'class' => 'btn',
			)
		));
	}
}
