<?php

namespace Users\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;
use Wall\Entity\Status;
use Wall\Entity\Image; 

class User
{
	const GENDER_MALE = 1;

	protected $id;
	protected $username;
	protected $name;
	protected $surname;
	protected $avatar;
	protected $bio;
	protected $location;
	protected $gender;
	protected $createdAt = null;
	protected $updatedAt = null;

	protected $feed = array();

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setSurname($surname)
	{
		$this->surname = $surname;
		return $this;
	}

	public function getSurname()
	{
		return $this->surname;
	}

	public function setAvatar($avatar)
	{
		if(empty($avatar)) {
			$defaultImage = new Image();
			$defaultImage->setFilename('default.png');
			$this->avatar = $defaultImage;
		} else {
			$hydrator = new ClassMethods();
			$this->avatar = $hydrator->hydrate($avatar, new Image());
		}
	}

	public function getAvatar()
	{
		return $this->avatar;
	}

	public function setBio($bio)
	{
		$this->bio = $bio;
		return $this;
	}

	public function getBio()
	{
		return $this->bio;
	}

	public function setLocation($location)
	{
		$this->location = $location;
		return $this;
	}

	public function getLocation()
	{
		return $this->location;
	}

	public function setGender($gender)
	{
		$this->gender = $gender;
		return $this;
	}

	public function getGenderString()
	{
		return $this->gender == self::GENDER_MALE ? 'Male' : 'Female';
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

	public function setFeed($feed)
	{
		$hydrator = new ClassMethods();

		foreach($feed as $entry) {
			if(array_key_exists('status', $entry)) {
				$this->feed[] = $hydrator->hydrate($entry, new Status());
			} else if(array_key_exists('filename', $entity)) {
				$this->feed[] = $hydrator->hydrate($entity, new Image());
			}
		}
	}

	public function getFeed()
	{
		return $this->feed;
	}
}
