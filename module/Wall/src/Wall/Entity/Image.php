<?php

namespace Wall\Entity;

class Image
{
	public $domain = 'http://zf2-api/images/';
	
	protected $id = null;
	protected $userId = null;
	protected $filename = null;
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
		$this->userId = (int) $userId;
		return $this;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setFilename($filename)
	{
		$this->filename = $filename;
		return $this;
	}

	public function getFilename()
	{
		return $this->filename;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = new \DateTime($createdAt);
		return $this;
	}

	public function getCreatedAt()
	{
		$this->createdAt;
	}

	public function setUpdateAt($updatedAt)
	{
		$this->updatedAt = new \DateTime($updatedAt);
		return $this;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function getUrl()
	{
		reurn $this->domain . $this->getFilename();
	}

	
}
