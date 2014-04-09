<?php

namespace Wall\Forms;

use Zend\Form\Form;
use Zend\Form\Element;

class LinkForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('link-content');
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'well input-append');

		$this->prepareElements();
	}

	protected function prepareElements()
	{
		$this->add(array(
			'name' => 'url',
			'type' => 'Zend\Form\Element\Url',
			'attributes' => array(
				'class' => 'span11'
			)
		));

		$this->add(new Element\Csrf('csrf'));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Submit',
				'class' => 'btn'
			),
		));
	}
}