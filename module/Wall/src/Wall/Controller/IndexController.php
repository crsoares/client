<?php

namespace Wall\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Wall\Entity\User;
use Api\Client\ApiClient as ApiClient;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$viewData = array();

		$username = $this->params()->fromRoute('username');
		$this->layout()->username = $username;

		$response = ApiClient::getWall($username);

		if($response !== false) {
			$hydrator = new ClassMethods();

			$user = $hydrator->hydrate($response, new User());
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}

		$viewData['profileData'] = $user;
		return $viewData;
 	}
}