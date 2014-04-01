<?php

namespace Wall\Entity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Status
{
	protected $id = null;
	protected $userId = null;
	protected $status = null;
	protected $createdAt = null;
	protected $updatedAt = null;

	public function setId($id)
	{
		$this->id = (int)$id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setUserId($userId)
	{
		$this->userId = (int)$userId;
		return $this;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = new \DateTime($updatedAt);
		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = new \DateTime($updatedAt);
		return $this;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public static function getInputFilter()
	{
		$inputFilter = new InputFilter();
		$factory = new InputFactory();

		$inputFilter->add($factory->createInput(array(
			'name' => 'status',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 65535,
					)
				)
			)
		)));

		return $inputFilter;
	}
}