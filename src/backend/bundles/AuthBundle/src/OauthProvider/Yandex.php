<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 22.02.2016
 * Time: 16:50
 */

namespace Auth\OauthProvider;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Yandex extends AbstractProvider
{
	public function getBaseAuthorizationUrl(){
		return 'https://oauth.yandex.ru/authorize';
	}

	public function getBaseAccessTokenUrl(array $params){
		return 'https://oauth.yandex.ru/token';
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token){
	}

	protected function getDefaultScopes(){
	}

	protected function checkResponse(ResponseInterface $response, $data){
	}

	protected function createResourceOwner(array $response, AccessToken $token){
	}

}