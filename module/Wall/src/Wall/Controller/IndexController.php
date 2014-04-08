<?php

namespace Wall\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Validator\File\Size;
use Zend\Validator\File\IsImage;

use Users\Entity\User;
use Api\Client\ApiClient as ApiClient;

use Wall\Forms\TextStatusForm;
use Wall\Forms\ImageForm;
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
		$imageForm = new ImageForm();

		if($request->isPost()) {
			$data = $request->getPost()->toArray();

			if(array_key_exists('status', $data)) {
				$result = $this->createStatus($statusForm, $user, $data);
			}

			if(!empty($request->getFiles()->image)) {
				$data = array_merge_recursive(
					$data,
					$request->getFiles()->toArray()
				);
				$result = $this->createImage($imageForm, $user, $data);
			}

			switch(true) {
				case $result instanceOf TextStatusForm:
					$statusForm = $result;
					break;
				
				case $result instanceOf ImageForm:
					$imageForm = $result;
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
		$imageForm->setAttribute('action', $this->url()->fromRoute('wall', array('username' => $user->getUsername())));
		$viewData['profileData'] = $user;
		$viewData['textContentForm'] = $statusForm;
		$viewData['imageContentForm'] = $imageForm;

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

	protected function createImage($form, $user, $data)
	{	
		if($data['image']['error'] != 0) {
			$data['image'] = null;
		}

		$form->setData($data);
		
		$size = new Size(array('max' => 2048000));
		$isImage = new IsImage();
		$filename = $data['image']['name'];
	
		$adapter = new \Zend\File\Transfer\Adapter\Http();
		$adapter->setValidators(array($size, $isImage), $filename);

		if(!$adapter->isValid()) {
			$errors = array();
			foreach($adapter->getMessages() as $key => $row) {
				$errors[] = $row;
			}
			$form->setMessages(array('image' => $errors));
		}

		$destPath = 'data/tmp/';
		$adapter->setDestination($destPath);
		
		$fileinfo = $adapter->getFileinfo();
		preg_match('/.+\/(.+)/', $fileindo['image']['type'], $matches);
		$extension = $matches[1];
		$newFilename = sprintf(
			'%s %s',
			sha1(uniqid(time(), true)),
			$extensioin
		);

		$adapter->addFilter('File\Rename', array('target' => $destPath . $newFile, 'overwrite' => true));

		if($adapter->receive($filename)) {
			$data = array();
			$data['image'] = base64_encode(
				file_get_contents(
					$destPath . $newFilename
				)
			);

			$data['user_id'] = $user->getId();

			unlink($destPath . $newFilename);

			$response = ApiCliente::postWallContent(
				$user->getUsername(), $data
			);
			return $response->isSuccess();
		}
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
