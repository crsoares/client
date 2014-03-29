<?php

namespace Api\Client;

use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Json\Decoder as JsonDecoder;
use Zend\Json\Json;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Este cliente gere todas as operações necessárias para fazer a interface com o 
 * API rede social
 */
class ApiClient
{
	/**
	 * Mantém o cliente, vamos reutilizar nesta classe
	 * 
	 * @var Client
	 */
	protected static $client = null;

	/**
	 * Mantém as urls endpoint
	 * 
	 * @var string	
	 */
	protected static $endpointHost = 'http://zf2-api';
	protected static $endpointWall = '/api/wall/%s';

	/**
	 * Realizar uma reqquest API para recuperar os dados de parede 
	 * De um usuário específico na rede social
	 *
	 * @param string $username
	 * @return Zend\Http\Response
	 */
	public static function getWall($username)
	{
		$url = self::$endpointHost . sprintf(self::$endpointWall, $username);
		return self::doRequest($url);
	}

	/**
	 * Executar uma solicitação de API para postar conteúdo na parede de um usuário específico
	 *
	 * @param string $username
	 * @param array $data 
	 * @return Zend\Http\Response
	 */
	public static function postWallContent($username, $data)
	{
		$url = self::$endpointHost . sprintf(self::$endpointWall, $username);
		return self::doRequest($url, $data, Request::METHOD_POST);
	}

	/**
	 * Criar uma nova instância do cliente, se não tê-lo ou 
	 * Devolver o que já temos para reutilizar
	 *
	 * @return Client 
	 */
	protected static function getClientInstance()
	{
		if(self::$client === null) {
			self::$client = new Client();
			self::$client->setEncType(Client::ENC_URLENCODED);
		}

		return self::$client;
	}

	/**
	 * Executar um pedido para o API
	 *
	 * @param string $url
	 * @param array $postData
	 * @param Client $client
	 * @return Zend\Http\Response	
	 */
	protected static function doRequest($url, array $postData = null, $method = Request::METHOD_GET)
	{
		$client = self::getClientInstance();
		$client->setUri($url);
		$client->setMethod($method);

		if($postData !== null) {
			$client->setParameterPost($postData);
		}

		$response = $client->send();

		if($response->isSuccess()) {
			return JsonDecoder::decode($response->getBody(), Json::TYPE_ARRAY);
		} else {
			$logger = new Logger();
			$logger->addWriter(new Stream('data/logs/apiclient.log'));
			$logger->debug($response->getBody);
			return false;
		}
	}
}