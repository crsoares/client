<?php

namespace Wall\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Users\Entity\User;
use Api\Client\ApiClient as ApiClient;

use Wall\Forms\TextStatusForm;
use Wall\Entity\Status;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$viewData = array();
		$flashMessenger = $this->flashMessenger();

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

		//Verifique se está enviando conteúdo
		$request = $this->getRequest();
		$statusForm = new TextStatusForm();

		if($request->isPost()) {
			$data = $request->getPost()->toArray();

			if(array_key_exists('status', $data)) {
				$result = $this->createStatus($statusForm, $user, $data);
			}

			switch(true) {
				case $result instanceOf TextStatusForm:
					$statusForm = $result;
					break;

				default:
					if($result == true) {
						$flashMessenger->addMessage('Novo conteúdo postado!');
						return $this->redirect()->toRoute(
									'wall',
									array('username' => $user->getUsername())
							   );
					} else {
						return $this->getResponse()->setStatusCode(500);
					}
					break;
			}
		}

		$statusForm->setAttribute('action', $this->url()->fromRoute('wall', array('username' => $user->getUsername())));
		$viewData['profileData'] = $user;
		$viewData['textContentForm'] = $statusForm;

		if($flashMessenger->hasMessages()) {
			$viewData['flashMessages'] = $flashMessenger->getMessages();
		}

		return $viewData;
 	}

 	protected function createStatus($form, $user, array $data)
 	{
 		$form->setInputFilter(Status::getInputFilter());
 		return $this->processSimpleForm($form, $user, $data);
 	}

 	protected function processSimpleForm($form, $user, array $data)
 	{
 		$form->setData($data);

 		if($form->isValid()) {
 			$data = $form->getData();
 			$data['user_id'] = $user->getId();
 			unset($data['submit']);
 			unset($data['csrf']);

 			$response = ApiClient::postWallContent($user->getUsername(), $data);

 			return $response['result'];
 		}

 		return $form;
 	}
}