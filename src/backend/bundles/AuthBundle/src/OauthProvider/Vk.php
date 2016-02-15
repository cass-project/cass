<?php
namespace Auth\OauthProvider;

use \League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * User: юзер
 * Date: 15.02.2016
 * Time: 17:03
 * To change this template use File | Settings | File Templates.
 */
class Vk extends AbstractProvider
{
	public function getBaseAuthorizationUrl(){
		return 'https://oauth.vk.com/authorize';
	}

	public function getBaseAccessTokenUrl(array $params){
		// TODO: Implement getBaseAccessTokenUrl() method.
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token){
		// TODO: Implement getResourceOwnerDetailsUrl() method.
	}

	protected function getDefaultScopes(){
		// TODO: Implement getDefaultScopes() method.
	}

	protected function checkResponse(ResponseInterface $response, $data){
		// TODO: Implement checkResponse() method.
	}

	protected function createResourceOwner(array $response, AccessToken $token){
		// TODO: Implement createResourceOwner() method.
	}




}