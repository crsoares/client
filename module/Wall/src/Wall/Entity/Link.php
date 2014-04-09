<?php

namespace Wall\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

class Link
{
	protected $id = null;
	protected $userId = null;
	protected $url = null;
	protected $title = null;
	protected $createdAt = null;
	protected $updatedAt = null;

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = new \DateTime($createdAt);
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
}