<?php

namespace Users\Entity;

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
		$this->avatar = $avatar;
		return $this;
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
}
